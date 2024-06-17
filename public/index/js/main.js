/*  ---------------------------------------------------
    Template Name: Ogani
    Description:  Ogani eCommerce  HTML Template
    Author: Colorlib
    Author URI: https://colorlib.com
    Version: 1.0
    Created: Colorlib
---------------------------------------------------------  */

"use strict";

(function ($) {
    /*------------------
        Preloader
    --------------------*/
    $(window).on("load", function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");

        /*------------------
            Gallery filter
        --------------------*/
        $(".featured__controls li").on("click", function () {
            $(".featured__controls li").removeClass("active");
            $(this).addClass("active");
        });
        if ($(".featured__filter").length > 0) {
            var containerEl = document.querySelector(".featured__filter");
            var mixer = mixitup(containerEl);
        }
    });

    /*------------------
        Background Set
    --------------------*/
    $(".set-bg").each(function () {
        var bg = $(this).data("setbg");
        $(this).css("background-image", "url(" + bg + ")");
    });

    //Humberger Menu
    $(".humberger__open").on("click", function () {
        $(".humberger__menu__wrapper").addClass(
            "show__humberger__menu__wrapper"
        );
        $(".humberger__menu__overlay").addClass("active");
        $("body").addClass("over_hid");
    });

    $(".humberger__menu__overlay").on("click", function () {
        $(".humberger__menu__wrapper").removeClass(
            "show__humberger__menu__wrapper"
        );
        $(".humberger__menu__overlay").removeClass("active");
        $("body").removeClass("over_hid");
    });

    /*------------------
		Navigation
	--------------------*/
    $(".mobile-menu").slicknav({
        prependTo: "#mobile-menu-wrap",
        allowParentLinks: true,
    });

    /*-----------------------
        Categories Slider
    ------------------------*/
    $(".categories__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 4,
        dots: false,
        nav: true,
        navText: [
            "<span class='fa fa-angle-left'><span/>",
            "<span class='fa fa-angle-right'><span/>",
        ],
        animateOut: "fadeOut",
        animateIn: "fadeIn",
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {
            0: {
                items: 1,
            },

            480: {
                items: 2,
            },

            768: {
                items: 3,
            },

            992: {
                items: 4,
            },
        },
    });

    $(".hero__categories__all").on("click", function () {
        $(".hero__categories ul").slideToggle(400);
    });

    /*--------------------------
        Latest Product Slider
    ----------------------------*/
    $(".latest-product__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: false,
        nav: true,
        navText: [
            "<span class='fa fa-angle-left'><span/>",
            "<span class='fa fa-angle-right'><span/>",
        ],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
    });

    /*-----------------------------
        Product Discount Slider
    -------------------------------*/
    $(".product__discount__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 3,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {
            320: {
                items: 1,
            },

            480: {
                items: 2,
            },

            768: {
                items: 2,
            },

            992: {
                items: 3,
            },
        },
    });

    /*---------------------------------
        Product Details Pic Slider
    ----------------------------------*/
    $(".product__details__pic__slider").owlCarousel({
        loop: true,
        margin: 20,
        items: 4,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
    });

    /*-----------------------
		Price Range Slider
	------------------------ */
    var rangeSlider = $(".price-range"),
        minamount = $("#minamount"),
        maxamount = $("#maxamount"),
        minPrice = rangeSlider.data("min"),
        maxPrice = rangeSlider.data("max");
    rangeSlider.slider({
        range: true,
        min: minPrice,
        max: maxPrice,
        values: [minPrice, maxPrice],
        slide: function (event, ui) {
            minamount.val("$" + ui.values[0]);
            maxamount.val("$" + ui.values[1]);
        },
    });
    minamount.val("$" + rangeSlider.slider("values", 0));
    maxamount.val("$" + rangeSlider.slider("values", 1));

    /*--------------------------
        Select
    ----------------------------*/
    $("select").niceSelect();

    /*------------------
		Single Product
	--------------------*/
    $(".product__details__pic__slider img").on("click", function () {
        var imgurl = $(this).data("imgbigurl");
        var bigImg = $(".product__details__pic__item--large").attr("src");
        if (imgurl != bigImg) {
            $(".product__details__pic__item--large").attr({
                src: imgurl,
            });
        }
    });

    /*-------------------
		Quantity change
	--------------------- */
    var proQty = $(".pro-qty");
    proQty.prepend('<span class="dec qtybtn">-</span>');
    proQty.append('<span class="inc qtybtn">+</span>');
    proQty.on("click", ".qtybtn", function () {
        var $button = $(this);
        var oldValue = $button.parent().find("input").val();
        if ($button.hasClass("inc")) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().find("input").val(newVal);
    });
})(jQuery);

