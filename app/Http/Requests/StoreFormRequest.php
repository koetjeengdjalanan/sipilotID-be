<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreFormRequest extends FormRequest
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
            'user_id'      => 'uuid|exists:App\Models\User,id',
            'title'        => 'required|string',
            'slug'         => 'required|string|unique:App\Models\Form,slug|alpha_dash',
            'excerpt'      => 'required|string',
            'publish_date' => 'numeric|after_or_equal:' . Carbon::now()->timestamp,
            'expire'       => 'numeric|gte:publish_date|required_with:publish_date',
        ];
    }
}
