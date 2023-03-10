<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMainContentRequest extends FormRequest
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
            'user_id' => 'required|exists:App\Models\User,id',
            'section' => 'required|digits_between:1,6|exists:App\Models\MainContent,section',
            'title'   => 'required|string',
            'content' => 'required|json',
            'image'   => 'required|url',
        ];
    }
}
