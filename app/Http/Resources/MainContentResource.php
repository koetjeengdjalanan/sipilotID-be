<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MainContentResource extends ResourceCollection
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
        return collect([
            'id'     => $data['id'],
            'title'  => $data['title'],
            'body'   => $data['body'],
            'image'  => $data['image'],
            'author' => $request->author->pluck('name'),
        ]);
    }
}
