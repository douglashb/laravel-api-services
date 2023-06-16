<?php

namespace App\Http\Resources\Remittance;

use App\Services\Uniteller\Traits\UnitellerAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class RemitQuoteExternalResource extends JsonResource
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
            'destCountryISOCode' => $this['dest_country_iso_code'],
            'destCurrencyISOCode' => $this['dest_currency_iso_code'],
            'transactionAmount' => $this['transaction_amount'],
            'payerSpecificCode' => $this['payer_specific_code'],
            'sendingMethodName' => $this['sending_method_name'],
            'receptionMethodId' => null,
            'receptionMethodName' => $this['reception_method_name'],
        ] + self::base();
    }
}
