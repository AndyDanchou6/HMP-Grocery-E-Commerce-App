<!DOCTYPE html>

<html lang="en" class="light-style" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Invoice Report - July 2024</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('logo/2.png ') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

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
            #printButton {
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
    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>
</head>

<body>

    <!-- Content -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h2 class="text-center mb-4">Invoice Report - July 2024</h2>

            <button id="printButton" onclick="printReport()" class="btn btn-outline-success mb-4">Print</button>
            <a id="printButton" href="{{ route('selectedItems.history') }}" class="btn btn-outline-danger mb-4">Back</a>

            <!-- Picked Up Orders -->
            <h4 class="mb-3">Picked Up Orders</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Reference No.</th>
                        <th scope="col">User ID</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Payment Type</th>
                        <th scope="col">Payment Condition</th>
                        <th scope="col">Status</th>
                        <th scope="col">Delivery Date</th>
                        <th scope="col">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>123457</td>
                        <td>2</td>
                        <td>3</td>
                        <td>COD</td>
                        <td>Unpaid</td>
                        <td>Picked Up</td>
                        <td>N/A</td>
                        <td>07/02/2024</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>

    <!-- Core JS -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
    <script src="../assets/js/main.js"></script>

    <script>
        function printReport() {
            // Hide the print button
            document.getElementById('printButton').style.display = 'none';

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

            // Show the print button again after printing
            document.getElementById('printButton').style.display = 'block';

            // Remove the print style after printing
            document.head.removeChild(printStyle);
        }
    </script>

</body>

</html>