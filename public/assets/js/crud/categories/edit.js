function openEditModal(userId) {
    var editModal = new bootstrap.Modal(document.getElementById("editModal"));
    editModal.show();

    fetch(`/api/getCategoryData/${userId}`, {
        method: "GET",
        headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
    })
        .then((res) => {
            return res.json();
        })
        .then((data) => {
            document.getElementById("editCategory").value =
                data.category_name || "";
            document.getElementById("editDescription").value =
                data.description || "";
        })
        .catch((error) => {
            console.error("Failed to fetch user information:", error.message);
        });

    document
        .getElementById("editFormElement")
        .addEventListener("submit", function (event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch(`/api/updateCategoryData/${userId}`, {
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