document.addEventListener("DOMContentLoaded", function () {
    var currentUrl = window.location.href;

    // Function to set active state for header menu based on current URL
    function setActiveHeaderMenuItem() {
        // Get all header menu item links
        var headerMenuLinks = document.querySelectorAll(
            ".header__menu ul li a"
        );

        // Loop through each header menu link
        headerMenuLinks.forEach(function (link) {
            // Check if the link's href matches the current URL
            if (link.href === currentUrl) {
                // Add 'active' class to the parent <li> element
                link.parentNode.classList.add("active");
            } else {
                // Remove 'active' class from the parent <li> element
                link.parentNode.classList.remove("active");
            }
        });
    }

    // Set initial active state
    setActiveHeaderMenuItem();

    // Add click event listener to each header menu link
    document.querySelectorAll(".header__menu ul li a").forEach(function (link) {
        link.addEventListener("click", function (event) {
            // Remove 'active' class from all header menu links
            document
                .querySelectorAll(".header__menu ul li")
                .forEach(function (menuLink) {
                    menuLink.classList.remove("active");
                });

            // Add 'active' class to the clicked link's parent <li> element
            this.parentNode.classList.add("active");

            // Update current URL
            currentUrl = this.href;

            // Allow default link behavior to proceed after handling active state
            // Remove the following line to restore normal link behavior without preventing redirection:
            // event.preventDefault();
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Get all category links
    const categoryLinks = document.querySelectorAll(".category-link");

    // Add click event listener to each category link
    categoryLinks.forEach((link) => {
        link.addEventListener("click", function (event) {
            // Check if the link has 'active' class already
            if (!this.classList.contains("active")) {
                // Remove 'active' class from all links
                categoryLinks.forEach((link) => {
                    link.classList.remove("active");
                });

                // Add 'active' class to the clicked link
                this.classList.add("active");
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const categoryButtons = document.querySelectorAll(".category-filter-btn");
    const productItems = document.querySelectorAll(".mix-categories");

    categoryButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const filter = this.getAttribute("data-filter");
            const filterId = this.getAttribute("data-filter-id");
            filterProducts(filter, filterId);
            updateActiveButton(this);
        });
    });

    function filterProducts(filter, filterId) {
        productItems.forEach((item) => {
            const itemCategory =
                item.getAttribute("data-category-id") == filterId ||
                filter === "*";
            const itemFilter =
                item.getAttribute("data-filter") === filter || filter === "*";
            const isVisible = itemCategory && itemFilter;

            if (isVisible) {
                item.style.opacity = "1";
                item.style.transform = "scale(1)";
                item.style.display = "block";
            } else {
                item.style.opacity = "0";
                item.style.transform = "scale(0.9)";
                item.style.display = "none"; // Adjust display to maintain layout flow
            }
        });

        // Reorder items based on visibility
        const visibleItems = Array.from(productItems).filter(
            (item) => item.style.opacity === "1"
        );
        visibleItems.forEach((item, index) => {
            item.style.order = index + 1;
        });
    }

    function updateActiveButton(activeButton) {
        categoryButtons.forEach((button) => button.classList.remove("active"));
        activeButton.classList.add("active");
    }
});

function maintenance() {
    alert("UNDER MAINTENANCE, sorry :{");
}
