<?php

namespace App\Services\Uniteller\Classes;

use App\Libraries\ApiErrorCode;
use App\Libraries\ResponseHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CountryStates extends Base
{
    public string $countryISOCode;

    /**
     * @param string $country_iso_code
     */
    public function setCountryIsoCode(string $country_iso_code): void
    {
        $this->countryISOCode = $country_iso_code;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ResponseHandler::badRequest(ApiErrorCode::INVALID_DATA, $validator->errors()->first()));
    }
}
