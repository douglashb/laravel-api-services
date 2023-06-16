<?php

namespace App\Http\Resources\Remittance;

use App\Services\Uniteller\Resources\AddressResource;
use App\Services\Uniteller\Traits\UnitellerAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonalInfoResource extends JsonResource
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
            'cellPhone' => $this['phone'],
            'workPhone' => '',
            'homePhone' => '',
            'sSN' => null,
            'gender' => $this['gender'],
            'userId' => $this['email'],
            'preferredLanguage' => null,
            'address' => new AddressResource($this),
        ] + self::baseSession();
    }
}
