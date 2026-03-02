@extends('layouts.app')
@section('content')


<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card-stat bg-primary">
            <h3>{{ $stats['total'] }}</h3>
            <p>Total Reservations</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-stat bg-success">
            <h3>{{ $stats['active'] }}</h3>
            <p>Active Stays</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-stat bg-warning">
            <h3>{{ $stats['today'] }}</h3>
            <p>Today</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-stat bg-danger">
            <h3>{{ $stats['checkout'] }}</h3>
            <p>Checkout Today</p>
        </div>
    </div>
</div>


<div class="card shadow-sm vh-100 overflow-auto">
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle" id="reservationTable">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Guest</th>
                    <th>Room</th>
                    <th>Stay</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($reservations as $res)
             <tr class="{{ $res->isCheckedOut() ? 'table-secondary opacity-85' : '' }}">
                    <td>{{ $loop->iteration }}</td>

                    <td>
                        <strong>{{ $res->guest->full_name }}</strong><br>
                        <small class="text-muted">{{ $res->guest->guest_phone }}</small>
                    </td>

                    <td>
                        <span class="badge bg-info">
                            Room {{ $res->room->room_number }}
                        </span><br>
                        <small>{{ ucfirst($res->room->room_class) }}</small>
                    </td>

                    <td>
                        {{ optional($res->stayDetail)->check_in_date?->format('d M Y') }}<br>
                        <small class="text-muted">
                            → {{ optional($res->stayDetail)->check_out_date?->format('d M Y') }}
                            ({{ optional($res->stayDetail)->no_of_nights }} nights)
                        </small>
                    </td>

                    <td>
                        <strong>{{ number_format(optional($res->stayDetail)->total_price, 2) }}</strong><br>
                        <small class="text-{{ optional($res->stayDetail)->balance > 0 ? 'danger' : 'success' }}">
                            Balance: {{ number_format(optional($res->stayDetail)->balance, 2) }}
                        </small>
                    <span class="badge bg-{{ $res->stayDetail->payment_status === 'paid' ? 'success' : 'warning' }}">
                        {{ ucfirst($res->stayDetail->payment_status) }}
                    </span>

                    </td>

                    <td>
                            @if($res->room_res_status === 'confirmed')
                                <span class="badge bg-success">
                                    <i class="fa fa-check-circle me-1"></i> Confirmed
                                </span>
                            @elseif($res->room_res_status === 'checked_out')
                                <span class="badge bg-secondary">
                                    <i class="fa fa-door-closed me-1"></i> Checked Out
                                </span>
                            @elseif($res->room_res_status === 'cancelled')
                                <span class="badge bg-danger">
                                    <i class="fa fa-times-circle me-1"></i> Cancelled
                                </span>
                            @else
                                <span class="badge bg-light text-dark">
                                    {{ ucfirst($res->room_res_status) }}
                                </span>
                            @endif
                        </td>



                    <td class="text-center">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                           <ul class="dropdown-menu dropdown-menu-end">
                            {{-- Cancel button only if not checked out and not already cancelled or paid --}}
                            @if(!$res->isCheckedOut() && $res->room_res_status !== 'cancelled' && optional($res->stayDetail)->payment_status !== 'paid')
                            <li>
                                <a href="javascript:void(0)" 
                                   class="dropdown-item text-danger cancel-reservation"
                                   data-id="{{ $res->id }}"
                                   data-url="{{ route('reservations.cancel', $res->id) }}">
                                    <i class="fa fa-times-circle me-2"></i> Cancel Reservation
                                </a>
                            </li>
                            @endif

                            {{-- View Details always available --}}
                            <li>
                                <a href="javascript:void(0)"
                                   class="dropdown-item text-primary view-reservation"
                                   data-id="{{ $res->id }}"
                                   data-url="{{ route('reservations.show', $res->id) }}">
                                    <i class="fa fa-eye me-2"></i> View Details
                                </a>
                            </li>

                            {{-- Checkout only if not cancelled or already checked out --}}
                            <li>
                                @if($res->isCheckedOut() || $res->room_res_status === 'cancelled')
                                    <span class="dropdown-item text-muted disabled" style="cursor:not-allowed">
                                        <i class="fa fa-door-closed me-2"></i> Checkout
                                    </span>
                                @else
                                    <a href="javascript:void(0)" 
                                       class="dropdown-item text-primary checkout"
                                       data-id="{{ $res->id }}"
                                       data-url="{{ route('checkout', $res->id) }}">
                                        <i class="fa fa-door-open me-2"></i> Checkout
                                    </a>
                                @endif
                            </li>

                            {{-- Invoice only if not cancelled --}}
                            <li>
                               @if($res->room_res_status === 'cancelled')
                                   <span class="dropdown-item text-muted disabled" style="cursor:not-allowed">
                                       <i class="fa fa-file-invoice me-2"></i> Invoice
                                   </span>
                               @else
                                   <a class="dropdown-item text-info"
                                       target="_blank"
                                       href="{{ route('reservations.invoice', $res->id) }}">
                                        <i class="fa fa-file-invoice me-2"></i> Invoice
                                    </a>
                               @endif
                            </li>

                            {{-- Add Payment only if not cancelled and balance > 0 --}}
                            @if(optional($res->stayDetail)->balance > 0 && $res->room_res_status !== 'cancelled')
                            <li>
                                <a href="javascript:void(0)"
                                   class="dropdown-item text-success pay-btn"
                                   data-id="{{ $res->stayDetail->id }}">
                                    <i class="fa fa-money-bill me-2"></i> Add Payment
                                </a>
                            </li>
                            @endif

                        </ul>

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

      
    </div>
