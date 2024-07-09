@if ($paginator->hasPages())
<div class="product__pagination">
    {{-- First Page Link --}}
    @if ($paginator->onFirstPage())
    <a class="disabled"><i class="fa fa-angle-double-left"></i></a>
    @else
    <a href="{{ $paginator->url(1) }}" rel="first"><i class="fa fa-angle-double-left"></i></a>
    @endif

    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
    <a class="disabled"><i class="fa fa-long-arrow-left"></i></a>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa fa-long-arrow-left"></i></a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
    {{-- "Three Dots" Separator --}}
    @if (is_string($element))
    <a class="disabled">{{ $element }}</a>
    @endif

    {{-- Array Of Links --}}
    @if (is_array($element))
    @foreach ($element as $page => $url)
    @if ($page == $paginator->currentPage())
    <a class="active">{{ $page }}</a>
    @else
    <a href="{{ $url }}">{{ $page }}</a>
    @endif
    @endforeach
    @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa fa-long-arrow-right"></i></a>
    @else
    <a class="disabled"><i class="fa fa-long-arrow-right"></i></a>
    @endif

    {{-- Last Page Link --}}
    @if ($paginator->hasMorePages())
    <a href="{{ $paginator->url($paginator->lastPage()) }}" rel="last"><i class="fa fa-angle-double-right"></i></a>
    @else
    <a class="disabled"><i class="fa fa-angle-double-right"></i></a>
    @endif
</div>
<style>
    .product__pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        list-style: none;
        padding: 0;
    }

    .product__pagination a {
        display: flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        color: #333;
        margin: 0 5px;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        transition: background-color 0.3s, color 0.3s;
    }

    .product__pagination a.disabled {
        color: #bbb;
        cursor: not-allowed;
    }

    .product__pagination a:hover:not(.disabled):not(.active) {
        background-color: #f0f0f0;
    }

    .product__pagination a.active {
        font-weight: bold;
        color: #fff;
        background-color: #696cff;
        border-color: #696cff;
    }

    .product__pagination a i {
        margin: 0 5px;
    }
</style>
@endif