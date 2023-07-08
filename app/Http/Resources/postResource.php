<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class postResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
        [
            'id'=>$this->id,
            'title'=>$this->title,
            'body'=>$this->body,
            'image'=>$this->image,
            'url'=>url(public_path('Upload'.$this->D_S.'Images'.$this->D_S.'PostImages'.$this->D_S).$this->image),
            'Pinned'=>$this->Pinned
        ];
    }
}
