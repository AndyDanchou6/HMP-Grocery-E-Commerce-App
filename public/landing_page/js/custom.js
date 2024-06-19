addEventListener("DOMContentLoaded", function () {
    // Hide navbar when on top of the page
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

    // Add email to login form via landing page
    var login = document.querySelector("#login-page");
    login.addEventListener("submit", function (e) {
        e.preventDefault();

        var email = document.querySelector("#login-email").value;

        sessionStorage.setItem("loginEmail", email);
        window.location.href = "/login";
    });

    // Sidebar Toggle
    const sidebarToggleButton = document.querySelector(".toggle-sidebar");
    var sidebarToggled = false;

    sidebarToggleButton.addEventListener("click", function () {
        const sidebar = document.querySelector("#sidebar");

        if (sidebarToggled == true) {
            sidebar.style.display = 'none';
            sidebarToggled = false;
        } else {
            sidebar.style.display = 'block';
            sidebarToggled = true;
        }
    });

    // Hide sidebar when nav is clicked 
    const clickedNav = document.querySelectorAll("#sidebar nav ul li");

    clickedNav.forEach(function (nav) {
        nav.addEventListener("click", function () {
            const sidebar = document.querySelector("#sidebar");

            sidebar.style.display = "none";
        });
    });
});
