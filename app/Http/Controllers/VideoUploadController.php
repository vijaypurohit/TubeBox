<?php

namespace App\Http\Controllers;


use App\Jobs\UploadVideo;
use Illuminate\Http\Request;


class VideoUploadController extends Controller
{
    // for showing video upload page.
    public function index()
    {
        return view('video.upload');
    }

    // after adding details of file in database, grab it and then uploading it
    public function store(Request $request)
    {


        $channel = $request->user()->channel()->first();

        $video = $channel->videos()->where('uid', $request->uid)->firstOrFail();

            $request->file('video')->move(storage_path() . '/uploads/videos/', $video->video_filename);

        $this->dispatch(new UploadVideo(
            $video->video_filename
        ));

        return response()->json(null, 200);
    }
}
