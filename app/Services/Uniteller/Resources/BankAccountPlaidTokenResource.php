<?php

namespace App\Services\Uniteller\Resources;

use App\Services\Uniteller\Traits\UnitellerAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class BankAccountPlaidTokenResource extends JsonResource
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
            'sendingMethodId' => $this->sendingMethodId ?? null,
        ] + self::baseSession();
    }
}
