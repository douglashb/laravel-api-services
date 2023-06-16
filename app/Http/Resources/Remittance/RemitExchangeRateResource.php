<?php

namespace App\Http\Resources\Remittance;

use App\Services\Uniteller\Traits\UnitellerAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class RemitExchangeRateResource extends JsonResource
{
    use UnitellerAttributes;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'countryIsoCode' => $this['country_iso_code'],
            'currencyIsoCode' => $this['currency_iso_code'],
        ] + self::base();
    }
}
