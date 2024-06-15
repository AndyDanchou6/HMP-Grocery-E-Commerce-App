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
                        <th>Reference Number </th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tableBody">
                    @if(count($purchaser) > 0)
                    @foreach ($purchaser as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user['username'] }}</td>
                        <td>{{ $user['referenceNo'] }}</td>
                        <td>{{ $user['address'] }}</td>
                        <td>
                            <a class="bx bx-message-alt me-1" href="#" data-bs-toggle="modal" data-bs-target="#messages{{$user['id']}}"></a>
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