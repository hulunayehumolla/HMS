@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5>Edit Room: {{ $room->room_number }}</h5>
        </div>
        <div class="card-body">
            <form id="updateRoomForm" enctype="multipart/form-data" method="post">
                @csrf

                {{-- Room Number --}}
                <div class="mb-3">
                    <label class="form-label">Room Number</label>
                    <input type="text" name="room_number" value="{{ old('room_number', $room->room_number) }}"
                           class="form-control" required>
                </div>

                <div class="row">
                    {{-- Type --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Room Type</label>
                        <select name="room_type" class="form-select" required>
                            @foreach(['single','double'] as $type)
                                <option value="{{ $type }}" {{ old('room_type', $room->room_type) === $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Class --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Room Class</label>
                        <select name="room_class" class="form-select" required>
                            @foreach(['normal','vip','luxury'] as $class)
                                <option value="{{ $class }}" {{ old('room_class', $room->room_class) === $class ? 'selected' : '' }}>
                                    {{ strtoupper($class) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Room Status</label>
                        <select name="room_status" class="form-select" required>
                            @foreach(['available','booked','maintenance'] as $status)
                                <option value="{{ $status }}" {{ old('room_status', $room->room_status) === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Price --}}
                <div class="mb-3">
                    <label class="form-label">Price ($)</label>
                    <input type="number" step="0.01" name="room_price" value="{{ old('room_price', $room->room_price) }}" class="form-control" required>
                </div>

                {{-- Services --}}
                <div class="mb-3">
                    <label class="form-label">Room Services</label>
                    <div class="row">
                        @php $services = ['wifi','tv','minibar','ac','balcony']; @endphp
                        @foreach($services as $service)
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="room_services[]"
                                           value="{{ $service }}"
                                           {{ in_array($service, old('room_services', $room->room_services ?? [])) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ strtoupper($service) }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Is Cleaned --}}
                <div class="mb-3 form-check">
                    <input type="checkbox" name="room_is_cleaned" value="1"
                           class="form-check-input" {{ old('room_is_cleaned', $room->room_is_cleaned) ? 'checked' : '' }}>
                    <label class="form-check-label">Room is Cleaned</label>
                </div>

                {{-- Existing Photos --}}
                <div class="mb-3">
                    <label class="form-label">Existing Photos</label>
                    <div class="d-flex flex-wrap gap-2" id="existingPhotos">
                        @if($room->room_photos)
                            @foreach($room->room_photos as $index => $photo)
                                <div class="position-relative photo-box" style="width:100px;height:100px;">
                                    <img src="{{ asset('storage/' . $photo) }}" 
                                         class="img-thumbnail" style="width:100%;height:100%;object-fit:cover;cursor:pointer;"
                                         onclick="openModal('{{ asset('storage/' . $photo) }}')">
                                    <button type="button" class="btn btn-sm btn-danger p-1 btn-delete-photo" style="position:absolute;top:2px;right:2px;"
                                            data-url="{{ route('rooms.deletePhoto', [$room, $index]) }}">
                                        &times;
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <span class="text-muted">No photos</span>
                        @endif
                    </div>
                </div>

                {{-- Upload New Photos --}}
                <div class="mb-3">
                    <label class="form-label">Upload New Photos</label>
                    <input type="file" name="room_photos[]" class="form-control" multiple onchange="previewImages(this)">
                </div>

                <div class="row" id="imagePreview"></div>

                <div class="text-end mt-4">
                    <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success" id="btnUpdateRoom">Update Room</button>
                </div>
            </form>
        </div>
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

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function openModal(src) {
    $('#modalImage').attr('src', src);
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}

// Preview images
function previewImages(input) {
    const preview = $('#imagePreview');
    preview.html('');
    Array.from(input.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const col = `<div class="col-md-3 mb-2"><div class="card"><img src="${e.target.result}" class="img-fluid rounded"></div></div>`;
            preview.append(col);
        };
        reader.readAsDataURL(file);
    });
}

// AJAX update room via jQuery
$('#updateRoomForm').on('submit', function(e){
    e.preventDefault();
    var formData = new FormData(this);
    formData.append('_method', 'POST'); // we can just use POST

    $.ajax({
        url: '{{ route("rooms.update", $room) }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        success: function(data){
            Swal.fire('Updated!', data.success, 'success');
        },
        error: function(xhr){
            let errMsg = 'Something went wrong';
            if(xhr.responseJSON && xhr.responseJSON.errors){
                errMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
            }
            Swal.fire('Error!', errMsg, 'error');
        }
    });
});

// AJAX photo deletion via jQuery + SweetAlert
$('.btn-delete-photo').on('click', function(){
    var btn = $(this);
    var url = btn.data('url');

    Swal.fire({
        title: 'Delete this photo?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then(result => {
        if(result.isConfirmed){
            $.ajax({
                url: url,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                success: function(data){
                    if(data.success){
                        btn.closest('.photo-box').remove();
                        Swal.fire('Deleted!', data.success, 'success');
                    }
                }
            });
        }
    });
});
</script>
@endsection
