@if($news->hasPages())
    <div class="mt-4 py-4">
        {{ $news->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
@endif
