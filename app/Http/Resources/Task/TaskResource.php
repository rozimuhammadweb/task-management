<?php

namespace App\Http\Resources\Task;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'deadline' => $this->deadline,
            'creator' => [
                'id' => $this->creator?->id,
                'name' => $this->creator?->name,
                'username' => $this->creator?->username,
            ],
            'assigned_users' => UserResource::collection(
                $this->whenLoaded('assignedUsers')
            ),
            'comments' => TaskCommentResource::collection(
                $this->whenLoaded('comments')
            ),
            'histories' => TaskHistoryResource::collection(
                $this->whenLoaded('histories')
            ),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
