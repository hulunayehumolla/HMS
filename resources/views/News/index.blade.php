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
.news-card ul,
.news-card ol {
    margin-left: 22px !important;
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
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
    <h2 class="text-center mb-2 text-primary">📢 News</h2>
    <hr class="mb-1">

    <div id="newsContainer">
        @include('News.newsCards', ['news' => $news])
    </div>

    {{-- The 'Load More' button and 'No More Posts' message container --}}
    <div class="text-center mb-4">
        {{-- Only show the "Load More" button if there are news to potentially load --}}
        @if($news->count() >= 2) {{-- Assuming 'perPage' is 2 or more --}}
            <button id="loadMoreBtn" class="btn btn-info" data-offset="{{ $news->count() }}">
                Load More
            </button>
        @endif
        {{-- Show this message if there are no news initially, or after all have been loaded --}}
        <div id="noMoreNewsMessage" class="alert alert-secondary mt-4" 
         style="display: {{ $news->count() > 0 && $news->count() < 2 ? 'block' : 'none' }}">
             No more news to display.
        </div>
    </div>
</div>



<div class="modal fade" id="dynamicImageModal" tabindex="-1" aria-labelledby="dynamicImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0">
                <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        {{-- Carousel items will be injected here by JavaScript --}}
                    </div>
                    {{-- Carousel controls will be injected here by JavaScript --}}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Delete button (this remains the same)
    // Using a delegated event handler for elements loaded dynamically
    $(document).on('click', '.btn-delete', function () {
        let id = $(this).data('id');
        let card = $(this).closest('.news-card');

        Swal.fire({
            title: 'Are you sure?',
            text: "This news will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            customClass: { popup: 'rounded-4 shadow-lg' }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('news.destroy', ':id') }}".replace(':id', id),
                    type: 'POST',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({ position: 'top-end', icon: 'success', title: response.message, showConfirmButton: false, timer: 2000, toast: true });
                            card.fadeOut(500, function() { $(this).remove(); });
                        } else {
                            Swal.fire({ position: 'top-end', icon: 'error', title: response.message || 'Something went wrong.', showConfirmButton: false, timer: 2000, toast: true });
                        }
                    },
                    error: function () {
                        Swal.fire({ position: 'top-end', icon: 'error', title: 'Unable to delete. Please try again.', showConfirmButton: false, timer: 2000, toast: true });
                    }
                });
            }
        });
    });

    // Load More Logic
    $('#loadMoreBtn').on('click', function() {
        let btn = $(this);
        let offset = btn.data('offset');
        const perPage = 5; // Match this with your controller's $perPage

        // Show loading state
        btn.prop('disabled', true).text('Loading...');

        $.ajax({
            url: "{{ route('news.index') }}",
            type: 'GET',
            data: { offset: offset }, // Send the offset
            success: function(response) {
                // Append the new HTML to the existing container
                $('#newsContainer').append(response.html);

                // Update the offset for the next request
                btn.data('offset', offset + response.count);

                // Check if the number of returned items is less than the perPage limit
                if (response.count < perPage) {
                    btn.hide(); // Hide the button
                    $('#noMoreNewsMessage').show(); // Show the 'no more' message
                } else {
                    btn.prop('disabled', false).text('Load More'); // Re-enable button
                }
            },
            error: function() {
                alert('Failed to load more announcements.');
                btn.prop('disabled', false).text('Load More'); // Re-enable on error
            }
        });
    });

    // Delegated event listener for opening the dynamic image modal
    $(document).on('click', '.news-image-trigger', function() {
        let imageUrls = $(this).data('image-urls');
        let imageIndex = $(this).data('image-index');
        let carouselInner = $('#imageCarousel .carousel-inner');
        let carousel = $('#imageCarousel');
        
        // Clear previous images and controls
        carouselInner.empty();
        carousel.find('.carousel-control-prev, .carousel-control-next').remove();

        // Populate the carousel with new images
        imageUrls.forEach(function(url, index) {
            let activeClass = index === imageIndex ? 'active' : '';
            let carouselItem = `<div class="carousel-item ${activeClass}">
                                    <img src="{{ asset('') }}${url}" class="d-block w-100 rounded" alt="News Image ${index + 1}">
                                </div>`;
            carouselInner.append(carouselItem);
        });

        // Add carousel controls if there's more than one image
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

        // Show the modal
        let imageModal = new bootstrap.Modal(document.getElementById('dynamicImageModal'));
        imageModal.show();
    });
});
</script>
@endsection