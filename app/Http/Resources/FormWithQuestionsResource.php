<?php

namespace App\Http\Resources;

use Arr;
use Illuminate\Http\Resources\Json\JsonResource;

class FormWithQuestionsResource extends JsonResource
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
        // dd($data);
        return [
            'id'           => $data['id'],
            'title'        => $data['title'],
            'slug'         => $data['slug'],
            'excerpt'      => $data['excerpt'],
            'media'        => MediaResource::collection($data['media'])->jsonSerialize(),
            'publish_date' => $data['publish_date'],
            'expire'       => $data['expire'],
            'questions'    => QuestionResource::collection($data['questions']),
        ];
    }
}
