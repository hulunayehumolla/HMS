<div class="row g-3">

    {{-- Guest & Room --}}
    <div class="col-md-6">
        <div class="border rounded p-3 h-100">
            <h6 class="text-muted mb-2">
                <i class="fa-solid fa-user me-1"></i> Guest
            </h6>
            <strong>{{ $reservation->guest->full_name }}</strong><br>
            <small class="text-muted">{{ $reservation->guest->guest_phone }}</small>
        </div>
    </div>

    <div class="col-md-6">
        <div class="border rounded p-3 h-100">
            <h6 class="text-muted mb-2">
                <i class="fa-solid fa-door-open me-1"></i> Room
            </h6>
            <strong>Room {{ $reservation->room->room_number }}</strong><br>
            <small class="text-muted">{{ ucfirst($reservation->room->room_class) }}</small>
        </div>
    </div>

    {{-- Stay --}}
    <div class="col-12">
        <div class="border rounded p-3">
            <h6 class="text-muted mb-3">
                <i class="fa-solid fa-calendar-days me-1"></i> Stay Details
            </h6>

            <div class="row text-center">
                <div class="col-md-4">
                    <div class="fw-bold">{{ $reservation->stayDetail?->check_in_date?->format('d M Y') }}</div>
                    <small class="text-muted">Check-in</small>
                </div>

                <div class="col-md-4">
                    <div class="fw-bold">{{ $reservation->stayDetail?->check_out_date?->format('d M Y') }}</div>
                    <small class="text-muted">Check-out</small>
                </div>

                <div class="col-md-4">
                    <div class="fw-bold">{{ $reservation->stayDetail?->no_of_nights ?? '-' }}</div>
                    <small class="text-muted">Nights</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Payment --}}
    <div class="col-12">
        <div class="border rounded p-3">
            <h6 class="text-muted mb-3">
                <i class="fa-solid fa-credit-card me-1"></i> Payment
            </h6>

            <div class="row">
                <div class="col-md-3">
                    <small class="text-muted">Price / Night</small>
                    <div class="fw-bold">{{ number_format($reservation->stayDetail?->price_per_night, 2) }}</div>
                </div>

                <div class="col-md-3">
                    <small class="text-muted">Total</small>
                    <div class="fw-bold">{{ number_format($reservation->stayDetail?->total_price, 2) }}</div>
                </div>

                <div class="col-md-3">
                    <small class="text-muted">Advance</small>
                    <div class="fw-bold">{{ number_format($reservation->stayDetail?->advance_payment, 2) }}</div>
                </div>

                <div class="col-md-3">
                    <small class="text-muted">Balance</small>
                    <div class="fw-bold text-{{ $reservation->stayDetail?->balance > 0 ? 'danger' : 'success' }}">
                        {{ number_format($reservation->stayDetail?->balance, 2) }}
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <small class="text-muted">Payment Method</small>
                    <div class="fw-bold">
                        {{ ucfirst($reservation->stayDetail?->payment_method ?? 'N/A') }}
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <small class="text-muted">Payment Status</small><br>
                    <span class="badge bg-{{ $reservation->stayDetail?->payment_status === 'paid' ? 'success' : 'warning' }}">
                        {{ ucfirst($reservation->stayDetail?->payment_status ?? 'unpaid') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Reservation Meta --}}
    <div class="col-12">
        <div class="border rounded p-3">
            <h6 class="text-muted mb-3">
                <i class="fa-solid fa-circle-info me-1"></i> Reservation Info
            </h6>

            <div class="row">
                <div class="col-md-4">
                    <small class="text-muted">Reserved On</small>
                    <div class="fw-bold">
                        {{ $reservation->room_res_date?->format('d M Y, h:i A') }}
                    </div>
                </div>

                <div class="col-md-4">
                    <small class="text-muted">Source</small>
                    <div class="fw-bold">
                        {{ ucfirst($reservation->room_res_source ?? 'N/A') }}
                    </div>
                </div>

                <div class="col-md-4">
                    <small class="text-muted">Recorded By</small>
                    <div class="fw-bold">
                        {{ $reservation->stayDetail?->recorded_by ?? 'System' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Status --}}
    <div class="col-12 text-end">
        <span class="badge fs-6 bg-{{ $reservation->room_res_status === 'confirmed' ? 'success' : 'secondary' }}">
            {{ ucfirst(str_replace('_', ' ', $reservation->room_res_status)) }}
        </span>
    </div>

</div>
