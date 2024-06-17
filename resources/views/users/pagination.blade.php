<div class="d-flex justify-content-between align-items-center mt-3" style="margin-bottom: 10px; margin-right: 10px;">
    <div class="text-muted" style="margin-left: 10px;">
        Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} Results
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-end mb-0">
            @if ($users->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link"><i class="tf-icon bx bx-chevrons-left"></i></span>
            </li>
            <li class="page-item disabled">
                <span class="page-link"><i class="tf-icon bx bx-chevron-left"></i></span>
            </li>
            @else
            <li class="page-item">
                <a class="page-link" href="{{ $users->previousPageUrl() }}"><i class="tf-icon bx bx-chevron-left"></i></a>
            </li>
            <li class="page-item">
                <a class="page-link" href="{{ $users->url(1) }}"><i class="tf-icon bx bx-chevrons-left"></i></a>
            </li>
            @endif

            @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
            @if ($page == $users->currentPage())
            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
            @else
            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
            @endif
            @endforeach

            @if ($users->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $users->nextPageUrl() }}"><i class="tf-icon bx bx-chevron-right"></i></a>
            </li>
            <li class="page-item">
                <a class="page-link" href="{{ $users->url($users->lastPage()) }}"><i class="tf-icon bx bx-chevrons-right"></i></a>
            </li>
            @else
            <li class="page-item disabled">
                <span class="page-link"><i class="tf-icon bx bx-chevron-right"></i></span>
            </li>
            <li class="page-item disabled">
                <span class="page-link"><i class="tf-icon bx bx-chevrons-right"></i></span>
            </li>
            @endif
        </ul>
    </nav>
</div>