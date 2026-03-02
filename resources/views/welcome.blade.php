@extends('layouts.header')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script defer src="https://unpkg.com/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>

<main class="min-h-screen font-sans">
<style>
div.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}
div.overflow-y-auto::-webkit-scrollbar-thumb {
    background-color: rgba(100,100,100,0.4);
    border-radius: 3px;
}
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.animate-fadeIn { animation: fadeIn 0.3s ease-out; }
</style>

<!-- ================= HERO SLIDER ================= -->
<div
x-data="{
current: 0,
slides: [
{ image: '{{ asset('hotel/slide1.jpg') }}', title: 'Quality Healthcare', caption: 'Compassionate medical care you can trust.' },
{ image: '{{ asset('hotel/slide2.jpg') }}', title: 'Modern Medical Facilities', caption: 'Advanced technology for accurate diagnosis.' },
{ image: '{{ asset('hotel/slide3.jpg') }}', title: 'Expert Medical Team', caption: 'Experienced doctors and nurses available 24/7.' },
{ image: '{{ asset('hotel/slide4.jpg') }}', title: 'Patient-Centered Care', caption: 'Your health and comfort come first.' },
{ image: '{{ asset('hotel/slide5.jpg') }}', title: 'Emergency Services', caption: 'Fast and reliable emergency response.' },
{ image: '{{ asset('hotel/slide6.jpg') }}', title: 'Trusted Community Hospital', caption: 'Serving Injibara and surrounding areas.' },
{ image: '{{ asset('hotel/slide7.jpg') }}', title: 'Healthy Community', caption: 'Building a healthier future together.' }
],
next() { this.current = (this.current + 1) % this.slides.length },
prev() { this.current = (this.current - 1 + this.slides.length) % this.slides.length },
autoplay() { setInterval(() => this.next(), 6000); }
}"
x-init="autoplay()"
class="relative w-full overflow-hidden shadow-xl">

<template x-for="(slide, index) in slides" :key="index">
<div x-show="current === index"
x-transition:enter="transition duration-1000 ease-out"
x-transition:enter-start="opacity-0 scale-105"
x-transition:enter-end="opacity-100 scale-100"
x-transition:leave="transition duration-1000 ease-in"
x-transition:leave-start="opacity-100"
x-transition:leave-end="opacity-0"
class="relative w-full min-h-screen flex justify-center items-center">
<img :src="slide.image" class="absolute inset-0 w-full h-full object-cover object-center">
</div>
</template>

<div class="absolute inset-0 bg-black/30 pointer-events-none"></div>

<div class="absolute inset-0 flex flex-col justify-center items-center text-center px-6">
<h1 class="text-3xl sm:text-5xl md:text-6xl font-extrabold text-white drop-shadow-xl" x-text="slides[current].title"></h1>
<p class="mt-4 text-lg sm:text-xl text-gray-200 max-w-2xl drop-shadow-md" x-text="slides[current].caption"></p>

<div class="mt-8 flex flex-col sm:flex-row gap-4">
<a href="#booking" class="px-8 py-3 bg-zare-orange text-white font-semibold rounded-xl shadow-lg hover:scale-105 transition">
Book Appointment
</a>
<a href="#rooms" class="px-8 py-3 border-2 border-white text-white rounded-xl hover:bg-white hover:text-black transition">
View Wards
</a>
</div>
</div>

<button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/40 text-white p-3 rounded-full">‹</button>
<button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/40 text-white p-3 rounded-full">›</button>
</div>

<!-- ================= ABOUT HOSPITAL ================= -->
<section class="py-24 bg-secondary-bg text-center px-4">
<div class="max-w-4xl mx-auto">
<h2 class="text-4xl font-extrabold text-zare-blue">
Welcome to Injibara Hospital
</h2>
<p class="mt-6 text-lg text-primary-text/80">
Injibara Hospital provides professional healthcare services with skilled medical staff, 
modern equipment, and compassionate patient care for the Injibara community.
</p>
</div>
</section>

<!-- ================= MEDICAL SERVICES ================= -->
<section id="foods" class="py-24 bg-secondary-bg px-4">
<div class="max-w-7xl mx-auto">
<div class="text-center mb-16">
<h2 class="text-4xl font-extrabold text-zare-blue">Medical Services</h2>
<p class="mt-4 text-lg text-primary-text/80">Comprehensive healthcare services for all patients.</p>
</div>


