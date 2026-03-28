<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services - Serviqo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #22c55e;
            --dark-green: #16a34a;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

@include('components.navbar')

    <!-- Header Section -->
    <header class="bg-white border-b border-gray-100 py-12">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Our Professional Services</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Explore our wide range of home services tailored to meet your needs. Quality and satisfaction guaranteed.</p>
        </div>
    </header>

    <!-- Services Grid -->
    <section class="py-16">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Cleaning -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all border border-gray-100 group overflow-hidden">
                     <div class="h-48 overflow-hidden bg-gray-50 flex items-center justify-center">
                        <img src="{{ asset('Images/Cleaning.jpg') }}" alt="Cleaning" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold mb-2">Cleaning Services</h3>
                        <p class="text-gray-600 mb-6">Professional home and office cleaning including deep cleaning, kitchen cleaning, and bathroom sanitization.</p>
                        <div class="flex items-center justify-between">
                            <span class="text-green-600 font-bold">$29 - $199</span>
                           <a href="{{ route('book', ['service' => 'cleaning']) }}" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">Book Now</a>
                        </div>
                    </div>
                </div>
                <!-- Appliance Repair -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all border border-gray-100 group overflow-hidden">
                     <div class="h-48 overflow-hidden bg-gray-50 flex items-center justify-center">
                        <img src="{{ asset('Images/Reapir.jpg') }}" alt="Appliance Repair" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold mb-2">Appliance Repair</h3>
                        <p class="text-gray-600 mb-6">Expert repair for AC, refrigerator, washing machine, microwave, and other essential home appliances.</p>
                        <div class="flex items-center justify-between">
                            <span class="text-green-600 font-bold">$49 - $250</span>
                            <a href="{{ route('book', ['service' => 'repair']) }}" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">Book Now</a>
                        </div>
                    </div>
                </div>
                <!-- Maintenance -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all border border-gray-100 group overflow-hidden">
                     <div class="h-48 overflow-hidden bg-gray-50 flex items-center justify-center">
                        <img src="{{ asset('Images/Plumbing.jpg') }}" alt="Maintenance" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold mb-2">Maintenance</h3>
                        <p class="text-gray-600 mb-6">Reliable plumbing, electrical work, carpentry, and general home maintenance services by certified professionals.</p>
                        <div class="flex items-center justify-between">
                            <span class="text-green-600 font-bold">$35 - $150</span>
                            <a href="{{ route('book', ['service' => 'maintenance']) }}" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">Book Now</a>
                        </div>
                    </div>
                </div>
                <!-- Beauty -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all border border-gray-100 group overflow-hidden">
                    <div class="h-48 overflow-hidden bg-gray-50 flex items-center justify-center">
                        <img src="{{ asset('Images/Makeup.jpg') }}" alt="Beauty & Makeover" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold mb-2">Beauty & Makeover</h3>
                        <p class="text-gray-600 mb-6">Get salon-quality beauty services, haircuts, facials, and massages in the comfort of your own home.</p>
                        <div class="flex items-center justify-between">
                            <span class="text-green-600 font-bold">$15 - $120</span>
                            <a href="{{ route('book', ['service' => 'beauty']) }}" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">Book Now</a>
                        </div>
                    </div>
                </div>

                <!-- Pest Control -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all border border-gray-100 group overflow-hidden">
                     <div class="h-48 overflow-hidden bg-gray-50 flex items-center justify-center">
                        <img src="{{ asset('Images/Pest.jpg') }}" alt="Pest Control" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold mb-2">Pest Control</h3>
                        <p class="text-gray-600 mb-6">Effective and safe pest management for termites, cockroaches, rodents, and other unwanted visitors.</p>
                        <div class="flex items-center justify-between">
                            <span class="text-green-600 font-bold">$60 - $300</span>
                            <a href="{{ route('book', ['service' => 'pest']) }}" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">Book Now</a>
                        </div>
                    </div>
                </div>
                <!-- Painting -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all border border-gray-100 group overflow-hidden">
                    <div class="h-48 overflow-hidden bg-gray-50 flex items-center justify-center">
                        <img src="{{ asset('Images/Painting.jpg') }}" alt="Painting" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                    </div>

                    <div class="p-8">
                        <h3 class="text-xl font-bold mb-2">Painting</h3>
                        <p class="text-gray-600 mb-6">Transform your space with our professional interior and exterior painting services. Free color consultation included.</p>
                        <div class="flex items-center justify-between">
                            <span class="text-green-600 font-bold">$199 - $2000+</span>
                            <a href="{{ route('book', ['service' => 'painting']) }}" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">Book Now</a>
                        </div>
                    </div>
                </div>
                <!-- Car Care -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all border border-gray-100 group overflow-hidden">
                        <div class="h-48 overflow-hidden bg-gray-50 flex items-center justify-center">
                        <img src="{{ asset('Images/Car care.jpg') }}" alt="Car Care" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold mb-2">Car Care Services</h3>
                        <p class="text-gray-600 mb-6">Professional car wash, detailing, interior cleaning, and minor repairs right at your doorstep.</p>
                        <div class="flex items-center justify-between">
                            <span class="text-green-600 font-bold">$19 - $149</span>
                            <a href="{{ route('book', ['service' => 'car']) }}" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">Book Now</a>
                        </div>
                    </div>
                </div>
                <!-- Trip & Travels -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all border border-gray-100 group overflow-hidden">
                        <div class="h-48 overflow-hidden bg-gray-50 flex items-center justify-center">
                        <img src="{{ asset('Images/Trip.jpg') }}" alt="Trip & Travels" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold mb-2">Trip & Travels</h3>
                        <p class="text-gray-600 mb-6">Hassle-free travel planning, ticket booking, and local tour guides for your next adventure.</p>
                        <div class="flex items-center justify-between">
                            <span class="text-green-600 font-bold">$99 - $999+</span>
                            <a href="{{ route('book', ['service' => 'travel']) }}" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">Book Now</a>
                        </div>
                    </div>
                </div>

                <!-- Health & Care -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all border border-gray-100 group overflow-hidden">
                        <div class="h-48 overflow-hidden bg-gray-50 flex items-center justify-center">
                        <img src="{{ asset('Images/Health.jpg') }}" alt="Health & Care" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold mb-2">Health & Care</h3>
                        <p class="text-gray-600 mb-6">Professional nursing care, physiotherapy, and elderly assistance services at home.</p>
                        <div class="flex items-center justify-between">
                            <span class="text-green-600 font-bold">$25 - $200/day</span>
                            <a href="{{ route('book', ['service' => 'health']) }}" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">Book Now</a>
                        </div>
                    </div>
                </div>

                <!-- House Shifting -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all border border-gray-100 group overflow-hidden">
                        <div class="h-48 overflow-hidden bg-gray-50 flex items-center justify-center">
                        <img src="{{ asset('Images/Shifting.jpg') }}" alt="House Shifting" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold mb-2">House Shifting</h3>
                        <p class="text-gray-600 mb-6">Reliable packing and moving services for smooth relocation. We handle your belongings with care.</p>
                        <div class="flex items-center justify-between">
                            <span class="text-green-600 font-bold">$150 - $1500+</span>
                            <a href="{{ route('book', ['service' => 'shifting']) }}" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">Book Now</a>
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
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Maintenance</a></li>
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