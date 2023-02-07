<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        return [
            'token_type'   => 'bearer',
            'access_token' => $data['access_token'],
            'expire_after' => $data['expire_after'],
            'issued_at'    => $data['issued_at'],
        ];
    }

}
