<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Video;
use App\Models\User;
use App\Models\Vote;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFProbe;
use FFMpeg\Format\Audio\Mp3;
use FFMpeg\Format\Video\X264;
use getID3;
use getid3_lib;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

use FFMpeg\FFMpeg;
use Intervention\Image\Facades\Image;
use App\Repositories\RandomStringGenerator;
use Monolog\Handler\FingersCrossed\ChannelLevelActivationStrategy;

//use Linkthrow\Ffmpeg\Classes\FFMPEG;


class ChannelController extends Controller
{
    public function show(Channel $channel)
    {
        return view('channel.show', [
            'channel' => $channel,
            'videos' => $channel->videos()->visible()->latestFirst()->paginate(5),
        ]);
    }

    public function index()
    {
        $channels=Channel::orderBy('name', 'asc')->paginate(10);
        return view('channel.index', [
            'channels' => $channels,
        ]);
    }

    public function subscriptions(User $user){
//        $this->authorize('update', $channel);
        $subscribedChannels = $user->subscribedChannels()->get();
//        dd($subscribedChannels);
        return view('channel.subscription.show', [
            'subscribedChannels' => $subscribedChannels,
        ]);
    }

    public function test()
    {

//        $path = base_path();                      //"C:\xampp\htdocs\ctube"
        $path = storage_path('uploads\videos'); //"C:\xampp\htdocs\ctube\storage\uploads\videos"
//        $path = app_path();                   //"C:\xampp\htdocs\ctube\app"
//        $path = public_path();                //"C:\xampp\htdocs\ctube\public"


//        $video_file = config('citube.video_path') . '/1s_158f7ed4a4adbd_v_159368e116f1db.mp4';
        //"http://localhost/ctube/public/1s_CIT_v_1593e94418eed1.MP4"
        $video_file = storage_path('uploads\videos').'\1s_158f7ed4a4adbd_v_159368e116f1db.mp4';
//        $video_file = storage_path('uploads\videos').'\1s_CIT_v_1593e98ae1dd3b.mp4';
        //"C:\xampp\htdocs\ctube\storage\uploads\videos\2s_15938ff5368f22_v_15938ff6505bf9.MP4"

//        $contents = Storage::disk('LocalVideo')->get('_default.png');
//        $exists = Storage::disk('LocalStorage')->exists('encoded_video/_default.png');
//        $url = Storage::disk('LocalStorage')->url('encoded_video/_default.png'); //"http://localhost/ctube/storage/uploads/videos/_default.png"
//        $size = Storage::disk('LocalVideo')->size('_default.png');  //15399  = 15KB
//        $time  = Storage::disk('LocalVideo')->lastModified('_default.png');  //1497265633  = 15KB
//        $create = Storage::disk('LocalVideo')->put('file1.txt', $size.$time);
//        $copied = Storage::disk('LocalStorage')->move('videos/_default.png', 'encoded_video/_default.png');
//        $copied = Storage::disk('LocalStorage')->move('encoded_video/_default.png', 'videos/_default.png');
//        $visibility = Storage::disk('LocalStorage')->getVisibility('videos/_default.png');
//        $delete = Storage::disk('LocalStorage')->delete(['videos/file1.txt', 'videos/file.txt']);

//        $files = Storage::disk('LocalStorage')->files('videos');

//        $files = Storage::disk('LocalStorage')->allFiles('videos');

//        dd($files);

        //doesn't work with localhost url
        $getID3 = new getID3;
        $file = $getID3->analyze($video_file);
        getid3_lib::CopyTagsToComments($file);
//        print_r($file);
        $playtime_string = $file['playtime_string'];
        $playtime_seconds = $file['playtime_seconds'];
        $filesize = $file['filesize'];
        $filepath = $file['filepath'];
        $filename = $file['filename'];
        $filenamepath = $file['filenamepath'];
        $fileformat = $file['fileformat'];
        $mime_type = $file['mime_type'];
        $bitrate = $file['bitrate'];
//        $errors = $file['error'];


        $fileNameWithoutExt = chop($filename, '.'.$fileformat);

        $file_out =  storage_path('uploads/encoded_video').'/'.$fileNameWithoutExt.'.mp4';

        set_time_limit(120);
        $thumbnailName = $fileNameWithoutExt.'_1';
        $result = FFMPEG::getThumbnails($video_file, $thumbnailName, 1);
////        $result =  FFMPEG::convert()->input($video_file)->bitrate(500000, 'video')->output($file_out)->go('-b:v 2048k');
//        $result =  FFMPEG::convert()->input($video_file)->bitrate(500000, 'video')->output($file_out)->progress($fileNameWithoutExt)->go('-s 720x480 -profile:v high -level 4.0 -c:v libx264 -preset slow -crf 23 -maxrate 1M -bufsize 2M -b:v 2048k -threads 0 -c:a aac -b:a 196k ');
//        $result = FFMPEG::getMediaInfo($video_file);
        $generatedThumb = $thumbnailName.'-01.png';
//        $getFile = Storage::disk('PublicStorage')->get($generatedThumb);
//        $create = Storage::disk('LocalStorage')->put('encoded_video/'.$thumbnailName.'.png', $getFile);
//        $delete = Storage::disk('PublicStorage')->delete($generatedThumb);
//        $delete = Storage::disk('LocalStorage')->delete('videos/'.$filename);
//        $allFiles = Storage::disk('LocalStorage')->files('tmp');
//        $delete = Storage::disk('LocalStorage')->delete($allFiles);
        dd($result);
//        dd($channel->totalVideoViews());
    }

