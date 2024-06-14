@extends('app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-4">
            <h4 style="margin: auto 0;">Users</h4>
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Add Product</a>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Avatar</th>
                        <th>Role</th>
                        <th>Username</th>
                        <th>Email</th>
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
    document.addEventListener("DOMContentLoaded", function() {
        fetch("/api/userAllData", {
                method: "GET",
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);

                const tableBody = document.getElementById("tableBody");

                for (let i = 0; i < data.length; i++) {
                    const user = data[i];
                    const roleBadge = user.role === 'Admin' ? '<span class="badge bg-label-success me-1">Admin</span>' : '<span class="badge bg-label-primary me-1">Customer</span>';
                    const tableRow = `
                        <tr>
                            <td>${i + 1}</td>
                            <td>
                                @if(!empty($user->avatar))
                                    <img src="{{ asset('storage/' . $user->avatar) }}" style="width: 35px; height: 35px;" alt="User Avatar" class="rounded-circle" />
                                @else
                                    <img src="{{ asset('assets/img/images.png') }}" style="width: 35px; height: 35px;" alt="Default Avatar" class="rounded-circle" />
                                @endif
                            </td>
                            <td>${roleBadge}</td>
                            <td>${user.name}</td>
                            <td>${user.email}</td>
                            <td>
                                <a class="" href="#" onclick="openEditModal(${user.id})">
                                    <i class="bx bx-edit-alt me-1"></i>
                                </a>
                                <a class="" href="#" onclick="deleteButton(${user.id})">
                                    <i class="bx bx-trash me-1"></i>
                                </a>
                            </td>
                        </tr>
                    `;

                    tableBody.innerHTML += tableRow;
                }
            })
            .catch((error) => {
                console.error("Failed to fetch user data:", error);
            });
    });

    function deleteButton(userId) {
        swal({
            title: "Delete Confirmation",
            text: "Are you sure you want to delete this user?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                fetch(`/api/user/${userId}`, {
                        method: "DELETE",
                        headers: {
                            Accept: "application/json",
                            Authorization: "Bearer " + localStorage.getItem("token"),
                        },
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.status === true) {
                            location.reload();
                        }
                    })
                    .catch((error) => {
                        console.error("Failed to delete user:", error);
                    });
            }
        });
    }
</script>


@endsection