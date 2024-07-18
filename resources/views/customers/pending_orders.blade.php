@extends('app')

@section('content')

<<<<<<< HEAD
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header row justify-content-between align-items-center">
            <h4 class="col-md-3"><span class="badge bg-label-danger me-1">Pending Orders</span></h4>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Reference No.</th>
                        <th>Order Type</th>
                        <th>Payment Type</th>
                        <th>Payment Condition</th>
                        <th>Items</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tableBody">
                    @if(count($userByReference) > 0)
                    @foreach ($userByReference as $referenceNo => $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge bg-label-primary me-1">{{ $referenceNo }}</span></td>
                        <td>
                            @if($user['order_retrieval'] == 'delivery')
                            <span class="badge bg-label-info me-1">Delivery</span>
                            @elseif($user['order_retrieval'] == 'pickup')
                            <span class="badge bg-label-primary me-1">Pickup</span>
                            @endif
                        </td>
                        <td>
                            @if($user['payment_type'] == 'COD')
                            <span class="badge bg-label-primary me-1">{{ $user['payment_type'] }}</span>
                            @elseif($user['payment_type'] == 'G-cash')
                            <span class="badge bg-label-info me-1">{{ $user['payment_type'] }}</span>
                            @else
                            <span class="badge bg-label-secondary me-1">{{ $user['payment_type'] }}</span>
                            @endif
                        </td>
                        <td>
                            @if($user['payment_condition'] == 'paid')
                            <span class="badge bg-label-success me-1">Paid</span>
                            @elseif($user['payment_proof'])
                            <span class="badge bg-label-warning me-1">Pending</span>
                            @else
                            <span class="badge bg-label-danger me-1">Unpaid</span>
                            @endif
                        </td>
                        <td>
                            <a class="bx bx-message-alt me-1 details-button" href="#" data-bs-toggle="modal" data-bs-target="#messages{{ $referenceNo }}" data-user-id="{{ $referenceNo }}"></a>
                            @include('selectedItems.modal.info', ['user' => $user])
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8" class="text-center">No orders available at the moment.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
=======

>>>>>>> 093c360d90d172c83bd1c9fab1185c6c1c892723
@endsection
