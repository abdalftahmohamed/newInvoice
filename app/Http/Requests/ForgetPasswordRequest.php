<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        //sometimes if token sended to the requst as th rquest has a key token so it is rquesd and min 5 else it scape all rules after sometimes
        return [
            'token' =>'sometimes|required|min:5',
            'email' => 'required|email'
        ];
    }
}
