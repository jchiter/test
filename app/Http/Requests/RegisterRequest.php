<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', Rule::unique(User::class, 'email')],
            'phone' => [
                'required',
                'string',
                Rule::unique(User::class, 'phone'),
                'regex:/^\+7[0-9]{10}$/'
            ],
            'password' => [
                'required',
                'min:6',
                'confirmed',
                'regex:/^.*(?=.*[A-Z]{1,})(?=.*[a-z]{1,})(?=.*[0-9]{1,})(?=.*[$%&!:]{1,}).*$/'
            ]
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
