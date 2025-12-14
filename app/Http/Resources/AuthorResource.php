<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
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
            'name' => $this->name,
            'bio' => $this->bio,
            'avatar' => $this->avatar && !str_starts_with($this->avatar, 'http')
                ? \Illuminate\Support\Facades\Storage::url($this->avatar)
                : $this->avatar,
        ];
    }
}
