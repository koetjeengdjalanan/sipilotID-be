<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFormRequest extends FormRequest
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
            'id'           => 'required|uuid|exists:App\Models\Form,id',
            'user_id'      => 'required|uuid|exists:App\Models\User,id',
            'title'        => 'required|string',
            'slug'         => 'required|url',
            'blog_url'     => 'required|url',
            'excerpt'      => 'required|string',
            'description'  => 'required|string',
            'publish_date' => 'numeric',
            'expire'       => 'numeric|gte:publish_date|required_with:publish_date',
        ];
    }
}
