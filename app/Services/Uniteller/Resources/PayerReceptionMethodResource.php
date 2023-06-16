<?php

namespace App\Services\Uniteller\Resources;

use App\Services\Uniteller\Traits\UnitellerAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class PayerReceptionMethodResource extends JsonResource
{
    use UnitellerAttributes;

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
            'countryISOCode' => $this['country_iso_code'],
            'currencyISOCode' => $this['currency_iso_code'],
            'stateISOCode' => $this['state_iso_code'],
        ] + self::base();
    }
}
