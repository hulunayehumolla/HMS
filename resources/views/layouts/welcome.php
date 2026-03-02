@extends('layouts.header')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script defer src="https://unpkg.com/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
<main class="min-h-screen font-sans">
    <style>
        /* Optional: nice thin scrollbar */
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
            { image: '{{ asset('hotel/slide1.jpg') }}', title: 'Luxury Redefined', caption: 'Experience comfort, elegance, and world-class hospitality.' },
            { image: '{{ asset('hotel/slide2.jpg') }}', title: 'Rooms & Suites', caption: 'Designed for relaxation, built for unforgettable stays.' },
            { image: '{{ asset('hotel/slide3.jpg') }}', title: 'Exceptional Service', caption: 'Because every guest deserves perfection.' },
            { image: '{{ asset('hotel/slide4.jpg') }}', title: 'Elegant Interiors', caption: 'Every detail crafted for comfort.' },
            { image: '{{ asset('hotel/slide5.jpg') }}', title: 'Relax & Unwind', caption: 'Peaceful spaces for ultimate relaxation.' },
            { image: '{{ asset('hotel/slide6.jpg') }}', title: 'Premium Amenities', caption: 'World-class services for guests.' },
            { image: '{{ asset('hotel/slide7.jpg') }}', title: 'Your Perfect Stay', caption: 'Experience unforgettable hospitality.' }
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
            <img :src="slide.image"
                 class="absolute inset-0 w-full h-full object-cover object-center">
        </div>
    </template>

    <div class="absolute inset-0 bg-black/30 pointer-events-none"></div>

    <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-6">
        <h1 class="text-3xl sm:text-5xl md:text-6xl font-extrabold text-white tracking-tight drop-shadow-xl"
            x-text="slides[current].title"></h1>
        <p class="mt-4 text-lg sm:text-xl text-gray-200 max-w-2xl drop-shadow-md"
           x-text="slides[current].caption"></p>

        <div class="mt-8 flex flex-col sm:flex-row gap-4">
            <a href="#booking"
               class="px-8 py-3 bg-zare-orange text-white font-semibold rounded-xl shadow-lg hover:scale-105 transition-transform duration-300">
                Book Your Stay
            </a>
            <a href="#rooms"
               class="px-8 py-3 border-2 border-white text-white rounded-xl hover:bg-white hover:text-black transition-all duration-300">
                Explore Rooms
            </a>
        </div>
    </div>

    <button @click="prev()"
            class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/40 text-white p-3 rounded-full hover:bg-black/60 transition z-10">‹</button>
    <button @click="next()"
            class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/40 text-white p-3 rounded-full hover:bg-black/60 transition z-10">›</button>
</div>

<!-- ================= ABOUT HOTEL ================= -->
<section class="py-24 bg-secondary-bg text-center px-4">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-4xl font-extrabold text-zare-blue">
            Welcome to {{ config('app.name') }}
        </h2>
        <p class="mt-6 text-lg text-primary-text/80">
            Nestled in the heart of the city, {{ config('app.name') }} offers premium accommodation,
            elegant design, and personalized service — crafted for both leisure and business travelers.
        </p>
    </div>
</section>






<!-- ================= AMENITIES ================= -->
<section id="amenities" class="py-24 bg-secondary-bg px-4">
    <div class="max-w-7xl mx-auto text-center">
        <h2 class="text-4xl font-bold mb-4">Hotel Amenities</h2>
        <p class="mb-12 text-primary-text/70">Everything you need for a perfect stay.</p>

          <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center text-lg font-medium">
            @php
                $amenities = ['🏊 Swimming Pool', '🍽 Restaurant & Bar', '💆 Spa & Wellness', '🏋 Fitness Center', '📶 Free Wi-Fi', '🚗 Free Parking', '🛎 24/7 Room Service', '📍 City Center Location'];
            @endphp
            @foreach($amenities as $item)
                <div class="p-4 bg-secondary-bg rounded-xl shadow-sm hover:bg-zare-blue hover:text-white transition  hover:scale-105 transition-transform duration-300">
                    {{ $item }}
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ================= RESTAURANT ================= -->
<section id="restaurant" class="py-24 bg-primary-bg px-4">
    <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center">
        <div>
            <h2 class="text-4xl font-bold mb-4">Fine Dining Experience</h2>
            <p class="text-primary-text/70 mb-6">
                Enjoy world-class cuisine prepared by expert chefs using fresh local and international ingredients.
            </p>
            <ul class="space-y-3 text-primary-text">
                <li>🍳 Breakfast, Lunch & Dinner</li>
                <li>🍷 Premium Bar & Lounge</li>
                <li>🌿 Outdoor Dining</li>
                <li>👨‍🍳 Professional Chefs</li>
            </ul>
        </div>
        <img src="{{ asset('hotel/dining.jpg') }}" class="rounded-2xl shadow-xl object-cover w-full h-96 hover:scale-105 transition-transform duration-300">
    </div>
