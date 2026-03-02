@extends('layouts.header')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Edit Food</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('welcome.update', $food) }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Food Name</label>
                                <input type="text" name="food_name"
                                       value="{{ old('food_name', $food->food_name) }}"
                                       class="form-control @error('food_name') is-invalid @enderror">
                                @error('food_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Food Type</label>
                                <select name="food_type"
                                        class="form-select @error('food_type') is-invalid @enderror">
                                    <option value="fasting"
                                        {{ old('food_type', $food->food_type) == 'fasting' ? 'selected' : '' }}>
                                        Fasting
                                    </option>
                                    <option value="non_fasting"
                                        {{ old('food_type', $food->food_type) == 'non_fasting' ? 'selected' : '' }}>
                                        Non-Fasting
                                    </option>
                                </select>
                                @error('food_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <input type="text" name="food_category"
                                       value="{{ old('food_category', $food->food_category) }}"
                                       class="form-control @error('food_category') is-invalid @enderror">
                                @error('food_category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Number of Persons</label>
                                <input type="number" name="food_number_of_person"
                                       value="{{ old('food_number_of_person', $food->food_number_of_person) }}"
                                       class="form-control @error('food_number_of_person') is-invalid @enderror">
                                @error('food_number_of_person')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Price (ETB)</label>
                                <input type="number" step="0.01"
                                       name="food_price"
                                       value="{{ old('food_price', $food->food_price) }}"
                                       class="form-control @error('food_price') is-invalid @enderror">
                                @error('food_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Food Photo</label>
                                <input type="file" name="food_photo"
                                       class="form-control @error('food_photo') is-invalid @enderror">
                                @error('food_photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        @if($food->food_photo)
                            <div class="mb-3">
                                <label class="form-label d-block">Current Image</label>
                                <img src="{{ asset('storage/'.$food->food_photo) }}"
                                     class="img-thumbnail"
                                     style="max-height:180px;">
                            </div>
                        @endif

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('welcome') }}"
                               class="btn btn-secondary">
                                Cancel
                            </a>
                            <button class="btn btn-success">
                                Update Food
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

