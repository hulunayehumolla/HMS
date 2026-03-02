@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <small class="text-muted">Overview of system statistics</small>
        </div>
       <div class="d-flex gap-2">

       <!-- Live Time -->
    <span class="badge bg-success px-3 py-2">
        <i class="fa-solid fa-clock me-1"></i>
        <span id="liveTime"></span>
    </span>
    <!-- Date -->
    <span class="badge bg-primary p-2">
        <i class="fa-solid fa-calendar-days me-1"></i>
        {{ now()->format('d M Y') }}
    </span>


   

        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4">

        @foreach($cards as $card)
        <div class="col-md-4">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-muted mb-1 small">{{ $card['label'] }}</p>
                        <h2 class="fw-bold mb-0">{{ $card['value'] }}</h2>
                    </div>

                    <div class="icon-circle">
                        <i class="fa-solid {{ $card['icon'] }}"></i>
                    </div>

                </div>
            </div>
        </div>
        @endforeach

    </div>

</div>

<!-- Custom Styles -->
<style>
.dashboard-card {
    transition: all 0.3s ease-in-out;
    border-radius: 5px;    
    width: 200px;
    height: 200px;
}

.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.icon-circle {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    background: linear-gradient(135deg, #4e73df, #1cc88a);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}
</style>
<script>
function updateTime() {
    const now = new Date();

    const options = {
        timeZone: 'Africa/Nairobi',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true   // ✅ 12 hour format
    };

    const time = now.toLocaleTimeString('en-US', options);
    document.getElementById('liveTime').innerHTML = time;
}

setInterval(updateTime, 1000);
updateTime();
</script>

@endsection