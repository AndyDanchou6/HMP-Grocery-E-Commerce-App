@extends('app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">Items to be Delivered</h4>
            <form action="{{ route('selectedItems.courierDashboard') }}" method="GET" class="d-flex">
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
                        <th>User Name</th>
                        <th>Reference No.</th>
                        <th>Phone No.</th>
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
                        <td><span class="badge bg-label-primary me-1">{{ $user['referenceNo'] }}</span></td>
                        <td><span class="badge bg-label-secondary me-1">{{ $user['phone'] }}</td>
                        <td><span class="badge bg-label-info me-1">{{ $user['address'] }}</td>
                        <td>
                            <a class="bx bx-box me-1 details-button" href="#" data-bs-toggle="modal" data-bs-target="#deliverInfo{{$user['referenceNo']}}" data-user-id="{{ $user['referenceNo'] }}"></a>
                            @include('selectedItems.modal.deliveryInfo')
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" class="text-center">No delivery requests available.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection