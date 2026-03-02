<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $fillable = [
        'invoice_number',
        'patient_id',
        'invoice_items_id',
        'invoice_date',
        'due_date',
        'status',
        'subtotal',
        'tax_percentage',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'paid_amount',
        'payment_method',
        'payment_for',
        'payment_status',
        'quantity',
        'transaction_reference',
        'payment_date',
    ];

    protected $casts = [
        'invoice_date'   => 'date',
        'due_date'       => 'date',
        'payment_date'   => 'datetime',
        'subtotal'       => 'decimal:2',
        'tax_percentage' => 'decimal:2',
        'tax_amount'     => 'decimal:2',
        'discount_amount'=> 'decimal:2',
        'total_amount'   => 'decimal:2',
        'paid_amount'    => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Invoice belongs to Patient
    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }

    // Invoice belongs to InvoiceItem
    public function invoiceItem()
    {
        return $this->belongsTo(\App\Models\InvoiceItem::class, 'invoice_items_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Auto Logic
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {

            // Auto Invoice Number
            if (!$invoice->invoice_number) {
                $invoice->invoice_number = 'INV-' . strtoupper(Str::random(6));
            }
        });

        static::saving(function ($invoice) {

            // If linked to invoice item, calculate subtotal
            if ($invoice->invoiceItem) {

                $invoice->subtotal =
                    $invoice->invoiceItem->quantity *
                    $invoice->invoiceItem->unit_price;
            }

            // Tax
            $invoice->tax_amount =
                ($invoice->subtotal * $invoice->tax_percentage) / 100;

            // Final Total
            $invoice->total_amount =
                $invoice->subtotal +
                $invoice->tax_amount -
                $invoice->discount_amount;

            // Payment Status
            if ($invoice->paid_amount >= $invoice->total_amount) {
                $invoice->payment_status = 'Paid';
                $invoice->status = 'Paid';
            } elseif ($invoice->paid_amount > 0) {
                $invoice->payment_status = 'Partial';
                $invoice->status = 'Partially Paid';
            } else {
                $invoice->payment_status = 'Unpaid';
                $invoice->status = 'Pending';
            }
        });
    }
}