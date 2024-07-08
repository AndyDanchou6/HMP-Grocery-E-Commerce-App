@extends('app')

@section('content')
@include('layouts.sweetalert')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">Package History</h4>
            <form action="{{ route('selected-items.show') }}" method="GET" class="d-flex">
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
                        <th>Items</th>
                        <th>Order Type</th>
                        <th>Payment Condition</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tableBody">
                    @if(count($userByReference) > 0)
                    @foreach ($userByReference as $referenceNo => $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge bg-label-primary me-1">{{ $referenceNo }}</span></td>
                        <td>{{ $user['name'] }}</td>
                        <td>
                            <a class="bx bx-message-alt me-1 details-button" href="#" data-bs-toggle="modal" data-bs-target="#messages{{ $referenceNo }}" data-user-id="{{ $referenceNo }}"></a>
                            @include('selectedItems.modal.info', ['user' => $user])
                        </td>
                        <td>
                            @if($user['order_retrieval'] == 'delivery')
                            <span class="badge bg-label-info me-1">Delivery</span>
                            @elseif($user['order_retrieval'] == 'pickup')
                            <span class="badge bg-label-primary me-1">Pickup</span>
                            @endif
                        </td>
                        <td>
                            @if($user['payment_condition'] == 'paid')
                            <span class="badge bg-label-success me-1">Paid</span>
                            @else
                            <span class="badge bg-label-danger me-1">Unpaid</span>
                            @endif
                        </td>
                        <td>
                            @if($user['status'] == 'forPackage')
                            <span class="badge bg-label-danger me-1">Pending</span>
                            @elseif($user['status'] == 'readyForRetrieval')
                            <span class="badge bg-label-warning me-1">To receive</span>
                            @elseif($user['status'] == 'delivered' || $user['status'] == 'pickedUp')
                            <span class="badge bg-label-success me-1">Completed</span>
                            @endif
                        </td>
                        <td>
                            @if($user['payment_condition'] == NULL)
                            <form action="{{ route('selected-items.updatePaymentCondition', ['referenceNo' => $referenceNo]) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="payment_condition" id="payment_condition" value="paid">
                                <button type="submit" class="btn btn-link p-0 m-0">
                                    <i class="bx bx-check details-button"></i>
                                </button>
                            </form>
                            @endif
                            @if($user['order_retrieval'] == 'delivery')
                            <a class="bi bi-eye me-1 details-button" href="#" data-bs-toggle="modal" data-bs-target="#proof{{ $referenceNo }}" data-user-id="{{ $referenceNo }}"></a>
                            @include('selectedItems.modal.proof', ['user' => $user])
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8" class="text-center">No Package Items found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @include('selectedItems.pagination')
    </div>
</div>
</div>
@endsection