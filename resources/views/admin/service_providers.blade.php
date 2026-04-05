<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Service Providers - Serviqo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen">

 @include('components.navbar')

    <div class="container mx-auto px-6 py-12">
        <div class="max-w-6xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Service Providers</h1>
                    <p class="text-gray-500 mt-1">Manage and monitor all registered service providers</p>
                </div>
                 <div class="flex items-center gap-4">
                    <button onclick="openAddModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl text-sm font-bold transition-all flex items-center shadow-md">
                        <i class="fas fa-plus mr-2"></i> Add Provider
                    </button>
                    <div class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">
                        Admin Portal
                    </div>
                </div>
            </div>

            <!-- Providers Table Card -->
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-8 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider">Provider Info</th>
                                <th class="px-8 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider">Contact</th>
                                <th class="px-8 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider">Location</th>
                                <th class="px-8 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider text-center">Rating</th>
                            </tr>
                        </thead>
                        <tbody id="providersList" class="divide-y divide-gray-50">
                            <!-- Skeleton Loading -->
                            <tr class="animate-pulse">
                                <td colspan="4" class="px-8 py-10 text-center text-gray-400">
                                    <i class="fas fa-spinner fa-spin mr-2"></i> Loading providers...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
             <!-- Add Provider Modal -->
    <div id="addProviderModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
            <div class="bg-gray-900 px-8 py-6 text-white flex justify-between items-center">
                <h2 class="text-xl font-bold">Add New Provider</h2>
                <button onclick="closeAddModal()" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form id="addProviderForm" class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Full Name</label>
                        <input type="text" name="full_name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Phone Number</label>
                        <input type="text" name="phone" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">NID Number</label>
                        <input type="text" name="nid" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">City / Division</label>
                        <div class="relative" id="cityContainer">
                            <button type="button" id="cityButton"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all text-gray-700 text-left flex items-center justify-between">
                                <span id="cityLabel">Select Division</span>
                                <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                            </button>
                            <div id="cityMenu"
                                class="hidden absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-xl max-h-60 overflow-y-auto">
                                <div class="p-1">
                                    <div class="city-option px-4 py-2 hover:bg-blue-50 rounded-lg cursor-pointer transition text-gray-700 text-sm" data-value="Dhaka">Dhaka</div>
                                    <div class="city-option px-4 py-2 hover:bg-blue-50 rounded-lg cursor-pointer transition text-gray-700 text-sm" data-value="Chittagong">Chittagong</div>
                                    <div class="city-option px-4 py-2 hover:bg-blue-50 rounded-lg cursor-pointer transition text-gray-700 text-sm" data-value="Sylhet">Sylhet</div>
                                    <div class="city-option px-4 py-2 hover:bg-blue-50 rounded-lg cursor-pointer transition text-gray-700 text-sm" data-value="Barisal">Barisal</div>
                                    <div class="city-option px-4 py-2 hover:bg-blue-50 rounded-lg cursor-pointer transition text-gray-700 text-sm" data-value="Rangpur">Rangpur</div>
                                    <div class="city-option px-4 py-2 hover:bg-blue-50 rounded-lg cursor-pointer transition text-gray-700 text-sm" data-value="Rajshahi">Rajshahi</div>
                                    <div class="city-option px-4 py-2 hover:bg-blue-50 rounded-lg cursor-pointer transition text-gray-700 text-sm" data-value="Khulna">Khulna</div>
                                </div>
                            </div>
                            <input type="hidden" name="city" id="cityInput" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Service Area</label>
                        <div class="relative" id="serviceAreaContainer">
                            <button type="button" id="serviceAreaButton"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all text-gray-700 text-left flex items-center justify-between">
                                <span id="serviceAreaLabel">Select Service Area</span>
                                <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                            </button>
                            <div id="serviceAreaMenu"
                                class="hidden absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-xl max-h-60 overflow-y-auto">
                                <div id="serviceAreaOptionsList" class="p-1">
                                    <div class="px-4 py-2 text-gray-400 text-sm">Loading...</div>
                                </div>
                            </div>
                            <input type="hidden" name="service_area_id" id="serviceAreaInput" required>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Full Address</label>
                        <input type="text" name="address" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
                    </div>
                    <div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Initial Rating</label>
                        <input type="number" step="0.1" min="0" max="5" name="rating" value="0.0" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
                    </div>
                </div>

                <!-- Service Offerings Section -->
                <div class="border-t border-gray-100 pt-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Service Offerings</h3>
                        <button type="button" onclick="addOfferingRow()" class="text-blue-600 hover:text-blue-700 text-sm font-bold flex items-center">
                            <i class="fas fa-plus-circle mr-1"></i> Add Service
                        </button>
                    </div>
                    <div id="offeringsContainer" class="space-y-4">
                        <!-- Dynamic Rows Will Appear Here -->
                    </div>
                </div>

                <div class="flex justify-end pt-4 gap-4">
                    <button type="button" onclick="closeAddModal()" class="px-8 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-all">Cancel</button>
                    <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">Save Provider</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const token = localStorage.getItem("token");

        if (!token) {
            window.location.href = "/login";
        }
         const regionData = {
            'Dhaka': ['Mirpur', 'Dhanmondi', 'Uttara', 'Gulshan', 'Banani', 'Mohammadpur', 'Tejgaon', 'Motijheel', 'Paltan', 'Savar', 'Keraniganj', 'Dohar'],
            'Chittagong': ["Cox's Bazar", 'Panchlaish', 'Halishahar', 'Pahartali', 'Chandgaon', 'Sitakunda', 'Rangunia', 'Sandwip', 'Mirsharai', 'Boalkhali'],
            'Sylhet': ['Zindabazar', 'Amberkhana', 'Tilagor', 'Noyashahar', 'Kumarpara', 'Moglabazar', 'Gowainghat', 'Beanibazar', 'Balaganj', 'Fenchuganj'],
            'Barisal': ['Sadatpur', 'Amtali', 'Agailjhara', 'Babuganj', 'Bakerganj', 'Banaripara', 'Gournadi', 'Hizla', 'Mehendiganj', 'Muladi', 'Wazirpur'],
            'Rangpur': ['Modern More', 'Kaunia', 'Gangachara', 'Pirgachha', 'Badarganj', 'Mithapukur', 'Pirganj', 'Rangpur Sadar', 'Taraganj', 'Pirgachha'],
            'Rajshahi': ['Motihar', 'Boalia', 'Paba', 'Durgapur', 'Bagha', 'Bagmara', 'Charghat', 'Godagari', 'Tanore', 'Puthia', 'Mohonpur'],
            'Khulna': ['Boyra', 'Khalishpur', 'Sonadanga', 'Daulatpur', 'Dumuria', 'Dighalia', 'Batiaghata', 'Phultala', 'Rupsha', 'Terokhada', 'Paikgachha']
        };

        const subServicesData = {
            'Cleaning Services': ['Home Cleaning', 'Furniture & Carpet Cleaning', 'Kitchen Cleaning', 'Washroom Cleaning'],
            'Appliance Repair': ['AC Repair', 'TV Repair', 'Washing Machine Repair', 'Oven Repair'],
            'Maintenance': ['Plumbing', 'Electrical Repair', 'Carpentry'],
            'Beauty & Makeover': ['Nail Extension', 'Hair Care', 'Home Makeover Service', 'Spa Service'],
            'Pest Control': ['Premium Pest Control', 'Regular Pest Control'],
            'Painting': ['Renovation', 'Renovation Consultancy', 'Building Painting', 'Room Painting'],
            'Car Care Services': ['Car Polishing & Detailing', 'Regular Car Wash', 'Diagnosis & Repair'],
            'Trip & Travels': ['Tourist Bus Rental', 'Tourist Guide Booking'],
            'Health & Care': ['Nursing Service', 'Caregiving', 'Doctor Consultance'],
            'House Shifting': ['House Shifting Service', 'Commercial Shifting Service', 'Pickup & Truck Rental']
        };

        function setupDropdown(buttonId, menuId, labelId, inputId, optionClass, onSelect) {
            const button = document.getElementById(buttonId);
            const menu = document.getElementById(menuId);
            const label = document.getElementById(labelId);
            const input = document.getElementById(inputId);

            if (!button || !menu) return;

            button.addEventListener('click', (e) => {
                e.stopPropagation();
                // Close other menus
                document.querySelectorAll('[id$="Menu"]').forEach(m => {
                    if (m.id !== menuId) m.classList.add('hidden');
                });
                menu.classList.toggle('hidden');
            });

            menu.addEventListener('click', (e) => {
                const option = e.target.closest('.' + optionClass);
                if (option) {
                    const value = option.getAttribute('data-value');
                    const text = option.textContent.trim();
                    label.textContent = text;
                    input.value = value;
                    menu.classList.add('hidden');
                    if (onSelect) onSelect(value);
                }
            });
        }

        document.addEventListener('click', () => {
            document.querySelectorAll('[id$="Menu"]').forEach(m => m.classList.add('hidden'));
        });

        setupDropdown('cityButton', 'cityMenu', 'cityLabel', 'cityInput', 'city-option');
        setupDropdown('serviceAreaButton', 'serviceAreaMenu', 'serviceAreaLabel', 'serviceAreaInput', 'service-area-option');

        let offeringRowCounter = 0;
        function addOfferingRow() {
            const container = document.getElementById('offeringsContainer');
            const rowId = `offering_row_${offeringRowCounter++}`;
            
            const div = document.createElement('div');
            div.id = rowId;
            div.className = "flex items-end gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100 animate-in fade-in slide-in-from-top-2 duration-300";
            
            let optionsHtml = '<option value="">Select Service</option>';
            for (const cat in subServicesData) {
                optionsHtml += `<optgroup label="${cat}">`;
                subServicesData[cat].forEach(s => {
                    optionsHtml += `<option value="${s}" data-category="${cat}">${s}</option>`;
                });
                optionsHtml += `</optgroup>`;
            }

            div.innerHTML = `
                <div class="flex-1">
                    <label class="block text-xs font-bold text-gray-500 mb-1">Sub-Service</label>
                    <select name="service_name" required class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                        ${optionsHtml}
                    </select>
                </div>
                <button type="button" onclick="document.getElementById('${rowId}').remove()" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            container.appendChild(div);
        }

        async function openAddModal() {
            document.getElementById('addProviderModal').classList.remove('hidden');
            document.getElementById('cityLabel').textContent = 'Select Division';
            document.getElementById('cityInput').value = '';
            document.getElementById('serviceAreaLabel').textContent = 'Select Service Area';
            document.getElementById('serviceAreaInput').value = '';
            document.getElementById('offeringsContainer').innerHTML = '';
            loadServiceAreas();
        }

        function closeAddModal() {
            document.getElementById('addProviderModal').classList.add('hidden');
            document.getElementById('addProviderForm').reset();
            document.getElementById('cityLabel').textContent = 'Select Division';
            document.getElementById('cityInput').value = '';
            document.getElementById('serviceAreaLabel').textContent = 'Select Service Area';
            document.getElementById('serviceAreaInput').value = '';
            document.getElementById('offeringsContainer').innerHTML = '';
        }

        async function loadServiceAreas() {
            try {
                const res = await fetch("/api/admin/service-areas", {
                    headers: {
                        Authorization: "Bearer " + token,
                        "Accept": "application/json"
                    }
                });
                const areas = await res.json();
                const list = document.getElementById('serviceAreaOptionsList');
                if (areas.length > 0) {
                    list.innerHTML = areas.map(a => `
                        <div class="service-area-option px-4 py-2 hover:bg-blue-50 rounded-lg cursor-pointer transition text-gray-700 text-sm" data-value="${a.id}">
                            ${a.city_name} - ${a.area_name}
                        </div>
                    `).join('');
                } else {
                    list.innerHTML = '<div class="px-4 py-2 text-gray-400 text-sm">No service areas found</div>';
                }
            } catch (err) {
                console.error("Error loading areas:", err);
            }
        }

        document.getElementById('addProviderForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData.entries());

            // Collect Offerings
            const offerings = [];
            const container = document.getElementById('offeringsContainer');
            const rows = container.querySelectorAll(':scope > div');
            rows.forEach(row => {
                const select = row.querySelector('[name="service_name"]');
                const serviceName = select.value;
                const categoryName = select.options[select.selectedIndex].getAttribute('data-category');
                if (serviceName) {
                    offerings.push({
                        service_name: serviceName,
                        category_name: categoryName
                    });
                }
            });
            data.offerings = offerings;

            try {
                const res = await fetch("/api/admin/providers", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await res.json();

                if (res.ok) {
                    alert('Provider and offerings added successfully!');
                    closeAddModal();
                    loadProviders();
                } else {
                    let errorMessage = result.message || 'Something went wrong';
                    if (result.errors) {
                        errorMessage += '\n' + Object.values(result.errors).flat().join('\n');
                    } else if (result.error) {
                        errorMessage += '\n' + result.error;
                    }
                    alert('Error: ' + errorMessage);
                }
            } catch (err) {
                console.error('Error adding provider:', err);
                alert('An error occurred. Please try again.');
            }
        });

        async function loadProviders() {
            try {
                const res = await fetch("/api/admin/providers", {
                    headers: {
                        Authorization: "Bearer " + token,
                        "Accept": "application/json"
                    }
                });
             if (res.status === 401) {
                    localStorage.removeItem("token");
                    window.location.href = "/login";
                    return;
                }

             const providers = await res.json();
            const list = document.getElementById("providersList");

           if (!providers || providers.length === 0) {
                    list.innerHTML = `
                        <tr>
                            <td colspan="4" class="px-8 py-12 text-center text-gray-500 italic">
                                No service providers found.
                            </td>
                        </tr>
                    `;
                    return;
                }

           let html = "";
                providers.forEach(p => {
                    html += `
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center font-bold mr-4">
                                        ${p.full_name ? p.full_name.charAt(0) : '?'}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">${p.full_name || 'Unnamed'}</div>
                                        <div class="text-xs text-gray-400">NID: ${p.nid || 'N/A'}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-sm text-gray-700 font-medium">${p.email}</div>
                                <div class="text-xs text-gray-400">${p.phone}</div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-sm text-gray-700 font-medium">${p.city}</div>
                                <div class="text-xs text-gray-400">${p.service_area ? p.service_area.area_name : 'Unknown Area'}</div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <div class="inline-flex items-center px-3 py-1 bg-yellow-50 text-yellow-700 rounded-full text-xs font-bold">
                                    <i class="fas fa-star mr-1"></i> ${p.rating || '0.0'}
                                </div>
                            </td>
                        </tr>
                    `;
                });

    
           list.innerHTML = html;

           } catch (err) {
                console.error("Error:", err);
                document.getElementById("providersList").innerHTML = `
                    <tr>
                        <td colspan="4" class="px-8 py-12 text-center text-red-500">
                            <i class="fas fa-exclamation-triangle mr-2"></i> Failed to load providers. Please try again.
                        </td>
                    </tr>
                `;
            }
        }

 loadProviders();
    </script>
</body>

</html>