<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'title'       => 'required|string|max:255',
            'body'        => 'required|string',
            'cover_image' => 'required|file|mimes:png,jpg,jpeg',
            'pinned'      => 'required|boolean',
        ];
    }


    public function messages()
    {
        return [
            'title.required'       => 'عنوان المقال مطلوب',
            'title.string'         => 'هذا الحقل يجب أن يكون نص',
            'title.max:255'        => 'هذا الحقل يجب ألا يتعدى 255 حرف',
            'body.required'        => 'محتوى المقال مطلوب',
            'body.string'          => 'هذا الحقل يجب أن يكون نص',
            'cover_image.required' => 'صورة المقال مطلوبة',
            'pinned.required'      => 'هذا الحقل مطلوب',
            'pinned.boolean'       => 'هذا الحقل يجب أن يكون 0 أو 1',
        ];
    }
}
