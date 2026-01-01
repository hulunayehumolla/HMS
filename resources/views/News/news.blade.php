@extends('layouts.header')

@section('content')
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

.read-more-btn {
    color: #0c8cb2;
    cursor: pointer;
    font-size: 0.85rem;
}

/* Footer */
.news-card .card-footer {
    padding: 0.7rem 1rem;
    background: #f9fafb;
    border-top: 1px solid #eee;
    font-size: 0.78rem;
    color: #555;
}

/* SEARCH PANEL */
#searchPanel {
    position: sticky;
    top: 20px;
}

/* Latest news links */
#latestNewsLinks {
    margin-top: 30px;
}

#latestNewsLinks h6 {
    margin-bottom: 10px;
}

#latestNewsLinks ul {
    list-style: none;
    padding: 0;
}

#latestNewsLinks ul li {
    padding: 4px 0;
}
</style>

<div class="row">
    {{-- LEFT: NEWS CARDS --}}
    <div class="col-lg-9 col-md-12 mb-4">
        <div id="newsContainer">
            @include('components.news-cards', ['news' => $news])
        </div>

        {{-- LOAD MORE BUTTON --}}
        <div class="text-center my-4">
            <button id="loadMoreBtn" class="btn btn-primary" data-offset="{{ $news->count() }}">
                Load More
            </button>
            <p id="noMoreNewsMessage" class="text-muted mt-3" style="display:none;">
                No more news available.
            </p>
        </div>
    </div>

{{-- RIGHT: SEARCH / FILTER PANEL --}}
<div class="col-lg-3 col-md-12 mb-4" id="searchPanel">
    <div class="card p-3">
        <h5 class="mb-3 text-primary">Filter News</h5>

        {{-- Search by Title --}}
        <div class="mb-2">
            <input type="text" id="searchTitle" class="form-control" placeholder="Search by title...">
        </div>

        {{-- Search by Month --}}
        <div class="mb-2">
            <input type="month" id="searchDate" class="form-control">
        </div>

        {{-- Search by Category --}}
        <div class="mb-2">
            <select id="searchCategory" class="form-control">
                <option value="">All Categories</option>
                @foreach($allCategories as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                @endforeach
            </select>
        </div>

        {{-- Filter Button --}}
        <button id="searchBtn" class="btn btn-primary w-100 mt-2 mb-3">Filter</button>

        {{-- Latest News Cards --}}
        <h5 class="text-primary mb-2">Latest News</h5>
        <div id="latestNewsCards">
            @foreach($latestNews as $ln)
            <div class="card mb-2 shadow-sm latest-news-card" style="cursor:pointer;" onclick="window.open('{{ route('news.show', $ln->id) }}', '_blank')">
                <div class="card-body p-2">
                    <p class="mb-1" style="font-size:0.85rem; font-weight:600; color:#2c3e50;">
                        {!! Str::limit($ln->title, 50) !!}
                    </p>
                    <small class="text-muted">{{ date('M d, Y', strtotime($ln->created_at)) }}</small>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
.latest-news-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.latest-news-card:hover {
    transform: translateY(-3px);
    text-decoration-color: lightblue;
    box-shadow: 0 5px 15px rgba(0,0,0,0.15);
}
</style>


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

{{-- JAVASCRIPT --}}
<script>
$(document).ready(function() {

    // ---------- LOAD MORE NEWS ----------
    $('#loadMoreBtn').on('click', function() {
        let btn = $(this);
        let offset = btn.data('offset');
        const perPage = 6;

        let title = $('#searchTitle').val();
        let date = $('#searchDate').val();
        let category = $('#searchCategory').val();

        btn.prop('disabled', true).text('Loading...');

        $.ajax({
            url: "{{ route('news.view.public') }}",
            type: "GET",
            data: { offset: offset, title: title, date: date, category: category },
            success: function(response) {
                $('#newsContainer').removeClass('search-results').append(response.html);
                btn.data('offset', offset + response.count);

                if (response.count < perPage) {
                    btn.hide();
                    $('#noMoreNewsMessage').show();
                } else {
                    btn.prop('disabled', false).text('Load More');
                }
            }
        });
    });

    // ---------- SEARCH / FILTER ----------
    $('#searchBtn').on('click', function() {
        let title = $('#searchTitle').val();
        let date = $('#searchDate').val();
        let category = $('#searchCategory').val();

        $.ajax({
            url: "{{ route('news.view.public') }}",
            type: "GET",
            data: { title: title, date: date, category: category },
            success: function(response) {
                $('#newsContainer').addClass('search-results').html(response.html);
                $('#loadMoreBtn').hide();
                $('#noMoreNewsMessage').hide();
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
