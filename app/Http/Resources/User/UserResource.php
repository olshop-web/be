<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'email'=>$this->email,
            'image'=>$this->image,
            'image_original'=>$this->image_original,
            'name'=>$this->name,
            'status'=>$this->status,
            'telp'=>$this->telp,
            'products'=>$this->whenLoaded('product', $this->product),
        ];
    }
}
