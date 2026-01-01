<style>
    /* --- Base Styles --- */
    .news-card {
        border: 1px solid #e5e9f0;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.25s ease;
        background: #fff;
    }

    .news-card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        transform: translateY(-3px);
    }

    .news-card .card-header {
        background: linear-gradient(90deg, #0d6efd0f, #00bcd410);
        border-bottom: none;
        padding: 0.75rem 1.25rem;
    }

    .news-card .card-title {
        font-size: 1.15rem;
        font-weight: 600;
        color: #0d6efd;
        margin: 0;
        flex: 1;
        text-transform: capitalize;
    }

    .badge-category {
        display: inline-block;
        font-weight: 500;
        font-size: 0.9rem;
        background: #eef2f7;
        border: 1px solid #d8e0e8;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        margin-left: 1.25rem;
    }

    /* --- Body --- */
    .news-card .card-body {
        padding: 1rem 1.25rem 0.5rem;
        color: #495057;
        line-height: 1.6;
        font-size: 0.95rem;
    }

    /* --- Images --- */
    .news-images {
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
    }

    .news-images img {
        height: 100px;
        width: auto;
        border-radius: 8px;
        cursor: pointer;
        object-fit: cover;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .news-images img:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* --- Footer --- */
    .news-card .card-footer {
        background: #f9fafc;
        border-top: 1px solid #edf0f4;
        padding: 0.65rem 1.25rem;
    }

    .news-card .card-footer p {
        font-size: 0.85rem;
        color: #6c757d;
        margin: 0;
    }

    /* --- Buttons --- */
    .news-card .btn-sm {
        border-radius: 10px;
        padding: 0.35rem 0.8rem;
        font-size: 0.85rem;
        transition: all 0.2s ease;
    }

    .news-card .btn-outline-info:hover {
        background-color: #0dcaf0;
        color: white;
        border-color: #0dcaf0;
    }

    .news-card .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
        border-color: #dc3545;
    }

    /* --- Responsive --- */
    @media (max-width: 768px) {
        .news-images img {
            height: 80px;
        }
        .news-card .card-title {
            font-size: 1rem;
        }
    }
</style>

@foreach($news as $new)
<div class="card shadow-sm news-card mb-4" data-id="{{ $new->id }}">
    <!-- Header -->
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
        <h3 class="card-title">{!! $new->title !!}</h3>
        <span class="badge-category">
            <strong>Posted to:</strong>
            {{ is_array($new->category) ? implode(', ', $new->category) : $new->category }}
        </span>
    </div>

    <!-- Body -->
    <div class="card-body">
        @if(!empty($new->images))
            <div class="news-images mb-3">
                @foreach($new->images as $key => $image)
                    <img src="{{ asset($image) }}"
                         alt="news Image"
                         class="news-image-trigger"
                         data-image-urls="{{ json_encode($new->images) }}"
                         data-image-index="{{ $key }}">
                @endforeach
            </div>
        @endif

        <p class="card-text">{!! $new->message !!}</p>
    </div>

    <!-- Footer Meta -->
    <div class="card-footer d-flex justify-content-between align-items-center small text-muted flex-wrap">
        <p class="mb-0">
            <i class="fas fa-user-circle me-1"></i>
            <strong>{{ $new->postedBy->first_name }} {{ $new->postedBy->middle_name }}</strong>
        </p>
        <p class="mb-0">
            <i class="far fa-clock me-1"></i>
            {{ $new->created_at->format('M d, Y') }}
            <span class="ms-2">({{ $new->created_at->diffForHumans() }})</span>
        </p>
    </div>

    <!-- Action Buttons -->
    <div class="card-footer d-flex justify-content-end gap-2">
        @can('update-news')
            <a href="{{ route('news.edit', $new->id) }}" class="btn btn-sm btn-outline-info">
                <i class="fa-solid fa-pen-to-square me-1"></i>Edit
            </a>
        @endcan
        @can('delete-news')
            <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-id="{{ $new->id }}">
                <i class="fa-solid fa-trash-can me-1"></i>Delete
            </button>
        @endcan
    </div>
</div>
@endforeach
