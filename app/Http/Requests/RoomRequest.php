<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_number'     => 'required|string|max:50|unique:rooms,room_number,' . ($this->room?->id ?? ''),
            'room_type'       => 'required|in:single,double',
            'room_status'     => 'required|in:available,booked,maintenance',
            'room_class'      => 'required|in:normal,vip,luxury',
            'room_price'      => 'required|numeric|min:0',
            'room_is_cleaned' => 'boolean',
            'room_services'   => 'nullable|array',
            'room_services.*' => 'string|in:wifi,tv,minibar,ac,balcony',
            'room_photos.*'   => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'room_services' => $this->room_services ?? [],
            'room_is_cleaned' => $this->has('room_is_cleaned') ? (bool) $this->room_is_cleaned : false,
        ]);
    }
}
