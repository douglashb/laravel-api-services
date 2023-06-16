<?php

namespace App\Http\Requests\Remittance;

use App\Libraries\ApiErrorCode;
use App\Libraries\ResponseHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RemitQuotePostRequest extends FormRequest
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
            'dest_country_iso_code' => 'required|string|between:2,2',
            'dest_currency_iso_code' => 'required|string|between:3,3',
            'transaction_amount' => 'required|numeric',
            'payer_specific_code' => 'required|string|between:2,32',
            'sending_method_name' => 'required|string|in:Bank Account,Credit Card,Debit Card',
            'reception_method_name' => 'required|string|in:Account Credit,Cash Pickup,WALLET',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ResponseHandler::badRequest(ApiErrorCode::INVALID_DATA, $validator->errors()->first()));
    }
}
