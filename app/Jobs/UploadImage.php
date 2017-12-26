<?php

namespace App\Jobs;

use File;
//use Image;
use Intervention\Image\Facades\Image;
use Storage;
//use Illuminate\Support\Facades\Storage;
use App\Models\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UploadImage implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $channel;
    public $fileId;

    public $tries = 5;
    public $timeout = 90;
    /**
     * Create a new job instance.
     *
     * @param Channel $channel
     * @param $fileId
     */
    public function __construct(Channel $channel, $fileId)
    {
        $this->channel = $channel;
        $this->fileId = $fileId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $path = storage_path() . '/uploads/profile/' . $this->fileId;
        $fileName = $this->fileId . '.png';

        Image::make($path)->encode('png')->fit(40, 40, function ($c) {
            $c->upsize();
        })->save();

        if(!config('citube.channel_local_storage')){
            if (Storage::disk('s3images')->put('profile/' . $fileName, fopen($path, 'r+'))) {
//                File::delete($path);
            }
        }
        
        $this->channel->image_filename = $fileName;
        $this->channel->save();
    }
}
