<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTagRequest extends FormRequest
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
            'name' => 'required|unique:tags'
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'الإسم مطلوب',
            'name.unique'   => 'هذا الإسم موجود بالفعل من قبل',
        ];
    }
}
