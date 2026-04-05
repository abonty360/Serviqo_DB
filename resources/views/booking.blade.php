<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Service - Serviqo</title>
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

    <div class="flex-grow container mx-auto px-6 py-12">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 flex flex-col md:flex-row">
                <!-- Left Side: Image/Info -->
                <div class="md:w-1/3 bg-green-500 p-12 text-white flex flex-col justify-center">
                    <div class="mb-8">
                        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-calendar-check text-3xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold mb-4">Book Your Service</h2>
                        <p class="text-green-50 opacity-90 leading-relaxed">
                            Fill out the form to schedule a professional service at your convenience.
                        </p>
                    </div>
                    <ul class="space-y-4 text-sm font-medium">
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-200"></i>
                            Verified Professionals
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-200"></i>
                            Safe & Secure Payments
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-200"></i>
                            24/7 Support Available
                        </li>
                    </ul>
                </div>

                <!-- Right Side: Form -->
                <div class="md:w-2/3 p-12">
                    <form id="bookingForm" class="space-y-6">
                        @csrf
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Service Selection -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Select Service</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                        <i class="fas fa-tools"></i>
                                    </span>
                                    <select name="service" id="service-select" required
                                        class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition bg-white appearance-none">
                                        <option value="">Choose a service...</option>
                                        <option value="cleaning">Cleaning Services</option>
                                        <option value="repair">Appliance Repair</option>
                                        <option value="maintenance">Maintenance</option>
                                        <option value="beauty">Beauty & Makeover</option>
                                        <option value="pest">Pest Control</option>
                                        <option value="painting">Painting</option>
                                        <option value="car">Car Care Services</option>
                                        <option value="travel">Trip & Travels</option>
                                        <option value="health">Health & Care</option>
                                        <option value="shifting">House Shifting</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Date -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Preferred Date</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                    <input type="date" name="date" required
                                        class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                                </div>
                            </div>

                            <!-- Time -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Preferred Time</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                        <i class="fas fa-clock"></i>
                                    </span>
                                    <input type="time" name="time" required
                                        class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Service Address</label>
                                <div class="relative">
                                    <span class="absolute top-3 left-4 text-gray-400">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                                    <textarea name="address" rows="3" required
                                        class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                                        placeholder="Enter your full address"></textarea>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Phone Number</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                    <input type="tel" name="phone" required
                                        class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                                        placeholder="+1 (555) 000-0000">
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-4">Select Payment Method</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <label class="relative flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-green-50 transition group peer-checked:border-green-500">
                                        <input type="radio" name="payment_method" value="cash" checked class="peer hidden">
                                        <div class="w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center peer-checked:border-green-500 peer-checked:bg-green-500 mr-3">
                                            <div class="w-2 h-2 bg-white rounded-full"></div>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-gray-700">Cash After Service</span>
                                            <span class="text-xs text-gray-500">Pay when job is done</span>
                                        </div>
                                        <i class="fas fa-money-bill-wave ml-auto text-gray-400 group-hover:text-green-500"></i>
                                    </label>

                                    <label class="relative flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-green-50 transition group">
                                        <input type="radio" name="payment_method" value="mobile_banking" class="peer hidden">
                                        <div class="w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center peer-checked:border-green-500 peer-checked:bg-green-500 mr-3">
                                            <div class="w-2 h-2 bg-white rounded-full"></div>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-gray-700">Mobile Banking</span>
                                            <span class="text-xs text-gray-500">bKash, Nagad, Rocket</span>
                                        </div>
                                        <i class="fas fa-mobile-screen ml-auto text-gray-400 group-hover:text-green-500"></i>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full py-4 bg-green-500 text-white font-bold rounded-xl hover:bg-green-600 shadow-lg shadow-green-200 transition-all transform hover:-translate-y-0.5 mt-4">
                            Confirm Booking
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Confirmation Modal -->
    <div id="confirmationModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-50 px-4">
        <div class="bg-white rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl transform transition-all">
            <div class="w-20 h-20 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-check text-4xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Booking Confirmed</h3>
            <p class="text-gray-500 mb-8">Thanks for being with us.</p>
            <button id="closeModal" class="w-full py-3 bg-green-500 text-white font-bold rounded-xl hover:bg-green-600 transition-all">
                Great!
            </button>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-auto">
        <div class="container mx-auto px-6 text-center">
            <p class="text-gray-400 text-sm">&copy; 2026 Serviqo. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Auto-select service from URL parameter
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const service = urlParams.get('service');
            if (service) {
                const select = document.getElementById('service-select');
                if (select) select.value = service.toLowerCase();
            }

            const bookingForm = document.getElementById('bookingForm');
            const confirmationModal = document.getElementById('confirmationModal');
            const closeModal = document.getElementById('closeModal');

            bookingForm.addEventListener('submit', function(e) {
                e.preventDefault();
                // Show modal
                confirmationModal.classList.remove('hidden');
            });

            closeModal.addEventListener('click', function() {
                confirmationModal.classList.add('hidden');
                // Optionally redirect home after confirmation
                window.location.href = '/';
            });
        });
    </script>

</body>

</html>