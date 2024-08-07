@extends('app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">For Package Orders</h4>
            <form action="{{ route('selectedItems.forPackaging') }}" method="GET" class="d-flex">
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
                        <th>Reference No.</th>
                        <th>User Name</th>
                        <th>Retrieval</th>
                        <th>Payment</th>
                        <th>Items</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tableBody">
                    @if(count($forPackage) > 0)
                    @foreach ($forPackage as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <span class="badge bg-label-primary me-1">{{ $user['referenceNo'] }}</span>
                        </td>
                        <td>{{ $user['name'] }}</td>
                        <td>
                            @if($user['order_retrieval'] == 'delivery')
                            <span class="badge bg-label-info me-1">{{ $user['order_retrieval'] }}</span>
                            @else
                            <span class="badge bg-label-primary me-1">{{ $user['order_retrieval'] }}</span>
                            @endif
                        </td>
                        <td>
                            @if($user['payment_type'] == 'COD')
                            <span class="badge bg-label-warning me-1">{{ $user['payment_type'] }}</span>
                            @elseif($user['payment_type'] == 'G-cash')
                            <span class="badge bg-label-danger me-1">{{ $user['payment_type'] }}</span>
                            @else
                            <span class="badge bg-label-secondary me-1">{{ $user['payment_type'] }}</span>
                            @endif
                        </td>
                        <td>
                            <a class="bx bx-message-alt me-1 details-button" href="#" data-bs-toggle="modal" data-bs-target="#readyMessages{{$user['referenceNo']}}" data-user-id="{{ $user['referenceNo'] }}"></a>
                            @include('selectedItems.modal.readyPackage')
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>

                        <td colspan="7" class="text-center">No orders for packaging.</td>

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
                            Showing {{ $forPackage->firstItem() }} to {{ $forPackage->lastItem() }} of {{ $forPackage->total() }} Results
                        </div>
                        <!-- Pagination -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-end mb-0">
                                @if ($forPackage->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link"><i class="tf-icon bx bx-chevrons-left"></i></span>
                                </li>
                                <li class="page-item disabled">
                                    <span class="page-link"><i class="tf-icon bx bx-chevron-left"></i></span>
                                </li>
                                @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $forPackage->url(1) }}"><i class="tf-icon bx bx-chevrons-left"></i></a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="{{ $forPackage->previousPageUrl() }}"><i class="tf-icon bx bx-chevron-left"></i></a>
                                </li>
                                @endif
                                @php
                                $currentPage = $forPackage->currentPage();
                                $lastPage = $forPackage->lastPage();
                                $startPage = max($currentPage - 2, 1);
                                $endPage = min($startPage + 4, $lastPage);
                                @endphp

                                @foreach ($forPackage->getUrlRange($startPage, $endPage) as $page => $url)
                                @if ($page == $currentPage)
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                                @endforeach

                                @if ($forPackage->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $forPackage->nextPageUrl() }}"><i class="tf-icon bx bx-chevron-right"></i></a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="{{ $forPackage->url($lastPage) }}"><i class="tf-icon bx bx-chevrons-right"></i></a>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {

        var deliveryAddresses = document.querySelectorAll('.delivery-address');

        if (deliveryAddresses) {
            deliveryAddresses.forEach(function(address) {

                var userReference = address.getAttribute('data-user-reference');

                var serviceFeeDiv = document.querySelector('#service-fee' + userReference);
                var serviceFeeInput = serviceFeeDiv.querySelector('input');

                var purchaseTotal = document.querySelector('#purchase-total' + userReference);
                var trimmedValue = purchaseTotal.value.substring(1).trim();
                var cleanPurchaseTotalValue = trimmedValue.replace(/,/g, '');
                var floatPurchaseTotalValue = parseFloat(cleanPurchaseTotalValue);

                var totalWithFeeField = document.querySelector('#total-with-fee' + userReference);

                if (totalWithFeeField) {

                    var totalWithFeeInput = totalWithFeeField.querySelector('input');

                    var selectedAddress = address.options[address.selectedIndex];
                    var selectedFee = selectedAddress.getAttribute('data-fee');

                    if (selectedFee == null) {

                        serviceFeeInput.value = '₱0.00';
                        totalWithFeeInput.value = '₱0.00'
                    } else {

                        var floatFeeValue = parseFloat(selectedFee);
                        serviceFeeInput.value = '₱' + floatFeeValue.toFixed(2);

                        var totalWithFee = floatFeeValue + floatPurchaseTotalValue;
                        totalWithFeeInput.value = '₱' + totalWithFee.toFixed(2);
                    }
                }

                address.addEventListener('change', function() {

                    var selectedAddress = address.options[address.selectedIndex];
                    var selectedFee = selectedAddress.getAttribute('data-fee');
                    var floatFeeValue = parseFloat(selectedFee);
                    serviceFeeInput.value = '₱' + floatFeeValue.toFixed(2);

                    var totalWithFee = floatFeeValue + floatPurchaseTotalValue;
                    totalWithFeeInput.value = '₱' + totalWithFee.toFixed(2);
                });
            });
        }
    })
</script>

@endsection