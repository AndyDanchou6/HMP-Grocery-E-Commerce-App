function openMessages(userID) {
    var editModal = new bootstrap.Modal(document.getElementById("messages"));
    editModal.show();

    fetch(`/api/getCategoryData/${userID}`, {
        method: "GET",
        headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
        },
    })
        .then((res) => {
            return res.json();
        })
        .then((data) => {
            document.getElementById("categoryTitle").textContent =
                data.category_name || "";
            document.getElementById("message").value = data.description || "";
        })
        .catch((error) => {
            console.error("Failed to fetch user information:", error.message);
        });
}
