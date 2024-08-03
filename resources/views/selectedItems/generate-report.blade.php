<!DOCTYPE html>
<html lang="en" class="light-style" dir="ltr" data-theme="theme-default" data-assets-path="sassets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>e-Mart - Invoice Report</title>
    <meta name="description" content="" />

    <link rel="icon" type="image/x-icon" href="{{ asset('logo/2.png ') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .content-wrapper,
            .content-wrapper * {
                visibility: visible;
            }

            .content-wrapper {
                position: absolute;
                left: 0;
                top: 0;
            }

            header,
            footer,
            nav {
                display: none !important;
            }

            .print-button {
                display: none !important;
            }

            @page {
                size: auto;
                margin: 20mm;
            }

            .page-break {
                page-break-after: always;
            }

            body {
                counter-reset: page;
            }

            .content-wrapper::after {
                position: fixed;
                bottom: 10px;
                left: 50%;
                transform: translateX(-50%);
                font-size: 12px;
                color: #000;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                padding: 8px;
                text-align: left;
                border: 1px solid #000;
            }

            th {
                background-color: #f2f2f2;
            }
        }

        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    </style>

    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h2 class="text-center mb-4">Invoice Report - {{ $month == 'all' ? 'All Months' : \Carbon\Carbon::parse($month)->format('F Y') }}</h2>

            <button class="print-button btn btn-outline-success mb-4" onclick="printReport()">Print</button>
            <a href="{{ route('selectedItems.history') }}"><button class="print-button btn btn-outline-danger mb-4">Back</button></a>

            <h4 class="mb-3">{{ $orderRetrievalType == 'both' ? 'All Orders' : ucfirst($orderRetrievalType) . ' Orders' }}</h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Reference No.</th>
                            <th scope="col">User Name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Payment Type</th>
                            <th scope="col">Payment Condition</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date Ordered</th>
                            @if ($orderRetrievalType == 'delivery')
                            <th scope="col">Date Delivered</th>
                            @elseif($orderRetrievalType == 'pickup')
                            <th scope="col">Date Picked Up</th>
                            @else
                            <th scope="col">Date Completed</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($fetchReport) > 0)
                        @foreach($fetchReport as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->referenceNo }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->payment_type }}</td>
                            @if($item->payment_condition == 'paid')
                            <td>Paid</td>
                            @else
                            <td>Not paid yet</td>
                            @endif
                            @if($item->status == 'forPackage')
                            <td>Pending</td>
                            @elseif($item->status == 'readyForRetrieval')
                            <td>Processing</td>
                            @else
                            <td>{{ ucfirst($item->status) }}</td>
                            @endif
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Manila')->format('F j, Y g:i A') }}</td>
                            @if($item->status == 'delivered' || $item->status == 'pickedUp')
                            <td>{{ \Carbon\Carbon::parse($item->updated_at)->timezone('Asia/Manila')->format('F j, Y g:i A') }}</td>
                            @else
                            <td>Not completed yet</td>
                            @endif
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="9" class="text-center">No Record Found.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        function printReport() {
            window.print();
        }
    </script>
</body>

</html>