</div>



<div class="modal fade" id="viewReservationModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa fa-eye me-2"></i> Reservation Details
                </h5>
                <button type="button" class="btn-close Close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div id="reservationViewContent" class="text-center text-muted py-4">
                    Loading...
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm Close" data-bs-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="paymentModal">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6>Add Payment</h6>
            </div>
            <div class="modal-body">
                <input type="number" id="payAmount" class="form-control" placeholder="Amount">
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-sm" id="confirmPay">Pay</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
      
      var table=new DataTable('#reservationTable',{
          
          lengthMenu:[
            [5,10,25,50,100,500,'All'],
            [5,10,25,50,100,500,-1]
            ],

      });



	// Checkout AJAX
	
// Setup CSRF for AJAX
$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });



$(document).on('click', '.checkout.disabled', function(e){
    e.preventDefault();
});
	
	$(document).on('click', '.checkout', function(){
    let url = $(this).data('url');

    Swal.fire({
        title: 'Confirm Checkout?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Checkout',
    }).then((result) => {
        if(result.isConfirmed){
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    _token: '{{ csrf_token() }}' // CSRF token
                },
                success: function(res){
                    if(res.success){
                        Swal.fire('Checked Out!', res.message, 'success').then(() => location.reload());
                    } else {
                        Swal.fire('Error', res.message || 'Something went wrong', 'error');
                    }
                },
                error: function(xhr){
                    Swal.fire('Error', xhr.responseJSON?.message || 'Server error', 'error');
                }
            });
        }
    });
});



  $('.Close').click(function () {
        $('#viewReservationModal').modal('hide');
    }); 

$(document).on('click', '.view-reservation', function () {
    let url = $(this).data('url');

    $('#reservationViewContent').html('Loading...');
    $('#viewReservationModal').modal('show');

    $.get(url, function (html) {
        $('#reservationViewContent').html(html);
    }).fail(function () {
        $('#reservationViewContent').html(
            '<div class="text-danger text-center">Failed to load data</div>'
        );
    });
});



// Cancel Reservation
$(document).on('click', '.cancel-reservation', function () {
    let url = $(this).data('url');

    Swal.fire({
        title: 'Confirm Cancellation?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Cancel it',
        cancelButtonText: 'No, Keep it'
    }).then((result) => {
        if(result.isConfirmed){
            $.post(url, { _token: '{{ csrf_token() }}' }, function(res){
                if(res.success){
                    Swal.fire('Cancelled!', res.message, 'success')
                        .then(() => location.reload());
                } else {
                    Swal.fire('Error', res.message || 'Something went wrong', 'error');
                }
            }).fail(function(xhr){
                Swal.fire('Error', xhr.responseJSON?.message || 'Server error', 'error');
            });
        }
    });
});




/*payment*/

let stayId = null;

$(document).on('click', '.pay-btn', function () {
    stayId = $(this).data('id');
    $('#paymentModal').modal('show');
});
$('#confirmPay').click(function () {
    let amount = $('#payAmount').val();

    // Use route name from Blade
    let url = "{{ route('payments.update', ':id') }}";
    url = url.replace(':id', stayId);

    $.post(url, { amount, _token: '{{ csrf_token() }}' }, function (res) {
        if (res.success) {
            Swal.fire('Success', res.message, 'success')
                .then(() => location.reload());
        }
    }).fail(function(xhr) {
        Swal.fire('Error', xhr.responseJSON?.message || 'Server error', 'error');
    });
});



})
</script>
@endsection