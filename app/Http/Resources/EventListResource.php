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
            'id'           => $data['id'] ?? null,
            'title'        => $data['title'] ?? null,
            'slug'         => $data['slug'] ?? null,
            'excerpt'      => $data['excerpt'] ?? null,
            'publish_date' => (int) $data['publish_date'] ?? null,
            'expire'       => (int) $data['expire'] ?? null,
            'imageUrl'     => $data['media'][0]['path'] ?? 'https://source.unsplash.com/random/640%C3%97480?party',
        ];
    }
}
