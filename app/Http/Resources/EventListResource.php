<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventListResource extends JsonResource
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
        // dd($data['id']);
        return [
            'id'           => $data['id'],
            'title'        => $data['title'],
            'slug'         => $data['slug'],
            'excerpt'      => $data['excerpt'],
            'publish_date' => $data['publish_date'],
            'expire'       => $data['expire'],
        ];
    }
}
