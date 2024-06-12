document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("createFormElement")
        .addEventListener("submit", function (event) {
            event.preventDefault();

            const formData = new FormData(this);
            fetch("/api/category", {
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
