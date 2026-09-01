<?php

namespace Automobile\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'variant_id' => $this->variant_id,
            'fuel_type' => $this->fuel_type,
            'body_type' => $this->body_type,
            'seating_capacity' => $this->seating_capacity,
            'launch_date' => $this->launch_date?->toDateString(),
            'discontinue_date' => $this->discontinue_date?->toDateString(),
            'details' => $this->details,
            'variant' => new VariantResource($this->whenLoaded('variant')),
            'parts' => PartResource::collection($this->whenLoaded('parts')),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
