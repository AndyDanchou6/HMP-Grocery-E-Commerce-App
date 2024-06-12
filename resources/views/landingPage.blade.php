<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Mart</title>

    <link href="{{ asset('landing_page/css/custom.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>

<body>
    <div class="page-container">
        <header class="bg-main">
            <h1 class="brand-name color-white">e-Mart</h1>
            <div class="search-bar bg-gray">
                <form>
                    <div class="search-icon bg-white"><i class="fa fa-search"></i></div>
                    <input type="text" placeholder="Search groceries...">
                    <button type="submit" class="bg-secondary color-white">Search</button>
                </form>
            </div>
            <div class="shopping-cart">
                <i class="fa fa-cart-arrow-down color-white"></i>
            </div>
        </header>
        <main class="bg-gray">
            <div class="content-wrapper">
                <section class="banner">
                    <div class="big-banner">
                        <img src="{{ asset('temporary_img/grocery big.jpeg') }}" alt="Big Banner">
                    </div>
                    <div class="small-banner">
                        <img src="{{ asset('temporary_img/grocery.jpeg') }}" alt="Small Banner">
                    </div>
                </section>
                <section class="categories"></section>
                <section class="top-sellers"></section>
                <section class="discounts"></section>
            </div>
        </main>
    </div>


</body>

</html>