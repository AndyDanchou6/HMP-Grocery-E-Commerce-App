var header = document.getElementById("header");
var firstSection = document.getElementById("welcome-section");

window.addEventListener("scroll", function () {
    if (isScrolledPastFirstSection()) {
        header.style.top = "0";
    } else {
        header.style.top = "-100px";
    }
});

function isScrolledPastFirstSection() {
    return (
        window.scrollY >
        firstSection.offsetTop + firstSection.offsetHeight - 100
    );
}

var login = document.querySelector("#login-page");
login.addEventListener("submit", function (e) {
    e.preventDefault();

    var email = document.querySelector("#login-email").value;

    sessionStorage.setItem("loginEmail", email);
    window.location.href = "/login";
});
