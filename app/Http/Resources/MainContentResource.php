<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MainContentResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        // dd($data[0]['section']);
        return collect(
            [
                'id'      => $data['id'],
                'title'   => $data['title'],
                'image'   => $data['image'],
                'content' => json_decode($data['content']),
            ]
        );
    }
}
