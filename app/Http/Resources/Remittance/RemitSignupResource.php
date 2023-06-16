<?php

namespace App\Http\Resources\Remittance;

use App\Classes\RemitterPersonalInfo;
use App\Services\Uniteller\Traits\UnitellerAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class RemitSignupResource extends JsonResource
{
    use UnitellerAttributes;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
                'remitterPersonalInfo' => [
                    'emailAddress' => $this['email'],
                    'firstName' => $this['first_name'],
                    'middleName' => $this['middle_name'],
                    'lastName' => $this['first_last_name'],
                    'secondLastName' => $this['second_last_name'],
                    'gender' => $this['gender'],
                    'birthDate' => $this['birth_date'],
                    'cellPhone' => $this['phone'],
                    'workPhone' => null,
                    'homePhone' => null,
                    'address' => [
                        'address1' => $this['address'],
                        'address2' => '',
                        'city' => $this['city'],
                        'country' => '',
                        'countryISOCode' => 'US',
                        'state' => $this['province_state_iso'],
                        'stateName' => $this['province_state'],
                        'zipCode' => $this['zip_code'],
                    ],
                    'destinationCountryISOCode' => $this['destination_country_iso_code'],
                    'optOutAffiliates' => 'NO',
                    'optOutExternal' => 'NO',
                    'optOutWlp' => 'NO',
                    'preferredLanguage' => app()->getLocale()
                ],
                'password' => $this['password'],
                'privacyPolicyAgreement' => 'YES',
                'remiterReferral' => null,
                'userIPAddress' => session('user_remote_address'),
                'agreementLocale' => null,
                'questionId' => config('internal.uniteller.question_id'),
                'answer' => $this['security_answer'],
                'answerHint' => $this['security_answer_hint'],
            ] + self::base();
    }
}
