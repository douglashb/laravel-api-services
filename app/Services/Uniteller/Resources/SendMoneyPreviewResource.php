<?php

namespace App\Services\Uniteller\Resources;

use App\Services\Uniteller\Traits\UnitellerAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class SendMoneyPreviewResource extends JsonResource
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
            'beneficiaryId' => $this['beneficiary_id'],
            'sendingMethodId' => $this['sending_method_id'],
            'sendingMethodName' => $this['sending_method_name'],
            'transactionAmount' => $this['transaction_amount'],
            'transactionCurrencyId' => $this['transaction_currency_id'] ?? null,
            'transactionCurrencyISOCode' => 'USD',
        ] + self::baseSession();
    }
}
