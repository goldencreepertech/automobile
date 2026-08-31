<?php

namespace Automobile\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleModelResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'manufacturer_id' => $this->manufacturer_id,
            'name' => $this->name,
            'manufacturer' => new ManufacturerResource($this->whenLoaded('manufacturer')),
            'variants' => VariantResource::collection($this->whenLoaded('variants')),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
