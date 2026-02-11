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
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'role' => $this->whenLoaded('roles', function () {
                return $this->roles->first()?->name;
            }),
            'pivot' => $this->whenPivotLoaded('task_users', function () {
                return [
                    'assigned_by' => $this->pivot->assigned_by,
                    'assigned_at' => $this->pivot->assigned_at,
                ];
            }),
        ];
    }
}
