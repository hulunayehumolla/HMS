@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Create New Room</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Room Number --}}
                        <div class="mb-3">
                            <label class="form-label">Room Number</label>
                            <input type="text"
                                   name="room_number"
                                   value="{{ old('room_number') }}"
                                   class="form-control @error('room_number') is-invalid @enderror">
                            @error('room_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            {{-- Room Type --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Room Type</label>
                                <select name="room_type" class="form-select @error('room_type') is-invalid @enderror">
                                    <option value="">-- Select --</option>
                                    @foreach(['single','double'] as $type)
                                        <option value="{{ $type }}" {{ old('room_type') === $type ? 'selected' : '' }}>
                                            {{ ucfirst($type) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Room Class --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Room Class</label>
                                <select name="room_class" class="form-select @error('room_class') is-invalid @enderror">
                                    <option value="">-- Select --</option>
                                    @foreach(['normal','vip','luxury'] as $class)
                                        <option value="{{ $class }}" {{ old('room_class') === $class ? 'selected' : '' }}>
                                            {{ strtoupper($class) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_class') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Room Status --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Room Status</label>
                                <select name="room_status" class="form-select @error('room_status') is-invalid @enderror">
                                    @foreach(['available','booked','maintenance'] as $status)
                                        <option value="{{ $status }}" {{ old('room_status') === $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Price --}}
                        <div class="mb-3">
                            <label class="form-label">Price (ETB)</label>
                            <input type="number" step="0.01"
                                   name="room_price"
                                   value="{{ old('room_price') }}"
                                   class="form-control @error('room_price') is-invalid @enderror">
                            @error('room_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Services --}}
                        <div class="mb-3">
                            <label class="form-label">Room Services</label>
                            <div class="row">
                                @php
                                    $services = ['wifi','tv','minibar','ac','balcony'];
                                @endphp

                                @foreach($services as $service)
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   name="room_services[]"
                                                   value="{{ $service }}"
                                                   {{ in_array($service, old('room_services', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                {{ strtoupper($service) }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Is Cleaned --}}
                        <div class="mb-3 form-check">
                            <input type="checkbox"
                                   name="room_is_cleaned"
                                   value="1"
                                   class="form-check-input"
                                   {{ old('room_is_cleaned', true) ? 'checked' : '' }}>
                            <label class="form-check-label">Room is Cleaned</label>
                        </div>

                        {{-- Photos --}}
                        <div class="mb-3">
                            <label class="form-label">Room Photos</label>
                            <input type="file"
                                   name="room_photos[]"
                                   class="form-control @error('room_photos.*') is-invalid @enderror"
                                   multiple
                                   onchange="previewImages(this)">
                            @error('room_photos.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Preview --}}
                        <div class="row" id="imagePreview"></div>

                        <div class="text-end mt-4">
                            <a href="{{ route('rooms.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                            <button class="btn btn-success">
                                Save Room
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>


<script>
function previewImages(input) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';

    // Convert FileList to array so we can manipulate it
    let files = Array.from(input.files);

    files.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = e => {
            const col = document.createElement('div');
            col.className = 'col-md-3 mb-2 position-relative';
            col.innerHTML = `
                <div class="card">
                    <img src="${e.target.result}" class="img-fluid rounded">
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 remove-preview">&times;</button>
                </div>`;
            preview.appendChild(col);

            // Add click event to remove button
            col.querySelector('.remove-preview').addEventListener('click', () => {
                files.splice(index, 1); // remove from array
                updateFileInput(input, files); // update the input
                col.remove(); // remove preview card
            });
        };
        reader.readAsDataURL(file);
    });
}

// Helper function to update the input FileList after removing a file
function updateFileInput(input, files) {
    const dataTransfer = new DataTransfer();
    files.forEach(file => dataTransfer.items.add(file));
    input.files = dataTransfer.files;
}
</script>

@endsection
