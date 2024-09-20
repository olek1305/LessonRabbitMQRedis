<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
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
            // Only include pivot if it exists
            'pivot' => $this->when($this->pivot, [
                'role_id' => $this->pivot->role_id ?? null,
                'permission_id' => $this->pivot->permission_id ?? null,
            ]),
        ];
    }


}
