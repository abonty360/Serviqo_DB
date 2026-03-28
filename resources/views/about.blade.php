<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Serviqo</title>
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

    <!-- Hero Section -->
    <header class="bg-white border-b border-gray-100 py-20">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 mb-6">Redefining Home Services</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Serviqo is on a mission to bring professional, reliable, and affordable home services to your doorstep with just a single tap.
            </p>
        </div>
    </header>

    <!-- Mission & Vision -->
    <section class="py-20">
        <div class="container mx-auto px-6">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Mission</h2>
                <p class="text-gray-600 text-lg leading-relaxed mb-12">
                    At Serviqo, we believe that everyone deserves a well-maintained home without the stress of finding reliable help. We bridge the gap between skilled professionals and homeowners, ensuring quality work and peace of mind.
                </p>
                <div class="grid md:grid-cols-2 gap-8 text-left">
                    <div class="flex items-center gap-4 p-6 bg-white rounded-2xl border border-gray-100 shadow-sm">
                        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex-shrink-0 flex items-center justify-center">
                            <i class="fas fa-bullseye text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Empowering Pros</h4>
                            <p class="text-sm text-gray-500">Creating opportunities for local skilled workers.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-6 bg-white rounded-2xl border border-gray-100 shadow-sm">
                        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex-shrink-0 flex items-center justify-center">
                            <i class="fas fa-heart text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Customer First</h4>
                            <p class="text-sm text-gray-500">Your satisfaction is our ultimate priority.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-24 bg-white relative overflow-hidden">
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Serviqo by the Numbers</h2>
                <div class="w-20 h-1.5 bg-green-500 mx-auto rounded-full"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Stat 1 -->
                <div class="p-8 bg-green-50 rounded-3xl border border-green-100 hover:shadow-xl hover:shadow-green-100/50 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-white text-green-500 rounded-2xl flex items-center justify-center mb-6 shadow-sm group-hover:scale-110 transition-transform">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <div class="text-4xl font-black text-gray-900 mb-2">10k+</div>
                    <div class="text-gray-600 font-medium">Happy Customers</div>
                </div>

                <!-- Stat 2 -->
                <div class="p-8 bg-green-50 rounded-3xl border border-green-100 hover:shadow-xl hover:shadow-green-100/50 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-white text-green-500 rounded-2xl flex items-center justify-center mb-6 shadow-sm group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-check text-2xl"></i>
                    </div>
                    <div class="text-4xl font-black text-gray-900 mb-2">500+</div>
                    <div class="text-gray-600 font-medium">Verified Pros</div>
                </div>

                <!-- Stat 3 -->
                <div class="p-8 bg-green-50 rounded-3xl border border-green-100 hover:shadow-xl hover:shadow-green-100/50 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-white text-green-500 rounded-2xl flex items-center justify-center mb-6 shadow-sm group-hover:scale-110 transition-transform">
                        <i class="fas fa-layer-group text-2xl"></i>
                    </div>
                    <div class="text-4xl font-black text-gray-900 mb-2">50+</div>
                    <div class="text-gray-600 font-medium">Service Categories</div>
                </div>

                <!-- Stat 4 -->
                <div class="p-8 bg-green-50 rounded-3xl border border-green-100 hover:shadow-xl hover:shadow-green-100/50 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-white text-green-500 rounded-2xl flex items-center justify-center mb-6 shadow-sm group-hover:scale-110 transition-transform">
                        <i class="fas fa-star text-2xl"></i>
                    </div>
                    <div class="text-4xl font-black text-gray-900 mb-2">4.8/5</div>
                    <div class="text-gray-600 font-medium">Average Rating</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-16">The Values We Live By</h2>
            <div class="grid md:grid-cols-3 gap-12">
                <div class="text-center">
                    <div class="w-20 h-20 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shield-alt text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Trust & Safety</h3>
                    <p class="text-gray-600">Rigorous background checks and identity verification for every professional on our platform.</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-gem text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Quality Excellence</h3>
                    <p class="text-gray-600">Standardized pricing and service protocols to ensure consistent high-quality results.</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-clock text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Punctuality</h3>
                    <p class="text-gray-600">Respecting your time with strictly scheduled arrivals and efficient service delivery.</p>
                </div>
            </div>
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