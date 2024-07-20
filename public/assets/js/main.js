/**
 * Main
 */

"use strict";

let menu, animate;

(function () {
    // Initialize menu
    //-----------------

    let layoutMenuEl = document.querySelectorAll("#layout-menu");
    layoutMenuEl.forEach(function (element) {
        menu = new Menu(element, {
            orientation: "vertical",
            closeChildren: false,
        });
        // Change parameter to true if you want scroll animation
        window.Helpers.scrollToActive((animate = false));
        window.Helpers.mainMenu = menu;
    });

    // Initialize menu togglers and bind click on each
    let menuToggler = document.querySelectorAll(".layout-menu-toggle");
    menuToggler.forEach((item) => {
        item.addEventListener("click", (event) => {
            event.preventDefault();
            window.Helpers.toggleCollapsed();
        });
    });

    // Display menu toggle (layout-menu-toggle) on hover with delay
    let delay = function (elem, callback) {
        let timeout = null;
        elem.onmouseenter = function () {
            // Set timeout to be a timer which will invoke callback after 300ms (not for small screen)
            if (!Helpers.isSmallScreen()) {
                timeout = setTimeout(callback, 300);
            } else {
                timeout = setTimeout(callback, 0);
            }
        };

        elem.onmouseleave = function () {
            // Clear any timers set to timeout
            document
                .querySelector(".layout-menu-toggle")
                .classList.remove("d-block");
            clearTimeout(timeout);
        };
    };
    if (document.getElementById("layout-menu")) {
        delay(document.getElementById("layout-menu"), function () {
            // not for small screen
            if (!Helpers.isSmallScreen()) {
                document
                    .querySelector(".layout-menu-toggle")
                    .classList.add("d-block");
            }
        });
    }

    // Display in main menu when menu scrolls
    let menuInnerContainer = document.getElementsByClassName("menu-inner"),
        menuInnerShadow =
            document.getElementsByClassName("menu-inner-shadow")[0];
    if (menuInnerContainer.length > 0 && menuInnerShadow) {
        menuInnerContainer[0].addEventListener("ps-scroll-y", function () {
            if (this.querySelector(".ps__thumb-y").offsetTop) {
                menuInnerShadow.style.display = "block";
            } else {
                menuInnerShadow.style.display = "none";
            }
        });
    }

    // Init helpers & misc
    // --------------------

    // Init BS Tooltip
    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Accordion active class
    const accordionActiveFunction = function (e) {
        if (e.type == "show.bs.collapse" || e.type == "show.bs.collapse") {
            e.target.closest(".accordion-item").classList.add("active");
        } else {
            e.target.closest(".accordion-item").classList.remove("active");
        }
    };

    const accordionTriggerList = [].slice.call(
        document.querySelectorAll(".accordion")
    );
    const accordionList = accordionTriggerList.map(function (
        accordionTriggerEl
    ) {
        accordionTriggerEl.addEventListener(
            "show.bs.collapse",
            accordionActiveFunction
        );
        accordionTriggerEl.addEventListener(
            "hide.bs.collapse",
            accordionActiveFunction
        );
    });

    // Auto update layout based on screen size
    window.Helpers.setAutoUpdate(true);

    // Toggle Password Visibility
    window.Helpers.initPasswordToggle();

    // Speech To Text
    window.Helpers.initSpeechToText();

    // Manage menu expanded/collapsed with templateCustomizer & local storage
    //------------------------------------------------------------------

    // If current layout is horizontal OR current window screen is small (overlay menu) than return from here
    if (window.Helpers.isSmallScreen()) {
        return;
    }

    // If current layout is vertical and current window screen is > small

    // Auto update menu collapsed/expanded based on the themeConfig
    window.Helpers.setCollapsed(true, false);
})();