    public function getJobProgress($id)
    {
        $result =  FFMPEG::getProgress($id);
      $json = \GuzzleHttp\json_decode($result);
        echo $json->Progress;
        dd($json);
//        return FFMPEG::getProgress($id);
    }

    public function test2()
    {
//        dd(storage_path() . '/uploads/profile/');
        $video_file = storage_path('uploads\videos').'\1s_158f7ed4a4adbd_v_159368e116f1db.mp4';
        $video_file2 = storage_path('uploads\encoded_video').'\101.mp4';

        $getID3 = new getID3;
        $file = $getID3->analyze($video_file);
        getid3_lib::CopyTagsToComments($file);
//        print_r($file);
//        $playtime_string = $file['playtime_string'];
//        $playtime_seconds = $file['playtime_seconds'];
//        $filesize = $file['filesize'];
//        $filepath = $file['filepath'];
        $filename = $file['filename'];
//        $filenamepath = $file['filenamepath'];
//        $fileformat = $file['fileformat'];
//        $mime_type = $file['mime_type'];
//        $bitrate = $file['bitrate'];
//        $errors = $file['error'];

        $fileNameWithoutExt = chop($file['filename'], '.'.$file['fileformat']);

        $thumbnailName = $fileNameWithoutExt.'_1.png';

//        $video_file2 = config('citube.video_path') . '1s_158f7ed4a4adbd_v_159368e116f1db.mp4';
        $audio_file = storage_path('uploads\videos').'\2.mp3';
//        dd($video_file2);
//       $result = FFMpeg::fromDisk('LocalStorage')
//            ->open('videos/'.$filename)
//            ->addFilter(function ($filters) {
//                $filters->resize(new \FFMpeg\Coordinate\Dimension(640, 480));
//            })
//            ->export()
//            ->toDisk('LocalStorage')
//            ->inFormat(new \FFMpeg\Format\Video\X264)
//            ->save('small_steve.mkv');

//       dd(FFMpeg::fromDisk('LocalStorage')->open('videos/'.$filename)->export()->toDisk('LocalStorage')->inFormat(new X264)->save('small_steve.mkv'));
//        $result =FFMpeg::fromDisk('LocalVideo')
//            ->open($filename)
//            ->getFrameFromSeconds(5)
//            ->export()
//            ->toDisk('LocalEncVideo')
//            ->save($thumbnailName);
//dd($result);
//        $media = FFMpeg::fromDisk('LocalVideo')->open($filename);
//
//        $durationInSeconds = $media->getDurationInSeconds(); // returns an int
//dd($durationInSeconds);

//       dd(FFMpeg::fromDisk('LocalVideo')->open($filename)->addFilter(function ($filters) {
//                $filters->resize(new Dimension(640, 480));
//            })->export()->toDisk('LocalEncVideo')->inFormat(new X264)->save('small_steve.mp4'));
    }

    public function test3()
    {
        $video_filename = 'oceans.mp4';
        $video_file = storage_path('uploads/videos/').$video_filename;
        $getID3 = new getID3;
        $fileDetails = $getID3->analyze($video_file);
        getid3_lib::CopyTagsToComments($fileDetails);
        dd($fileDetails);
    }

