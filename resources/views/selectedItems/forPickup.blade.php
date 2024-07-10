@extends('app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">For Pickup Orders</h4>
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
    </div>
</div>
@endsection