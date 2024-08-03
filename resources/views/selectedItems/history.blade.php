@extends('app')

@section('content')
@include('layouts.sweetalert')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">Package History</h4>
            <form action="{{ route('selectedItems.history') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search......" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bx-search-alt-2'></i>
                    </button>
                </div>
            </form>
            <a href="{{ route('generate-invoice', ['month' => request('month'), 'type' => request('type')]) }}" class="btn btn-primary my-auto ms-2">Generate Report</a>
        </div>
        <div class="card-body">
            <div class="d-flex">
                <form action="{{ route('selectedItems.history') }}" method="GET" class="d-flex mb-4">
                    <div class="form-group me-1">
                        <label for="monthSelect" class="visually-hidden">Choose a month:</label>
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ request('month') == 'all' || !request('month') ? 'All Months' : \Carbon\Carbon::parse(request('month'))->format('F Y') }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="max-height: 250px; overflow-y: auto;">
                                <li><a class="dropdown-item" href="?month=all&type={{ request('type') }}">All Months</a></li>
                                @foreach ($months as $month)
                                <li><a class="dropdown-item" href="?month={{ $month }}&type={{ request('type') }}">
                                        {{ \Carbon\Carbon::parse($month)->format('F Y') }}
                                    </a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="form-group me-1">
                        <form action="" method="GET">
                            <input type="hidden" name="month" value="{{ request('month') }}">
                            <select name="type" class="form-select" onchange="this.form.submit()">
                                <option value="both" {{ request('type') == 'both' ? 'selected' : '' }}>Both</option>
                                <option value="delivery" {{ request('type') == 'delivery' ? 'selected' : '' }}>Delivery</option>
                                <option value="pickup" {{ request('type') == 'pickup' ? 'selected' : '' }}>Pickup</option>
                            </select>
                        </form>
                    </div>
                </form>
            </div>
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
                        <th>Payment Type</th>
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
                            @if($user['status'] == 'denied')
                            <a class="bx bx-message-alt me-1 details-button text-danger bx-tada" href="#" data-bs-toggle="modal" data-bs-target="#messages{{ $referenceNo }}" data-user-id="{{ $referenceNo }}"></a>
                            @include('selectedItems.modal.info', ['user' => $user])
                            @elseif($user['status'] == 'pickedUp' || $user['status'] == 'delivered')
                            <a class="bx bx-message-alt me-1 details-button text-success" href="#" data-bs-toggle="modal" data-bs-target="#messages{{ $referenceNo }}" data-user-id="{{ $referenceNo }}"></a>
                            @include('selectedItems.modal.info', ['user' => $user])
                            @else
                            <a class="bx bx-message-alt me-1 details-button" href="#" data-bs-toggle="modal" data-bs-target="#messages{{ $referenceNo }}" data-user-id="{{ $referenceNo }}"></a>
                            @include('selectedItems.modal.info', ['user' => $user])
                            @endif
                        </td>
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
                            @else
                            <span class="badge bg-label-danger me-1">Unpaid</span>
                            @endif
                        </td>
                        <td>
                            @if($user['status'] == 'forPackage')
                            <span class="badge bg-label-primary me-1">Pending</span>
                            @elseif($user['status'] == 'readyForRetrieval')
                            <span class="badge bg-label-warning me-1">Processing</span>
                            @elseif($user['status'] == 'delivered' || $user['status'] == 'pickedUp')
                            <span class="badge bg-label-success me-1">Completed</span>
                            @else
                            <span class="badge bg-label-danger me-1">{{ $user['status'] }}</span>
                            @endif
                        </td>
                        <td>
                            @if($user['proof_of_delivery'])
                            <a class="bi bi-eye me-1 details-button" href="#" data-bs-toggle="modal" data-bs-target="#proof{{ $referenceNo }}" data-user-id="{{ $referenceNo }}"></a>
                            @include('selectedItems.modal.proof', ['user' => $user])
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="9" class="text-center">No package history available.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @include('selectedItems.pagination2')
    </div>
</div>
</div>
<script>
    document.querySelectorAll('.btn-group').forEach(group => {
        const button = group.querySelector('.dropdown-toggle');
        group.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function() {
                button.textContent = this.textContent;
            });
        });
    });
</script>
@endsection