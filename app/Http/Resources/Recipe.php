<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Recipe extends JsonResource
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
            'id'              => $this->id,
            'name'            => $this->name,
            'type'            => $this->type,
            'cuisine'         => $this->cuisine,
            'ingredients'     => $this->ingredients,
            'directions'      => $this->directions,
            'notes'           => $this->notes ?? '',
            'calories'        => $this->calories ?? '',
            'created_at'      => date('F d, Y H:is', strtotime($this->created_at)),
        ];
    }
}
