<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_task' => $this->id_task,
            'title' => $this->title,
            'description' => $this->description,
            'id_status' => $this->id_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}