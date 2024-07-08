@extends('app')

@section('content')
@include('layouts.sweetalert')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">Selected Items</h4>
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
                        <td colspan="7" class="text-center">No Selected Items found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('customScript')
<script>
    // document.addEventListener('DOMContentLoaded', function() {

    //     var subTotalField = document.querySelectorAll('.item-sub-total');
    //     var totalContainer = {};

    //     subTotalField.forEach(function(subtotal) {
    //         var itemReferenceNo = subtotal.getAttribute('data-item-id');
    //         var [referenceNo, itemId] = itemReferenceNo.split('_');

    //         var price = parseFloat(document.querySelector('.item-price[data-item-id="' + itemReferenceNo + '"]').value.replace(/[^0-9.-]+/g, ""));
    //         var quantity = parseInt(document.querySelector('.item-quantity[data-item-id="' + itemReferenceNo + '"]').value);
    //         var userSubTotalField = document.querySelector('.item-sub-total[data-item-id="' + itemReferenceNo + '"]');

    //         var tempSubTotal = price * quantity;
    //         userSubTotalField.value = tempSubTotal.toLocaleString('en-PH', {
    //             style: 'currency',
    //             currency: 'PHP'
    //         });

    //         if (!totalContainer[referenceNo]) {
    //             totalContainer[referenceNo] = tempSubTotal;
    //         } else {
    //             totalContainer[referenceNo] += tempSubTotal;
    //         }
    //     });

    //     var totals = document.querySelectorAll('.purchase-total');

    //     totals.forEach(function(total) {
    //         var totalId = total.getAttribute('data-total-id');
    //         total.value = totalContainer[totalId].toLocaleString('en-PH', {
    //             style: 'currency',
    //             currency: 'PHP'
    //         });
    //     });
    // });
</script>
@endsection