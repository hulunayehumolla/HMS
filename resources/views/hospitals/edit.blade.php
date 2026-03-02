@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-6">
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Edit: {{ $hospital->name }}</h1>
            <img src="{{ $hospital->logo ? asset('storage/'.$hospital->logo) : 'https://ui-avatars.com/api/?name='.$hospital->name }}" class="w-16 h-16 rounded-xl shadow-md object-cover border-2 border-white">
        </div>

        <form action="{{ route('hospitals.update', $hospital->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="text-sm font-bold text-gray-600">Hospital Name</label>
                    <input type="text" name="name" value="{{ $hospital->name }}" class="w-full mt-1 p-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="text-sm font-bold text-gray-600">Email</label>
                    <input type="email" name="email" value="{{ $hospital->email }}" class="w-full mt-1 p-3 border rounded-xl">
                </div>

                <div>
                    <label class="text-sm font-bold text-gray-600">Kebele</label>
                    <input type="text" name="kebele" value="{{ $hospital->kebele }}" class="w-full mt-1 p-3 border rounded-xl">
                </div>

                <div class="flex items-center gap-3 p-4 bg-blue-50 rounded-xl">
                    <input type="checkbox" name="is_active" {{ $hospital->is_active ? 'checked' : '' }} class="w-5 h-5 text-blue-600">
                    <label class="font-bold text-blue-800">Hospital remains active</label>
                </div>

                <div class="md:col-span-2 flex justify-end gap-4 mt-4">
                    <a href="{{ route('hospitals.index') }}" class="px-6 py-3 text-gray-500 font-bold">Back</a>
                    <button type="submit" class="bg-blue-600 text-white px-10 py-3 rounded-xl font-bold hover:bg-blue-700 shadow-lg transition-all">Update Hospital Details</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection