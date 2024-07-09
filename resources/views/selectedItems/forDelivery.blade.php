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
                            <td>{{ $user['referenceNo'] }}</td>
                            <td>{{ $user['payment_type'] }}</td>
                            @if($user['delivery_date'])
                            <td>{{ \Carbon\Carbon::parse($user['delivery_date'])->format('l, F j, Y g:i A') }}</td>
                            @else
                            <td>Not Scheduled Yet</td>
                            @endif
                            <td>
                                <a href="#" class="btn btn-primary my-auto ms-2" data-bs-toggle="modal" data-bs-target="#createModal">Add New</a>
                                @include('users.modal.create')
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="7" class="text-center">No Selected Items found1.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
        </div>
    </div>
</div>
@endsection

