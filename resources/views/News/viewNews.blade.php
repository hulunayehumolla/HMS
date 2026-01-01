@extends('layouts.app')
@section('content')
<style>
/* === Announcement Card Styling === */
.news-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    margin-bottom: 1rem;
}
.news-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
}
.news-card .card-header {
    background: linear-gradient(135deg, #7B99AB, #A3BDC9);
    padding: 0.9rem 1.2rem;
    border-bottom: 1px solid #ddd;
    display: flex;
    justify-content: center;
    align-items: center;
}
.news-card .card-header h3 {
    font-size: 1.2rem;
    font-weight: 600;
    margin: 0;
    color: #2c3e50;
    text-align: center;
}
.news-card .card-body {
    padding: 1.25rem 1.5rem;
    background-color: #fff;
    color: #444;
}
.news-card .card-body p {
    font-size: 0.95rem;
    line-height: 1.7;
    color: #555;
    margin-bottom: 0;
}
.news-card .news-images {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
    margin-bottom: 1rem;
}
.news-card .news-images img {
    max-width: 300px;
    border-radius: 8px;
    transition: transform 0.2s ease;
}
.news-card .news-images img:hover {
    transform: scale(1.05);
    cursor: zoom-in;
}
.news-card ul {
    list-style-type: disc;  /* default bullet for unordered lists */
    list-style-position: outside; /* bullets outside the content */
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
    padding-left: 40px; /* standard indentation */
}

.news-card ol {
    list-style-type: decimal; /* default numbering for ordered lists */
    list-style-position: outside;
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
    padding-left: 40px;
}
.news-card .card-footer {
    background: #f9fafb;
    border-top: 1px solid #eee;
    font-size: 0.85rem;
    color: #666;
    padding: 0.6rem 1rem;
    display: flex;
    justify-content: flex-end;
    align-items: center;
}
.news-card .card-footer i { color: #0c8cb2; }

.hover-grow {
    transition: transform 0.2s ease-in-out;
}
.hover-grow:hover {
    transform: scale(1.03);
    cursor: zoom-in;
}

.modal-body img {
    width: 100%;
    max-height: 80vh;
    object-fit: contain;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .news-card .news-images img {
        max-width: 150px;
    }
}
@media (max-width: 576px) {
    .news-card .news-images img {
        max-width: 100%;
    }
}
</style>

<div class="container">
    <h5 class="text-center mb-2 text-primary">News</h5>
    <hr class="mb-1">
    <div id="newsContainer">
        @include('News.newsCardsForUsers', ['news' => $new])
    </div>

    <div class="text-center mb-4">
        @if($new->count() >= 2)
            <button id="loadMoreBtn" class="btn btn-info" data-offset="{{ $news->count() }}">
                Load More
            </button>
        @endif
        <div id="noMoreNewsMessage" class="alert alert-secondary mt-4" 
         style="display: {{ $new->count() > 0 && $new->count() < 2 ? 'block' : 'none' }}">
             No more news to display.
        </div>
    </div>
</div>

{{-- Bootstrap modal for images --}}
<div class="modal fade" id="dynamicImageModal" tabindex="-1" aria-labelledby="dynamicImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0">
                <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner"></div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
$(document).ready(function() {
    // Load More Logic
    $('#loadMoreBtn').on('click', function() {
        let btn = $(this);
        let offset = btn.data('offset');
        const perPage = 5;

        btn.prop('disabled', true).text('Loading...');

        $.ajax({
            url: "{{ route('news.view.users') }}",
            type: 'GET',
            data: { offset: offset },
            success: function(response) {
                $('#newsContainer').append(response.html);
                btn.data('offset', offset + response.count);

                if (response.count < perPage) {
                    btn.hide();
                    $('#noMoreNewsMessage').show();
                } else {
                    btn.prop('disabled', false).text('Load More');
                }
            },
            error: function() {
                alert('Failed to load more news.');
                btn.prop('disabled', false).text('Load More');
            }
        });
    });

    // Open images in modal carousel
    $(document).on('click', '.news-image-trigger', function() {
        let imageUrls = $(this).data('image-urls');
        let imageIndex = $(this).data('image-index');
        let carouselInner = $('#imageCarousel .carousel-inner');
        let carousel = $('#imageCarousel');

        carouselInner.empty();
        carousel.find('.carousel-control-prev, .carousel-control-next').remove();

        imageUrls.forEach(function(url, index) {
            let activeClass = index === imageIndex ? 'active' : '';
            let carouselItem = `<div class="carousel-item ${activeClass}">
                                    <img src="{{ asset('') }}${url}" class="d-block w-100 rounded" alt="News Image ${index + 1}">
                                </div>`;
            carouselInner.append(carouselItem);
        });

        if (imageUrls.length > 1) {
            let prevBtn = `<button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                           </button>`;
            let nextBtn = `<button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                           </button>`;
            carousel.append(prevBtn).append(nextBtn);
        }

        let imageModal = new bootstrap.Modal(document.getElementById('dynamicImageModal'));
        imageModal.show();

        // Enable zoom on all carousel images
     
    });
});
</script>
@endsection
