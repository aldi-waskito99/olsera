<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id_pajak' => $this->pajak_id,
            'nama pajak' => $this->nama_pajak,
            'rate' => $this->rate,
        ];
    }
}
