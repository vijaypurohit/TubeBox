<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Video;
use App\Http\Requests;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->q) {
            return redirect('/home');
        }

//        $channels = Channel::search($request->q)->take(2)->get();
//        $videos = Video::search($request->q)->where('visible', true)->get();
//        $videos = Video::search($request->q)->get();
        $q = $request->q;
        $channels = Channel::where('name','LIKE','%'.$q.'%')->orWhere('description','LIKE','%'.$q.'%')->get();
//        $videos = Video::where('title','LIKE','%'.$q.'%')->orWhere('description','LIKE','%'.$q.'%')->where('visibility', 'public')->get();
        $videos = Video::where([
                                ['title','LIKE','%'.$q.'%'],
                                ['visibility', 'public'],
                                ['processed', '1'],
                    ])->orWhere('description','LIKE','%'.$q.'%')->orderBy('created_at', 'desc')->get();
//            dd($videos);

        return view('search.index', [
            'channels' => $channels,
            'videos' => $videos,
        ]);
    }
}
