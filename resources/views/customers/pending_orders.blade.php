    @extends('app')

    @section('content')

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
                        <!-- Table rows will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('customers.modal.orders')

    @endsection
