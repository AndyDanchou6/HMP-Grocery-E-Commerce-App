<!DOCTYPE html>
<html :class="{ 'theme-dark': light }" x-data="data()" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Mart - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/tailwind/css/tailwind.output.css') }}">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="{{ asset('asset/tailwind/js/init-alpine.js') }}"></script>
</head>

<body>
    <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="flex flex-col md:flex-row">
                <div class="h-32 md:h-auto md:w-1/2">
                    <img aria-hidden="true" class="object-cover w-full h-full dark:hidden" src="{{ asset('asset/tailwind/img/image2.avif') }}" alt="Office" />
                    <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block" src="asset/tailwind/img/login-office-dark.jpeg" alt="Office" />
                </div>
                <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                    <div class="w-full">
                        <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                            Login
                        </h1>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-2 py-1 rounded">
                                <div class="text-s font-semibold text-red-600 dark:text-gray-300">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif
                            <div style="padding-bottom: 10px;"></div>
                            <div class="form-group">
                                <label for="exampleInputName" class="block text-sm text-gray-700 dark:text-gray-400">Email</label>
                                <input name="email" type="email" id="email" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" aria-describedby="nameHelp" placeholder="Email" />
                            </div>
                            <div class="form-group mt-4">
                                <label for="exampleInputPassword" class="block text-sm text-gray-700 dark:text-gray-400">Password</label>
                                <input name="password" type="password" id="password" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Password" />
                            </div>
                            <div class="form-group" style="padding: 10px;">
                            </div>
                            <button type="submit" class="block w-full px-4 py-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 border border-transparent rounded-lg focus:outline-none focus:shadow-outline-blue" style="background-color: #007BFF;">
                                Login
                            </button>
                        </form>
                        <hr class="my-8" />
                        <p class="mt-1"><a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" href="{{ route('register') }}">
                                Don't have an account? Register here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        if (sessionStorage.getItem('loginEmail')) {
            var loginEmail = sessionStorage.getItem('loginEmail')
            var emailInput = document.querySelector('#email');

            emailInput.value = sessionStorage.getItem('loginEmail');
            emailInput.setAttribute('placeholder', sessionStorage.getItem('loginEmail'));
        }
    </script>
</body>

</html>