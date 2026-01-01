@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3 text-end">
        <a href="{{ route('rooms.create') }}" class="btn btn-success">Add Room</a>
    </div>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Room</th>
                <th>Type</th>
                <th>Class</th>
                <th>Status</th>
                <th>Price</th>
                <th>Photos</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @forelse($rooms as $room)
            <tr>
                <td>{{ $loop->iteration + ($rooms->currentPage() - 1) * $rooms->perPage() }}</td>
                <td>{{ $room->room_number }}</td>
                <td>{{ ucfirst($room->room_type) }}</td>
                <td>{{ ucfirst($room->room_class) }}</td>
                <td>
                    <span class="badge bg-{{ $room->room_status === 'available' ? 'success' : ($room->room_status === 'booked' ? 'danger' : 'warning') }}">
                        {{ ucfirst($room->room_status) }}
                    </span>
                </td>
                <td>{{ number_format($room->room_price, 2) }} ETB</td>
                <td>
                    @if($room->room_photos)
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($room->room_photos as $photo)
                                <img src="{{ asset('storage/' . $photo) }}"
                                     alt="room photo"
                                     class="img-thumbnail room-thumb"
                                     style="width:50px;height:50px;object-fit:cover;cursor:pointer;"
                                     onclick="openModal('{{ asset('storage/' . $photo) }}')">
                            @endforeach
                        </div>
                    @else
                        <span class="text-muted">No photos</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('rooms.edit', $room) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form method="POST" action="{{ route('rooms.destroy', $room) }}" class="d-inline">
                        @csrf 
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this room?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">No rooms found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $rooms->links() }}
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 text-center">
                <img id="modalImage" src="" class="img-fluid rounded shadow-sm">
            </div>
            <div class="text-center mt-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<script>
function openModal(src) {
    const modalImage = document.getElementById('modalImage');
    modalImage.src = src;
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
}
</script>
@endsection

