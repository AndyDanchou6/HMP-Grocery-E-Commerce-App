document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("loginFormElement")
        .addEventListener("submit", function (event) {
            event.preventDefault();

            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;

            const data = {
                email: email,
                password: password,
            };

            fetch("/api/login", {
                method: "POST",
                body: JSON.stringify(data),
                headers: {
                    "Content-type": "application/json",
                    Accept: "application/json",
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            })
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    console.log(data);
                    if (data.status == true) {
                        localStorage.setItem("token", data.access_token);
                        swal({
                            title: "Good job!",
                            text: data.message,
                            icon: "success",
                            button: "Proceed",
                        }).then(() => {
                            window.location.href = "/home";
                        });
                    }
                });
        });
});
