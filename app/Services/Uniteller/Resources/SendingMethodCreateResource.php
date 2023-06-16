<?php

namespace App\Services\Uniteller\Resources;

use App\Services\Uniteller\Traits\UnitellerAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class SendingMethodCreateResource extends JsonResource
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
            'sendingMethodName' => $this['type'],
            'bankName' => $this['bank_name'] ?? null,
            'accountType' => $this['account_type'] ?? null,
            'routingNumber' => $this['routing_number'] ?? null,
            'accountNumber' => $this['account_number'] ?? null,
            'billingPhone' => $this['phone'],
            'cardType' => $this['brand'] ?? null,
            'cardNumber' => $this['card_number'] === null ? null : str_replace(' ', '', $this['card_number']),
            'expireDate' => $this['expiration_month'] === null ? null : $this['expiration_month'] . $this['expiration_year'],
            'cvvNumber' => $this['cvv'] ?? null,
            'billingAddress' => new AddressResource($this),
            'allowCreditDebitTwoAmounts' => 'YES',
            'nickName' => $this['nickName'] ?? null,
        ] + self::baseSession();
    }
}
