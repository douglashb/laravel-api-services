<?php

namespace App\Http\Requests\Profile;

use App\Libraries\ApiErrorCode;
use App\Libraries\ResponseHandler;
use App\Rules\EmailFormat;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginPostRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                new EmailFormat(),
            ],
            'password' => [
                'required',
                'string',
                'between:8,20',
            ],
            'platform' => 'required|string|in:android,ios,web',
            'ip_address' => 'required|ip',
            'device_type' => 'required|string|in:computer,laptop,table,mobile',
            'device_model' => 'required|string',
            'serial_number' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => __('email.not_registered'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ResponseHandler::badRequest(ApiErrorCode::INVALID_DATA, $validator->errors()->first()));
    }
}
