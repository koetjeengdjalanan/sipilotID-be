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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "title"          => 'required',
            "slug"           => 'required|unique:posts,slug|alpha_dash',
            "user_id"        => 'required|exists:users,id|uuid',
            "category_id"    => 'required|exists:categories,id|uuid',
            "tags"           => 'sometimes|nullable|array',
            "thumbnail"      => 'sometimes|nullable|url',
            "excerpt"        => 'required',
            "body"           => 'required',
            "published_date" => 'numeric',
        ];
    }

    /**
     * @author Martin Sambulare <martin@rakhasa.com>
     * Get the validated data from the request.
     *
     * @param  string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function validated($key = null, $default = null)
    {
        $data = data_get($this->validator->validated(), $key, $default);
        return array_merge($data, [
            'published_date' => date('Y-m-d H:i:s', $data['published_date']),
        ]);
    }
}
