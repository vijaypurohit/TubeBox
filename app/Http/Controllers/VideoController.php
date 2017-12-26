<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\VideoUpdateRequest;
use App\Http\Requests\VideoCreateRequest;

class VideoController extends Controller
{
    public function show(Video $video)
    {
        return view('video.show', [
            'video' => $video,
        ]);
    }

    // indexing all the user videos as a list
    public function index(Request $request)
    {
        $videos = $request->user()->videos()->latestFirst()->paginate(10);
//        dd($videos);
        return view('video.index', [
            'videos' => $videos,
        ]);
    }

    public function edit(Video $video)
    {
        $this->authorize('edit', $video);
        
        return view('video.edit', [
            'video' => $video,
        ]);
    }

    //updating the file data into database
    public function update(VideoUpdateRequest $request, Video $video)
    {
        $this->authorize('update', $video);

        $video->update([
            'title' => $request->title,
            'description' => $request->description,
            'visibility' => $request->visibility,
            'allow_votes' => $request->has('allow_votes'),
            'allow_comments' => $request->has('allow_comments'),
        ]);

        if ($request->ajax()) {
            return response()->json(null, 200);
        }
         session()->flash('videoUpdate', 'The video has been updated');
        return redirect()->back();
//        return redirect('/videos');
    }

    //storing the file data into database
    /**
     * @param VideoCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(VideoCreateRequest $request)
    {
//        $uid = uniqid(true);
        $channel = $request->user()->channel()->first();

        $uid = $channel->user_id.'s_'.$channel->slug.'_v_'.uniqid(true);

        $video = $channel->videos()->create([
            'uid' => $uid,
            'title' => $request->title,
            'description' => $request->description,
            'visibility' => $request->visibility,
            'video_filename' => "{$uid}.{$request->extension}",
        ]);
//        dd($video);

        return response()->json([
            'data' => [
                'uid' => $uid,
//                'request' => $request->file('video'),
//                'title' => $request->title,
//                'description' => $request->description,
//                'visibility' => $request->visibility,
//                'video_filename' => "{$uid}.{$request->extension}",
            ]
        ], 200);
    }

    public function delete(Video $video)
    {
        $this->authorize('delete', $video);
        
        $video->delete();

        return redirect()->back();
    }

    public function encode(Request $request, Video $video)
    {
        if (!$video->ownedByUser($request->user())) {
            return;
        }

        $response = [
            'uid' => $video->uid,
            'processed' => $video->processed,
            'video_id' => $video->video_id,
            'processed_percentage' => $video->processed_percentage,
        ];

        return response()->json([
            'data' => $response
        ], 200);
    }


}
