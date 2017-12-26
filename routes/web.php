<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $citube_img = storage_path().'/citube.png';
//    dd($citube_img);
    return view('welcome')->with('citube',$citube_img);
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/code', function (){
    return view('terms.code');
});
//Route::get('/test', 'ChannelController@test');
//Route::get('/test/{uid}', 'ChannelController@getJobProgress');
//Route::get('/test2', 'ChannelController@test2');
//Route::get('/test3', 'ChannelController@test3');
//Route::get('/test4', 'ChannelController@test4');
//Route::get('/test5/{channel}', 'ChannelController@test5');

Route::get('/search', 'SearchController@index');
Route::post('/webhook/encoding', 'EncodingWebhookController@handle');

Route::get('/channel/{channel}', 'ChannelController@show');
Route::get('/channels', 'ChannelController@index');

Route::get('/videos/{video}', 'VideoController@show');
Route::post('/videos/{video}/views', 'VideoViewController@create');

Route::get('/videos/{video}/votes', 'VideoVoteController@show');
Route::get('/videos/{video}/encode', 'VideoController@encode');
Route::get('/videos/{video}/comments', 'VideoCommentController@index');
Route::get('/subscription/{channel}', 'ChannelSubscriptionController@show');

Route::get('/channel/{user}/subscriptions', 'ChannelController@subscriptions');

Route::group(['middleware'=>['auth']], function (){
    Route::get('/upload', 'VideoUploadController@index');
    Route::post('/upload', 'VideoUploadController@store');

    Route::get('/videos', 'VideoController@index');
    Route::post('/videos', 'VideoController@store');

    Route::get('/videos/{video}/edit', 'VideoController@edit');
    Route::put('/videos/{video}', 'VideoController@update');
    Route::delete('/videos/{video}', 'VideoController@delete');

    Route::get('/channel/{channel}/edit', 'ChannelSettingsController@edit');
    Route::put('/channel/{channel}/edit', 'ChannelSettingsController@update');

    Route::post('/videos/{video}/votes', 'VideoVoteController@create');
    Route::delete('/videos/{video}/votes', 'VideoVoteController@remove');

    Route::post('/videos/{video}/comments', 'VideoCommentController@create');
    Route::delete('/videos/{video}/comments/{comment}', 'VideoCommentController@delete');

    Route::post('/subscription/{channel}', 'ChannelSubscriptionController@create');
    Route::delete('/subscription/{channel}', 'ChannelSubscriptionController@delete');
});
