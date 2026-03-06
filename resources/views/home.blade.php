<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviqo - Home Services On Demand</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #22c55e;
            --dark-green: #16a34a;
        }
    </style>
</head>
<body class="bg-white text-gray-800">

    <!-- Navigation -->
    <nav class="flex items-center justify-between px-8 py-4 bg-white border-b sticky top-0 z-50">
        <div class="flex items-center space-x-2">
            <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                <i class="fas fa-tools text-white text-xl"></i>
            </div>
            <span class="text-2xl font-bold text-gray-900 tracking-tight">Serviqo</span>
        </div>
        <div class="hidden md:flex ml-auto space-x-10 font-medium text-gray-600">
            <a href="#" class="hover:text-green-600 transition">Services</a>
            <a href="#" class="hover:text-green-600 transition">How it Works</a>
            <a href="#" class="hover:text-green-600 transition">Become a Pro</a>
        </div>
        <div class="flex space-x-4">
            @if (session('logged_in'))
                <a href="/profile" class="px-7 py-2 text-green-600 font-semibold hover:bg-green-50 rounded-lg transition">
                    <i class="fas fa-user-circle text-xl"></i> Profile
                </a>
            @else
                <a href="/login" class="px-7 py-2 text-green-600 font-semibold hover:bg-green-50 rounded-lg transition">Login</a>
                <a href="/signup" class="px-7 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 shadow-md transition">Sign Up</a>
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative bg-gradient-to-br from-green-50 to-white py-20 lg:py-32 overflow-hidden">
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-3xl">
                <h1 class="text-5xl lg:text-7xl font-extrabold text-gray-900 leading-tight mb-6">
                    Home Services,<br>
                    <span class="text-green-500">On Demand</span>
                </h1>
                <p class="text-xl text-gray-600 mb-10 leading-relaxed">
                    Book trusted professionals for cleaning, repairs, beauty services, and more. 
                    Quality service at your doorstep.
                </p>

                <!-- Search Bar -->
                <div class="bg-white p-2 rounded-2xl shadow-xl flex flex-col md:flex-row items-center gap-2 border border-green-100">
                    <div class="flex-1 w-full flex items-center px-4 py-3 border-b md:border-b-0 md:border-r border-gray-100">
                        <i class="fas fa-location-dot text-green-500 mr-3"></i>
                        <input type="text" placeholder="Enter location" class="w-full focus:outline-none text-gray-700">
                    </div>
                    <div class="flex-1 w-full flex items-center px-4 py-3">
                        <i class="fas fa-search text-green-500 mr-3"></i>
                        <select class="w-full focus:outline-none text-gray-700 bg-transparent appearance-none">
                            <option value="">Select service</option>
                            <option value="cleaning">Home Cleaning</option>
                            <option value="repairs">Plumbing & Repair</option>
                            <option value="beauty">Beauty & Salon</option>
                            <option value="painting">House Painting</option>
                        </select>
                    </div>
                    <button class="w-full md:w-auto px-10 py-4 bg-green-500 text-white font-bold rounded-xl hover:bg-green-600 transition-all shadow-lg hover:shadow-green-200">
                        Search
                    </button>
                </div>

                <!-- Popular Services Tags -->
                <div class="mt-8 flex flex-wrap gap-3">
                    <span class="text-sm text-gray-500 py-1">Popular:</span>
                    <a href="#" class="text-sm bg-white border border-gray-200 px-3 py-1 rounded-full hover:border-green-400 hover:text-green-600 transition">Cleaning</a>
                    <a href="#" class="text-sm bg-white border border-gray-200 px-3 py-1 rounded-full hover:border-green-400 hover:text-green-600 transition">AC Repair</a>
                    <a href="#" class="text-sm bg-white border border-gray-200 px-3 py-1 rounded-full hover:border-green-400 hover:text-green-600 transition">Pest Control</a>
                </div>
            </div>
        </div>

        <!-- Decorative Elements -->
        <div class="absolute right-0 top-0 w-1/3 h-full hidden lg:block opacity-10">
            <svg class="w-full h-full text-green-500" fill="currentColor" viewBox="0 0 100 100">
                <circle cx="80" cy="20" r="15" />
                <circle cx="90" cy="60" r="20" />
                <circle cx="70" cy="90" r="10" />
            </svg>
        </div>
    </header>

</body>
</html>
