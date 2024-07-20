@extends('app')

@section('content')
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

        <div class="col-md-12">
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
                                                    <a class="page-link" href="{{ $inventories->url(1) }}"> <i class="tf-icon bx bx-chevron-left"></i> </a>
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

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentPage = 1;

        function fetchCriticalProducts(page) {
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
                    }, 5000);
                })
                .catch(error => {
                    console.error('Error fetching critical products:', error);
                    setTimeout(() => {
                        fetchCriticalProducts(currentPage);
                    }, 5000);
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
                        <a href="{{ route('inventories.index') }}" class="bi bi-arrow-right-short me-1">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                `;
                tableBody.appendChild(row);
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

            const prevLi = document.createElement('li');
            const prevLink = document.createElement('a');
            prevLink.className = 'page-link disabled';
            prevLink.innerHTML = '<i class="tf-icon bx bx" style="background-color: black;"></i>';
            prevLi.appendChild(prevLink);
            linksContainer.appendChild(prevLi);

            for (let i = Math.max(1, currentPage - 2); i <= Math.min(lastPage, currentPage + 2); i++) {
                const pageLi = document.createElement('li');
                pageLi.className = `page-item ${currentPage === i ? 'active' : ''}`;
                const pageLink = document.createElement('a');
                pageLink.className = 'page-link';
                pageLink.href = `{{ route('inventories.criticalProducts') }}?page=${i}`;
                pageLink.setAttribute('data-page', i.toString());
                pageLink.innerHTML = i.toString();
                pageLi.appendChild(pageLink);
                linksContainer.appendChild(pageLi);
            }

            const nextLi = document.createElement('li');
            const nextLink = document.createElement('a');
            nextLink.className = 'page-link disabled';
            nextLink.innerHTML = '<i class="tf-icon bx bx-chevron"></i>';
            nextLi.appendChild(nextLink);
            linksContainer.appendChild(nextLi);
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
                            updatePagination(inventories);
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
    });
</script>

@endsection