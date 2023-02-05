<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class UserProfileResource extends JsonResource
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
            'id'       => $data['id'],
            'name'     => $data['name'],
            'email'    => $data['email'],
            'imageUrl' => $data['media']['path'],
            'role'     => Arr::pluck($data['roles'], 'name'),
        ];
    }
}
