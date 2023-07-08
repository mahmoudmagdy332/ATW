<?php

namespace App\Http\Requests;

use App\Trait\ApiTrait ;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LoginRequest extends FormRequest
{
    use ApiTrait;
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|max:255',
            'device_name' => 'string|255',
        ];
    }
    public function messages()
    {
        return [
            '*.required' => 'هذا الحقل مطلوب',

        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->send(false,'Validation errors',401,$validator->errors())
            );
    }
}
