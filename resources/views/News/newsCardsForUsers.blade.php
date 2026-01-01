@foreach($news as $new)
@php
    $threeDaysAgo = now()->subDays(3);
    $isNew = $new->created_at > $threeDaysAgo;
@endphp

<div class="card shadow-sm news-card" data-id="{{ $new->id }}">
    
    <!-- Title Section -->
    <div class="card-header d-flex justify-content-between align-items-center">  
        <h3 class="card-title mb-0">{!! $new->title !!}</h3>
        @if($isNew)
            <span class="badge bg-danger text-white  ms-auto ">NEW</span>
        @endif
    </div>

    <!-- Body Section -->
    <div class="card-body">
        @if(!empty($new->images))
            <div class="news-images">
                @foreach($new->images as $key => $image)
                    <img src="{{ asset($image) }}"
                         alt="News Image"
                         class="hover-grow news-image-trigger shadow-sm"
                         data-image-urls="{{ json_encode($new->images) }}"
                         data-image-index="{{ $key }}">
                @endforeach
            </div>
        @endif

        <p class="card-text">{!! $new->message !!}</p>
    </div>

    <!-- Footer Section -->
    <div class="card-footer">
        <span>
            <i class="far fa-calendar-alt me-1"></i>
            {{ $new->created_at->format('M d, Y') }}
            <span class="ms-2">({{ $new->created_at->diffForHumans() }})</span>
        </span>
    </div>

</div>
@endforeach

