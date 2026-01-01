<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodMenu extends Model
{
    protected $table = 'food_menus';

    protected $fillable = [
        'food_name',
        'food_type',
        'food_content',
        'food_category',
        'food_number_of_person',
        'food_description',
        'food_price',
        'food_photo',
    ];

    protected $casts = [
        'food_price' => 'decimal:2',
        'food_number_of_person' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function getIsFastingAttribute(): bool
    {
        return $this->food_type === 'fasting';
    }

    public function getIsNonFastingAttribute(): bool
    {
        return $this->food_type === 'non_fasting';
    }
}
