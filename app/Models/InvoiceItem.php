<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    // Table name (optional if Laravel can infer)
    protected $table = 'invoice_items';

    // Fillable fields for mass assignment
    protected $fillable = [
        'invoice_items_id',
        'service_name',
        'category',
        'unit_price',
        'total_price',
    ];

    // Optional: if you want to define a relationship to Invoice
    // Note: Your migration does NOT have invoice_id, so this is optional
      public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}