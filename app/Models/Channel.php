<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Channel extends Model
{
//    use Searchable;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image_filename',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function getImage()
    {
        if(config('citube.channel_local_storage'))
        {
            if (!$this->image_filename) {
                return config('citube.channel_profile_path') . 'default.png';
            }
            return config('citube.channel_profile_path').chop($this->image_filename, ".png");
//            return storage_path('app').chop($this->image_filename, ".png");
        }
        else
        {
            if (!$this->image_filename) {
                return config('citube.buckets.images') . '/profile/default.png';
            }
            return config('citube.buckets.images') . '/profile/' . $this->image_filename;
        }
    }

    //just only the subscriptions
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function subscriptionCount()
    {
        return $this->subscriptions->count();
    }

    public function totalVideoViews()
    {
        //
        return $this->hasManyThrough(VideoView::class, Video::class)->count();
    }

    public function totalVideoVotes()
    {
        $videos = $this->videos()->visible()->get();
        $sum=0;
        foreach ($videos as $video){
            $votes = $video->votes()->count();
            $sum+=$votes;
        }
        return $sum;
    }

    public function totalVideoUpVotes()
    {
        $videos = $this->videos()->visible()->get();
        $sum=0;
        foreach ($videos as $video){
            $votes = $video->upVotes()->count();
            $sum+=$votes;
        }
        return $sum;
    }

}
