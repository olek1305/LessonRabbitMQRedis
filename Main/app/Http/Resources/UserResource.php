<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(Request $request): array
    {
        $user = User::with('role.permissions')->find(auth()->id());

        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            $this->mergeWhen(\Auth::user() && \Auth::user()->isAdmin(), [
                'role' => $this->role,
            ]),
            $this->mergeWhen(\Auth::user() && \Auth::user()->isInfluencer(), [
                'revenue' => $this->revenue,
            ]),
        ];
    }
}
