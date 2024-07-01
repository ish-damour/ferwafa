@if ($paginator->hasPages())
    <div class="d-flex justify-content-between align-items-center">
        <div class="mt-1 mr-2">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>
        <div>
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="btn btn-secondary disabled">Previous</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-outline-primary my-1">Previous</a>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-outline-success">Next</a>
            @else
                <span class="btn btn-secondary disabled">Next</span>
            @endif
        </div>
    </div>
@endif
