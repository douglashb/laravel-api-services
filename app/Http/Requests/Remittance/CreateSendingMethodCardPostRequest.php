<?php

namespace App\Http\Requests\Remittance;

use App\Libraries\ApiErrorCode;
use App\Libraries\ResponseHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardExpirationMonth;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardNumber;

class CreateSendingMethodCardPostRequest extends FormRequest
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
            'card_number' => ['required', new CardNumber()],
            'expiration_year' => ['required', new CardExpirationYear($this->request->get('expiration_month'))],
            'expiration_month' => ['required', new CardExpirationMonth($this->request->get('expiration_year'))],
            'cvv' => ['required', new CardCvc($this->request->get('card_number'))],
            'type' => 'required|string|in:Bank Account,Credit Card,Debit Card',
            'brand' => 'required|string|in:Visa,Master Card',
            'phone' => 'required|string|between:8,16',
            'address' => 'required|string|between:3,64',
            'city' => 'required|string|between:3,32',
            'state_name' => 'required|string|between:3,32',
            'state_iso_code' => 'required|string|between:2,2',
            'zip_code' => 'required|string|between:4,6',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ResponseHandler::badRequest(ApiErrorCode::INVALID_DATA, $validator->errors()->first()));
    }
}
