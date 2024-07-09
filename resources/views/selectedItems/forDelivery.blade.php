    @extends('app')

    @section('content')
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
                            <td><span class="badge bg-label-primary me-1">{{ $user['referenceNo'] }}</span></td>
                            <td>
                                @if($user['payment_type'] == 'COD')
                                <span class="badge bg-label-primary me-1">{{ $user['payment_type'] }}</span>
                                @elseif($user['payment_type'] == 'G-cash')
                                <span class="badge bg-label-info me-1">{{ $user['payment_type'] }}</span>
                                @else
                                <span class="badge bg-label-secondary me-1">{{ $user['payment_type'] }}</span>
                                @endif
                            </td>
                            @if($user['delivery_date'])
                            <td> <span class="badge bg-label-success me-1">{{ \Carbon\Carbon::parse($user['delivery_date'])->format('l, F j, Y g:i A') }}</span></td>
                            @else
                            <td> <span class="badge bg-label-danger me-1">Not Scheduled Yet</span></td>
                            @endif
                            <td>
                                <a class="bx bx-message-alt me-1 details-button" href="#" data-bs-toggle="modal" data-bs-target="#forDelivery{{$user['referenceNo']}}" data-user-id="{{ $user['referenceNo'] }}"></a>
                                @include('selectedItems.modal.forDelivery')
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