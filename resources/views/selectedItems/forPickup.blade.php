@extends('app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">For Pickup Orders</h4>
            <form action="{{ route('selectedItems.forPickup') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search......" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bx-search-alt-2'></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User Name</th>
                        <th>Reference No.</th>
                        <th>Facebook</th>
                        <th>Phone</th>
                        <th>Items</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tableBody">
                    @if(count($forPickup) > 0)
                    @foreach ($forPickup as $user)
                    <tr>
                        <td style="display: none;" class="id-field">{{ $user['id'] }}</td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user['name'] }}</td>
                        <td> <span class="badge bg-label-primary me-1">{{ $user['referenceNo'] }}</span></td>
                        <td> <span class="badge bg-label-secondary me-1">{{ $user['fb_link'] }}</span></td>
                        <td> <span class="badge bg-label-secondary me-1">{{ $user['phone'] }}</span></td>
                        <td>
                            <a class="bx bx-message-alt me-1 details-button" href="#" data-bs-toggle="modal" data-bs-target="#forPickUp{{$user['referenceNo']}}" data-user-id="{{ $user['referenceNo'] }}" data-item-id="{{ $user['id'] }}"></a>
                            @include('selectedItems.modal.forPickUp')
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" class="text-center">No Selected Items found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <tfoot>
            <tr>
                <td colspan="4">
                    <div class="d-flex justify-content-between align-items-center mt-3" style="margin-bottom: 10px; margin-right: 10px;">
                        <div class="text-muted" style="margin-left: 10px;">
                            Showing {{ $forPickup->firstItem() }} to {{ $forPickup->lastItem() }} of {{ $forPickup->total() }} Results
                        </div>
                        <!-- Pagination -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-end mb-0">
                                @if ($forPickup->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link"><i class="tf-icon bx bx-chevrons-left"></i></span>
                                </li>
                                <li class="page-item disabled">
                                    <span class="page-link"><i class="tf-icon bx bx-chevron-left"></i></span>
                                </li>
                                @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $forPickup->url(1) }}"><i class="tf-icon bx bx-chevrons-left"></i></a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="{{ $forPickup->previousPageUrl() }}"><i class="tf-icon bx bx-chevron-left"></i></a>
                                </li>
                                @endif
                                @php
                                $currentPage = $forPickup->currentPage();
                                $lastPage = $forPickup->lastPage();
                                $startPage = max($currentPage - 2, 1);
                                $endPage = min($startPage + 4, $lastPage);
                                @endphp

                                @foreach ($forPickup->getUrlRange($startPage, $endPage) as $page => $url)
                                @if ($page == $currentPage)
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                                @endforeach

                                @if ($forPickup->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $forPickup->nextPageUrl() }}"><i class="tf-icon bx bx-chevron-right"></i></a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="{{ $forPickup->url($lastPage) }}"><i class="tf-icon bx bx-chevrons-right"></i></a>
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
    </div>
</div>
@endsection