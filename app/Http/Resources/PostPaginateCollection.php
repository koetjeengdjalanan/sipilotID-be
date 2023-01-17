<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PostPaginateCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'per_page'          => $this->perPage(),
            'total'             => $this->total(),
            'current_page'      => $this->currentPage(),
            'last_page'         => $this->lastPage(),
            'last_page_url'     => $this->url($this->lastPage()),
            'next_page_url'     => $this->nextPageUrl(),
            'previous_page_url' => $this->previousPageUrl(),
            'first_page_url'    => $this->url(1),
            'from'              => $this->firstItem(),
            'to'                => $this->lastItem(),
            'path'              => $this->resource->toArray()['path'],
            'items'             => PostResource::collection($this->collection)->jsonSerialize(),
        ];
    }
}
