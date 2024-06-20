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
                        <th>User Name</th>
                        <th>Reference No.</th>
                        <th>Facebook</th>
                        <th>Address</th>
                        <th>Items</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tableBody">
                    @if(count($userByReference) > 0)
                    @foreach ($userByReference as $user)
                    <tr>
                        <td style="display: none;" class="id-field">{{ $user['id'] }}</td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['referenceNo'] }}</td>
                        <td>{{ $user['fb_link'] }}</td>
                        <td>{{ $user['address'] }}</td>
                        <td>
                            <a class="bx bx-message-alt me-1 details-button" href="#" data-bs-toggle="modal" data-bs-target="#messages{{$user['referenceNo']}}" data-user-id="{{ $user['referenceNo'] }}"></a>
                            @include('selectedItems.modal.moreInfo')
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
    addEventListener('DOMContentLoaded', function() {

        var subTotalField = document.querySelectorAll('.item-sub-total');
        var totalContainer = [];

        subTotalField.forEach(function(subtotal) {

            var itemReferenceNo= subtotal.getAttribute('data-item-id');
            var toSplit = itemReferenceNo;
            var [referenceNo, itemId] = toSplit.split('_');

            var price = document.querySelector('.item-price[data-item-id="' + itemReferenceNo + '"]').value;
            var quantity = document.querySelector('.item-quantity[data-item-id="' + itemReferenceNo + '"]').value;
            var userSubTotalField = document.querySelector('.item-sub-total[data-item-id="' + itemReferenceNo + '"]');

            var tempSubTotal;
            tempSubTotal = price * quantity;
            userSubTotalField.value = tempSubTotal;

            if (totalContainer[referenceNo] == null) {
                totalContainer[referenceNo] = tempSubTotal;
            } else {
                totalContainer[referenceNo] += tempSubTotal;
            }
        });


        var totals = document.querySelectorAll('.purchase-total');

        totals.forEach(function(total) {

            var totalId = total.getAttribute('data-total-id');

            total.querySelector('.purchase-total[data-total-id="' + totalId + '"]');

            total.value = totalContainer[totalId];
        });
    });
</script>
@endsection