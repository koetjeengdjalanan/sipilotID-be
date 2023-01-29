<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class PostResource extends JsonResource
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
            'id'           => $data['id'],
            'title'        => $data['title'],
            'thumbnail'    => $this->media->pluck('path'),
            'slug'         => $data['slug'],
            'published_at' => $data['published_date'],
            'updated_at'   => $data['updated_at'],
            'author'       => new AuthorResource($data['author']),
            'category'     => new CategoryResource($data['category']),
            'tags'         => TagResource::collection($data['tags']),
            'excerpt'      => Str::limit($data['excerpt'], 300),
            'body'         => $data['body'],
        ];
    }
}
