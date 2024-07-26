<!DOCTYPE html>
<html lang="en" :class="{ 'theme-dark': light }" x-data="data()">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Mart - Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/tailwind/css/tailwind.output.css') }}">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="{{ asset('asset/tailwind/js/init-alpine.js') }}"></script>
</head>

<body>
    <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="flex flex-col overflow-y-auto md:flex-row">
                <div class="h-32 md:h-auto md:w-1/2">
                    <img aria-hidden="true" class="object-cover w-full h-full dark:hidden" src="{{ asset('asset/tailwind/img/image2.avif') }}" alt="Office" />
                    <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block" src="assets/tailwind/img/login-office-dark.jpeg" alt="Office">
                </div>
                <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                    <div class="w-full">
                        <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">Create account</h1>
                        <form method="POST" action="{{ route('register') }}">
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
                            <label class="block mt-4 text-sm" style="display: none;">
                                <span class="text-gray-700 dark:text-gray-400">Role</span>
                                <input name="role" value="Customer" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" readonly>
                            </label>
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Username</span>
                                <input name="name" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                            </label>
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Email</span>
                                <input name="email" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                            </label>
                            <div class="flex flex-col md:flex-row">
                                <div class="md:w-1/2 md:pr-2">
                                    <label class="block mt-4 text-sm">
                                        <span class="text-gray-700 dark:text-gray-400">Password</span>
                                        <input name="password" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" type="password" />
                                    </label>
                                </div>
                                <div style="padding-left: 20px;"></div>
                                <div class="md:w-1/2 md:pl-2">
                                    <label class="block mt-4 text-sm">
                                        <span class="text-gray-700 dark:text-gray-400">Confirm password</span>
                                        <input name="password_confirmation" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" type="password">
                                    </label>
                                </div>
                            </div>

                            <div style="padding-top: 20px;"></div>

                            <button type="submit" class="block w-full px-4 py-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 border border-transparent rounded-lg focus:outline-none focus:shadow-outline-blue" style="background-color: #007BFF;">
                                Create Account
                            </button>
                        </form>
                        <hr class="my-8">

                        <p class="mt-4">
                            <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" href="{{ route('login') }}">Already have an account? Login</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>