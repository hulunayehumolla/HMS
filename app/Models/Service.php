<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'service_name',
        'service_class',
        'service_type',
        'service_category',
        'service_status',
        'service_photo',
        'service_description',
    ];

    /*
    |--------------------------------------------------------------------------
    | Accessors (Optional)
    |--------------------------------------------------------------------------
    */

    public function getIsPaidAttribute(): bool
    {
        return $this->service_type === 'paid';
    }

    public function getIsAvailableAttribute(): bool
    {
        return $this->service_status === 'available';
    }
}