</section>

<!-- ================= GALLERY ================= -->
<section id="gallery" class="py-24 bg-secondary-bg px-4">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold">Photo Gallery</h2>
            <p class="mt-4 text-primary-text/70">
                Discover the beauty of {{ config('app.name') }}
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach (['g1.jpg','g2.jpg','g3.jpg','g4.jpg','g5.jpg','g6.jpg','g7.jpg','g8.jpg'] as $img)
                <img src="{{ asset('gallery/'.$img) }}" class="rounded-xl h-56 w-full object-cover hover:scale-105 transition-transform duration-300">
            @endforeach
        </div>
    </div>
</section>

<!-- ================= ABOUT US ================= -->
<section id="about" class="py-12 bg-primary-bg px-4">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-4xl font-extrabold text-zare-blue">About {{ config('app.name') }}</h2>
        <p class="mt-6 text-lg text-primary-text/80">
            {{ config('app.name') }} is built on elegance, comfort, and exceptional service.
            We welcome guests from around the world and deliver unforgettable hospitality experiences.
        </p>

           <div class="mt-10 grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach(['⭐ 5-Star Service', '🏨 Luxury Rooms', '🍽 Fine Dining', '📍 Prime Location'] as $item)
                <div class="p-6 bg-secondary-bg rounded-xl shadow hover:bg-zare-blue hover:text-white transition duration-300">
                    {{ $item }}
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ================= CTA ================= -->
<section id="booking" class="bg-zare-blue py-20 text-center text-white px-4">
    <h2 class="text-4xl font-extrabold">Ready for an Unforgettable Stay?</h2>
    <p class="mt-4 text-xl text-white/90">
        Reserve your room today and experience hospitality at its finest.
    </p>
    <a href="#" class="inline-block mt-8 px-10 py-3 bg-white text-zare-blue font-semibold rounded-xl shadow-lg hover:opacity-90 transition">
        Book Now
    </a>
</section>

<!-- ================= CONTACT ================= -->
<section id="contact" class="py-24 bg-secondary-bg px-4">
    <div class="max-w-7xl mx-auto">

        <!-- Heading -->
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-zare-blue">Contact Us</h2>
            <p class="mt-4 text-primary-text/70 max-w-2xl mx-auto">
                Have a question or need assistance? Our team is available 24/7.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">

            <!-- Contact Info -->
            <div class="space-y-6">
                <div class="flex items-start space-x-4">
                    <div class="text-2xl">📍</div>
                    <div>
                        <h4 class="font-semibold text-lg">Address</h4>
                        <p class="text-primary-text/70">Injibara, Amhara, Ethiopia</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="text-2xl">📞</div>
                    <div>
                        <h4 class="font-semibold text-lg">Phone</h4>
                        <p class="text-primary-text/70">+251 91834940</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="text-2xl">✉️</div>
                    <div>
                        <h4 class="font-semibold text-lg">Email</h4>
                        <p class="text-primary-text/70"> info@karnedhotel.com</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="text-2xl">🕒</div>
                    <div>
                        <h4 class="font-semibold text-lg">Reception Hours</h4>
                        <p class="text-primary-text/70">Open 24 Hours / 7 Days</p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-primary-bg rounded-2xl shadow-xl p-8">
                <form method="POST" action="#">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Full Name</label>
                        <input type="text" class="w-full rounded-lg border-gray-300 focus:border-zare-orange focus:ring-zare-orange" placeholder="Your name">
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Email Address</label>
                        <input type="email" class="w-full rounded-lg border-gray-300 focus:border-zare-orange focus:ring-zare-orange" placeholder="you@example.com">
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Message</label>
                        <textarea rows="4" class="w-full rounded-lg border-gray-300 focus:border-zare-orange focus:ring-zare-orange" placeholder="How can we help you?"></textarea>
                    </div>
                    <button type="submit" class="w-full py-3 bg-zare-orange text-white rounded-xl font-semibold shadow hover:opacity-90 transition">
                        Send Message
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>

