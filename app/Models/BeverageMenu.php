<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeverageMenu extends Model
{
    protected $table = 'beverage_menus';

    protected $fillable = [
        'name',
        'class',
        'type',
        'description',
        'photo',
        'price',
        'recorded_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function getIsAlcoholicAttribute(): bool
    {
        return $this->class === 'alcoholic';
    }

    public function getIsHotAttribute(): bool
    {
        return $this->class === 'hot';
    }

    public function getIsColdAttribute(): bool
    {
        return $this->class === 'cold';
    }
}
