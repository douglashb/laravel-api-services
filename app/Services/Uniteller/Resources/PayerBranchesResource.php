<?php

namespace App\Services\Uniteller\Resources;

use App\Services\Uniteller\Traits\UnitellerAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class PayerBranchesResource extends JsonResource
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
            'payerSpecificCode' => $this['payer_specific_code'],
            'countryISOCode' => $this['country_iso_code'],
            'currencyISOCode' => $this['currency_iso_code'],
            'receptionMethodName' => $this['reception_method_name'],
            'stateISOCode' => $this['state_iso_code'],
            'city' => $this['city'] ?? null,
            'address' => $this['address'] ?? null,
        ] + self::base();
    }
}
