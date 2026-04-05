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
                                    <select id="main-service-select" required
                                        class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition bg-white appearance-none">
                                        <option value="">Choose a service category...</option>
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
                             <!-- Hidden input to hold the actual service value for form submission -->
                                <input type="hidden" name="service" id="final-service-value">

                            <!-- Dynamic Sub-Service Selection -->
                            <div id="sub-service-container" class="md:col-span-2 hidden animate-fade-in">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Select Specific Service</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                        <i class="fas fa-list-ul"></i>
                                    </span>
                                    <select id="sub-service-select"
                                        class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition bg-white appearance-none">
                                        <!-- Options populated via JS -->
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

                            <!-- Division -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Division</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 pointer-events-none">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                                    <select name="city" id="divisionSelect" required
                                        class="block w-full pl-11 pr-10 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition appearance-none bg-white text-gray-700">
                                        <option value="" disabled selected>Select Division</option>
                                        <option value="Dhaka">Dhaka</option>
                                        <option value="Chittagong">Chittagong</option>
                                        <option value="Sylhet">Sylhet</option>
                                        <option value="Barisal">Barisal</option>
                                        <option value="Rangpur">Rangpur</option>
                                        <option value="Rajshahi">Rajshahi</option>
                                        <option value="Khulna">Khulna</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Region -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Region</label>
                                <div class="relative dropdown-container" id="regionContainer">
                                    <button type="button" id="regionButton"
                                        class="w-full pl-11 pr-10 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition bg-white text-gray-700 text-left flex items-center justify-between">
                                        <span id="regionLabel">Select Region</span>
                                        <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                                    </button>
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 pointer-events-none">
                                        <i class="fas fa-globe"></i>
                                    </span>
                                    <div id="regionMenu"
                                        class="hidden absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-xl max-h-60 overflow-y-auto">
                                        <div id="regionOptionsList" class="p-1">
                                            <div class="px-4 py-2 text-gray-400 text-sm">Please select a division first</div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="region" id="regionInput" required>
                                </div>
                            </div>

                            <!-- Road No -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Road No.</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                        <i class="fas fa-road"></i>
                                    </span>
                                    <input type="text" name="road_no" required
                                        class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                                        placeholder="Road No.">
                                </div>
                            </div>

                            <!-- House No -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">House No.</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                        <i class="fas fa-home"></i>
                                    </span>
                                    <input type="text" name="house_no" required
                                        class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                                        placeholder="House No.">
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
                            class="w-full py-4 bg-green-500 text-white font-bold rounded-xl hover:bg-green-600 shadow-xl shadow-green-500/20 transition-all transform hover:-translate-y-1 active:scale-[0.98] mt-6 flex items-center justify-center gap-3 group">
                            <span class="text-lg">Confirm Booking</span>
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
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
            const mainSelect = document.getElementById('main-service-select');
            const subContainer = document.getElementById('sub-service-container');
            const subSelect = document.getElementById('sub-service-select');
            const finalValueInput = document.getElementById('final-service-value');

            const subServicesData = {
                'cleaning': [
                    { value: 'cleaning', label: 'All Cleaning Services' },
                    { value: 'home cleaning', label: 'Home Cleaning' },
                    { value: 'furniture & carpet cleaning', label: 'Furniture & Carpet Cleaning' },
                    { value: 'kitchen cleaning', label: 'Kitchen Cleaning' },
                    { value: 'washroom cleaning', label: 'Washroom Cleaning' }
                ],
                'repair': [
                    { value: 'repair', label: 'All Appliance Repair' },
                    { value: 'ac repair', label: 'AC Repair' },
                    { value: 'tv repair', label: 'TV Repair' },
                    { value: 'washing machine repair', label: 'Washing Machine Repair' },
                    { value: 'oven repair', label: 'Oven Repair' }
                ],
                'maintenance': [
                    { value: 'maintenance', label: 'All Maintenance' },
                    { value: 'plumbing', label: 'Plumbing' },
                    { value: 'electrical repair', label: 'Electrical Repair' },
                    { value: 'carpentry', label: 'Carpentry' }
                ],
                'beauty': [
                    { value: 'beauty', label: 'All Beauty & Makeover' },
                    { value: 'nail extension', label: 'Nail Extension' },
                    { value: 'hair care', label: 'Hair Care' },
                    { value: 'home makeover', label: 'Home Makeover Service' },
                    { value: 'spa', label: 'Spa Service' }
                ],
                'pest': [
                    { value: 'pest', label: 'All Pest Control' },
                    { value: 'premium pest control', label: 'Premium Pest Control' },
                    { value: 'regular pest control', label: 'Regular Pest Control' }
                ],
                'painting': [
                    { value: 'painting', label: 'All Painting' },
                    { value: 'renovation', label: 'Renovation' },
                    { value: 'renovation consultancy', label: 'Renovation Consultancy' },
                    { value: 'building painting', label: 'Building Painting' },
                    { value: 'room painting', label: 'Room Painting' }
                ],
                'car': [
                    { value: 'car', label: 'All Car Care' },
                    { value: 'car polishing & detailing', label: 'Car Polishing & Detailing' },
                    { value: 'regular car wash', label: 'Regular Car Wash' },
                    { value: 'diagnosis & repair', label: 'Diagnosis & Repair' }
                ],
                'travel': [
                    { value: 'travel', label: 'All Trip & Travels' },
                    { value: 'tourist bus rental', label: 'Tourist Bus Rental' },
                    { value: 'tourist guide booking', label: 'Tourist Guide Booking' }
                ],
                'health': [
                    { value: 'health', label: 'All Health & Care' },
                    { value: 'nursing service', label: 'Nursing Service' },
                    { value: 'caregiving', label: 'Caregiving' },
                    { value: 'doctor consultance', label: 'Doctor Consultance' }
                ],
                'shifting': [
                    { value: 'shifting', label: 'All House Shifting' },
                    { value: 'house shifting service', label: 'House Shifting Service' },
                    { value: 'commercial shifting service', label: 'Commercial Shifting Service' },
                    { value: 'pickup & truck rental', label: 'Pickup & Truck Rental' }
                ]
            };

            const regionData = {
                'Dhaka': ['Mirpur', 'Dhanmondi', 'Uttara', 'Gulshan', 'Banani', 'Mohammadpur', 'Tejgaon', 'Motijheel', 'Paltan', 'Savar', 'Keraniganj', 'Dohar'],
                'Chittagong': ["Cox's Bazar", 'Panchlaish', 'Halishahar', 'Pahartali', 'Chandgaon', 'Sitakunda', 'Rangunia', 'Sandwip', 'Mirsharai', 'Boalkhali'],
                'Sylhet': ['Zindabazar', 'Amberkhana', 'Tilagor', 'Noyashahar', 'Kumarpara', 'Moglabazar', 'Gowainghat', 'Beanibazar', 'Balaganj', 'Fenchuganj'],
                'Barisal': ['Sadatpur', 'Amtali', 'Agailjhara', 'Babuganj', 'Bakerganj', 'Banaripara', 'Gournadi', 'Hizla', 'Mehendiganj', 'Muladi', 'Wazirpur'],
                'Rangpur': ['Modern More', 'Kaunia', 'Gangachara', 'Pirgachha', 'Badarganj', 'Mithapukur', 'Pirganj', 'Rangpur Sadar', 'Taraganj', 'Pirgachha'],
                'Rajshahi': ['Motihar', 'Boalia', 'Paba', 'Durgapur', 'Bagha', 'Bagmara', 'Charghat', 'Godagari', 'Tanore', 'Puthia', 'Mohonpur'],
                'Khulna': ['Boyra', 'Khalishpur', 'Sonadanga', 'Daulatpur', 'Dumuria', 'Dighalia', 'Batiaghata', 'Phultala', 'Rupsha', 'Terokhada', 'Paikgachha']
            };

            function setupDropdown(buttonId, menuId, labelId, inputId, optionClass, onSelect) {
                const button = document.getElementById(buttonId);
                const menu = document.getElementById(menuId);
                const label = document.getElementById(labelId);
                const input = document.getElementById(inputId);

                if (!button || !menu) return;

                button.addEventListener('click', (e) => {
                    e.stopPropagation();
                    document.querySelectorAll('[id$="Menu"]').forEach(m => {
                        if (m.id !== menuId) m.classList.add('hidden');
                    });
                    menu.classList.toggle('hidden');
                });

                menu.addEventListener('click', (e) => {
                    const option = e.target.closest('.' + optionClass);
                    if (option) {
                        const value = option.getAttribute('data-value');
                        label.textContent = value;
                        input.value = value;
                        menu.classList.add('hidden');
                        if (onSelect) onSelect(value);
                    }
                });
            }

            document.addEventListener('click', () => {
                document.querySelectorAll('[id$="Menu"]').forEach(m => m.classList.add('hidden'));
            });

            const divisionSelect = document.getElementById('divisionSelect');
            if (divisionSelect) {
                divisionSelect.addEventListener('change', function () {
                    const division = this.value;
                    const regionOptionsList = document.getElementById('regionOptionsList');
                    const regions = regionData[division] || [];

                    document.getElementById('regionLabel').textContent = 'Select Region';
                    document.getElementById('regionInput').value = '';

                    if (regions.length > 0) {
                        regionOptionsList.innerHTML = regions.map(region => `
                            <div class="region-option px-4 py-2 hover:bg-green-50 rounded-lg cursor-pointer transition text-gray-700" data-value="${region}">
                                ${region}
                            </div>
                        `).join('');
                    } else {
                        regionOptionsList.innerHTML =
                            '<div class="px-4 py-2 text-gray-400 text-sm">No regions available</div>';
                    }
                });
            }

            setupDropdown('regionButton', 'regionMenu', 'regionLabel', 'regionInput', 'region-option');

            function updateSubServices(category, preselectedValue = null) {
                const subs = subServicesData[category];
                if (subs) {
                    subSelect.innerHTML = subs.map(s => 
                        `<option value="${s.value}" ${preselectedValue === s.value ? 'selected' : ''}>${s.label}</option>`
                    ).join('');
                    subContainer.classList.remove('hidden');
                    finalValueInput.value = subSelect.value;
                } else {
                    subContainer.classList.add('hidden');
                    finalValueInput.value = category;
                }
            }

            mainSelect.addEventListener('change', function() {
                updateSubServices(this.value);
            });

            subSelect.addEventListener('change', function() {
                finalValueInput.value = this.value;
            });

            // Initial check from URL
            const urlParams = new URLSearchParams(window.location.search);
            let serviceParam = urlParams.get('service');
            
            if (serviceParam) {
                serviceParam = serviceParam.toLowerCase();
                // Check if it's a sub-service
                let parentCategory = null;
                for (const cat in subServicesData) {
                    if (subServicesData[cat].some(s => s.value === serviceParam)) {
                        parentCategory = cat;
                        break;
                    }
                }

                if (parentCategory) {
                    mainSelect.value = parentCategory;
                    updateSubServices(parentCategory, serviceParam);
                    finalValueInput.value = serviceParam;
                } else {
                    mainSelect.value = serviceParam;
                    updateSubServices(serviceParam);
                }
            }

            const bookingForm = document.getElementById('bookingForm');
            const confirmationModal = document.getElementById('confirmationModal');
            const closeModal = document.getElementById('closeModal');

            bookingForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(bookingForm);
                const data = Object.fromEntries(formData.entries());
                
                // Construct the full address from parts
                data.address = `House: ${data.house_no}, Road: ${data.road_no}, Region: ${data.region}, City: ${data.city}`;
                
                const token = localStorage.getItem("token");

                fetch('/api/book', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + token
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        confirmationModal.classList.remove('hidden');
                    } else {
                        alert('Error: ' + (result.message || 'Validation failed'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred during the booking process.');
                });
            });

            closeModal.addEventListener('click', function () {
                confirmationModal.classList.add('hidden');
                window.location.href = '/';
            });
        });
    </script>

</body>

</html>