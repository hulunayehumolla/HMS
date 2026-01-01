<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /* it was return false;*/
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'userId' => ['required', 'max:255'],
            'userFname' => ['required',  'max:255'],
            'userMname' => ['required',  'max:255'],
            'userLname' => ['required',  'max:255'],
            'username' => ['required',   'max:255', 'unique:users'],
            'password' => ['required', 'string',  'confirmed'],
        ];
    }
}
