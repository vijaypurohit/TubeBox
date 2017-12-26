<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Video;
use App\Http\Requests;
use Illuminate\Http\Request;

class VideoViewController extends Controller
{
    const BUFFER = 30;

    public function create(Request $request, Video $video)
    {
        if (!$video->canBeAccessed($request->user())) {
            return;
        }
//if user is authenticate
        // get last view for user
        // check if in buffer
        // return if too soon
        // get last view for current ip
        // do the same
        if ($request->user()) {
            $lastUserView = $video->views()->latestByUser($request->user())->first();

            if ($this->withinBuffer($lastUserView)) {
                return;
            }
        }

        $lastIpView = $video->views()->latestByIp($request->ip())->first();
            if ($this->withinBuffer($lastIpView)) {
                return;
            }

        $video->views()->create([
            'user_id' => $request->user() ? $request->user()->id : null,
            'ip' => $request->ip(),
        ]);

        return response()->json(null, 200);
    }

    protected function withinBuffer($view)
    {
        return $view && $view->created_at->diffInSeconds(Carbon::now()) < self::BUFFER;
    }
}
