@extends('layouts.header')

@section('content')

<style>
    /* (all your original CSS unchanged above) */

    /* ===== DARK MODE SUPPORT (added) ===== */
    html.dark .news-card {
        background: #1d1f23 !important;
        border-color: #2c2f35 !important;
        color: #e5e5e5 !important;
    }

    html.dark .news-card .card-header {
        background: #2a2d31 !important;
        color: #e5e5e5 !important;
    }

    html.dark .news-card .card-footer {
        background: #1d1f23 !important;
        border-color: #2c2f35 !important;
        color: #bbb !important;
    }

    html.dark #searchPanel .card {
        background: #1d1f23 !important;
        border-color: #2c2f35 !important;
        color: #e5e5e5 !important;
    }

    html.dark #searchPanel input,
    html.dark #searchPanel select {
        background: #2a2d31 !important;
        color: #fff !important;
        border-color: #444 !important;
    }

    html.dark #latestNewsCards .latest-news-card {
        background: #2a2d31 !important;
        border-color: #333 !important;
        color: #e5e5e5 !important;
    }

    html.dark #latestNewsCards .latest-news-card small {
        color: #bbb !important;
    }

    html.dark #latestNewsCards .latest-news-card:hover {
        background: #36393f !important;
       
    }
</style>

<style>
/* ===== GRID LAYOUT FOR NEWS ===== */
#newsContainer {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

/* When showing search results (1 row of 3 cards max) */
#newsContainer.search-results {
    grid-template-columns: repeat(3, 1fr);
    grid-auto-rows: 1fr;
}

/* Tablets */
@media (max-width: 992px) {
    #newsContainer {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Mobile */
@media (max-width: 576px) {
    #newsContainer {
        grid-template-columns: repeat(1, 1fr);
    }
}

/* ===== CARD DESIGN ===== */
.news-card {
    border-radius: 14px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    transition: 0.2s ease;
    display: flex;
    flex-direction: column;
}

.news-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 18px rgba(0,0,0,0.15);
    color: darkblue;
}

/* Header */
.news-card .card-header {
    background: #eef4f7;
    padding: 0.8rem;
    text-align: center;
}
.news-card .card-header h3 {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    color: #2c3e50;
}

/* Small image preview */
.news-card .news-images img {
    width: 100%;
    height: 140px;
    object-fit: cover;
    border-radius: 6px;
    cursor: pointer;
    margin-bottom: 10px;
}

/* Body */
.news-card .card-body {
    padding: 0.9rem 1rem;
    font-size: 0.88rem;
    flex-grow: 1;
}



/* Footer */
.news-card .card-footer {
    padding: 0.7rem 1rem;
    background: #f9fafb;
    border-top: 1px solid #eee;
    font-size: 0.78rem;
    color: #555;
}

 .latest-news-card:hover {
        color: blue;
    }

</style>

  <!-- Hero Section (Retained for color basis) -->
        <section class="relative hero-bg py-2 md:py-4 overflow-hidden border-b border-gray-200 dark:border-[#282828]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">


                <h1 class="mt-4 text-4xl sm:text-6xl lg:text-4xl font-extrabold tracking-tighter leading-snug">
                   <span class="text-zare-orange">   {{ config('app.name') }} </span>,
                     <span class="text-zare-blue">News Page </span>.
                </h1>

                <p class="mt-6 max-w-3xl mx-auto text-lg sm:text-xl text-primary-text/80">
                      {{ config('app.name') }}
                </p>

              
            </div>
        </section>


<div class="row">

    {{-- LEFT: NEWS CARDS --}}
    <div class="col-lg-9 col-md-12 mb-4 py-3">
        
        {{-- news cards container --}}
        <div id="newsContainer" class="dark:text-gray-200">
            @include('components.news-cards', ['news' => $news])
        </div>

        {{-- PAGINATION --}}
        <div id="paginationContainer" class="dark:text-gray-200">
            @include('components.pagination', ['news' => $news])
        </div>
    </div>

    {{-- RIGHT: SEARCH PANEL --}}
    <div class="col-lg-3 col-md-12 mb-4 py-3" id="searchPanel">
        <div class="card p-3 dark:bg-[#1d1f23] dark:border-[#2c2f35] dark:text-gray-200">

            <h5 class="mb-3 text-primary dark:text-gray-200">Filter News</h5>

            <div class="mb-2">
                <input type="text" id="searchTitle"
                       class="form-control dark:bg-[#2a2d31] dark:text-white dark:border-[#444]"
                       placeholder="Search by title...">
            </div>

            <div class="mb-2">
                <input type="month" id="searchDate"
                       class="form-control dark:bg-[#2a2d31] dark:text-white dark:border-[#444]">
            </div>

            <div class="mb-2">
                <select id="searchCategory"
                        class="form-control dark:bg-[#2a2d31] dark:text-white dark:border-[#444]">
                    <option value="">All Categories</option>
                    @foreach($allCategories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <button id="searchBtn" class="btn btn-primary w-100 mt-2 mb-3">Filter</button>

            {{-- Latest news --}}
            <h5 class="text-primary mb-2 dark:text-gray-200">Latest News</h5>

            <div id="latestNewsCards">
                @foreach($latestNews as $ln)
                <div class="shadow-sm latest-news-card dark:bg-[#2a2d31] dark:border dark:border-[#333] dark:text-gray-200"
                     style="cursor:pointer;"
                     onclick="window.open('{{ route('news.show', $ln->id) }}','_blank')">
                     
                    <div class="p-2">
                        <p class="mb-1 latest dark:text-gray-200"
                           style="font-size:0.85rem; font-weight:600; color:#2c3e50;">
                            {!! Str::limit($ln->title, 50) !!}
                        </p>
                        <small class="text-muted dark:text-gray-400">
                            {{ date('M d, Y', strtotime($ln->created_at)) }}
                        </small>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</div>






{{-- IMAGE MODAL --}}
<div class="modal fade" id="dynamicImageModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div id="imageCarousel" class="carousel slide">
          <div class="carousel-inner"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {

    // ---------- SEARCH / FILTER ----------
   $('#searchBtn').on('click', function () {
    let title = $('#searchTitle').val();
    let date = $('#searchDate').val();
    let category = $('#searchCategory').val();

    $.ajax({
        url: "{{ route('news.view.public') }}",
        type: "GET",
        data: { title, date, category },
        success: function (response) {
            $('#newsContainer').html(response.html);
            $('#paginationContainer').html(response.pagination);
        }
    });
});


    // ---------- IMAGE MODAL ----------
    $(document).on('click', '.news-image-trigger', function() {
        let images = $(this).data('image-urls');
        let index = $(this).data('image-index');

        let inner = $('#imageCarousel .carousel-inner');
        inner.empty();

        images.forEach((url, i) => {
            inner.append(`
                <div class="carousel-item ${i === index ? 'active':''}">
                    <img src="${url}" class="d-block w-100">
                </div>
            `);
        });

        new bootstrap.Modal(document.getElementById('dynamicImageModal')).show();
    });

});
</script>
@endsection
