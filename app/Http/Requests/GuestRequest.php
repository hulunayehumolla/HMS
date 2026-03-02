<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'guest_id_type'   => 'required|string|max:50',
            'guest_id_number' => 'required|string|max:100',
            'guest_fname'     => 'required|string|max:100',
            'guest_mname'     => 'nullable|string|max:100',
            'guest_lname'     => 'required|string|max:100',
            'guest_sex'       => 'required|in:Male,Female',
            'guest_phone'     => 'required|string|max:20',
            'guest_email'     => 'nullable|email',
            'guest_country'   => 'required|string|max:100',
            'guest_region'    => 'nullable|string|max:100',
            'guest_town'      => 'nullable|string|max:100',
            'guest_reg_date'  => 'sometimes|date',
            'guest_reg_by'    => 'sometimes|string|max:100',
        ];
    }
}
