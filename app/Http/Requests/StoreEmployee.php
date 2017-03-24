<?php

namespace App\Http\Requests;

use App\Validators\AddressValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class StoreEmployee extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $isUpdate = $this->method() == 'PUT';

        return [
            'name' => 'required',
            'date_of_birth' => 'required|date',
            'address1' => 'required',
            'address1' => 'nullable',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
            'email' => 'required|email|unique:employees' . ($isUpdate ? ",$this->get('id')" : ''),
        ];
    }

    public function response(array $errors)
    {
        return new JsonResponse($errors, 422);
    }

    public function withValidator($validator)
    {
        return count($validator->errors()) == 0
            ? AddressValidator::validate($validator, $this)
            : $validator;
    }
}
