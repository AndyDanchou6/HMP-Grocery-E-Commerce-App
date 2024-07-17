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

    @section('customScript')
    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            let fetchedData = null;

            async function fetchOrders() {
                try {
                    const response = await fetch('/customer/pendingOrderUpdate');
                    const data = await response.json();
                    fetchedData = data;

                    const tableBody = document.getElementById('tableBody');
                    tableBody.innerHTML = '';

                    const userByReference = data.userByReference;

                    if (userByReference && userByReference.length > 0) {
                        userByReference.forEach((user, index) => {
                            const row = document.createElement('tr');

                            row.innerHTML = `
                                <td>${index + 1}</td>
                                <td><span class="badge bg-primary me-1">${user.referenceNo}</span></td>
                                <td><strong>${user.order_retrieval ? user.order_retrieval.charAt(0).toUpperCase() + user.order_retrieval.slice(1) : ''}</strong></td>
                                <td>
                                    <span class="badge bg-${user.payment_type === 'COD' ? 'primary' : user.payment_type === 'G-cash' ? 'info' : 'secondary'} me-1">${user.payment_type}</span>
                                </td>
                                <td>
                                    <span class="badge bg-${user.payment_condition === 'paid' ? 'success' : 'danger'} me-1">${user.payment_condition ? user.payment_condition.charAt(0).toUpperCase() + user.payment_condition.slice(1) : 'Unpaid'}</span>
                                </td>
                                <td>
                                    <a class="bx bx-message-alt me-1 details-button" href="#" data-bs-toggle="modal" data-bs-target="#messagesModal" data-reference-no="${user.referenceNo}"></a>
                                </td>
                            `;

                            tableBody.appendChild(row);

                            // row.querySelectorAll('.details-button').forEach(button => {
                            //     button.addEventListener('click', async function(event) {
                            //         event.preventDefault();
                            //         const referenceNo = event.currentTarget.getAttribute('data-reference-no');
                            //         await fetchMessages(referenceNo);
                            //     });
                            // });
                        });
                    } else {
                        const row = document.createElement('tr');
                        row.innerHTML = `<td colspan="6" class="text-center">No orders available at the moment.</td>`;
                        tableBody.appendChild(row);
                    }
                } catch (error) {
                    console.error('Error fetching orders:', error);
                } finally {
                    setTimeout(fetchOrders, 5000);
                }
            }

            // async function fetchMessages(referenceNo) {
            //     const messagesModalBody = document.querySelector('#messagesModal .modal-body');
            //     const messagesModalFooter = document.querySelector('#messagesModal .modal-footer');
            //     messagesModalBody.innerHTML = '';
            //     messagesModalFooter.innerHTML = '';

            //     if (fetchedData && fetchedData.userByReference) {
            //         const user = fetchedData.userByReference.find(user => user.referenceNo === referenceNo);

            //         if (user && user.items && user.items.length > 0) {
            //             let totalSubtotal = 0;

            //             user.items.forEach((item, index) => {
            //                 const priceFormatted = new Intl.NumberFormat('en-PH', {
            //                     style: 'currency',
            //                     currency: 'PHP'
            //                 }).format(item.price);

            //                 const subtotal = item.quantity * item.price;
            //                 totalSubtotal += subtotal;

            //                 const subtotalFormatted = new Intl.NumberFormat('en-PH', {
            //                     style: 'currency',
            //                     currency: 'PHP'
            //                 }).format(subtotal);

            //                 messagesModalBody.innerHTML += `
            //                     <div class="row mb-3 item-row">
            //                         <div class="col-12 col-sm-6 col-md-4 mb-3">
            //                             <label for="item_name_${index}" class="col-form-label">Item Name</label>
            //                             <input type="text" id="item_name_${index}" class="form-control" value="${item.product_name}" readonly>
            //                         </div>
            //                         <div class="col-6 col-sm-3 col-md-2 mb-3">
            //                             <label for="quantity_${index}" class="col-form-label">Quantity</label>
            //                             <input type="text" id="quantity_${index}" class="form-control" value="${item.quantity}" readonly>
            //                         </div>
            //                         <div class="col-6 col-sm-3 col-md-3 mb-3">
            //                             <label for="price_${index}" class="col-form-label">Price</label>
            //                             <input type="text" id="price_${index}" class="form-control" value="${priceFormatted}" readonly>
            //                         </div>
            //                         <div class="col-12 col-sm-4 col-md-3 mb-3">
            //                             <label for="subtotal_${index}" class="col-form-label">Subtotal</label>
            //                             <input type="text" id="subtotal_${index}" class="form-control" value="${subtotalFormatted}" readonly>
            //                         </div>
            //                     </div>

            //                     <div class="col-sm-12">
            //                         <hr>
            //                     </div>
            //                 `;
            //             });

            //             const totalFormatted = new Intl.NumberFormat('en-PH', {
            //                 style: 'currency',
            //                 currency: 'PHP'
            //             }).format(totalSubtotal);

            //             messagesModalFooter.innerHTML = `
            //                 <div class="row row-cols-1 row-cols-md-2 align-items-center mb-3">
            //                     <div class="row mb-3">
            //                         <div class="col-12">
            //                             <label class="col-form-label">Total</label>
            //                             <input type="text" class="form-control" value="${totalFormatted}" readonly>
            //                         </div>
            //                     </div>
            //                     <div class="row mb-3">
            //                         <div class="col-12">
            //                             <label class="col-form-label">Reference No.</label>
            //                             <input type="text" class="form-control" value="${user.referenceNo}" readonly>
            //                         </div>
            //                     </div>
            //                     <div class="row mb-3">
            //                         <div class="col-12">
            //                             <label class="col-form-label">Order Retrieval</label>
            //                             <input type="text" class="form-control" value="${user.order_retrieval ? user.order_retrieval.charAt(0).toUpperCase() + user.order_retrieval.slice(1) : ''}" readonly>
            //                         </div>
            //                     </div>
            //                     <div class="row mb-3">
            //                         <div class="col-12">
            //                             <label class="col-form-label">Date</label>
            //                             <input type="text" class="form-control" value="${new Date(user.created_at).toLocaleString('en-PH', { timeZone: 'Asia/Manila', weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true })}" readonly>
            //                         </div>
            //                     </div>
            //                 </div>
            //             `;

            //             if (user.order_retrieval === 'delivery') {
            //                 const deliverySchedule = user.delivery_date ?
            //                     `<div class="col-md-6">
            //                         <label for="" class="col-form-label">Delivery Schedule:</label>
            //                         <input type="text" class="form-control" value="${new Date(user.delivery_date).toLocaleString('en-PH', { timeZone: 'Asia/Manila', weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true })}" readonly>
            //                     </div>
            //                     ` :
            //                     `<div class="col-md-6">
            //                         <label for="" class="col-form-label">Delivery Schedule:</label>
            //                         <input type="text" class="form-control" value="Not Scheduled Yet" readonly>
            //                     </div>
            //                     `;

            //                 messagesModalFooter.innerHTML += `
            //                     <div class="row align-items-center mb-3">
            //                         ${deliverySchedule}
            //                         <div class="col-md-6">
            //                             <label for="" class="col-form-label">Courier Name:</label>
            //                             <input type="text" class="form-control" value="${user.courier_id}" readonly>
            //                         </div>
            //                     </div>
            //                 `;
            //             }

            //             if (user.payment_proof) {
            //                 messagesModalFooter.innerHTML += `
            //                     <div class="mb-3">
            //                         <label for="payment_proof" class="col-form-label">Payment Proof:</label>
            //                         <img src="${user.payment_proof}" class="img-fluid" alt="Payment Proof">
            //                     </div>
            //                 `;
            //             }
            //         } else {
            //             messagesModalBody.innerHTML = '<p>No messages found for this order.</p>';
            //         }
            //     } else {
            //         messagesModalBody.innerHTML = '<p>Error fetching order details.</p>';
            //     }
            // }

            await fetchOrders();

            setInterval(async () => {
                await fetchOrders();
            }, 5000);

        });
    </script>

    @endsection
