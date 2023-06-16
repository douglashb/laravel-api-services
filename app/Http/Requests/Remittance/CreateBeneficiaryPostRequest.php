<?php

namespace App\Http\Requests\Remittance;

use App\Libraries\ApiErrorCode;
use App\Libraries\ResponseHandler;
use App\Rules\LettersAndNumbersOnly;
use App\Rules\NamesWithSpace;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CreateBeneficiaryPostRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'gender' => 'required|string|in:M,F',
            'firstName' => [
                'required',
                'string',
                'between:3,32',
                new NamesWithSpace(),
            ],
            'midName' => [
                'nullable',
                'string',
                'between:3,32',
                new NamesWithSpace(),
            ],
            'lastName' => [
                'required',
                'string',
                'between:3,32',
                new NamesWithSpace(),
            ],
            'secLastName' => [
                'nullable',
                'string',
                'between:3,32',
                new NamesWithSpace(),
            ],
            'accHolderName' => [
                Rule::requiredIf($this->request->get('receptionMethod') === 'Account Credit'),
                'nullable',
            ],
            'accNumber' => [
                Rule::requiredIf($this->request->get('receptionMethod') === 'Account Credit'),
                'nullable',
            ],
            'accType' => [
                'nullable',
            ],
            'address.address1' => [
                'required',
                new LettersAndNumbersOnly(),
                'string',
                'between:3,60',
            ],
            'address.city' => 'required|string|between:3,60',
            'address.state' => 'required|string|between:2,6',
            'address.stateName' => 'required|string|between:3,60',
            'address.country' => 'required|string|between:3,60',
            'address.countryISOCode' => 'required|string|between:2,2',
            'address.zipCode' => 'required|digits_between:4,7',
            'cellPhone' => 'required|digits_between:8,15',
            'payer' => 'required|string|max:32',
            'receptionMethod' => 'required|string|in:Account Credit,Cash Pickup,WALLET',
            'destCountryISOCode' => 'required|string|between:2,2',
            'destCurrencyISOCode' => 'required|string|between:3,3',
            'payerSpecificCode' => 'required|string|between:3,16',
            'payerBranchCode' => 'string|between:3,25|nullable',
            'payerInfo' => 'nullable',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ResponseHandler::badRequest(ApiErrorCode::INVALID_DATA, $validator->errors()->first()));
    }
}
