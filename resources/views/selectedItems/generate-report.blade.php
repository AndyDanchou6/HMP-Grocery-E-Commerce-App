<!DOCTYPE html>
<html lang="en" class="light-style" dir="ltr" data-theme="theme-default" data-assets-path="sassets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>e-Mart - Invoice Report</title>
    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('logo/2.png ') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
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

            /* Hide headers and footers */
            header,
            footer,
            nav {
                display: none !important;
            }

            /* If needed, hide specific elements */
            .print-button {
                display: none !important;
            }

            /* Page number at the bottom */
            .page-number {
                position: fixed;
                bottom: 10px;
                left: 0;
                right: 0;
                text-align: center;
                font-size: 12px;
                color: #000;
            }
        }
    </style>

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}">
    </script>
    <script src="{{ asset('assets/js/config.js') }}">
    </script>
</head>

<body>
    <!-- Content -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h2 class="text-center mb-4">Invoice Report - {{ $month == 'all' ? 'All Months' : \Carbon\Carbon::parse($month)->format('F Y') }}</h2>

            <button class="print-button btn btn-outline-success mb-4" onclick="printReport()">Print</button>
            <a href="{{ route('selectedItems.history') }}"><button class="print-button btn btn-outline-danger mb-4">Back</button></a>

            <!-- Picked Up Orders -->
            <h4 class="mb-3">{{ $orderRetrievalType == 'both' ? 'All Orders' : ucfirst($orderRetrievalType) . ' Orders' }}</h4>
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
                        <td>To Receive</td>
                        @else
                        <td>{{ ucfirst($item->status) }}</td>
                        @endif
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Manila')->format('l, F j, Y g:i A') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->updated_at)->timezone('Asia/Manila')->format('l, F j, Y g:i A') }}</td>
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

    <!-- Core JS -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        function printReport() {
            // Hide the print buttons
            document.querySelectorAll('.print-button').forEach(button => button.style.display = 'none');

            // Create a print style sheet
            const printStyle = document.createElement('style');
            printStyle.innerHTML = `
                @media print {
                    @page {
                        margin: 20mm;
                    }
                    /* Additional print styles can be added here */
                }
            `;
            document.head.appendChild(printStyle);

            // Open print dialog
            window.print();

            // Show the print buttons again after printing
            document.querySelectorAll('.print-button').forEach(button => button.style.display = 'block');

            // Remove the print style after printing
            document.head.removeChild(printStyle);
        }
    </script>
</body>

</html>