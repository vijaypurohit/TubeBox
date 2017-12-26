<?php

namespace App\Jobs;

use App\Models\Video;

use getID3;
use getid3_lib;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Coordinate\Dimension;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Repositories\RandomStringGenerator;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Intervention\Image\Facades\Image;

class UploadVideo implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $filename;
    public $ffmpeg;
    public $getID3;
    public $token;

    public $tries = 5;
    public $timeout = 90;

    /**
     * Create a new job instance.
     *
     * @param $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
        $this->ffmpeg = FFMpeg::create(array(
            'ffmpeg.binaries'  => env('FFMPEG'),
            'ffprobe.binaries' => env('FFPROBE'),
            'timeout'          => 3600, // The timeout for the underlying process
            'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
        ));
        $this->getID3 = new getID3;
            $customAlphabet = 'a1b2c3d4e5f6g7h8i9j0klmnopqrstuvwxyz';
            $generator = new RandomStringGenerator($customAlphabet);
            $tokenLength = 30;
        $this->token = $generator->generate($tokenLength);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $video_file = storage_path('/uploads/videos/').$this->filename;

        $fileDetails = $this->getID3->analyze($video_file);
        getid3_lib::CopyTagsToComments($fileDetails);

        // uploading to amazon s3 then encoding with telestream cloud and then moving encoded video to different s3 folder
        if(!config('citube.video_local_storage'))
        {
            if (Storage::disk('s3drop')->put($this->filename, fopen($video_file, 'r+'))) {
                File::delete($video_file);
            }
        }
        else{
            $this->generateThumbnail($fileDetails, $this->ffmpeg, $this->token );
            $this->transcodingVideo($fileDetails, $this->ffmpeg, $this->token );
        }

    }

    public function transcodingVideo($fileDetails, $ffmpeg, $token)
    {
        $enc_vid_path = storage_path('uploads/encoded_video/');
            $out_vid_path = $enc_vid_path.$token.'.mp4';

        $videoModel = $this->getVideoByFilename($fileDetails['filename']);

        $video = $ffmpeg->open($fileDetails['filenamepath']);
        $video
            ->filters()
            ->resize(new Dimension(720, 480))
            ->synchronize();
        $format = new X264('aac', 'libx264');
        $format->on('progress', function ($video, $format, $percentage) use($videoModel) {
//            echo "$percentage % transcoded";
            $videoModel->processed_percentage = $percentage;
            $videoModel->save();
        });
        $format
            ->setKiloBitrate(2048)
            ->setAudioChannels(2)
            ->setAudioKiloBitrate(128);

        $video->save($format, $out_vid_path);

        $videoModel->processed = true;
        $videoModel->video_id = $token;
        $videoModel->save();
        File::delete($fileDetails['filenamepath']);

    }

    public function generateThumbnail($fileDetails, $ffmpeg, $token )
    {
        $thumbnailName = $token.'_1.png';
        $thumbTimeCode = $fileDetails['playtime_seconds']/2;
        $enc_vid_path = storage_path('uploads/encoded_video/');
        $thumbPath = $enc_vid_path.$thumbnailName;

        $video = $ffmpeg->open( $fileDetails['filenamepath'] );
        $video
            ->frame(TimeCode::fromSeconds($thumbTimeCode))
            ->save($thumbPath);

        Image::make($thumbPath)->encode('png')->fit(720,480, function ($c) {
            $c->upsize();
        })->save();
        return ;
    }

    protected function getVideoByFilename($filename)
    {
        return Video::where('video_filename', $filename)->firstOrFail();
    }

//    public function failed(Exception $exception)
//    {
//        // Send user notification of failure, etc...
//    }
}
