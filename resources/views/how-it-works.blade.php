<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>How it Works - Serviqo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #22c55e;
            --dark-green: #16a34a;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

@include('components.navbar')

    <!-- Header -->
    <header class="bg-white border-b border-gray-100 py-16">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6">Simple, Fast & Reliable</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Discover how Serviqo makes it easy to get professional help for your home in just a few clicks.</p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow py-20">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-16 items-center mb-32">
                <div>
                    <div class="inline-block px-4 py-2 bg-green-100 text-green-700 rounded-lg font-bold text-sm mb-6">STEP 01</div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Find the Service You Need</h2>
                    <p class="text-gray-600 text-lg leading-relaxed mb-8">
                        Browse through our extensive list of categories including Cleaning, Repairs, Beauty, Maintenance, and more. Use our search tool to find exactly what you're looking for in your local area.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                            <span class="text-gray-700 font-medium">Over 50+ service categories</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                            <span class="text-gray-700 font-medium">Location-based professional matching</span>
                        </li>
                    </ul>
                </div>
                <div class="bg-white p-4 rounded-3xl shadow-xl border border-gray-100">
                    <img src="{{ asset('Images/Finding.jpg') }}" alt="Find the Service" class="rounded-2xl w-full h-80 object-cover">
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-16 items-center mb-32 md:flex-row-reverse">
                <div class="md:order-2">
                    <div class="inline-block px-4 py-2 bg-green-100 text-green-700 rounded-lg font-bold text-sm mb-6">STEP 02</div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Choose Your Schedule</h2>
                    <p class="text-gray-600 text-lg leading-relaxed mb-8">
                        Select a date and time that works best for you. Whether you need immediate help or want to schedule for next week, our pros are flexible and ready to assist.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                            <span class="text-gray-700 font-medium">Real-time availability</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                            <span class="text-gray-700 font-medium">Instant confirmation</span>
                        </li>
                    </ul>
                </div>
                <div class="bg-white p-4 rounded-3xl shadow-xl border border-gray-100 md:order-1">
                    <img src="{{ asset('Images/Schedule.jpg') }}" alt="Choose Your Schedule" class="rounded-2xl w-full h-80 object-cover">
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-16 items-center mb-32">
                <div>
                    <div class="inline-block px-4 py-2 bg-green-100 text-green-700 rounded-lg font-bold text-sm mb-6">STEP 03</div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Confirm and Relax</h2>
                    <p class="text-gray-600 text-lg leading-relaxed mb-8">
                        Review your booking details, select your preferred payment method, and confirm. A verified professional will arrive at your doorstep as scheduled.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                            <span class="text-gray-700 font-medium">Secure online payments</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                            <span class="text-gray-700 font-medium">Cash on delivery option</span>
                        </li>
                    </ul>
                </div>
                <div class="bg-white p-4 rounded-3xl shadow-xl border border-gray-100 flex items-center justify-center">
                    <img src="{{ asset('Images/Confirm.jpg') }}" alt="Confirm and Relax" class="rounded-2xl w-full h-96 object-contain bg-gray-50">
                </div>
            </div>
        </div>
    </main>

    <!-- CTA Section -->
    <section class="py-20 bg-green-500">
        <div class="container mx-auto px-6 text-center text-white">
            <h2 class="text-3xl md:text-4xl font-bold mb-8">Ready to get started?</h2>
            <a href="{{ route('services') }}" class="px-12 py-4 bg-white text-green-600 font-bold rounded-xl hover:bg-gray-100 transition-all shadow-xl inline-block">Explore Services</a>
        </div>
    </section>

    <!-- Footer -->
      <footer class="bg-gray-900 text-white py-12 mt-auto">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-green-500 rounded flex items-center justify-center">
                            <i class="fas fa-tools text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-bold tracking-tight">Serviqo</span>
                    </div>
                    <p class="text-gray-400 text-sm">Your trusted partner for all home services.</p>
                </div>

                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Services</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Cleaning</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Repair</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Maintenance</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Beauty</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Company</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-green-500 transition text-sm">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Careers</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Contact</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Blog</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Help Center</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">FAQs</a></li>
                    </ul>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center text-gray-500 text-sm pt-8 border-t border-gray-800">
                <p>&copy; 2026 Serviqo. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-white transition"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="hover:text-white transition"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>