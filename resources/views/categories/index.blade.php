@extends('app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">Category</h4>
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Add Product</a>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tableBody">
                    <!-- Table rows will be populated here -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/categoryAllData', {
            method: 'GET',
            headers: {
                Accept: 'application/json',
                Authorization: 'Bearer ' + localStorage.getItem('token'),
            }
        }).then(response => {
            return response.json();
        }).then(data => {
            console.log(data);

            const tableBody = document.getElementById('tableBody');

            for (let i = 0; i < data.length; i++) {
                const tableData = `<tr>
                                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>${i + 1}</strong></td>
                                    <td>${data[i].category_name}</td>
                                    <td><a class="" href="#" onclick="openMessages(${data[i].id})"><i class="bx bx-message-alt me-1"></i></a></td>
                                    <td>
                                        <a class="" href="#" onclick="openEditModal(${data[i].id})"><i class="bx bx-edit-alt me-1"></i></a>
                                        <a class="" href="#" onclick="deleteButton(${data[i].id})"><i class="bx bx-trash me-1"></i></a>
                                    </td>
                                </tr>`;

                tableBody.innerHTML += tableData;
            }

        }).catch(error => {
            console.error('Failed to fetch inventory data:', error);
        });
    });

    function deleteButton(userId) {
        swal({
            title: "Delete Confirmation",
            text: "Are you sure you want to delete this product?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then(willDeleted => {
            if (willDeleted) {
                fetch(`/api/category/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        Accept: 'application/json',
                        Authorization: 'Bearer ' + localStorage.getItem('token'),
                    }
                }).then(response => {
                    return response.json();
                }).then(data => {
                    if (data.status === true) {
                        location.reload();
                    }
                }).catch(error => {
                    console.error('Failed to delete product:', error);
                });
            }
        });
    }
</script>

@include('categories.create')
@include('categories.edit')
@include('categories.description')

@endsection