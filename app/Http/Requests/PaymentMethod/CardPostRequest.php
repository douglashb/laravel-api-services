<?php

namespace App\Http\Requests\PaymentMethod;

use App\Libraries\ApiErrorCode;
use App\Libraries\ResponseHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardExpirationMonth;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardNumber;

class CardPostRequest extends FormRequest
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
            'number' => ['required', new CardNumber],
            'exp_year' => ['required', new CardExpirationYear($this->request->get('exp_month'))],
            'exp_month' => ['required', new CardExpirationMonth($this->request->get('exp_year'))],
            'cvc' => ['required', new CardCvc($this->request->get('number'))],
            'city' => 'required|string',
            'address_1' => 'required|string',
            'address_2' => 'string|string|nullable',
            'postal_code' => 'required|numeric',
            'state' => 'required|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ResponseHandler::badRequest(ApiErrorCode::INVALID_DATA, $validator->errors()->first()));
    }
}
