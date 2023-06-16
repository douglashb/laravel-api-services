<?php

namespace App\Services\Uniteller\Resources;

use App\Services\Uniteller\Traits\UnitellerAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class BeneficiaryResource extends JsonResource
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
        ] + self::baseSession();
    }
}
