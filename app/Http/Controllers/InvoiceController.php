<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    // List invoices with pagination
    public function index()
    {
        $patients = Patient::all();
        $invoiceItems = InvoiceItem::all(); // To select existing items if needed
        $invoices = Invoice::with('patient', 'invoiceItem') // relationship name in model
                           ->latest()
                           ->paginate(10); // 10 per page

        return view('invoice.index', compact('invoices','patients','invoiceItems'));
    }

    // Show create invoice page
    public function create()
    {
        $patients = Patient::all();
        $invoiceItems = InvoiceItem::all(); // To select existing items if needed
        return view('invoice.create', compact('patients', 'invoiceItems'));
    }

    // Store invoice and invoice item
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'invoice_date' => 'required|date',
            'item_name' => 'required|string',
            'category' => 'nullable|string',
            'quantity' => 'required|numeric|min:1',
            'unit_price' => 'required|numeric|min:0',
            'tax_percentage' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string',
            'payment_for' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Create Invoice Item
            $item = InvoiceItem::create([
                'service_name' => $request->item_name,
                'category' => $request->category ?? 'General',
                'quantity' => $request->quantity,
                'unit_price' => $request->unit_price,
                'total_price' => $request->quantity * $request->unit_price,
            ]);

            // Calculate totals
            $subtotal = $item->total_price;
            $tax_amount = $subtotal * (($request->tax_percentage ?? 0) / 100);
            $total_amount = $subtotal + $tax_amount - ($request->discount_amount ?? 0);

            // Create Invoice
            $invoice = Invoice::create([
                'patient_id' => $request->patient_id,
                'invoice_items_id' => $item->id,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date ?? null,
                'status' => $request->status ?? 'Pending',
                'subtotal' => $subtotal,
                'tax_percentage' => $request->tax_percentage ?? 0,
                'tax_amount' => $tax_amount,
                'discount_amount' => $request->discount_amount ?? 0,
                'total_amount' => $total_amount,
                'paid_amount' => $request->paid_amount ?? 0,
                'payment_method' => $request->payment_method ?? null,
                'payment_for' => $request->payment_for ?? null,
                'payment_status' => $request->paid_amount > 0 ? 'Partial' : 'Unpaid',
            ]);

            DB::commit();

            return redirect()->route('invoices.index')->with('success', 'Invoice created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create invoice: ' . $e->getMessage());
        }
    }

    // Show invoice details
    public function show(Invoice $invoice)
    {
        $invoice->load('patient', 'invoiceItem');
        return view('invoices.show', compact('invoice'));
    }

    // Delete invoice
    public function destroy(Invoice $invoice)
    {
        DB::beginTransaction();
        try {
            // Optional: delete related invoice item
            if ($invoice->invoiceItem) {
                $invoice->invoiceItem->delete();
            }
            $invoice->delete();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Invoice deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}