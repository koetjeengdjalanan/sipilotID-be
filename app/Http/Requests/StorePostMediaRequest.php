<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostMediaRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'path'    => 'required|url',
            'post_id' => 'required_if:form_id,null|uuid|exists:\App\Models\Post,id',
            'form_id' => 'required_if:post_id,null|uuid|exists:\App\Models\form,id',
        ];
    }
}
