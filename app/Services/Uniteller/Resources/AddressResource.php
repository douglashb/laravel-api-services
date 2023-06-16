<?php

namespace App\Services\Uniteller\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'address1' => $this['address'],
            'address2' => '',
            'country' => $this['country'],
            'countryISOCode' => $this['countryISOCode'] ?? null,
            'city' => $this['city'],
            'state' => $this['state_iso_code'],
            'stateName' => $this['state_name'],
            'zipCode' => $this['zip_code'],
        ];
    }
}
