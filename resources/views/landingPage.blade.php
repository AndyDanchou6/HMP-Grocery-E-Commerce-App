<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Mart</title>

    <!-- Css -->
    <link href="{{ asset('landing_page/css/custom.css') }}" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Racing+Sans+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Racing+Sans+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Racing+Sans+One&display=swap" rel="stylesheet">

</head>

<body class="bg-white">
    <div class="page-container">
        <aside id="sidebar">
            <nav>
                <ul>
                    <li class="casual-font"><a class="color-main" href="#welcome-section">Home</a></li>
                    <li class="casual-font"><a class="color-main" href="#about">About</a></li>
                    <li class="casual-font"><a class="color-main" href="#contact">Contact</a></li>
                    <li class="casual-font"><a class="color-main" href="/login">Sign in</a></li>
                </ul>
            </nav>
        </aside>
        <header id="header">
            <nav>
                <ul>
                    <li class="casual-font"><a href="#welcome-section">Home</a></li>
                    <li class="casual-font"><a href="#about">About</a></li>
                    <li class="casual-font"><a href="#contact">Contact</a></li>
                    <li class="casual-font"><a href="/login">Sign in</a></li>
                </ul>
            </nav>
            <div class="toggle-sidebar">
                <i class="fas fa-bars color-main"></i>
            </div>
            <div class="brand-header">

            </div>
        </header>

        <section id="welcome-section">
            <div class="logo-wrap">
            </div>
            <div class="footer">
                <p class="color-dark">&#169; e-Mart 2024. All rights reserved.</p>
            </div>
        </section>

        <section id="login-page">
            <div>
                <p class="color-main casual-font text-shadow-white">Shop anytime. Anywhere.</p>
                <form>
                    <input type="email" id="login-email" placeholder="Email Address...">
                    <button type="submit" class="casual-font color-white">Login</button>
                </form>
            </div>
        </section>

        <section id="about">
            <div class="section-header">
                <p class="casual-font color-dark">About | e-Mart</p>
            </div>
            <div class="content-wrapper row">
                <div class="contents intro">
                    <div class="header">
                        <p class="formal-font">What is e-Mart ?</p>
                    </div>
                    <p>
                        Welcome to e-Mart, your premier online shopping platform that connects customers with stores and facilitates convenient delivery services on scheduled times. At e-Mart, we act as mediators between customers and a variety of stores, providing a seamless shopping experience from the comfort of your own home.

                        Our platform offers a wide range of products from various stores, allowing customers to browse through an extensive selection of items and make purchases with ease. Whether you're looking for groceries, electronics, clothing, or household essentials, e-Mart has you covered.

                        One of the key features of e-Mart is our scheduled delivery service, which ensures that your purchases arrive at your doorstep at a time that is convenient for you. Our delivery services are provided by the stores themselves, and are limited to the location scope of each individual store. This means that delivery options may vary depending on your proximity to the store's location.

                        We understand the importance of convenience and reliability when it comes to online shopping, which is why we strive to provide a seamless and efficient shopping experience for our customers. With e-Mart, you can shop with confidence, knowing that your orders will be delivered promptly and securely.

                        Thank you for choosing e-Mart for all your online shopping needs. We look forward to serving you and providing you with an exceptional shopping experience.</p>
                </div>
                <div class="contents our-team">
                    <div class="header">
                        <p class="formal-font">Our Team</p>
                    </div>

                </div>
            </div>
        </section>

        <section id="contact">
            <div class="section-header">
                <p class="casual-font color-dark">Contacts</p>
            </div>
            <div class="content-wrapper row">
                <div class="contents contact-info">
                    <div class="row">
                        <i class="fa fa-globe"></i>
                        <div class="column">
                            <p>Location</p>
                            <p>Brgy. Zone 2 Sogod, Soutern Leyte</p>
                        </div>
                    </div>
                    <div class="row">
                        <i class="fa fa-envelope"></i>
                        <div class="column">
                            <p>Email</p>
                            <p><a href="">e-mart@gmail.com</a></p>
                        </div>
                    </div>
                    <div class="row">
                        <i class="fa fa-phone"></i>
                        <div class="column">
                            <p>Phone Number</p>
                            <p>09307696919</p>
                        </div>
                    </div>
                    <div class="map">
                    </div>
                </div>
                <div class="contents inquiries">
                    <form>
                        <div class="row">
                            <input type="text" name="fullname" placeholder="Full Name">
                            <input type="email" name="email" placeholder="Email">
                        </div>
                        <div class="column">
                            <input type="text" name="subject" placeholder="Subject">
                            <textarea id="message" name="message" placeholder="Message..."></textarea>
                            <button type="submit" class="bg-secondary color-white">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <script src="{{ asset('landing_page/js/custom.js') }}"></script>
</body>

</html>