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

@include('components.navbar')
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
                <div
                    class="bg-white p-2 rounded-2xl shadow-xl flex flex-col md:flex-row items-center gap-2 border border-green-100">
                    <div
                        class="flex-1 w-full flex items-center px-4 py-3 border-b md:border-b-0 md:border-r border-gray-100">
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
                    <a href="{{ route('services') }}"
                        class="w-full md:w-auto px-10 py-4 bg-green-500 text-white font-bold rounded-xl hover:bg-green-600 transition-all shadow-lg hover:shadow-green-200 text-center">
                        Search
                    </a>
                </div>

                <!-- Popular Services Tags -->
                <div class="mt-8 flex flex-wrap gap-3">
                    <span class="text-sm text-gray-500 py-1">Popular:</span>
                    <a href="#"
                        class="text-sm bg-white border border-gray-200 px-3 py-1 rounded-full hover:border-green-400 hover:text-green-600 transition">Cleaning</a>
                    <a href="#"
                        class="text-sm bg-white border border-gray-200 px-3 py-1 rounded-full hover:border-green-400 hover:text-green-600 transition">AC
                        Repair</a>
                    <a href="#"
                        class="text-sm bg-white border border-gray-200 px-3 py-1 rounded-full hover:border-green-400 hover:text-green-600 transition">Pest
                        Control</a>
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

    <!-- How It Works Section -->
    <section class="py-20 bg-green-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">How it Works</h2>
                <p class="text-gray-600">Ordering a service has never been easier</p>
            </div>
            <div class="grid md:grid-cols-4 gap-8">
                <div class="relative text-center">
                    <div
                        class="w-16 h-16 bg-white text-green-600 rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-6 text-2xl font-bold">
                        1</div>
                    <h3 class="font-bold mb-2">Select Service</h3>
                    <p class="text-sm text-gray-600">Pick from our wide range of home services</p>
                    <div class="hidden md:block absolute top-8 left-1/2 w-full h-0.5 bg-green-200 -z-10"></div>
                </div>
                <div class="relative text-center">
                    <div
                        class="w-16 h-16 bg-white text-green-600 rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-6 text-2xl font-bold">
                        2</div>
                    <h3 class="font-bold mb-2">Choose Time</h3>
                    <p class="text-sm text-gray-600">Select a date and time that fits your schedule</p>
                    <div class="hidden md:block absolute top-8 left-1/2 w-full h-0.5 bg-green-200 -z-10"></div>
                </div>
                <div class="relative text-center">
                    <div
                        class="w-16 h-16 bg-white text-green-600 rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-6 text-2xl font-bold">
                        3</div>
                    <h3 class="font-bold mb-2">Book Pro</h3>
                    <p class="text-sm text-gray-600">Confirm order with a verified professional</p>
                    <div class="hidden md:block absolute top-8 left-1/2 w-full h-0.5 bg-green-200 -z-10"></div>
                </div>
                <div class="text-center">
                    <div
                        class="w-16 h-16 bg-green-500 text-white rounded-2xl shadow-md flex items-center justify-center mx-auto mb-6 text-2xl font-bold">
                        <i class="fas fa-check"></i>
                    </div>
                    <h3 class="font-bold mb-2">Relax</h3>
                    <p class="text-sm text-gray-600">Our expert will arrive and get the job done</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Simple Features Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-12">Why Choose Serviqo?</h2>
            <div class="grid md:grid-cols-3 gap-12">
                <div class="p-8 rounded-2xl hover:bg-green-50 transition">
                    <div
                        class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shield-halved text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Verified Pros</h3>
                    <p class="text-gray-600">Every professional is background checked and highly rated by users.</p>
                </div>
                <div class="p-8 rounded-2xl hover:bg-green-50 transition">
                    <div
                        class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-bolt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Fast Ordering</h3>
                    <p class="text-gray-600">Book services in less than 60 seconds with instant confirmation.</p>
                </div>
                <div class="p-8 rounded-2xl hover:bg-green-50 transition">
                    <div
                        class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-headset text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">24/7 Support</h3>
                    <p class="text-gray-600">Our customer support team is always here to help you with anything.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Services Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Popular Services</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Choose from our wide range of professional home services</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Cleaning -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all border border-gray-100 group overflow-hidden">
                    <div class="h-48 overflow-hidden bg-gray-50 flex items-center justify-center">
                        <img src="{{ asset('Images/Cleaning.jpg') }}" alt="Cleaning" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold mb-2">Cleaning Services</h3>
                        <p class="text-gray-600 mb-4">Professional home and office cleaning</p>
                        <a href="{{ route('book', ['service' => 'cleaning']) }}" class="text-green-600 font-semibold flex items-center group-hover:underline">
                            Book Now <i class="fas fa-chevron-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>
                <!-- Appliance Repair -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all border border-gray-100 group overflow-hidden">
                    <div class="h-48 overflow-hidden bg-gray-50 flex items-center justify-center">
                        <img src="{{ asset('Images/Reapir.jpg') }}" alt="Appliance Repair" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold mb-2">Appliance Repair</h3>
                        <p class="text-gray-600 mb-4">Fix AC, fridge, washing machine & more</p>
                        <a href="{{ route('book', ['service' => 'repair']) }}" class="text-green-600 font-semibold flex items-center group-hover:underline">
                            Book Now <i class="fas fa-chevron-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>
                <!-- Maintenance -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all border border-gray-100 group overflow-hidden">
                    <div class="h-48 overflow-hidden bg-gray-50 flex items-center justify-center">
                        <img src="{{ asset('Images/Plumbing.jpg') }}" alt="Maintenance" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold mb-2">Maintenance</h3>
                        <p class="text-gray-600 mb-4">Plumbing, electrical, carpentry services</p>
                        <a href="{{ route('book', ['service' => 'maintenance']) }}" class="text-green-600 font-semibold flex items-center group-hover:underline">
                            Book Now <i class="fas fa-chevron-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>
                <!-- Beauty -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all border border-gray-100 group overflow-hidden">
                    <div class="h-48 overflow-hidden bg-gray-50 flex items-center justify-center">
                        <img src="{{ asset('Images/Makeup.jpg') }}" alt="Beauty & Makeover" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold mb-2">Beauty & Makeover</h3>
                        <p class="text-gray-600 mb-4">Salon services at your doorstep</p>
                        <a href="{{ route('book', ['service' => 'beauty']) }}" class="text-green-600 font-semibold flex items-center group-hover:underline">
                            Book Now <i class="fas fa-chevron-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>
                <!-- Pest Control -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all border border-gray-100 group overflow-hidden">
                    <div class="h-48 overflow-hidden bg-gray-50 flex items-center justify-center">
                        <img src="{{ asset('Images/Pest.jpg') }}" alt="Pest Control" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold mb-2">Pest Control</h3>
                        <p class="text-gray-600 mb-4">Complete pest management solutions</p>
                        <a href="{{ route('book', ['service' => 'pest']) }}" class="text-green-600 font-semibold flex items-center group-hover:underline">
                            Book Now <i class="fas fa-chevron-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>
                <!-- Painting -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all border border-gray-100 group overflow-hidden">
                    <div class="h-48 overflow-hidden bg-gray-50 flex items-center justify-center">
                        <img src="{{ asset('Images/Painting.jpg') }}" alt="Painting" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold mb-2">Painting</h3>
                        <p class="text-gray-600 mb-4">Interior and exterior painting</p>
                        <a href="{{ route('book', ['service' => 'painting']) }}" class="text-green-600 font-semibold flex items-center group-hover:underline">
                            Book Now <i class="fas fa-chevron-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">What Our Customers Say</h2>
                <p class="text-gray-600">Hear from our satisfied users about their experiences</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-green-50 p-8 rounded-3xl relative">
                    <div class="flex justify-between items-start mb-6">
                        <div class="text-green-500 text-4xl"><i class="fas fa-quote-left"></i></div>
                        <div class="flex text-yellow-400 text-sm">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-700 italic mb-8 leading-relaxed">
                        “Amazing service! The cleaner was professional and thorough. My home has never looked better.”
                    </p>
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-green-200 rounded-full flex items-center justify-center text-green-700 font-bold mr-4">
                            SJ</div>
                        <div>
                            <h4 class="font-bold text-gray-900">Sarah Johnson</h4>
                            <p class="text-sm text-green-600">Deep Cleaning</p>
                        </div>
                    </div>
                </div>
                <!-- Testimonial 2 -->
                <div class="bg-green-50 p-8 rounded-3xl relative">
                    <div class="flex justify-between items-start mb-6">
                        <div class="text-green-500 text-4xl"><i class="fas fa-quote-left"></i></div>
                        <div class="flex text-yellow-400 text-sm">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-700 italic mb-8 leading-relaxed">
                        “Quick response and excellent work. Fixed my AC within an hour. Highly recommend!”
                    </p>
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-green-200 rounded-full flex items-center justify-center text-green-700 font-bold mr-4">
                            MC</div>
                        <div>
                            <h4 class="font-bold text-gray-900">Michael Chen</h4>
                            <p class="text-sm text-green-600">AC Repair</p>
                        </div>
                    </div>
                </div>
                <!-- Testimonial 3 -->
                <div class="bg-green-50 p-8 rounded-3xl relative">
                    <div class="flex justify-between items-start mb-6">
                        <div class="text-green-500 text-4xl"><i class="fas fa-quote-left"></i></div>
                        <div class="flex text-yellow-400 text-sm">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-700 italic mb-8 leading-relaxed">
                        “The salon service at home was incredible. Saved so much time and the results were perfect.”
                    </p>
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-green-200 rounded-full flex items-center justify-center text-green-700 font-bold mr-4">
                            ER</div>
                        <div>
                            <h4 class="font-bold text-gray-900">Emily Rodriguez</h4>
                            <p class="text-sm text-green-600">Beauty Services</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
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
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Maintenance</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Beauty</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Company</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Careers</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Contact</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Blog</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Help Center</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Terms of
                                Service</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Privacy Policy</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">FAQs</a></li>
                    </ul>
                </div>
            </div>

            <div
                class="flex flex-col md:flex-row justify-between items-center text-gray-500 text-sm pt-8 border-t border-gray-800">
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