    public function test4()
    {
        $customAlphabet = 'a1b2c3d4e5f6g7h8i9j0klmnopqrstuvwxyz';
        $generator = new RandomStringGenerator($customAlphabet);
        $tokenLength = 30;
        $token = $generator->generate($tokenLength);

$name='vijay';
        $video_filename = 'oceans.mp4';
//        $video_filename = 'coals.mov';
//        $video_filename = 'morgen-20030714.avi';
//        $video_filename = 'SampleVideo_320x240_10mb.3gp';
//        $video_filename = 'SampleVideo_640x360_10mb.flv';
//        $video_filename = 'SampleVideo_720x480_5mb.mkv';
//        $video_filename = '1s_CIT_v_159423ba00e121.mp4';
//        $video_filename = '2s_15938ff5368f22_v_15938ff6505bf9.MP4';
        $video_file = storage_path('uploads/videos/').$video_filename;
//        $video_file = storage_path() . '/uploads/videos/' . $video->video_filename;

        $ffmpeg = FFMpeg::create(array(
            'ffmpeg.binaries'  => env('FFMPEG'),
            'ffprobe.binaries' => env('FFPROBE'),
            'timeout'          => 3600, // The timeout for the underlying process
            'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
        ));

        $getID3 = new getID3;
        $fileDetails = $getID3->analyze($video_file);
        getid3_lib::CopyTagsToComments($fileDetails);



        $enc_vid_path = storage_path('uploads/encoded_video/');
//        $enc_aud_path = storage_path('uploads/encoded_audio/');

//        $video = $ffmpeg->open( $fileDetails['filenamepath'] );
// video to gif
//        $enc_gif_path = $enc_aud_path.$token.'.gif';
//        $video
//            ->gif(TimeCode::fromSeconds(2), new Dimension(720, 480), 3)
//            ->save($enc_gif_path);

//Video to Audio with waveform
//        $audio_format = new Mp3();
//        $audio_format->on('progress', function ($video, $audio_format, $percentage) {
//            echo "$percentage % transcoded";
//        });
//        $audio_format
//            ->setAudioChannels(2)
//            ->setAudioKiloBitrate(256);
//        $out_name = $enc_aud_path.$token.'.mp3';
//
//        $video->save($audio_format, $out_name);
//
//             $waveform_path = $enc_aud_path.$thumbnailName;
//        $waveform = $video->waveform();
//        $waveform->save($waveform_path);
////after audio to video
//            $audio = $ffmpeg->open( $out_name );
// //audio filters                   //starting point and duration
//        $audio->filters()->clip(TimeCode::fromSeconds(10), TimeCode::fromSeconds(5))
////            ->resample(126000)
//            ->addMetadata([
//                "title" => "Some Title",
//                "artist" => $name,
//                "album" => "vijay album",
//                "composer" => "vijay_composer",
//                "track" => 1,
//                "artwork" => 'citube.png',
//                "year" => '2017',
//                "genre" => 'Bolly',
//                "description" => 'THis is demo work',
//            ]);
//
//            $out_name = $enc_aud_path.$token.'_clipped_.mp3';
//        $audio->save($audio_format, $out_name);
//video WaterMark

        $thumbnailName = $token.'_1.png';
        $thumbTimeCode = $fileDetails['playtime_seconds']/2;
            $thumbPath = $enc_vid_path.$thumbnailName;

//        $video
//            ->frame(TimeCode::fromSeconds($thumbTimeCode))
//            ->save($thumbPath);
////
//        Image::make($thumbPath)->encode('png')->fit(720,480, function ($c) {
//            $c->upsize();
//        })->save();

        $out_vid_path = $enc_vid_path.$token.'_demo_.mp4';
        $wPath =  $enc_vid_path.'w.png';
//        $videoModel = $this->getVideoByFilename($fileDetails['filename']);
//
        $video = $ffmpeg->open( $fileDetails['filenamepath'] );
        $video
            ->filters()
            ->resize(new Dimension(720, 480))
            ->watermark('citube.png', array(
                'position' => 'relative',
                'bottom' => 90,
                'right' => 90,
            ))
            ->synchronize();
//dd($video);
        $format = new X264('aac', 'libx264');
//        $format->on('progress', function ($video, $format, $percentage) use($videoModel) {
////            echo "$percentage % transcoded";
//            $videoModel->processed_percentage = $percentage;
//            $videoModel->save();;
//        });

        $format
            ->setKiloBitrate(2048)
            ->setAudioChannels(2)
            ->setAudioKiloBitrate(128);

        $video->save($format, $out_vid_path);
//
////        $videoModel = $this->getVideoByFilename($fileDetails['filename']);
//        $videoModel->processed = true;
//        $videoModel->video_id = $token;
////        $videoModel->processed_percentage = 85;
//        $videoModel->save();
////        File::delete($fileDetails['filenamepath']);

        dd($video);
    }
    protected function getVideoByFilename($filename)
    {
        return Video::where('video_filename', $filename)->firstOrFail();
    }

    protected function test5(Channel $channel)
    {
        echo $channel->totalVideoUpVotes();
//        $videos = $channel->videos()->visible()->get();
////        dd( $videos);
//        $sum=0;
//        foreach ($videos as $video){
//            $votes = $video->votes()->count();
//            echo ( $votes);
//            $sum+=$votes;
//            echo '<br>';
//            echo ( $sum);
//            echo '<br>';
//        }

//        dd( $channel->totalVideoVotes());


    }




}
