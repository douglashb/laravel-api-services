<?php

namespace App\Services\Uniteller\Resources;

use App\Services\Uniteller\Traits\UnitellerAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class BankAccountPlaidResource extends JsonResource
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
            'publicToken' => $this['public_token'],
            'institutionId' => $this['account_id'],
            'accountId' => $this['institution_id'],
            'institutionName' => $this['institution_name'],
        ] + self::baseSession();
    }
}
