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
        // return parent::toArray($request);
        return [
            'name'            => $this->name,
            'type'            => $this->type,
            'cuisine'         => $this->cuisine,
            'ingredients'     => $this->ingredients,
            'directions'      => $this->directions,
            'notes'           => $this->notes,
            'nutrition_facts' => $this->points,
            'created_at'      => $this->created_at,
        ];
    }
}
