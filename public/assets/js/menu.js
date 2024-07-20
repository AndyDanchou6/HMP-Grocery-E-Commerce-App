document.addEventListener("DOMContentLoaded", function () {
    const menuItems = document.querySelectorAll(".menu-item");

    // Function to handle menu item click
    function handleMenuItemClick(clickedItem) {
        // Remove 'active' class from all menu items
        menuItems.forEach(function (menuItem) {
            menuItem.classList.remove("active");
        });

        // Add 'active' class to clicked menu item
        clickedItem.classList.add("active");

        // Store the ID of the clicked menu item in localStorage
        localStorage.setItem("activeMenuItemId", clickedItem.id);
    }

    // Add event listener to each menu item
    menuItems.forEach(function (item) {
        item.addEventListener("click", function () {
            handleMenuItemClick(this);
        });
    });

    // Check if there's a previously clicked menu item and highlight it
    const activeMenuItemId = localStorage.getItem("activeMenuItemId");
    if (activeMenuItemId) {
        const activeMenuItem = document.getElementById(activeMenuItemId);
        if (activeMenuItem) {
            handleMenuItemClick(activeMenuItem);
        }
    }

    // Highlight the menu item corresponding to the current page URL
    const currentPageUrl = window.location.href;
    menuItems.forEach(function (menuItem) {
        const menuItemUrl = menuItem.querySelector("a").getAttribute("href");
        if (currentPageUrl.includes(menuItemUrl)) {
            handleMenuItemClick(menuItem);
        }
    });

    document
        .getElementById("navbar-item")
        .addEventListener("click", function (test) {}); // Event listener for navbar items
    const navbarItems = document.querySelectorAll(
        "#navbar-item .navbar-nav .nav-item"
    );
    navbarItems.forEach(function (navbarItem) {
        navbarItem.addEventListener("click", function (event) {
            // Remove 'active' class from all menu items
            menuItems.forEach(function (menuItem) {
                menuItem.classList.remove("active");
            });

            // Store the ID of the clicked navbar item in localStorage
            localStorage.setItem("activeNavbarItemId", navbarItem.id);
            localStorage.removeItem("activeMenuItemId"); // Clear menu item selection
        });
    });

    // Check if there's a previously clicked navbar item and prevent menu item activation
    const activeNavbarItemId = localStorage.getItem("activeNavbarItemId");
    if (activeNavbarItemId) {
        // Clear any active menu item
        menuItems.forEach(function (menuItem) {
            menuItem.classList.remove("active");
        });

        // Store the ID of the clicked navbar item in localStorage
        localStorage.setItem("activeNavbarItemId", activeNavbarItemId);
    }
});
