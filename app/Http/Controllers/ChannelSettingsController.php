<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\ChannelUpdateRequest;
use App\Jobs\UploadImage;
use Illuminate\Support\Facades\Storage;

class ChannelSettingsController extends Controller
{
    public function edit(Channel $channel)
    {
//        dd($channel);
        $this->authorize('edit', $channel);

        return view('channel.settings.edit', [
            'channel' => $channel
        ]);
    }

    public function update(ChannelUpdateRequest $request, Channel $channel)
    {
        $this->authorize('update', $channel);
        
        $channel->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
        ]);

        // temp moving to storage
        if ($request->file('image')) {
            //image name without extension
            $fileId = 'img'.$channel->user_id.$channel->slug;    //  $fileId = uniqid(true);

            Storage::disk('LocalStorage')->delete('profile/'.$fileId);
                //moving to local storage
            $request->file('image')->move(storage_path() . '/uploads/profile/', $fileId );
                //Dispatch the job
            $this->dispatch(new UploadImage($channel, $fileId));
//            $request->session()->flash('status', 'Task was successful!');
        }

        session()->flash('channelUpdate', 'The Channel information has been updated');
        return redirect()->to("/channel/{$channel->slug}/edit");
    }
}
