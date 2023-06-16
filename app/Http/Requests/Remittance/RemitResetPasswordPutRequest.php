<?php

namespace App\Http\Requests\Remittance;

use App\Libraries\ApiErrorCode;
use App\Libraries\ResponseHandler;
use App\Rules\EmailFormat;
use App\Rules\NamesInPassword;
use App\Rules\PasswordVerification;
use App\Rules\PhoneBelongsToEmail;
use App\Rules\VerifyRepeatedPassword;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RemitResetPasswordPutRequest extends FormRequest
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
                new EmailFormat,
                'exists:profile_users,email'
            ],
            'phone' => [
                'required',
                new PhoneBelongsToEmail($this->request->get('email'))
            ],
            'code' => [
                'required',
                'string',
                'min:6',
                'max:6',
            ],
            'password' => [
                'required',
                'string',
                'between:8,20',
                new PasswordVerification,
                new VerifyRepeatedPassword($this->request->get('email')),
                new NamesInPassword([], $this->request->get('email')),
            ],
            'device_type' => 'required|string|in:computer,laptop,table,mobile',
            'device_model' => 'required|string',
            'serial_number' => 'required|string',
            'imei' => 'required|string',
            'udid' => 'required|string'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ResponseHandler::badRequest(ApiErrorCode::INVALID_DATA, $validator->errors()->first()));
    }
}
