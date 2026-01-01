@extends('layouts.header')

@section('content')

<div class="container py-5 text-gray-900 dark:text-gray-200">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('news.view.public') }}" class="text-primary dark:text-blue-400">
                    News
                </a>
            </li>
            <li class="breadcrumb-item active  text-[#3b3b3b] dark:text-white" aria-current="page">
                {!! Str::limit($news->title, 40) !!}
            </li>
        </ol>
    </nav>

    {{-- News Title --}}
    <h1 class="fw-bold mb-4 mt-2 text-[#1c2a39] dark:text-white">
        {!! $news->title !!}
    </h1>

    {{-- Meta Info --}}
    <p class="text-secondary dark:text-gray-400 mb-4">
        <i class="far fa-calendar-alt me-1"></i>
        {{ $news->created_at->format('M d, Y') }}
        <span class="ms-2">({{ $news->created_at->diffForHumans() }})</span>
    </p>

    {{-- Images Gallery --}}
    @if(!empty($news->images))
        <div id="newsGallery" class="mb-4 d-flex flex-wrap gap-2">
            @foreach($news->images as $i => $image)
                <img src="{{ asset($image) }}"
                     class="img-fluid rounded mb-3 shadow-sm news-image-trigger
                            border border-gray-300 dark:border-gray-600"
                     style="cursor:pointer; max-width: 400px; height: 400px; object-fit: cover;"
                     data-image-urls='@json($news->images)'
                     data-image-index="{{ $i }}">
            @endforeach
        </div>
    @endif

    {{-- Full Content --}}
    <div class="news-content text-gray-900 dark:text-white"
         style="font-size: 1rem; line-height: 1.7;">
        {!! $news->message !!}
    </div>

    {{-- Back Button --}}
    <div class="mt-4">
        <a href="{{ route('news.view.public') }}"
           class="btn btn-outline-secondary dark:text-gray-300 dark:border-gray-500 dark:hover:bg-gray-700">
            ← Back to News
        </a>
    </div>

</div>

{{-- Modal for Images --}}
<div class="modal fade" id="dynamicImageModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content dark:bg-[#1d1f23] dark:text-gray-100">
      <div class="modal-body">
        <div id="imageCarousel" class="carousel slide">
          <div class="carousel-inner"></div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- JS for Image Modal --}}
<script>
$(document).ready(function() {

    $(document).on('click', '.news-image-trigger', function() {
        let imageUrls = $(this).data('image-urls');
        let imageIndex = $(this).data('image-index');
        let carouselInner = $('#imageCarousel .carousel-inner');
        let carousel = $('#imageCarousel');

        carouselInner.empty();
        carousel.find('.carousel-control-prev, .carousel-control-next').remove();

        imageUrls.forEach(function(url, index) {
            let activeClass = index === imageIndex ? 'active' : '';
            let carouselItem = `
                <div class="carousel-item ${activeClass}">
                    <img src="{{ asset('') }}${url}" class="d-block w-100 rounded" alt="News Image ${index + 1}">
                </div>`;
            carouselInner.append(carouselItem);
        });

        if (imageUrls.length > 1) {
            let prevBtn = `
                <button class="carousel-control-prev" type="button"
                        data-bs-target="#imageCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                    <span class="visually-hidden">Previous</span>
                </button>`;

            let nextBtn = `
                <button class="carousel-control-next" type="button"
                        data-bs-target="#imageCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                    <span class="visually-hidden">Next</span>
                </button>`;

            carousel.append(prevBtn).append(nextBtn);
        }

        let imageModal = new bootstrap.Modal(document.getElementById('dynamicImageModal'));
        imageModal.show();
    });
});
</script>

@endsection
