@extends('app')

@section('content')
@include('layouts.sweetalert')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">For Delivery Orders</h4>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User Name</th>
                        <th>Reference No.</th>
                        <th>Payment Type</th>
                        <th>Delivery Schedule</th>
                        <th>Items</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tableBody">
                    @if(count($forDelivery) > 0)
                    @foreach ($forDelivery as $user)
                    <tr>
                        <td style="display: none;" class="id-field">{{ $user['id'] }}</td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['referenceNo'] }}</td>
                        <td>{{ $user['payment_type'] }}</td>
                        @if($user['delivery_date'])
                        <td>{{ \Carbon\Carbon::parse($user['delivery_date'])->format('l, F j, Y g:i A') }}</td>
                        @else
                        <td>Not Scheduled Yet</td>
                        @endif
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
</script>
@endsection