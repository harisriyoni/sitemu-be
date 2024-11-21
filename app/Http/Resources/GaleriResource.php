<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GaleriResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type_galeri_id' => $this->type_galeri_id,
            'image_url' => asset('storage/' . $this->image),
            'title_image' => $this->title_image,
        ];
    }
}
