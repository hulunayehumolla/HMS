@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">
            {{ $editHospital ? 'Edit Hospital Information' : 'Register New Hospital' }}
        </h3>

     
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- ================= FORM CARD ================= --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <form method="POST"
                  action="{{ $editHospital ? route('hospitals.update', $editHospital) : route('hospitals.store') }}"
                  enctype="multipart/form-data">

                @csrf
                @if($editHospital) @method('PUT') @endif

                <div class="row g-3">

                    {{-- BASIC INFO --}}
                    <div class="col-12">
                        <h5 class="fw-bold text-primary">Basic Information</h5>
                        <hr>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Hospital Name *</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name', $editHospital->name ?? '') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Registration Number</label>
                        <input type="text" name="registration_number" class="form-control"
                               value="{{ old('registration_number', $editHospital->registration_number ?? '') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Type *</label>
                        <select name="type" class="form-select" required>
                            <option value="">Select Type</option>
                            <option value="General"
                                {{ old('type', $editHospital->type ?? '') == 'General' ? 'selected' : '' }}>
                                General
                            </option>
                            <option value="Specialized"
                                {{ old('type', $editHospital->type ?? '') == 'Specialized' ? 'selected' : '' }}>
                                Specialized
                            </option>
                            <option value="Clinic"
                                {{ old('type', $editHospital->type ?? '') == 'Clinic' ? 'selected' : '' }}>
                                Clinic
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Capacity (Beds)</label>
                        <input type="number" name="capacity_beds" class="form-control"
                               value="{{ old('capacity_beds', $editHospital->capacity_beds ?? 0) }}">
                    </div>

                    {{-- CONTACT INFO --}}
                    <div class="col-12 mt-4">
                        <h5 class="fw-bold text-primary">Contact Information</h5>
                        <hr>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email', $editHospital->email ?? '') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone *</label>
                        <input type="text" name="phone_number" class="form-control"
                               value="{{ old('phone_number', $editHospital->phone_number ?? '') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Emergency Contact</label>
                        <input type="text" name="emergency_contact" class="form-control"
                               value="{{ old('emergency_contact', $editHospital->emergency_contact ?? '') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Website</label>
                        <input type="url" name="website" class="form-control"
                               value="{{ old('website', $editHospital->website ?? '') }}">
                    </div>

                    {{-- LOCATION INFO --}}
                    <div class="col-12 mt-4">
                        <h5 class="fw-bold text-primary">Location Information</h5>
                        <hr>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Country *</label>
                        <input type="text" name="country" class="form-control"
                               value="{{ old('country', $editHospital->country ?? '') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Zone *</label>
                        <input type="text" name="zone" class="form-control"
                               value="{{ old('zone', $editHospital->zone ?? '') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Woreda *</label>
                        <input type="text" name="woreda" class="form-control"
                               value="{{ old('woreda', $editHospital->woreda ?? '') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Kebele *</label>
                        <input type="text" name="kebele" class="form-control"
                               value="{{ old('kebele', $editHospital->kebele ?? '') }}" required>
                    </div>

                    {{-- LOGO + STATUS --}}
                    <div class="col-12 mt-4">
                        <h5 class="fw-bold text-primary">Logo & Status</h5>
                        <hr>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Hospital Logo</label>
                        <input type="file" name="logo" class="form-control">

                        @if($editHospital && $editHospital->logo)
                            <div class="mt-2">
                                <img src="{{ asset($editHospital->logo) }}"
                                     width="120"
                                     class="img-thumbnail">
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6 d-flex align-items-center">
                        <div class="form-check mt-4">
                            <input type="checkbox"
                                   name="is_active"
                                   value="1"
                                   class="form-check-input"
                                   {{ old('is_active', $editHospital->is_active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label">
                                Hospital is Active
                            </label>
                        </div>
                    </div>

                </div>

                {{-- Submit Button --}}
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        {{ $editHospital ? 'Update Hospital' : 'Register Hospital' }}
                    </button>

                    @if($editHospital)
                        <a href="{{ route('hospitals.index') }}"
                           class="btn btn-secondary">
                            Cancel
                        </a>
                    @endif
                </div>

            </form>

        </div>
    </div>

</div>
@endsection