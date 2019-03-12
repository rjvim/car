<?php

namespace Betalectic\Permiso\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Permission extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
            'entity_type' => $this->entity_type,
            'meta' => json_decode($this->meta),
        ];
    }
}
