@foreach ($news as $new)

    @if(!$new || !($new instanceof \App\Models\News))
        @continue
    @endif

    @php
        $threeDaysAgo = now()->subDays(2);
        $isNew = $new->created_at && $new->created_at > $threeDaysAgo;
        $preview = Str::limit(strip_tags($new->message ?? ''), 180, '...');
        $images = is_array($new->images) ? $new->images : [];
    @endphp

    <div class="card news-card h-100 shadow-sm border-1 rounded-2 overflow-hidden d-flex flex-column
                bg-white dark:bg-[#1d1f23] 
                border-gray-200 dark:border-[#2c2f35]
                text-gray-900 dark:text-gray-200 transition">

        {{-- Header --}}
        <div class="card-header bg-light text-center py-2
                    dark:bg-[#2a2d31] dark:text-gray-200">
            @if($isNew)
                <span class="badge bg-danger px-3 py-1 fw-bold">NEW</span>
            @endif
        </div>

        {{-- Body --}}
        <div class="card-body d-flex flex-column">

            {{-- Images --}}
            @if(count($images) > 0)
                <div class="news-images mb-3 d-flex gap-2 flex-wrap justify-content-center">

                    @foreach ($images as $i => $image)
                        @if($i < 2)
                            <div class="position-relative border-1 ">
                                <img src="{{ asset($image) }}"
                                     alt="news image"
                                     class="news-image-trigger"
                                     style="cursor:pointer; max-width:fit-content; height:100px; object-fit:cover;"
                                     data-image-urls="{{ json_encode($images) }}"
                                     data-image-index="{{ $i }}">

                                {{-- Overlay for extra images --}}
                                @if($i === 1 && count($images) > 2)
                                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center
                                                bg-black/50 dark:bg-black/60 text-white dark:text-gray-100"
                                         style="font-weight:bold; font-size:1.2rem; cursor:pointer;">
                                        +{{ count($images) - 2 }} more
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach

                </div>
            @endif

            {{-- Title --}}
            <h3 class="news-title fw-bold mb-2 text-[#1c2a39] dark:text-white" style="font-size:1.15rem;">
                {!! $new->title !!}
            </h3>

            {{-- Preview --}}
            <h5 class=" text-[#1c2a39] dark:text-white" style="flex-grow:1; line-height:1.5;">
                {!! $preview !!}
            </h5>

            {{-- Read more --}}
            <div class="mt-auto text-end">
                <a href="{{ route('news.show', $new->id) }}" 
                   class="btn btn-outline-primary btn-sm fw-semibold rounded-pill
                          dark:border-gray-500 dark:text-gray-300 dark:hover:bg-gray-700"
                   target="_blank">
                    View Full Post →
                </a>
            </div>

        </div>

        {{-- Footer --}}
        <div class="card-footer bg-white dark:bg-[#1d1f23] border-top-0 
                    text-muted dark:text-gray-400 
                    border-gray-200 dark:border-[#2c2f35]
                    small d-flex justify-content-between align-items-center pt-2">

            <span>
                <i class="far fa-calendar-alt me-1"></i>
                @if($new->created_at)
                    {{ $new->created_at->format('M d, Y') }}
                @else
                    N/A
                @endif
            </span>

            <span>
                @if($new->created_at)
                    ({{ $new->created_at->diffForHumans() }})
                @else
                    (N/A)
                @endif
            </span>

        </div>

    </div>

@endforeach

make the  image fit to the card.. witdh