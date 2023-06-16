<?php

namespace App\Http\Requests\Profile;

use App\Libraries\ApiErrorCode;
use App\Libraries\ResponseHandler;
use App\Rules\NamesInPassword;
use App\Rules\ValidatePassword;
use App\Rules\VerifyPassword;
use App\Rules\VerifyRepeatedPassword;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChangePasswordPutRequest extends FormRequest
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
            'old_password' => [
                'required',
                'string',
                new VerifyPassword(),
            ],
            'password' => [
                'required',
                'string',
                'between:8,20',
                new ValidatePassword(),
                new VerifyRepeatedPassword(),
                new NamesInPassword(auth()->user())
            ],
            'code' => [
                'present',
                'digits:6',
                'nullable',
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ResponseHandler::badRequest(ApiErrorCode::INVALID_DATA, $validator->errors()->first()));
    }
}
