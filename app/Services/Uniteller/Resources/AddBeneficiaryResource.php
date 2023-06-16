<?php

namespace App\Services\Uniteller\Resources;

use App\Services\Uniteller\Traits\UnitellerAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class AddBeneficiaryResource extends JsonResource
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
        $resource = [
            'beneficiarySummary' => [
                'id' => null,
                'gender' => $this['gender'],
                'emailId' => null,
                'firstName' => $this['firstName'],
                'midName' => $this['midName'] ?? null,
                'lastName' => $this['lastName'] ?? null,
                'secLastName' => $this['secLastName'] ?? null,
                'nickName' => null,
                'accHolderName' => $this['accHolderName'] ?? null,
                'accNumber' => $this['accNumber'] ?? null,
                'accType' => $this['accType'] ?? null,
                'address' => [
                    'address1' => $this['address']['address1'] ?? null,
                    'address2' => null,
                    'city' => $this['address']['city'] ?? null,
                    'state' => $this['address']['state'] ?? null,
                    'stateName' => $this['address']['stateName'] ?? null,
                    'country' => $this['address']['country'] ?? null,
                    'countryISOCode' => $this['address']['countryISOCode'] ?? null,
                    'zipCode' => $this['address']['zipCode'] ?? null,
                ],
                'beneDOB' => null,
                'homePhone' => null,
                'cellPhone' => $this['cellPhone'],
                'workPhone' => null,
                'beneStatus' => null,
                'payer' => $this['payer'] ?? null,
                'receptionMethod' => $this['receptionMethod'],
                'destinationCurrency' => null,
                'destCountryISOCode' => $this['destCountryISOCode'],
                'destCurrencyISOCode' => $this['destCurrencyISOCode'],
                'payerSpecificCode' => $this['payerSpecificCode'] ?? null,
                'payerBranchCode' => $this['payerBranchCode'] ?? null,
                'beneVerification' => null,
                'payerInfo' => null,
                'isCurpVerified' => null,
            ],
        ] + self::baseSession();

        if (isset($this['additionalFieldInfo']) && $this['additionalFieldInfo'] !== '') {
            $resource['additionalFieldInfo'] = $this['additionalFieldInfo'];
        }

        return $resource;
    }
}
