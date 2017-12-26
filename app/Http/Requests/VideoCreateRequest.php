<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed title
 * @property mixed description
 * @property mixed visibility
 * @property mixed extension
 */
class VideoCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:191',
            'description' => 'max:2000',
            'visibility' => 'required|in:public,unlisted,private',
            'video' => 'required|mimes:mp4,avi,mov,flv,qt,mkv|
                                mimetypes:video/mp4,video/x-msvideo,video/x-flv,video/quicktime,video/3gpp,video/x-matroska',

        ];
    }
}
