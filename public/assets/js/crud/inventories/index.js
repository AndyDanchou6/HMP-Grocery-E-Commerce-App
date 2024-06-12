document.addEventListener("DOMContentLoaded", function () {
    fetch("/api/inventoryAllData", {
        method: "GET",
        headers: {
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
    })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            console.log(data);

            const tableBody = document.getElementById("tableBody");

            for (let i = 0; i < data.length; i++) {
                const tableData = `<tr>
                                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>${
                                        i + 1
                                    }</strong></td>
                                    <td>${data[i].category.category_name}</td>
                                    <td>
                                        <img src="storage/${
                                            data[i].product_img
                                        }" style="width: 35px; height: 35px;" alt="Product Image" class="rounded-circle" />
                                    </td>
                                    <td>${data[i].product_name}</td>
                                    <td>${data[i].price}</td>
                                    <td>${data[i].quantity}</td>
                                    <td>
                                        <a class="" href="#" onclick="openEditModal(${
                                            data[i].id
                                        })"><i class="bx bx-edit-alt me-1"></i></a>
                                        <a class="" href="#" onclick="deleteButton(${
                                            data[i].id
                                        })"><i class="bx bx-trash me-1"></i></a>
                                    </td>
                                </tr>`;

                tableBody.innerHTML += tableData;
            }
        })
        .catch((error) => {
            console.error("Failed to fetch inventory data:", error);
        });
});

function deleteButton(userId) {
    swal({
        title: "Delete Confirmation",
        text: "Are you sure you want to delete this product?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDeleted) => {
        if (willDeleted) {
            fetch(`/api/inventory/${userId}`, {
                method: "DELETE",
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            })
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    if (data.status === true) {
                        location.reload();
                    }
                })
                .catch((error) => {
                    console.error("Failed to delete product:", error);
                });
        }
    });
}
