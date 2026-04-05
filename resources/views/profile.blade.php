<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviqo - My Profile</title>
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
    <script>
        async function loadProfile() {

            const token = localStorage.getItem("token");

            if (!token) {
                window.location.href = "/login";
                return;
            }

            const response = await fetch("/api/me", {
                headers: {
                    "Authorization": "Bearer " + token,
                    "Accept": "application/json"
                }
            });

            if (!response.ok) {
                localStorage.removeItem("token");
                window.location.href = "/login";
                return;
            }

            const user = await response.json();

            document.getElementById("profileName").textContent =
                user.fname + " " + user.lname;
            document.getElementById("profileLocation").innerHTML =
                `<i class="fas fa-map-marker-alt mr-2"></i> ${user.city}, ${user.region}`;

            document.getElementById("profileEmail").textContent = user.email;

            document.getElementById("profilePhone").textContent =
                user.phone ?? "Not provided";

            // Update stats
            document.getElementById("bookingsCount").textContent = user.service_orders ? user.service_orders.length : 0;
               document.getElementById("reviewsCount").textContent = user.reviews ? user.reviews.length : 0;
            // Store user data globally
            window.currentUserData = user;

            // Initial Render
            window.activityLimit = 5;
            renderActivities();
        }

        function renderActivities() {
            const user = window.currentUserData;
            const activityContainer = document.getElementById("recent-activity-container");
            const viewAllBtn = document.getElementById('viewAllBtn');

            if (!activityContainer || !user || !user.service_orders) return;

            if (user.service_orders.length === 0) {
                  activityContainer.innerHTML = '<p class="text-gray-500 text-sm">You haven\'t placed any orders yet.</p>';
                if (viewAllBtn) viewAllBtn.classList.add('hidden');
            } else {
                activityContainer.innerHTML = '';
                
                const uiNames = {
                    'cleaning': 'Cleaning Services',
                    'repair': 'Appliance Repair',
                    'maintenance': 'Maintenance',
                    'beauty': 'Beauty & Makeover',
                    'pest': 'Pest Control',
                    'painting': 'Painting',
                    'car': 'Car Care Services',
                    'travel': 'Trip & Travels',
                    'health': 'Health & Care',
                    'shifting': 'House Shifting'
                };

                let ordersToRender = window.activityLimit ? user.service_orders.slice(0, window.activityLimit) : user.service_orders;

                ordersToRender.forEach((order, index) => {
                    let serviceName = "General Service";
                    if (order.items && order.items.length > 0 && order.items[0].offering && order.items[0].offering.sub_service) {
                        serviceName = order.items[0].offering.sub_service.service_name;
                    }
                    
                    let displayServiceName = uiNames[serviceName.toLowerCase()] || serviceName;

                    let statusColor = order.status === 'completed' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600';
                    let icon = order.status === 'completed' ? 'fa-check-circle' : 'fa-clock';
                    let dateObj = new Date(order.scheduled_datetime);
                    let dateText = isNaN(dateObj) ? order.scheduled_datetime : dateObj.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit'});

                    activityContainer.innerHTML += `
                        <div onclick="openBookingDetailsModal(${index})" class="flex items-start space-x-4 pb-6 border-b border-gray-50 cursor-pointer hover:bg-gray-50 p-3 rounded-xl transition group">
                            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center shrink-0">
                                <i class="fas ${icon}"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-bold text-gray-900 capitalize group-hover:text-green-600 transition">${displayServiceName}</h4>
                                    <span class="text-xs font-bold px-2 py-1 ${statusColor} rounded-lg capitalize">${order.status}</span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Scheduled for ${dateText} • Total: $${order.total_amount}</p>
                            </div>
                            <div class="self-center opacity-0 group-hover:opacity-100 transition">
                                <i class="fas fa-chevron-right text-gray-300"></i>
                            </div>
                        </div>
                    `;
                });

                if (viewAllBtn) {
                    if (user.service_orders.length <= 5) {
                        viewAllBtn.classList.add('hidden');
                    } else {
                        viewAllBtn.classList.remove('hidden');
                         viewAllBtn.textContent = window.activityLimit === null ? 'Show Less History' : 'View Full Order History';
                    }
                }
            }
        }

        function toggleActivities() {
            window.activityLimit = window.activityLimit === 5 ? null : 5;
            renderActivities();
        }

        function openBookingDetailsModal(index) {
            const user = window.currentUserData;
            const order = user.service_orders[index];
            if (!order) return;

            const uiNames = {
                'cleaning': 'Cleaning Services',
                'repair': 'Appliance Repair',
                'maintenance': 'Maintenance',
                'beauty': 'Beauty & Makeover',
                'pest': 'Pest Control',
                'painting': 'Painting',
                'car': 'Car Care Services',
                'travel': 'Trip & Travels',
                'health': 'Health & Care',
                'shifting': 'House Shifting'
            };

            let serviceName = "General Service";
            if (order.items && order.items.length > 0 && order.items[0].offering && order.items[0].offering.sub_service) {
                serviceName = order.items[0].offering.sub_service.service_name;
            }
            let displayServiceName = uiNames[serviceName.toLowerCase()] || serviceName;

            let icon = order.status === 'completed' ? 'fa-check-circle' : 'fa-tools';
            let statusColor = order.status === 'completed' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600';
            
            let dateObj = new Date(order.scheduled_datetime);
            let dateText = isNaN(dateObj) ? order.scheduled_datetime : dateObj.toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit'});

            document.getElementById('detailsTitle').textContent = displayServiceName;
            document.getElementById('detailsIcon').className = `fas ${icon} text-2xl`;
            document.getElementById('detailsStatus').textContent = order.status;
            document.getElementById('detailsStatus').className = `inline-block mt-2 px-3 py-1 text-sm font-bold rounded-lg capitalize ${statusColor}`;
            document.getElementById('detailsDate').textContent = dateText;
            document.getElementById('detailsOrderId').textContent = "#" + String(order.id).padStart(5, '0');
            document.getElementById('detailsPayment').textContent = order.payment_status;
            document.getElementById('detailsTotal').textContent = "$" + order.total_amount;

            document.getElementById('bookingDetailsModal').classList.remove('hidden');
        }

        function closeBookingDetailsModal() {
            document.getElementById('bookingDetailsModal').classList.add('hidden');

        }

        async function submitEditProfile(event) {
            event.preventDefault();
            
            const form = event.target;
            const submitBtn = document.getElementById('saveProfileBtn');
            const originalBtnText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';
            submitBtn.disabled = true;
            
            document.getElementById('editProfileError').classList.add('hidden');
            document.getElementById('editProfileSuccess').classList.add('hidden');

            const formData = {
                fname: form.fname.value,
                lname: form.lname.value,
                email: form.email.value,
                phone: form.phone.value,
                address: form.address.value,
                city: form.city.value,
                region: form.region.value,
                dob: form.dob.value
            };

            const token = localStorage.getItem("token");

            try {
                const response = await fetch("/api/profile", {
                    method: 'PUT',
                    headers: {
                        "Authorization": "Bearer " + token,
                        "Accept": "application/json",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(formData)
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || 'Failed to update profile. Please check your inputs.');
                }

                // Show success message
                document.getElementById('editProfileSuccess').classList.remove('hidden');
                
                // Reload profile data on page
                loadProfile();
                
                // Close modal after delay
                setTimeout(() => {
                    toggleEditModal('close');
                }, 1500);
                
            } catch (error) {
                const errorDiv = document.getElementById('editProfileError');
                errorDiv.textContent = error.message;
                errorDiv.classList.remove('hidden');
            } finally {
                // Restore button state
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
            }
        }

        function toggleEditModal(action) {
            const modal = document.getElementById('editProfileModal');
            
            if (action === 'open') {
                // Populate form with current user data
                const user = window.currentUserData;
                if (user) {
                    document.getElementById('edit_fname').value = user.fname || '';
                    document.getElementById('edit_lname').value = user.lname || '';
                    document.getElementById('edit_email').value = user.email || '';
                    document.getElementById('edit_phone').value = user.phone || '';
                    document.getElementById('edit_address').value = user.address || '';
                    document.getElementById('edit_city').value = user.city || '';
                    document.getElementById('edit_region').value = user.region || '';
                    document.getElementById('edit_dob').value = user.dob || '';
                }
                
                // Hide messages
                document.getElementById('editProfileError').classList.add('hidden');
                document.getElementById('editProfileSuccess').classList.add('hidden');
                
                modal.classList.remove('hidden');
            } else {
                modal.classList.add('hidden');
            }
        }

        loadProfile();
    </script>

    <main class="container mx-auto px-6 py-12">
        <div class="max-w-4xl mx-auto">
            <!-- Profile Header -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                <div class="h-32 bg-gradient-to-r from-green-400 to-green-600"></div>
                <div class="px-8 pb-8">
                    <div class="relative flex justify-between items-end -mt-12 mb-6">
                        <div class="p-1 bg-white rounded-full">
                            <div
                                class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center border-4 border-white text-green-500">
                                <i class="fas fa-user text-4xl"></i>
                            </div>
                        </div>
                        <button
                            onclick="toggleEditModal('open')"
                            class="px-6 py-2 bg-white border border-gray-200 rounded-xl font-semibold hover:bg-gray-50 transition shadow-sm">
                            Edit Profile
                        </button>
                    </div>
                    <div>
                        <h1 id="profileName" class="text-3xl font-bold text-gray-900"></h1>
                        <p id="profileLocation" class="text-gray-500 flex items-center mt-1"></p>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-4">Contact Info</h3>
                        <div class="space-y-4">
                            <div class="flex items-center text-sm">
                                <i class="fas fa-envelope w-8 text-green-500 text-lg"></i>
                                <div>
                                    <p class="text-gray-400 text-xs uppercase font-bold tracking-wider">Email</p>
                                    <p id="profileEmail" class="font-medium">/p>
                                </div>
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-phone w-8 text-green-500 text-lg"></i>
                                <div>
                                    <p class="text-gray-400 text-xs uppercase font-bold tracking-wider">Phone</p>
                                    <p id="profilePhone" class="font-medium"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-4">Account Stats</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center p-3 bg-green-50 rounded-2xl">
                                <p id="bookingsCount" class="text-2xl font-bold text-green-600">0</p>
                                <p class="text-xs text-gray-500 font-medium">Orders Confirmed</p>
                            </div>
                            <div class="text-center p-3 bg-green-50 rounded-2xl">
                                <p id="reviewsCount" class="text-2xl font-bold text-green-600">0</p>
                                <p class="text-xs text-gray-500 font-medium">Reviews</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-900 text-xl mb-6">Order History</h3>

                        <div id="recent-activity-container" class="space-y-6">
                            <div class="flex justify-center p-4">
                                <i class="fas fa-spinner fa-spin text-green-500 text-2xl"></i>
                            </div>
                        </div>

                        <button id="viewAllBtn" onclick="toggleActivities()"
                            class="w-full mt-6 py-3 text-green-600 font-bold hover:bg-green-50 rounded-xl transition hidden">
                            View Full Order History
                        </button>
                    </div>

                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-900 text-xl mb-6">Settings</h3>
                        <div class="space-y-3">
                            <button
                                class="w-full flex items-center justify-between p-4 hover:bg-gray-50 rounded-2xl transition group">
                                <div class="flex items-center">
                                    <i class="fas fa-shield-alt w-8 text-green-500"></i>
                                    <span class="font-medium">Password & Security</span>
                                </div>
                                <i class="fas fa-chevron-right text-xs text-gray-300"></i>
                            </button>
                            <button
                                class="w-full flex items-center justify-between p-4 hover:bg-gray-50 rounded-2xl transition group">
                                <div class="flex items-center">
                                    <i class="fas fa-bell w-8 text-green-500"></i>
                                    <span class="font-medium">Notifications</span>
                                </div>
                                <i class="fas fa-chevron-right text-xs text-gray-300"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Edit Profile Modal -->
        <div id="editProfileModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white rounded-3xl w-full max-w-2xl shadow-xl my-8">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center sticky top-0 bg-white rounded-t-3xl z-10">
                    <h2 class="text-2xl font-bold text-gray-900">Edit Profile</h2>
                    <button onclick="toggleEditModal('close')" class="text-gray-400 hover:text-gray-600 transition">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div class="p-8 max-h-[70vh] overflow-y-auto">
                    <!-- Alerts -->
                    <div id="editProfileError" class="hidden mb-6 p-4 bg-red-50 text-red-600 rounded-xl text-sm font-medium border border-red-100"></div>
                    <div id="editProfileSuccess" class="hidden mb-6 p-4 bg-green-50 text-green-600 rounded-xl text-sm font-medium border border-green-100">
                        Profile updated successfully!
                    </div>

                    <form id="editProfileForm" onsubmit="submitEditProfile(event)" class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Name fields -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">First Name</label>
                                <input type="text" id="edit_fname" name="fname" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm bg-gray-50 focus:bg-white">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Last Name</label>
                                <input type="text" id="edit_lname" name="lname" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm bg-gray-50 focus:bg-white">
                            </div>

                            <!-- Contact fields -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                                <input type="email" id="edit_email" name="email" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm bg-gray-50 focus:bg-white">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                                <input type="text" id="edit_phone" name="phone" required placeholder="01XXXXXXXXX"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm bg-gray-50 focus:bg-white">
                            </div>

                            <!-- Personal fields -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Date of Birth</label>
                                <input type="date" id="edit_dob" name="dob" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm bg-gray-50 focus:bg-white">
                            </div>
                            
                            <!-- Location fields -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Detailed Address</label>
                                <textarea id="edit_address" name="address" rows="2"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm bg-gray-50 focus:bg-white"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">City</label>
                                <select id="edit_city" name="city" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm bg-gray-50 focus:bg-white appearance-none">
                                    <option value="">Select City</option>
                                    <option value="Dhaka">Dhaka</option>
                                    <option value="Chittagong">Chittagong</option>
                                    <option value="Sylhet">Sylhet</option>
                                    <option value="Barisal">Barisal</option>
                                    <option value="Rangpur">Rangpur</option>
                                    <option value="Rajshahi">Rajshahi</option>
                                    <option value="Khulna">Khulna</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Region/Area</label>
                                <input type="text" id="edit_region" name="region" required placeholder="e.g., Gulshan, Dhanmondi"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm bg-gray-50 focus:bg-white">
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-100 flex justify-end space-x-4 sticky bottom-0 bg-white z-10">
                            <button type="button" onclick="toggleEditModal('close')"
                                class="px-6 py-3 border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">
                                Cancel
                            </button>
                            <button type="submit" id="saveProfileBtn"
                                class="px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-xl shadow-sm hover:shadow transition flex items-center">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Booking Details Modal -->
        <div id="bookingDetailsModal" class="fixed inset-0 bg-black/50 z-[60] hidden flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl w-full max-w-md shadow-xl overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h2 class="text-xl font-bold text-gray-900">Order Details</h2>
                    <button onclick="closeBookingDetailsModal()" class="text-gray-400 hover:text-gray-600 transition">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="p-8 space-y-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-50 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i id="detailsIcon" class="fas fa-tools text-2xl"></i>
                        </div>
                        <h3 id="detailsTitle" class="text-2xl font-bold text-gray-900 capitalize"></h3>
                        <p id="detailsStatus" class="inline-block mt-2 px-3 py-1 text-sm font-bold rounded-lg"></p>
                    </div>
                    
                    <div class="space-y-4 pt-4 border-t border-gray-100">
                        <div class="flex justify-between items-start">
                            <span class="text-gray-500 font-medium">Scheduled For</span>
                            <span id="detailsDate" class="text-gray-900 font-semibold text-right max-w-[60%]"></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 font-medium">Order ID</span>
                            <span id="detailsOrderId" class="text-gray-900 font-semibold"></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 font-medium">Payment Status</span>
                            <span id="detailsPayment" class="text-gray-900 font-semibold capitalize"></span>
                        </div>
                        <div class="pt-4 border-t border-gray-100 flex justify-between items-center mt-2">
                            <span class="text-gray-900 font-bold">Total Amount</span>
                            <span id="detailsTotal" class="text-xl font-bold text-green-600"></span>
                        </div>
                    </div>
                </div>
                <div class="p-6 border-t border-gray-100 bg-gray-50 flex justify-end">
                    <button onclick="closeBookingDetailsModal()" class="w-full py-3 bg-gray-200 text-gray-800 font-bold rounded-xl hover:bg-gray-300 transition">Close Window</button>
                </div>
            </div>
        </div>

    </main>

    <footer class="bg-white border-t border-gray-100 py-12">
        <div class="container mx-auto px-6 text-center text-gray-500 text-sm">
            <p>&copy; 2026 Serviqo. All rights reserved.</p>
        </div>
    </footer>
    <script>
        window.addEventListener("pageshow", function () {
            const token = localStorage.getItem("token");

            if (!token) {
                window.location.replace("/login");
            }
        });
    </script>
</body>

</html>