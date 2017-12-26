<?php
return [
    'default_disk' => 'LocalStorage',

    'ffmpeg.binaries' => env('FFMPEG'),
    'ffmpeg.threads'  => 12,
    'ffprobe.binaries' => env('FFPROBE'),

    'timeout' => 3600,
];
