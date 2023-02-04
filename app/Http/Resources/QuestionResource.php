<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'order'    => $data['order'],
            'question' => $data['question'],
            'type'     => $data['type'],
            'label'    => json_decode($data['label']),
        ];
    }
}
