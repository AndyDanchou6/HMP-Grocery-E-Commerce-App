function openEditModal(userId) {
    var editModal = new bootstrap.Modal(document.getElementById("editModal"));
    editModal.show();

    fetch("/api/categoryAllData", {
        method: "GET",
        headers: {
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Failed to fetch category data");
            }
            return response.json();
        })
        .then((data) => {
            const categorySelect = document.getElementById("edit_category_id");
            categorySelect.innerHTML = "";
            for (let i = 0; i < data.length; i++) {
                const option = document.createElement("option");
                categorySelect.innerHTML += `<option value="${data[i].id}">${data[i].category_name}</option>`;
            }
        })
        .catch((error) => {
            console.error("Error fetching category data:", error);
        });

    fetch(`/api/getInventoryData/${userId}`, {
        method: "GET",
        headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
    })
        .then((res) => {
            return res.json();
        })
        .then((data) => {
            document.getElementById("edit_category_id").value =
                data.category_id || "";
            document.getElementById("editProductName").value =
                data.product_name || "";
            document.getElementById("editPrice").value = data.price || "";
            document.getElementById("editQuantity").value = data.quantity || "";
        })
        .catch((error) => {
            console.error("Failed to fetch user information:", error.message);
        });

    document
        .getElementById("editFormElement")
        .addEventListener("submit", function (event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch(`/api/updateInventoryData/${userId}`, {
                method: "POST",
                body: formData,
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            })
                .then((res) => {
                    return res.json();
                })
                .then((data) => {
                    console.log(data);
                    if (data.status) {
                        location.reload();
                    }
                })
                .catch((error) => {
                    console.error(
                        "Failed to update user information:",
                        error.message
                    );
                    swal("Oops!", "Failed to update user information", "error");
                });
        });
}
