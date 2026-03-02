@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Dashboard Cards --}}
    <div class="row g-3 mb-4">
        @php
            $cards = [
                ['label'=>'Total Items','value'=>$stats['total'],'icon'=>'fa-file-invoice','bg'=>'bg-dark text-white'],
                ['label'=>'Total Revenue','value'=>$stats['total_revenue'],'icon'=>'fa-dollar-sign','bg'=>'bg-success text-white'],
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

    {{-- Tabs --}}
    <ul class="nav nav-tabs mb-3" id="invoiceTab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#viewItems">
                <i class="fa-solid fa-eye me-1"></i> View Items
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#addItem">
                <i class="fa-solid fa-plus me-1"></i> Add Item
            </button>
        </li>
    </ul>

    <div class="tab-content">

        {{-- View Items --}}
        <div class="tab-pane fade show active" id="viewItems">
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-bordered table-hover align-middle" id="itemsTable">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Item ID</th>
                                <th>Service Name</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemsBody">
                            @foreach($invoice_items as $item)
                            <tr id="itemRow{{ $item->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->invoice_items_id }}</td>
                                <td>{{ $item->service_name }}</td>
                                <td>{{ $item->category }}</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm qtyInput" data-id="{{ $item->id }}" value="{{ $item->quantity }}" min="1">
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm priceInput" data-id="{{ $item->id }}" value="{{ $item->unit_price }}" step="0.01" min="0">
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm totalInput" data-id="{{ $item->id }}" value="{{ $item->total_price }}" readonly>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm deleteBtn" data-id="{{ $item->id }}">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Add Item --}}
        <div class="tab-pane fade" id="addItem">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form id="addItemForm">
                        @csrf
                        <div class="row g-3 mb-3">
                            <div class="col-md-2">
                                <label>Item ID</label>
                                <input type="text" name="invoice_items_id" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label>Service Name</label>
                                <input type="text" name="service_name" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label>Category</label>
                                <input type="text" name="category" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label>Quantity</label>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label>Unit Price</label>
                                <input type="number" step="0.01" name="unit_price" id="unit_price" value="0.00" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label>Total Price</label>
                                <input type="number" step="0.01" name="total_price" id="total_price" value="0.00" class="form-control" readonly>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Add Item</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // Calculate total price for add item form
    const quantity = document.getElementById('quantity');
    const unitPrice = document.getElementById('unit_price');
    const totalPrice = document.getElementById('total_price');

    function calculateTotal() {
        let qty = parseFloat(quantity.value) || 0;
        let price = parseFloat(unitPrice.value) || 0;
        totalPrice.value = (qty * price).toFixed(2);
    }

    quantity.addEventListener('input', calculateTotal);
    unitPrice.addEventListener('input', calculateTotal);
    calculateTotal();

    // Add item via AJAX
    $('#addItemForm').submit(function(e){
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: "{{ route('invoice_items.store') }}",
            method: "POST",
            data: formData,
            success: function(res){
                let row = `<tr id="itemRow${res.id}">
                    <td>#</td>
                    <td>${res.invoice_items_id}</td>
                    <td>${res.service_name}</td>
                    <td>${res.category}</td>
                    <td><input type="number" class="form-control form-control-sm qtyInput" data-id="${res.id}" value="${res.quantity}" min="1"></td>
                    <td><input type="number" class="form-control form-control-sm priceInput" data-id="${res.id}" value="${res.unit_price}" step="0.01" min="0"></td>
                    <td><input type="number" class="form-control form-control-sm totalInput" data-id="${res.id}" value="${res.total_price}" readonly></td>
                    <td><button class="btn btn-danger btn-sm deleteBtn" data-id="${res.id}">Delete</button></td>
                </tr>`;
                $('#itemsBody').append(row);
                $('#addItemForm')[0].reset();
                calculateTotal();
                alert('Item added successfully!');
            },
            error: function(xhr){
                alert('Error: '+xhr.responseJSON.message ?? 'Something went wrong');
            }
        });
    });

    // Delete item via AJAX
    $('#itemsBody').on('click', '.deleteBtn', function(){
        if(!confirm('Are you sure?')) return;
        let id = $(this).data('id');
        $.ajax({
            url: '/invoice_items/'+id,
            method: 'DELETE',
            data: {_token: "{{ csrf_token() }}"},
            success: function(){
                $('#itemRow'+id).remove();
                alert('Item deleted successfully!');
            },
            error: function(){
                alert('Failed to delete item');
            }
        });
    });

    // Inline update via AJAX
    $('#itemsBody').on('input', '.qtyInput, .priceInput', function(){
        let id = $(this).data('id');
        let row = $('#itemRow'+id);
        let qty = parseFloat(row.find('.qtyInput').val()) || 0;
        let price = parseFloat(row.find('.priceInput').val()) || 0;
        let total = (qty * price).toFixed(2);
        row.find('.totalInput').val(total);

        // Update database after 500ms delay
        clearTimeout(row.data('timeout'));
        row.data('timeout', setTimeout(function(){
            $.ajax({
                url: '/invoice_items/'+id,
                method: 'PUT',
                data: {
                    _token: "{{ csrf_token() }}",
                    quantity: qty,
                    unit_price: price,
                    total_price: total
                },
                success: function(){
                    console.log('Item updated');
                },
                error: function(){
                    alert('Failed to update item');
                }
            });
        }, 500));
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