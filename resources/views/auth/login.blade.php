<!DOCTYPE html>
<html :class="{ 'theme-dark': light }" x-data="data()" lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('asset/tailwind/css/tailwind.output.css') }}">
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
  <script src="{{ asset('asset/tailwind/js/init-alpine.js') }}"></script>
  <script>
      const token = localStorage.getItem('token');
      if(token)
      {
        window.location.href = '/home';
      }
  </script>
</head>
<body>
  <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
    <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
      <div class="flex flex-col md:flex-row">
        <div class="h-32 md:h-auto md:w-1/2">
          <img aria-hidden="true" class="object-cover w-full h-full dark:hidden" src="asset/tailwind/img/login-office.jpeg" alt="Office" />
          <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block" src="asset/tailwind/img/login-office-dark.jpeg" alt="Office" />
        </div>
        <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
          <div class="w-full">
            <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
              Login
            </h1>
            <form id="loginFormElement" method="POST" action="">
              <div style="padding-bottom: 10px;"></div>
             <div class="form-group">
                <label for="exampleInputName" class="block text-sm text-gray-700 dark:text-gray-400">Username</label>
                <input name="name" type="text" id="name" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" aria-describedby="nameHelp" placeholder="Username" />
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
              <p class="mt-1"><a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" href="/register">
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('loginFormElement').addEventListener('submit', function(event) {
        event.preventDefault();

        const name = document.getElementById('name').value;
        const password = document.getElementById('password').value;

        const data = {
            name: name,
            password: password
        };

        fetch('/api/login', {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            }
        }).then(response => {
            return response.json();
        }).then(data => {
            console.log(data);
            if(data.status == true)
            {
                localStorage.setItem('token', data.access_token);
                swal({
                    title: "Good job!",
                    text: data.message,
                    icon: "success",
                    button: "Proceed",
                }).then(() => {
                    window.location.href = '/home';
                });
            }
        })

      });
    });
  </script>
  <script src="{{ asset('sweetalert.min.js') }}"></script>
</body>
</html>
