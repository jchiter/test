<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'login' => [
                'required',
                'string',
                'regex:/^\+7[0-9]{10}|([a-z0-9+-]+)(.[a-z0-9+-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/'
            ],
            'password' => ['required', 'string'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => trans('request.parameters'),
            'errors' => $validator->errors(),
        ], Response::HTTP_BAD_REQUEST));
    }
}