document.addEventListener("DOMContentLoaded", function () {
    const mainMenuItems = document.querySelectorAll(".menu-item");
    const paymentsMenuItem = document.getElementById("payment-menu");
    const subMenuItems = paymentsMenuItem
        ? paymentsMenuItem.querySelectorAll(".menu-sub .menu-item")
        : [];

    // Function to handle menu item click
    function handleMenuItemClick(clickedItem) {
        // Remove 'active' class from all main menu items and their links
        mainMenuItems.forEach(function (menuItem) {
            menuItem.classList.remove("active");
            menuItem.querySelector(".menu-link").classList.remove("active");
        });

        // Remove 'active' class from all submenu items and their links
        subMenuItems.forEach(function (subMenuItem) {
            subMenuItem.classList.remove("active");
            subMenuItem.querySelector(".menu-link").classList.remove("active");
        });

        // Add 'active' class to clicked menu item and its link
        clickedItem.classList.add("active");
        clickedItem.querySelector(".menu-link").classList.add("active");

        // Store the ID of the clicked menu item in localStorage
        localStorage.setItem("activeMenuItemId", clickedItem.id);
    }

    // Add event listener to each main menu item
    mainMenuItems.forEach(function (item) {
        item.addEventListener("click", function () {
            handleMenuItemClick(this);
        });
    });

    // Add event listener to each submenu item
    subMenuItems.forEach(function (item) {
        item.addEventListener("click", function (event) {
            event.stopPropagation(); // Prevent triggering the main menu item click
            handleMenuItemClick(this);
        });
    });

    // Function to highlight the active menu based on URL
    function highlightActiveMenu() {
        const currentPageUrl = window.location.href;

        // Remove 'active' class from all main and submenu items and their links
        mainMenuItems.forEach(function (menuItem) {
            menuItem.classList.remove("active");
            menuItem.querySelector(".menu-link").classList.remove("active");
        });
        subMenuItems.forEach(function (menuItem) {
            menuItem.classList.remove("active");
            menuItem.querySelector(".menu-link").classList.remove("active");
        });

        // Check and highlight the submenu item corresponding to the current page URL
        let subMenuMatched = false;
        subMenuItems.forEach(function (menuItem) {
            const menuItemUrl = menuItem
                .querySelector("a")
                ?.getAttribute("href");
            if (menuItemUrl && currentPageUrl.includes(menuItemUrl)) {
                menuItem.classList.add("active");
                menuItem.querySelector(".menu-link").classList.add("active");
                paymentsMenuItem.classList.add("active");
                paymentsMenuItem
                    .querySelector(".menu-link")
                    .classList.add("active");
                subMenuMatched = true;
            }
        });

        // If no submenu item is matched, check and highlight the main menu item
        if (!subMenuMatched) {
            mainMenuItems.forEach(function (menuItem) {
                const menuItemUrl = menuItem
                    .querySelector("a")
                    ?.getAttribute("href");
                if (menuItemUrl && currentPageUrl.includes(menuItemUrl)) {
                    menuItem.classList.add("active");
                    menuItem
                        .querySelector(".menu-link")
                        .classList.add("active");
                }
            });
        }
    }

    // Check if there's a previously clicked menu item and highlight it
    const activeMenuItemId = localStorage.getItem("activeMenuItemId");
    if (activeMenuItemId) {
        const activeMenuItem = document.getElementById(activeMenuItemId);
        if (activeMenuItem) {
            handleMenuItemClick(activeMenuItem);
        }
    }

    // Highlight the menu item corresponding to the current page URL on page load
    highlightActiveMenu();

    // Listen for URL changes
    window.addEventListener("popstate", highlightActiveMenu);
    window.addEventListener("pushstate", highlightActiveMenu); // For programmatic navigation if using pushState
    window.addEventListener("replacestate", highlightActiveMenu); // For programmatic navigation if using replaceState

    // Hijack pushState and replaceState to trigger the event
    const originalPushState = history.pushState;
    history.pushState = function () {
        originalPushState.apply(this, arguments);
        window.dispatchEvent(new Event("pushstate"));
    };

    const originalReplaceState = history.replaceState;
    history.replaceState = function () {
        originalReplaceState.apply(this, arguments);
        window.dispatchEvent(new Event("replacestate"));
    };
});

document.addEventListener("DOMContentLoaded", function () {
    const navbarIcons = document.querySelectorAll(".navbar-icon");
    const notificationIcon = document.getElementById("notificationIcon");

    let previouslyActiveIcon = null; // Variable to track the previously active icon

    // Function to handle navbar icon click
    function handleNavbarIconClick(icon) {
        // Remove 'text-primary' class from all navbar icons except the notificationIcon
        navbarIcons.forEach(function (item) {
            if (item !== notificationIcon) {
                item.classList.remove("text-primary");
            }
        });

        // Add 'text-primary' class to the clicked navbar icon, excluding notificationIcon
        if (icon !== notificationIcon) {
            icon.classList.add("text-primary");
            previouslyActiveIcon = icon; // Update previously active icon
        } else {
            // Clear previously active icon when notification icon is clicked
            previouslyActiveIcon = null;
        }
    }

    // Highlight the menu item or icon based on URL on page load
    function highlightActiveNavbar() {
        const currentPageUrl = window.location.href;

        navbarIcons.forEach(function (icon) {
            if (icon === notificationIcon) return; // Skip notificationIcon

            const iconUrl = icon.getAttribute("href");
            if (iconUrl && currentPageUrl.includes(iconUrl)) {
                handleNavbarIconClick(icon);
            }
        });

        // If no active icon based on URL, highlight previously active icon if available
        if (previouslyActiveIcon) {
            handleNavbarIconClick(previouslyActiveIcon);
        }
    }

    // Call highlightActiveNavbar on page load
    highlightActiveNavbar();

    // Listen for URL changes to maintain active state
    window.addEventListener("popstate", highlightActiveNavbar);
    window.addEventListener("pushstate", highlightActiveNavbar); // For programmatic navigation if using pushState
    window.addEventListener("replacestate", highlightActiveNavbar); // For programmatic navigation if using replaceState

    // Hijack pushState and replaceState to trigger the event
    const originalPushState = history.pushState;
    history.pushState = function () {
        originalPushState.apply(this, arguments);
        window.dispatchEvent(new Event("pushstate"));
    };

    const originalReplaceState = history.replaceState;
    history.replaceState = function () {
        originalReplaceState.apply(this, arguments);
        window.dispatchEvent(new Event("replacestate"));
    };
});

function logout() {
    swal({
        title: "Logout Confirmation",
        text: "Are you sure you want to logout",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((logout) => {
        if (logout) {
            window.location.href = "/";
        }
    });
}
