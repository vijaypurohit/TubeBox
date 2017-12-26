<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;
use App\Traits\Orderable;

class Video extends Model
{
    use SoftDeletes, Orderable;
//        Searchable ;

    protected $fillable = [
        'title',
        'description',
        'uid',
        'video_filename',
        'video_id',
        'processed',
        'visibility',
        'allow_votes',
        'allow_comments',
        'processed_percentage',
    ];

    public function getRouteKeyName()
    {
        return 'uid';
    }

    public function getThumbnail()
    {
        $defaultPath = config('citube.enc_video_url') . '_default.png';;
        $path = config('citube.enc_video_url') . $this->video_id . '_1.png';

        if (!$this->isProcessed()) {
            return $defaultPath;     // offline path
        }

        if(config('citube.video_local_storage')) {
            return ( ( Storage::disk('LocalStorage')->exists('encoded_video/'.$this->video_id.'_1.png') == false  ? $defaultPath : $path  ) );
        }
        else{
            return config('citube.buckets.videos') . '/' . $this->video_id . '_1.jpg';
        }

    }

    public function getStreamUrl()
    {
        if(config('citube.video_local_storage')) {
            return config('citube.enc_video_url'). $this->video_id . '.mp4' ;
        }
        else{
            return config('citube.buckets.videos') . '/' . $this->video_id . '.mp4';
        }
    }

    public function toSearchableArray()
    {
        $properties = $this->toArray();
        $properties['visible'] = $this->isProcessed() && $this->isPublic();

        return $properties;
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }


    public function processedPercentage()
    {
        return $this->processed_percentage;
    }

    public function isProcessed()
    {
        return $this->processed;
    }

    public function isPrivate()
    {
        return $this->visibility === 'private';
    }

    public function isPublic()
    {
        return $this->visibility === 'public';
    }

    public function ownedByUser(User $user)
    {
        return $this->channel->user->id === $user->id;
    }

    public function canBeAccessed($user = null)
    {
        if (!$user && $this->isPrivate()) {
            return false;
        }

        if ($user && $this->isPrivate() && ($user->id !== $this->channel->user_id)) {
            return false;
        }

        return true;
    }

// Views
    public function views()
    {
        return $this->hasMany(VideoView::class);
    }

    public function viewCount()
    {
        return $this->views->count();
    }

// Votes
    public function votesAllowed()
    {
        return (bool) $this->allow_votes;
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    public function upVotes()
    {
        return $this->votes()->where('type', 'up');
    }

    public function downVotes()
    {
        return $this->votes()->where('type', 'down');
    }

    public function voteFromUser(User $user)
    {
        return $this->votes()->where('user_id', $user->id);
    }

// Comments
    public function commentsAllowed()
    {
        return (bool) $this->allow_comments;
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('reply_id');
    }

//Scope Query
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeProcessed($query)
    {
        return $query->where('processed', true);
    }

    public function scopePublic($query)
    {
        return $query->where('visibility', 'public');
    }

    public function scopeVisible($query)
    {
        return $query->processed()->public();
    }
}
