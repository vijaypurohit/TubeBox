<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function videosFromSubscriptions(User $user, $limit = 5)
    {
        // all the videos from subscribed videos in chronological order to show them in index page
        // pluck video will get only videos from videos and channels list of subscribers
        return $user->subscribedChannels()
            ->with(['videos' => function ($query) use ($limit) {$query->visible()->take($limit);}])
            ->get()->pluck('videos')->flatten()->sortByDesc('created_at');
    }
}
