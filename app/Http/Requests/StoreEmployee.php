<?php

namespace App\Http\Requests;

use App\Validators\AddressValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class StoreEmployee extends FormRequest
{
    private function ifUpdateAppendId(string $data)
    {
        return $this->method() == 'PUT'
            ? "$data," . $this->route('employee')
            : $data;
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'date_of_birth' => 'required|date',
            'address1' => 'required',
            'address1' => 'nullable',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
            'email' => $this->ifUpdateAppendId('required|email|unique:employees,email'),
        ];
    }

    public function response(array $errors)
    {
        return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function withValidator($validator)
    {
        return count($validator->errors()) == 0
            ? AddressValidator::validate($validator, $this)
            : $validator;
    }
}
