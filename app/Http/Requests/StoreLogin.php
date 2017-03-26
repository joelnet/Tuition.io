<?php

namespace App\Http\Requests;

use App\Validators\AddressValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class StoreLogin extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required',
            'password' => 'required',
        ];
    }

    public function response(array $errors)
    {
        return new JsonResponse($errors, Response::HTTP_NO_CONTENT);
    }
}
