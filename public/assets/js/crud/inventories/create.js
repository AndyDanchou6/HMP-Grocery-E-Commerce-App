document.addEventListener("DOMContentLoaded", function () {
    fetch("/api/categoryAllData", {
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
            const categorySelect = document.getElementById("category_id");
            categorySelect.innerHTML =
                '<option value="" selected disabled>Choose Category</option>';
            for (let i = 0; i < data.length; i++) {
                categorySelect.innerHTML += `<option value="${data[i].id}">${data[i].category_name}</option>`;
            }
        });

    document
        .getElementById("createFormElement")
        .addEventListener("submit", function (event) {
            event.preventDefault();

            const formData = new FormData(this);
            fetch("/api/inventory", {
                method: "POST",
                body: formData,
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
                    if (data.status) {
                        location.reload();
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    swal({
                        title: "Error",
                        text: "There was an error creating the product",
                        icon: "error",
                        button: "Try Again",
                    });
                });
        });
});
