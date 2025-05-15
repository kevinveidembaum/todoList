<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'description'   => $this->description,
            'is_completed'  => $this->is_completed,
            'created_at'    => Carbon::parse($this->created_at)->format('d/m/Y H:i'),
            'updated_at'    => Carbon::parse($this->updated_at)->format('d/m/Y H:i'),
        ];
    }
}
