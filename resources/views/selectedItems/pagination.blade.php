<tfoot>
    <tr>
        <td colspan="4">
            <div class="d-flex justify-content-between align-items-center mt-3" style="margin-bottom: 10px; margin-right: 10px;">
                <div class="text-muted" style="margin-left: 10px;">
                    Showing {{ $userByReference->firstItem() }} to {{ $userByReference->lastItem() }} of {{ $userByReference->total() }} Results
                </div>
                <!-- Pagination -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-end mb-0">
                        @if ($userByReference->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link"><i class="tf-icon bx bx-chevrons-left"></i></span>
                        </li>
                        <li class="page-item disabled">
                            <span class="page-link"><i class="tf-icon bx bx-chevron-left"></i></span>
                        </li>
                        @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $userByReference->url(1) }}"><i class="tf-icon bx bx-chevrons-left"></i></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="{{ $userByReference->previousPageUrl() }}"><i class="tf-icon bx bx-chevron-left"></i></a>
                        </li>
                        @endif
                        @php
                        $currentPage = $userByReference->currentPage();
                        $lastPage = $userByReference->lastPage();
                        $startPage = max($currentPage - 2, 1);
                        $endPage = min($startPage + 4, $lastPage);
                        @endphp

                        @foreach ($userByReference->getUrlRange($startPage, $endPage) as $page => $url)
                        @if ($page == $currentPage)
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                        @endforeach

                        @if ($userByReference->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $userByReference->nextPageUrl() }}"><i class="tf-icon bx bx-chevron-right"></i></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="{{ $userByReference->url($lastPage) }}"><i class="tf-icon bx bx-chevrons-right"></i></a>
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
        </td>
    </tr>
</tfoot>