</div>
</section>

<!-- ================= WARDS ================= -->
<section id="rooms" class="py-24 bg-primary-bg px-4">
<div class="max-w-7xl mx-auto">
<div class="text-center mb-16">
<h2 class="text-4xl font-extrabold text-zare-blue">Hospital Wards & Departments</h2>
<p class="mt-4 text-lg text-primary-text/80">Comfortable wards and specialized medical care.</p>
</div>




</div>
</section>

<!-- ================= FACILITIES ================= -->
<section id="amenities" class="py-24 bg-secondary-bg px-4">
<div class="max-w-7xl mx-auto text-center">
<h2 class="text-4xl font-bold mb-4">Hospital Facilities</h2>
<p class="mb-12 text-primary-text/70">Essential healthcare services and support units.</p>

@php
$amenities = [
'🚑 Emergency Services',
'🩺 Outpatient Department',
'👶 Maternity Ward',
'🧪 Laboratory Services',
'💊 Pharmacy',
'🩻 Radiology & X-Ray',
'🏥 Inpatient Wards',
'📶 Free Wi-Fi'
];
@endphp

<div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-lg font-medium">
@foreach($amenities as $item)
<div class="p-4 bg-secondary-bg rounded-xl shadow hover:bg-zare-blue hover:text-white transition">
{{ $item }}
</div>
@endforeach
</div>
</div>
</section>

<!-- ================= LAB & PHARMACY ================= -->
<section id="restaurant" class="py-24 bg-primary-bg px-4">
<div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center">

<div>
<h2 class="text-4xl font-bold mb-4">Laboratory & Pharmacy Services</h2>
<p class="text-primary-text/70 mb-6">
We provide reliable diagnostic testing and a fully stocked pharmacy 
to support accurate and timely medical treatment.
</p>

<ul class="space-y-3 text-primary-text">
<li>🧪 Diagnostic Testing</li>
<li>💊 Prescription Medicines</li>
<li>🩻 Medical Imaging</li>
<li>👨‍⚕️ Professional Lab Staff</li>
</ul>
</div>

<img src="{{ asset('hotel/dining.jpg') }}" class="rounded-2xl shadow-xl object-cover w-full h-96">
</div>
</section>

<!-- ================= ABOUT ================= -->
<section id="about" class="py-12 bg-primary-bg px-4">
<div class="max-w-4xl mx-auto text-center">
<h2 class="text-4xl font-extrabold text-zare-blue">About Injibara Hospital</h2>

<p class="mt-6 text-lg text-primary-text/80">
Injibara Hospital is committed to delivering high-quality medical services, 
ensuring patient safety, and improving healthcare access in Injibara and surrounding areas.
</p>

<div class="mt-10 grid grid-cols-2 md:grid-cols-4 gap-6">
@foreach(['⭐ Trusted Healthcare', '🩺 Skilled Doctors', '🏥 Modern Facilities', '📍 Serving Injibara Community'] as $item)
<div class="p-6 bg-secondary-bg rounded-xl shadow hover:bg-zare-blue hover:text-white transition">
{{ $item }}
</div>
@endforeach
</div>
</div>
</section>

<!-- ================= CTA ================= -->
<section id="booking" class="bg-zare-blue py-20 text-center text-white px-4">
<h2 class="text-4xl font-extrabold">Need Medical Assistance?</h2>
<p class="mt-4 text-xl text-white/90">
Book an appointment and receive professional healthcare today.
</p>

<a href="#" class="inline-block mt-8 px-10 py-3 bg-white text-zare-blue font-semibold rounded-xl shadow-lg">
Book Appointment
</a>
</section>

<!-- ================= CONTACT ================= -->
<section id="contact" class="py-24 bg-secondary-bg px-4">
<div class="max-w-7xl mx-auto text-center mb-16">
<h2 class="text-4xl font-bold text-zare-blue">Contact Injibara Hospital</h2>
<p class="mt-4 text-primary-text/70">We are available 24/7 to assist patients.</p>
</div>

<div class="max-w-3xl mx-auto space-y-6">
<p>📍 Injibara, Amhara, Ethiopia</p>
<p>📞 +251 91834940</p>
<p>✉️ info@injibarahospital.com</p>
<p>🕒 Open 24 Hours / 7 Days</p>
</div>
</section>

</main>
@endsection
