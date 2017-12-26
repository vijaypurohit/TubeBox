<?php
/**
 * Created by PhpStorm.
 * User: vijay
 * Date: 23-Apr-17
 * Time: 3:28 AM
 */
// basename(base_path()) is base directory name
return [

    'channel_local_storage'=>true,
    'video_local_storage'=>true,

    'channel_profile_path' => config('app.url').'/'.basename(base_path()).'/storage/uploads/profile/',

    'video_url' => config('app.url') . '/'.basename(base_path()).'/storage/uploads/videos/',
    'enc_video_url' => config('app.url') . '/'.basename(base_path()).'/storage/uploads/encoded_video/',

    'storage_url' => config('app.url') . '/'.basename(base_path()).'/storage/',
    'public_url' => config('app.url') . '/'.basename(base_path()).'/public/',

    'buckets' => [
        'videos' => 'https://s3.ap-south-1.amazonaws.com/videos.citube.com',
        'images' => 'https://s3.ap-south-1.amazonaws.com/images.citube.com',
    ]

];
