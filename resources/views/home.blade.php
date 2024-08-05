@extends('app')

@section('content')

<style>
    .inactive {
        border: 1px solid #3B71CA;
        color: #3B71CA;
    }

    .active {
        background-color: #3B71CA;
        color: white;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">

        <div class="col-md-6 col-xl-4">
            <div class="card shadow-none bg-transparent border border-primary mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-box-seam me-2"></i>
                        <h5 class="card-title mb-0">Package</h5>
                        <span class="badge bg-primary ms-auto d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;" id="packageCount"> </span>
                    </div>
                    <a href="{{ route('selectedItems.forPackaging') }}">
                        <button class="btn btn-primary btn-sm mt-3">View here</button>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card shadow-none bg-transparent border border-success mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-truck me-2"></i>
                        <h5 class="card-title mb-0">Delivery</h5>
                        <span class="badge bg-success ms-auto d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;" id="deliveryCount"></span>
                    </div>
                    <a href="{{ route('selectedItems.forDelivery') }}">
                        <button class="btn btn-success btn-sm mt-3">View here</button>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card shadow-none bg-transparent border border-info mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-bag me-2"></i>
                        <h5 class="card-title mb-0">Pickup</h5>
                        <span class="badge bg-info ms-auto d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;" id="pickupCount"></span>
                    </div>
                    <a href="{{ route('selectedItems.forPickup') }}">
                        <button class="btn btn-info btn-sm mt-3">View here</button>
                    </a>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function updatePackageCount() {
                    fetch('{{ route("selectedItems.count") }}')
                        .then(response => {
                            return response.json();
                        })
                        .then(data => {
                            const forPackagingCount = document.getElementById('packageCount');
                            if (forPackagingCount) {
                                forPackagingCount.textContent = data.count1 || '0';
                                forPackagingCount.style.display = data.count1 !== undefined ? 'block' : 'none';
                            }

                            const forDeliveryCount = document.getElementById('deliveryCount');
                            if (forDeliveryCount) {
                                forDeliveryCount.textContent = data.count2 || '0';
                                forDeliveryCount.style.display = data.count2 !== undefined ? 'block' : 'none';
                            }

                            const forPickupCount = document.getElementById('pickupCount');
                            if (forPickupCount) {
                                forPickupCount.textContent = data.count3 || '0';
                                forPickupCount.style.display = data.count3 !== undefined ? 'block' : 'none';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching count:', error);
                        });
                }

                updatePackageCount();

                setInterval(updatePackageCount, 5000);
            });
        </script>

        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center mb-4">
                    <h4 style="margin: auto 0; color: red;">Critical Products</h4>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                @if(Auth::user()->role == 'Admin')
                                <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0" id="tableBody">
                            <!-- Table body content will be filled dynamically -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    <div id="paginationLinks" class="d-flex justify-content-end" style="margin-top: 10px;">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination">
                                                <li class="page-item {{ $inventories->onFirstPage() ? 'disabled' : '' }}">
                                                    <a class="page-link" href="{{ $inventories->url(1) }}"> <i class="tf-icon bx bx-chevron-left d-none"></i> </a>
                                                </li>
                                                <li class="page-item {{ $inventories->previousPageUrl() ? '' : 'disabled' }}">
                                                    <a class="page-link" href="#" data-page="prev"><i class="tf-icon bx bx-chevron-left"></i></a>
                                                </li>
                                                <li class="page-item {{ $inventories->nextPageUrl() ? '' : 'disabled' }}">
                                                    <a class="page-link" href="#" data-page="next"><i class="tf-icon bx bx-chevron-right"></i></a>
                                                </li>
                                                <li class="page-item {{ $inventories->hasMorePages() ? '' : 'disabled' }}">
                                                    <a class="page-link" href="#" data-page="{{ $inventories->lastPage() }}"><i class="tf-icon bx bx-chevrons-right"></i></a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sales -->
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center mb-4">
                    <h4 style="margin: auto 0; color: red;">Sales</h4>
                    <select name="filter" id="filter-sales" class="py-2 px-5 rounded" style="outline: none; border: 1px solid grey; color: grey;">
                        <option value="all">Filter Sales</option>
                        <option value="thisDay">This Day</option>
                        <option value="thisWeek">This Week</option>
                        <option value="thisMonth">This Month</option>
                        <option value="thisYear">This Year</option>
                    </select>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Products</th>
                                <th>Sold</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0" id="sales-table-body">
                            <!-- Sales Data are populated using javascript -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    <div class="container my-4">
                                        <div class="d-flex justify-content-end">
                                            <div class="d-flex" style="max-width: 250px;">

                                                <button class="btn btn-primary mx-1" id="first-page"> &laquo; </button>

                                                <div class="scrollable-content flex-grow-1 d-flex align-items-center" style="overflow-x: auto; white-space: nowrap;">
                                                    <div class="d-flex" id="sales-pagination-links">
                                                        <!-- Javascript createPaginationLinks -->
                                                    </div>
                                                </div>

                                                <button class="btn btn-primary mx-1" id="last-page"> &#187; </button>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="restock-modals"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentPage = 1;

        function fetchCriticalProducts(page) {
            const openModals = document.querySelectorAll('.modal.show');
            openModals.forEach(modal => {
                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                }
            });

            fetch(`{{ route('inventories.criticalProducts') }}?page=${page}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const inventories = data.inventories.data;
                    updateTable(inventories);
                    updatePagination(data.inventories);
                    setTimeout(() => {
                        fetchCriticalProducts(currentPage);
                    }, 10000);
                })
                .catch(error => {
                    console.error('Error fetching critical products:', error);
                    setTimeout(() => {
                        fetchCriticalProducts(currentPage);
                    }, 10000);
                });
        }

        function updateTable(inventories) {
            const tableBody = document.getElementById('tableBody');
            if (!tableBody) return;
            tableBody.innerHTML = '';

            if (inventories.length === 0) {
                const newRow = document.createElement('tr');
                const noDataCell = document.createElement('td');
                noDataCell.colSpan = 4;
                noDataCell.classList.add('text-center');
                noDataCell.textContent = 'No Critical Products Found';
                newRow.appendChild(noDataCell);
                tableBody.appendChild(newRow);
                return;
            }

            inventories.forEach((inventory, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${index + 1}</td>
                <td>${inventory.product_name}</td>
                <td><span class="badge bg-label-danger me-1">${inventory.quantity}</span></td>
                <td>
                    <a href="#" class="bx bx-plus me-1" data-bs-toggle="modal" data-bs-target="#restock${inventory.id}">
                    </a>
                </td>
            `;
                tableBody.appendChild(row);

                const restockModalsContainer = document.querySelector('#restock-modals');
                if (restockModalsContainer) {
                    if (!document.getElementById(`restock${inventory.id}`)) {
                        var modalId = `restock${inventory.id}`;
                        var restockAPI = `/restock/${inventory.id}`;
                        var newRestockModal = `
                        <div class="modal fade" id="${modalId}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                    <form action="${restockAPI}" method="POST" enctype="multipart/form-data" id="editFormElement">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">${inventory.product_name}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container">
                                                <div class="column">
                                                    <label for="restock-quantity-${inventory.id}" class="mb-3">Quantity</label>
                                                    <input type="number" name="quantity" id="restock-quantity-${inventory.id}" class="form-control" placeholder="Add decided amount">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-outline-success">Restock</button>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    `;
                        restockModalsContainer.innerHTML += newRestockModal;
                    }
                }
            });
        }

        function updatePagination(inventories) {
            const paginationLinks = document.getElementById('paginationLinks');
            if (!paginationLinks) return;

            const currentPage = inventories.current_page;
            const lastPage = Math.ceil(inventories.total / inventories.per_page);

            const linksContainer = paginationLinks.querySelector('ul.pagination');
            if (!linksContainer) return;

            linksContainer.innerHTML = '';

            // const prevLi = document.createElement('li');
            // const prevLink = document.createElement('a');
            // prevLink.className = 'page-link disabled';
            // prevLink.innerHTML = '<i class="tf-icon bx bx-chevron-left"></i>';
            // prevLi.appendChild(prevLink);
            // linksContainer.appendChild(prevLi);

            for (let i = Math.max(1, currentPage - 2); i <= Math.min(lastPage, currentPage + 2); i++) {
                const pageLi = document.createElement('li');
                pageLi.className = `page-item ${currentPage === i ? 'active' : ''}`;
                const pageLink = document.createElement('a');
                pageLink.className = 'page-link';
                pageLink.href = '#';
                pageLink.setAttribute('data-page', i.toString());
                pageLink.innerHTML = i.toString();
                pageLi.appendChild(pageLink);
                linksContainer.appendChild(pageLi);
            }

            // const nextLi = document.createElement('li');
            // const nextLink = document.createElement('a');
            // nextLink.className = 'page-link disabled';
            // nextLink.innerHTML = '<i class="tf-icon bx bx-chevron-right"></i>';
            // nextLi.appendChild(nextLink);
            // linksContainer.appendChild(nextLi);
        }

        document.getElementById('paginationLinks').addEventListener('click', function(event) {
            event.preventDefault();
            if (event.target.tagName === 'A') {
                const page = event.target.getAttribute('data-page');
                if (page && page !== 'prev' && page !== 'next') {
                    currentPage = parseInt(page);
                    fetchCriticalProducts(currentPage)
                        .then(inventories => {
                            updateTable(inventories);
                            // updatePagination(inventories);
                        })
                        .catch(error => {
                            console.error('Error fetching critical products:', error);
                        });
                } else if (page === 'prev' && currentPage > 1) {
                    currentPage--;
                    fetchCriticalProducts(currentPage)
                        .then(inventories => {
                            updateTable(inventories);
                            updatePagination(inventories);
                        })
                        .catch(error => {
                            console.error('Error fetching critical products:', error);
                        });
                } else if (page === 'next') {
                    currentPage++;
                    fetchCriticalProducts(currentPage)
                        .then(inventories => {
                            updateTable(inventories);
                            updatePagination(inventories);
                        })
                        .catch(error => {
                            console.error('Error fetching critical products:', error);
                        });
                }
            }
        });

        fetchCriticalProducts(currentPage);

        async function fetchSales(filter) {
            try {
                var response = await fetch(`/admin/sales/${filter}`);

                if (!response.ok) {
                    throw new Error('Network response was not ok.');
                }

                var data = await response.json();

                if (data.status !== 200) {
                    throw new Error('Error fetching sales.');
                }

                var salesData = data.data;
                var numberOfPage = 0;

                Object.entries(salesData).forEach(([pageNumbers, products]) => {
                    numberOfPage += 1
                })

                createPaginationLinks(numberOfPage)
                populateTable(data.data[1], 1);

                const salesPaginationLinksContainer = document.querySelector('#sales-pagination-links')
                var paginationLinks = salesPaginationLinksContainer.querySelectorAll('div');

                paginationLinks.forEach(function(link) {

                    link.addEventListener('click', function() {

                        var pageId = link.getAttribute('id');
                        var rawId = pageId.substring(5).trim();
                        var currentActive = salesPaginationLinksContainer.querySelector('div.active');

                        // Show the data of page
                        populateTable(data.data[rawId], rawId);

                        // change the active button (primarily the color of the button)
                        link.classList.add('active');
                        currentActive.classList.remove('active');
                        currentActive.classList.add('inactive');
                    });
                })

                const firstPageButton = document.querySelector('#first-page');

                firstPageButton.addEventListener('click', function() {

                    var currentActive = salesPaginationLinksContainer.querySelector('div.active');
                    currentActive.classList.remove('active');
                    currentActive.classList.add('inactive');
                    var firstPage = document.querySelector('#page_' + 1);
                    firstPage.classList.remove('inactive');
                    firstPage.classList.add('active');

                    populateTable(data.data[1], 1);
                })

                const lastPageButton = document.querySelector('#last-page');

                lastPageButton.addEventListener('click', function() {

                    var currentActive = salesPaginationLinksContainer.querySelector('div.active');
                    currentActive.classList.remove('active');
                    currentActive.classList.add('inactive');
                    var lastPage = document.querySelector('#page_' + numberOfPage);
                    lastPage.classList.remove('inactive');
                    lastPage.classList.add('active');

                    populateTable(data.data[numberOfPage], numberOfPage);
                })
            } catch (error) {
                console.error('Something went wrong! :', error.message);
                await new Promise(resolve => setTimeout(resolve, 3000));
                fetchSales(filter, page);
            }
        }

        function populateTable(paginatedSales, pageNumber) {

            var loopIteration = 1;

            if (pageNumber > 1) {
                loopIteration += (10 * pageNumber) - 10;
            }

            var salesTable = document.querySelector('#sales-table-body');
            salesTable.innerHTML = '';

            Object.entries(paginatedSales).forEach(([productId, soldProduct]) => {
                const productImageUrl = `/storage/${soldProduct.product_img}`;
                var variant = `[${soldProduct.variant}]`;

                if (soldProduct.variant == null) {
                    variant = '[No Variant]'
                }

                var dataRow = `
                <tr>
                    <td>${loopIteration}</td>
                    <td>
                        <img src="${productImageUrl}" style="width: 45px; height: 45px; margin-right: 20px;" alt="Product Image" class="rounded-circle">
                        ${soldProduct.product_name} ${variant}
                    </td>
                    <td>${soldProduct.quantity}</td>
                </tr>
            `;

                salesTable.innerHTML += dataRow;
                loopIteration += 1;
            });
        }

        function createPaginationLinks(numberOfPage) {
            const salesPaginationLinks = document.querySelector('#sales-pagination-links');

            salesPaginationLinks.innerHTML = '';

            var pageNumber = 1;
            var pageNumberButtons = '';

            do {

                var pageNumberButtons = `
                    <div class="rounded text-center inactive" style="margin: 0 2px;" id="page_${pageNumber}">
                        <p class="h-100" style="margin-bottom: 0; padding: 10px;">${pageNumber}</p>
                    </div>
                `;

                if (pageNumber == 1) {
                    pageNumberButtons = `
                        <div class="rounded text-center active" style="margin: 0 2px;" id="page_${pageNumber}">
                            <p class="h-100" style="margin-bottom: 0; padding: 10px;">${pageNumber}</p>
                        </div>
                    `;
                }

                salesPaginationLinks.innerHTML += pageNumberButtons;

                pageNumber += 1;
            } while (pageNumber <= numberOfPage);

        }

        fetchSales('all');

        // change data according filter
        document.querySelector('#filter-sales').addEventListener('change', function() {

            var salesTable = document.querySelector('#sales-table-body');
            salesTable.innerHTML = '';

            fetchSales(this.value);
        })

        // Allow mousewheel to scroll pagination links
        const scrollableContent = document.querySelector('.scrollable-content');

        scrollableContent.addEventListener('wheel', function(event) {
            if (event.deltaY !== 0) {
                scrollableContent.scrollLeft += event.deltaY;
                event.preventDefault(); // Prevent the default vertical scroll
            }
        });
    });
</script>

@endsection