</main>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const classes = ['normal', 'vip', 'luxury'];
        
        classes.forEach(roomClass => {
            new Swiper(`.roomSwiper-${roomClass}`, {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: false,
                pagination: {
                    el: `.roomSwiper-${roomClass} .swiper-pagination`,
                    clickable: true,
                },
                // Optional: Autoplay if you want them to move automatically
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: true,
                },
            });
        });
    });
</script>
<script>
    // Build the room data properly with full URLs
    const roomData = {
        normal: [
            @if(isset($roomsGrouped['normal']))
                @foreach($roomsGrouped['normal'] as $r)
                {
                    num: "{{ $r->room_number }}",
                    type: "{{ $r->room_type }}",
                    price: "{{ number_format($r->room_price) }}",
                    img: "{{ ($r->room_photos && count($r->room_photos) > 0) ? asset('storage/'.$r->room_photos[0]) : asset('hotel/rooms/default.jpg') }}"
                },
                @endforeach
            @endif
        ],
        vip: [
            @if(isset($roomsGrouped['vip']))
                @foreach($roomsGrouped['vip'] as $r)
                {
                    num: "{{ $r->room_number }}",
                    type: "{{ $r->room_type }}",
                    price: "{{ number_format($r->room_price) }}",
                    img: "{{ ($r->room_photos && count($r->room_photos) > 0) ? asset('storage/'.$r->room_photos[0]) : asset('hotel/rooms/default.jpg') }}"
                },
                @endforeach
            @endif
        ],
        luxury: [
            @if(isset($roomsGrouped['luxury']))
                @foreach($roomsGrouped['luxury'] as $r)
                {
                    num: "{{ $r->room_number }}",
                    type: "{{ $r->room_type }}",
                    price: "{{ number_format($r->room_price) }}",
                    img: "{{ ($r->room_photos && count($r->room_photos) > 0) ? asset('storage/'.$r->room_photos[0]) : asset('hotel/rooms/default.jpg') }}"
                },
                @endforeach
            @endif
        ]
    };

    let currentClass = '';
    let currentIndex = 0;

    function openGallery(cls, idx) {
        currentClass = cls;
        currentIndex = idx;
        const modal = document.getElementById('galleryModal');
        
        updateModal();
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function updateModal() {
        const data = roomData[currentClass][currentIndex];
        const imgEl = document.getElementById('modalImg');
        
        // Update content
        imgEl.src = data.img;
        document.getElementById('modalTitle').innerText = "Room " + data.num;
        document.getElementById('modalDesc').innerText = data.type.toUpperCase() + " — " + data.price + " ETB";
        document.getElementById('modalCounter').innerText = "Image " + (currentIndex + 1) + " of " + roomData[currentClass].length;
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % roomData[currentClass].length;
        updateModal();
    }

    function prevImage() {
        currentIndex = (currentIndex - 1 + roomData[currentClass].length) % roomData[currentClass].length;
        updateModal();
    }

    function closeGallery() {
        const modal = document.getElementById('galleryModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    // Swiper Init
    document.addEventListener('DOMContentLoaded', function () {
        ['normal', 'vip', 'luxury'].forEach(c => {
            new Swiper(`.roomSwiper-${c}`, {
                slidesPerView: 1,
                spaceBetween: 20,
                pagination: { el: `.roomSwiper-${c} .swiper-pagination`, clickable: true },
            });
        });
    });

    // Keys
    document.addEventListener('keydown', (e) => {
        if (!document.getElementById('galleryModal').classList.contains('hidden')) {
            if (e.key === "ArrowRight") nextImage();
            if (e.key === "ArrowLeft") prevImage();
            if (e.key === "Escape") closeGallery();
        }
    });
</script>


@endsection
