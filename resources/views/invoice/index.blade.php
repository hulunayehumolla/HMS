@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Dashboard Cards --}}
    <div class="row g-3 mb-4">
        @php
            $cards = [
                ['label'=>'Total Invoices','value'=>$stats['total_invoices'] ?? 0,'icon'=>'fa-file-invoice','bg'=>'bg-dark text-white'],
                ['label'=>'Total Revenue','value'=>$stats['total_revenue'] ?? 0,'icon'=>'fa-dollar-sign','bg'=>'bg-success text-white'],
            ];
        @endphp

        @foreach($cards as $card)
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3 px-3 d-flex align-items-center">
                    <div class="icon-box {{ $card['bg'] }} me-3">
                        <i class="fa-solid {{ $card['icon'] }}"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">{{ $card['label'] }}</small>
                        <h5 class="fw-bold mb-0">{{ $card['value'] }}</h5>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Invoice Tabs --}}
    <ul class="nav nav-tabs mb-3" id="invoiceTab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#viewInvoices">
                <i class="fa-solid fa-eye me-1"></i> View Invoices
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#addInvoice">
                <i class="fa-solid fa-plus me-1"></i> Add Invoice
            </button>
        </li>
    </ul>

    <div class="tab-content">

        {{-- View Invoices --}}
        <div class="tab-pane fade show active" id="viewInvoices">
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Invoice No</th>
                                <th>Patient</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->patient->first_name ?? '' }} {{ $invoice->patient->last_name ?? '' }}</td>
                                <td>{{ $invoice->total_amount }}</td>
                                <td>{{ $invoice->paid_amount }}</td>
                                <td>
                                    <span class="badge bg-{{ $invoice->payment_status=='Paid' ? 'success' : ($invoice->payment_status=='Partial' ? 'warning' : 'secondary') }}">
                                        {{ $invoice->payment_status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>

        {{-- Add Invoice --}}
        <div class="tab-pane fade" id="addInvoice">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form id="invoiceForm" action="{{ route('invoice.store') }}" method="POST">
                        @csrf

                        {{-- Patient Info --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Patient</label>
                                <select name="patient_id" class="form-select" required>
                                    <option value="">Select Patient</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Invoice Date</label>
                                <input type="date" name="invoice_date" class="form-control" required>
                            </div>
                        </div>

                        {{-- Invoice Items --}}
                        <h5>Items</h5>
                        <table class="table table-bordered mb-3" id="itemsTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Service Name</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="itemsBody"></tbody>
                        </table>

                        <div class="row g-2 mb-3">
                            <div class="col-md-3">
                                <input type="text" id="item_name" placeholder="Service Name" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="number" id="quantity" placeholder="Qty" value="1" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="number" step="0.01" id="unit_price" placeholder="Unit Price" value="0.00" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="number" step="0.01" id="total_price" placeholder="Total" readonly class="form-control">
                            </div>
                            <div class="col-md-3">
                                <button type="button" id="addItemBtn" class="btn btn-success w-100">Add Item</button>
                            </div>
                        </div>

                        {{-- Tax & Discount --}}
                        <div class="row g-2 mb-3">
                            <div class="col-md-3">
                                <label>Tax %</label>
                                <input type="number" step="0.01" name="tax_percentage" class="form-control" value="0">
                            </div>
                            <div class="col-md-3">
                                <label>Discount</label>
                                <input type="number" step="0.01" name="discount_amount" class="form-control" value="0">
                            </div>
                            <div class="col-md-3">
                                <label>Paid Amount</label>
                                <input type="number" step="0.01" name="paid_amount" class="form-control" value="0">
                            </div>
                            <div class="col-md-3">
                                <label>Payment Method</label>
                                <select name="payment_method" class="form-select">
                                    <option value="Cash">Cash</option>
                                    <option value="Bank">Bank</option>
                                    <option value="Insurance">Insurance</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Save Invoice</button>
                        </div>

                        {{-- Hidden input to store items --}}
                        <input type="hidden" name="items_data" id="items_data">
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    // Item calculation
    const itemName = document.getElementById('item_name');
    const qty = document.getElementById('quantity');
    const unitPrice = document.getElementById('unit_price');
    const totalPrice = document.getElementById('total_price');
    const itemsBody = document.getElementById('itemsBody');
    const itemsData = document.getElementById('items_data');

    function updateTotal() {
        totalPrice.value = ((parseFloat(qty.value) || 0) * (parseFloat(unitPrice.value) || 0)).toFixed(2);
    }

    qty.addEventListener('input', updateTotal);
    unitPrice.addEventListener('input', updateTotal);

    let itemsArray = [];

    document.getElementById('addItemBtn').addEventListener('click', function() {
        if (!itemName.value) return alert('Enter item name');

        const item = {
            name: itemName.value,
            quantity: parseFloat(qty.value) || 0,
            unit_price: parseFloat(unitPrice.value) || 0,
            total: parseFloat(totalPrice.value) || 0,
        };

        itemsArray.push(item);
        itemsData.value = JSON.stringify(itemsArray);

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.name}</td>
            <td>${item.quantity}</td>
            <td>${item.unit_price.toFixed(2)}</td>
            <td>${item.total.toFixed(2)}</td>
            <td><button type="button" class="btn btn-danger btn-sm removeItem">Delete</button></td>
        `;
        itemsBody.appendChild(row);

        row.querySelector('.removeItem').addEventListener('click', () => {
            const index = Array.from(itemsBody.children).indexOf(row);
            itemsArray.splice(index, 1);
            itemsData.value = JSON.stringify(itemsArray);
            row.remove();
        });

        itemName.value = '';
        qty.value = 1;
        unitPrice.value = 0;
        totalPrice.value = 0;
    });
</script>

<style>
    .icon-box {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection