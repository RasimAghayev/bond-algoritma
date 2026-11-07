<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseOrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'bond_id' => $this->bond_id,
            'order_date' => $this->order_date,
            'number_bonds_received' => (float) $this->number_bonds_received,
            'bond' => new BondResource($this->whenLoaded('bond')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
