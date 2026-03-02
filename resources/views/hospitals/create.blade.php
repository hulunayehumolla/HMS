@extends('layouts.app')
@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<div class="min-h-screen bg-slate-50 p-4 md:p-10">
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center gap-4 mb-8">
            <div class="bg-blue-600 p-3 rounded-lg shadow-lg shadow-blue-200">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h1 class="text-3xl font-bold text-slate-800">Add New Hospital</h1>
        </div>

        <form action="{{ route('hospitals.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                        <h3 class="font-bold text-slate-700 mb-4 flex items-center gap-2">
                            <span class="w-1 h-4 bg-blue-500 rounded-full"></span> Basic Details
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="text-xs font-bold uppercase text-slate-500">Hospital Name</label>
                                <input type="text" name="name" required class="w-full mt-1 p-3 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="text-xs font-bold uppercase text-slate-500">Reg. Number</label>
                                <input type="text" name="registration_number" class="w-full mt-1 p-3 bg-slate-50 border-none rounded-xl">
                            </div>
                            <div>
                                <label class="text-xs font-bold uppercase text-slate-500">Hospital Type</label>
                                <select name="type" class="w-full mt-1 p-3 bg-slate-50 border-none rounded-xl">
                                    <option>General</option>
                                    <option>Specialized</option>
                                    <option>Referral</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                        <h3 class="font-bold text-slate-700 mb-4 flex items-center gap-2">
                            <span class="w-1 h-4 bg-blue-500 rounded-full"></span> Location Info (Ethiopia)
                        </h3>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="text-xs font-bold uppercase text-slate-500">Zone</label>
                                <input type="text" name="zone" required class="w-full mt-1 p-3 bg-slate-50 border-none rounded-xl">
                            </div>
                            <div>
                                <label class="text-xs font-bold uppercase text-slate-500">Woreda</label>
                                <input type="text" name="woreda" required class="w-full mt-1 p-3 bg-slate-50 border-none rounded-xl">
                            </div>
                            <div>
                                <label class="text-xs font-bold uppercase text-slate-500">Kebele</label>
                                <input type="text" name="kebele" required class="w-full mt-1 p-3 bg-slate-50 border-none rounded-xl">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                        <label class="font-bold text-slate-700 block mb-4">Branding</label>
                        <div class="border-2 border-dashed border-slate-200 rounded-2xl p-4 text-center">
                            <input type="file" name="logo" class="text-xs">
                            <p class="text-[10px] text-slate-400 mt-2">Upload Hospital Logo</p>
                        </div>
                        <input type="text" name="slogan" placeholder="Slogan" class="w-full mt-4 p-3 bg-slate-50 border-none rounded-xl text-sm">
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                        <label class="font-bold text-slate-700 block mb-2">Status</label>
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-xl">
                            <span class="text-sm font-bold text-green-700">Set as Active</span>
                            <input type="checkbox" name="is_active" checked class="w-5 h-5 accent-green-600">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <button type="submit" class="bg-blue-600 text-white px-12 py-4 rounded-2xl font-bold shadow-xl shadow-blue-200 hover:bg-blue-700 transition-all">Save Hospital Records</button>
            </div>
        </form>
    </div>
</div>
@endsection