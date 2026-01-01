@foreach ($news as $new)

    @if(!$new instanceof \App\Models\News)
        @continue
    @endif

    @php
        $isNew = $new->created_at && $new->created_at > now()->subDays(2);
        $preview = Str::limit(strip_tags($new->message ?? ''), 180, '...');
        $images = is_array($new->images) ? $new->images : [];
    @endphp

    <div class="card news-card h-100 shadow-sm rounded-2 overflow-hidden d-flex flex-column
                bg-white dark:bg-[#1d1f23]
                border border-gray-200 dark:border-[#2c2f35]
                text-gray-900 dark:text-gray-200 transition">

        {{-- Body --}}
        <div class="card-body d-flex flex-column">

            {{-- Images --}}
            @if(count($images))
                <div class="news-images mb-3">

                    @foreach ($images as $i => $image)
                        @break($i >= 2)

                        <div class="position-relative mb-2">
                            <img src="{{ asset($image) }}"
                                 class="news-image-trigger w-100"
                                 style="height:150px; object-fit:cover; cursor:pointer;"
                                 data-image-urls="{{ json_encode($images) }}"
                                 data-image-index="{{ $i }}"
                                 alt="news image">

                            {{-- Extra Images Overlay --}}
                            @if($i === 1 && count($images) > 2)
                                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex
                                            align-items-center justify-content-center
                                            bg-black/50 dark:bg-black/60 text-white
                                            fw-bold"
                                     style="font-size:1.2rem; cursor:pointer;">
                                    +{{ count($images) - 2 }} more
                                </div>
                            @endif
                        </div>

                    @endforeach

                </div>
            @endif

            {{-- Title --}}
            <h3 class="fw-bold mb-2 text-[#1c2a39] dark:text-white" style="font-size:1.15rem;">
                {!! $new->title !!}
            </h3>

            {{-- Preview --}}
            <p class="text-[#1c2a39] dark:text-white flex-grow-1" style="line-height:1.5;">
                {!! $preview !!}
            </p>

        </div>

        {{-- Footer --}}
        <div class="card-footer d-flex justify-content-between align-items-center small
                    bg-white dark:bg-[#1d1f23]
                    text-muted dark:text-gray-400 border-0">

            {{-- Date --}}
            <span>
                <i class="far fa-calendar-alt me-1"></i>
                {{ optional($new->created_at)->format('M d, Y') ?? 'N/A' }}
            </span>

            {{-- Human Time --}}
            <span>
                ({{ optional($new->created_at)->diffForHumans() ?? 'N/A' }})
            </span>

        </div>

        {{-- Read More --}}
        <div class="p-3 pt-0 text-end">
            <a href="{{ route('news.show', $new->id) }}"
               class="btn btn-outline-primary btn-sm fw-semibold 
                      dark:border-gray-500 dark:text-gray-300 dark:hover:bg-gray-700"
               target="_blank">
                View Full Post →
            </a>
        </div>

    </div>

@endforeach
