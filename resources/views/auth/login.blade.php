<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviqo - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/login.css'])
</head>

<body class="flex items-center justify-center min-h-screen">

    <div
        class="bg-white rounded-2xl text-left overflow-hidden shadow-2xl sm:max-w-md sm:w-full border border-green-100 mx-auto my-8">
        <div class="bg-white px-8 pt-10 pb-8">
            <div class="text-center mb-8">
                <div id="signupSuccessMsg"
                    class="hidden mb-6 p-4 bg-green-100 text-green-700 rounded-xl text-sm font-bold animate-bounce">
                    <i class="fas fa-check-circle mr-2"></i> Registration Successful! Please Login.
                </div>
                <div
                    class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-lock text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">Welcome Back</h3>
                <p class="text-gray-500 mt-2">Login to manage your bookings</p>
            </div>
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-xl">
                    {{ $errors->first() }}
                </div>
            @endif
            <form action="{{ route('customer.login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="email" required
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                            placeholder="name@example.com">
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <label class="block text-sm font-semibold text-gray-700">Password</label>
                        <a href="#" class="text-sm font-medium text-green-600 hover:text-green-700">Forgot password?</a>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" required
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                            placeholder="Password">
                    </div>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember"
                        class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                    <label class="ml-2 block text-sm text-gray-700">Remember me</label>
                </div>

                <button type="submit"
                    class="w-full py-4 bg-green-500 text-white font-bold rounded-xl hover:bg-green-600 shadow-lg shadow-green-200 transition-all transform hover:-translate-y-0.5">
                    Sign In
                </button>
            </form>

            <div class="mt-8 text-center border-t border-gray-100 pt-6">
                <p class="text-gray-600">Don't have an account?
                    <a href="/signup" class="font-bold text-green-600 hover:text-green-700">Create Account</a>
                </p>
                <div class="mt-4">
                    <a href="/guest" class="text-base font-bold text-green-600 hover:text-green-700 transition-colors">
                        Continue as Guest
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('signup') === 'success') {
                const successMsg = document.getElementById('signupSuccessMsg');
                if (successMsg) {
                    successMsg.classList.remove('hidden');
                }
                const newUrl = window.location.pathname;
                window.history.replaceState({}, document.title, newUrl);
            }
        });
    </script>
    <script>
        document.querySelector("form").addEventListener("submit", async function (e) {
            e.preventDefault();

            const btn = this.querySelector('button[type="submit"]');
            const originalText = btn.textContent;
            btn.textContent = 'Signing in...';
            btn.disabled = true;

            // Show/hide error message
            let errDiv = document.getElementById('loginError');
            if (!errDiv) {
                errDiv = document.createElement('div');
                errDiv.id = 'loginError';
                errDiv.className = 'mb-4 p-3 bg-red-100 text-red-700 rounded-xl text-sm';
                errDiv.style.display = 'none';
                this.insertBefore(errDiv, this.firstChild);
            }
            errDiv.style.display = 'none';

            try {
                const formData = new FormData(this);

                const response = await fetch("/login", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                });

                const text = await response.text();
                let data;
                try {
                    data = JSON.parse(text);
                } catch (_) {
                    errDiv.textContent = 'Unexpected server error. Please try again.';
                    errDiv.style.display = 'block';
                    btn.textContent = originalText;
                    btn.disabled = false;
                    return;
                }

                if (!data.error) {
                    localStorage.setItem("token", data.token);
                    localStorage.setItem("user", JSON.stringify(data.customer));
                    const user = data.customer;

                    if (user && user.role === "admin") {
                        window.location.href = "/admin/dashboard";
                    } else {
                        window.location.href = "/";
                    }
                } else {
                    errDiv.textContent = data.message || 'Invalid email or password.';
                    errDiv.style.display = 'block';
                    btn.textContent = originalText;
                    btn.disabled = false;
                }
            } catch (err) {
                errDiv.textContent = 'Network error. Please check your connection and try again.';
                errDiv.style.display = 'block';
                btn.textContent = originalText;
                btn.disabled = false;
            }
        });
    </script>
    <script>
        // Only redirect away from login if user navigates BACK via browser cache
        // (e.g. pressing the back button after logging in).
        // Do NOT redirect on normal page load so the user can actually log in.
        window.addEventListener("pageshow", function (e) {
            if (e.persisted) {
                const token = localStorage.getItem("token");
                if (token) {
                    window.location.replace("/");
                }
            }
        });
    </script>
</body>

</html>