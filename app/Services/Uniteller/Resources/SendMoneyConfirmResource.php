<?php

namespace App\Services\Uniteller\Resources;

use App\Services\Uniteller\Traits\UnitellerAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class SendMoneyConfirmResource extends JsonResource
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
            'transactionInternalReference' => $this['transaction_internal_reference'],
            'promotionCode' => $this['promotion_code'] ?? null,
            'uicReceiptMode' => $this['uic_receipt_mode'] ?? null,
            'uic' => $this['uic'] ?? null,
        ] + self::baseSession();
    }
}
