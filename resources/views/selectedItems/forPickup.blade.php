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
                    @if(count($forPickup) > 0)
                    @foreach ($forPickup as $user)
                    <tr>
                        <td style="display: none;" class="id-field">{{ $user['id'] }}</td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['referenceNo'] }}</td>
                        <td>{{ $user['fb_link'] }}</td>
                        <td>{{ $user['address'] }}</td>
                        <td>
                            <a class="bx bx-message-alt me-1 details-button" href="#" data-bs-toggle="modal" data-bs-target="#messages{{$user['referenceNo']}}" data-user-id="{{ $user['referenceNo'] }}"></a>
                        </td>
                    </tr>
                    @include('selectedItems.modal.moreInfo')
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
    document.addEventListener('DOMContentLoaded', function() {
        function hideOptions(orderRetrieval) {
            var options = document.querySelectorAll('.payment_type');

            options.forEach(function(option) {
                if (orderRetrieval == 'delivery') {
                    if (option.classList.contains('instore')) {
                        option.style.display = 'none';
                    }
                    if (option.classList.contains('cod')) {
                        option.style.display = 'block';
                    }
                } else if (orderRetrieval == 'pickup') {
                    if (option.classList.contains('cod')) {
                        option.style.display = 'none';
                    }
                    if (option.classList.contains('instore')) {
                        option.style.display = 'block';
                    }
                }
            });
        }

        var orderRetrievals = document.querySelectorAll('.order_retrieval');

        orderRetrievals.forEach(function(orderRetrieval) {

            hideOptions(orderRetrieval.value);

            orderRetrieval.addEventListener('change', function() {

                hideOptions(orderRetrieval.value);
            });
        });

        var subTotalField = document.querySelectorAll(".item-sub-total");
        var totalContainer = {};

        subTotalField.forEach(function(subtotal) {
            var itemReferenceNo = subtotal.getAttribute("data-item-id");
            var [referenceNo, itemId] = itemReferenceNo.split("_");

            var price = parseFloat(
                document
                .querySelector(
                    '.item-price[data-item-id="' + itemReferenceNo + '"]'
                )
                .value.replace(/[^0-9.-]+/g, "")
            );
            var quantity = parseInt(
                document.querySelector(
                    '.item-quantity[data-item-id="' + itemReferenceNo + '"]'
                ).value
            );

            if (quantity < 0) {
                alert("Quantity cannot be negative.");
                quantity = 0;
                document.querySelector(
                    '.item-quantity[data-item-id="' + itemReferenceNo + '"]'
                ).value = 0;
            }

            var userSubTotalField = document.querySelector(
                '.item-sub-total[data-item-id="' + itemReferenceNo + '"]'
            );

            var tempSubTotal = price * quantity;
            userSubTotalField.value = tempSubTotal.toLocaleString("en-PH", {
                style: "currency",
                currency: "PHP",
            });

            if (!totalContainer[referenceNo]) {
                totalContainer[referenceNo] = tempSubTotal;
            } else {
                totalContainer[referenceNo] += tempSubTotal;
            }
        });

        var totals = document.querySelectorAll(".purchase-total");

        totals.forEach(function(total) {
            var totalId = total.getAttribute("data-total-id");
            total.value = totalContainer[totalId].toLocaleString("en-PH", {
                style: "currency",
                currency: "PHP",
            });
        });
    });
</script>
@endsection