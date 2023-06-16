<?php

namespace App\Http\Requests\Profile;

use App\Libraries\ApiErrorCode;
use App\Libraries\ResponseHandler;
use App\Rules\EmailFormat;
use App\Rules\EmailVerification;
use App\Rules\NamesInPassword;
use App\Rules\PasswordVerification;
use App\Rules\UniquePhone;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAccountPostRequest extends FormRequest
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
            'first_name' => [
                'required',
                'string',
                'between:3,16',
                'regex:/^[A-ZÁÉÍÓÚÑa-záéíóúñ]+$/',
            ],
            'middle_name' => 'present|string|between:3,32|regex:/^[A-ZÁÉÍÓÚÑa-záéíóúñ]+$/|nullable',
            'first_last_name' => [
                'required',
                'string',
                'between:3,16',
                'regex:/^[A-ZÁÉÍÓÚÑa-záéíóúñ]+$/',
            ],
            'second_last_name' => 'present|string|between:3,32|regex:/^[A-ZÁÉÍÓÚÑa-záéíóúñ]+$/|nullable',
            'phone' => [
                'required',
                'digits_between:8,14',
                new UniquePhone(),
//                new LookupPhone($this->request->merchant),
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:20',
                new PasswordVerification(),
                new NamesInPassword($this->request->all()),
            ],
            'email' => [
                'required',
                'between:3,128',
                new EmailFormat(),
                'unique:profile_users,email',
                new EmailVerification(),
            ],
            'province_state' => 'required|string|between:3,64',
            'province_state_iso' => 'required|string|between:2,2',
            'city' => 'required|string|between:3,64',
            'platform' => 'required|in:android,web,ios',
            'ip_address' => 'required|ip',
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => __('email.registered'),
            'phone.digits_between' => __('phone.format'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ResponseHandler::badRequest(ApiErrorCode::INVALID_DATA, $validator->errors()->first()));
    }
}
