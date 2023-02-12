<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'title'   => 'required|string|unique:\App\Models\Category,title',
            'slug'    => 'required|string|unique:\App\Models\Category,slug',
            'user_id' => 'required|uuid|exists:\App\Models\User,id',
        ];
    }
}
