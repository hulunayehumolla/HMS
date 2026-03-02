<?php

namespace App\Http\Controllers;

use App\Models\InvoiceItem;
use Illuminate\Http\Request;

class InvoiceItemController extends Controller
{
    // Show all invoice items with stats
    public function index()
    {
        $invoice_items = InvoiceItem::latest()->paginate(10);

        $stats = [
            'total' => InvoiceItem::count(),
            'total_revenue' => InvoiceItem::sum('total_price'),
        ];

        return view('invoice.indexinvoiceitem', compact('invoice_items', 'stats'));
    }

    // Store a new invoice item (AJAX ready)
    public function store(Request $request)
    {
        $request->validate([
            'invoice_items_id' => 'required|string|unique:invoice_items,invoice_items_id',
            'service_name' => 'required|string',
            'category' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
        ]);

        $item = InvoiceItem::create([
            'invoice_items_id' => $request->invoice_items_id,
            'service_name' => $request->service_name,
            'category' => $request->category,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'total_price' => $request->total_price,
        ]);

        // Return JSON response for AJAX
        return response()->json([
            'success' => true,
            'message' => 'Invoice item added successfully.',
            'item' => $item
        ]);
    }

    // Delete an invoice item (AJAX ready)
    public function destroy(InvoiceItem $invoiceItem)
    {
        $invoiceItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Invoice item deleted successfully.'
        ]);
    }

    // Optional: Update an invoice item (if needed in future)
    public function update(Request $request, InvoiceItem $invoiceItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
        ]);

        $invoiceItem->update([
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'total_price' => $request->total_price,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Invoice item updated successfully.',
            'item' => $invoiceItem
        ]);
    }
}