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

            try {
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
            } catch (error) {
                console.error('Error loading profile:', error);
                alert('Failed to load profile. Please refresh the page.');
            }
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

                    let statusColor = 'bg-yellow-100 text-yellow-600';
                    let icon = 'fa-clock';
                    
                    if (order.status === 'completed' || order.status === 'Order Confirmed') {
                        statusColor = 'bg-green-100 text-green-600';
                        icon = 'fa-check-circle';
                    } else if (order.status === 'cancelled') {
                        statusColor = 'bg-red-100 text-red-600';
                        icon = 'fa-times-circle';
                    }
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
                                <p class="text-sm text-gray-500 mt-1">Scheduled for ${dateText} • Total: ৳${order.total_amount}</p>
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

           let icon = 'fa-tools';
            let statusColor = 'bg-yellow-100 text-yellow-600';

            if (order.status === 'completed' || order.status === 'Order Confirmed') {
                icon = 'fa-check-circle';
                statusColor = 'bg-green-100 text-green-600';
            } else if (order.status === 'cancelled') {
                icon = 'fa-times-circle';
                statusColor = 'bg-red-100 text-red-600';
            }
            
            let dateObj = new Date(order.scheduled_datetime);
            let dateText = isNaN(dateObj) ? order.scheduled_datetime : dateObj.toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit'});

            document.getElementById('detailsTitle').textContent = displayServiceName;
            document.getElementById('detailsIcon').className = `fas ${icon} text-2xl`;
            document.getElementById('detailsStatus').textContent = order.status;
            document.getElementById('detailsStatus').className = `inline-block mt-2 px-3 py-1 text-sm font-bold rounded-lg capitalize ${statusColor}`;
            document.getElementById('detailsDate').textContent = dateText;
            document.getElementById('detailsOrderId').textContent = "#" + String(order.id).padStart(5, '0');
            document.getElementById('detailsPayment').textContent = order.payment_status;
            document.getElementById('detailsTotal').textContent = "৳" + order.total_amount;

            // Store current order for rating
            window.currentOrderForRating = order;

            // Show/hide rating button based on status
            const ratingBtn = document.getElementById('openRatingModalBtn');
            if (order.status === 'Order Confirmed' || order.status === 'completed') {
                ratingBtn.classList.remove('hidden');
            } else {
                ratingBtn.classList.add('hidden');
            }


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
        // Rating and Review Functions
        function openRatingModal() {
            const order = window.currentOrderForRating;
            if (!order) return;

            // Store the current order for rating
            window.ratingOrderId = order.id;
            window.ratingOrderData = order;
            window.currentRating = 0;

            console.log('Opening rating modal with order:', {
                id: order.id,
                customer_id: order.customer_id,
                status: order.status,
                payment_status: order.payment_status
            });

            // Update modal with order information
            const modal = document.getElementById('ratingModal');
            if (!modal) return;

            // Populate order details from the rating modal (simpler version)
            const serviceName = order.items && order.items.length > 0 && order.items[0].offering && order.items[0].offering.sub_service 
                ? order.items[0].offering.sub_service.service_name 
                : 'General Service';
            
            document.getElementById('ratingOrderTitle').textContent = serviceName;
            document.getElementById('ratingOrderId').textContent = "#" + String(order.id).padStart(5, '0');
            
            // Reset stars
            document.getElementById('ratingStarContainer').innerHTML = '';
            document.getElementById('ratingInput').value = 0;
            document.getElementById('reviewNotesInput').value = '';
            
            for (let i = 1; i <= 5; i++) {
                const star = document.createElement('button');
                star.type = 'button';
                star.className = 'text-3xl transition hover:scale-110';
                star.innerHTML = '<i class="fas fa-star" style="color: #d1d5db;"></i>';
                star.onclick = () => setRating(i);
                document.getElementById('ratingStarContainer').appendChild(star);
            }

            // Show modal
            modal.classList.remove('hidden');
        }

        function closeRatingModal() {
            const modal = document.getElementById('ratingModal');
            if (modal) {
                modal.classList.add('hidden');
            }
            window.ratingOrderId = null;
            window.ratingOrderData = null;
            window.currentRating = 0;
        }

        function setRating(rating) {
            document.getElementById('ratingInput').value = rating;
            const stars = document.getElementById('ratingStarContainer').querySelectorAll('button');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.innerHTML = '<i class="fas fa-star" style="color: #22c55e;"></i>';
                } else {
                    star.innerHTML = '<i class="fas fa-star" style="color: #d1d5db;"></i>';
                }
            });
        }

        async function submitRating() {
            const rating = parseInt(document.getElementById('ratingInput').value);
            const reviewText = document.getElementById('reviewNotesInput').value.trim();
            const orderId = window.ratingOrderId;
            const token = localStorage.getItem('token');

            // Validation
            if (!rating || rating === 0) {
                showPopupMessage('Rating Required', 'Please select a rating before submitting.', 'info');
                return;
            }

            console.log('Attempting to submit rating for order:', window.currentOrderForRating);

            // Extract provider ID from order
            let providerId = null;
            if (window.currentOrderForRating) {
                console.log('Order items:', window.currentOrderForRating.items);
                
                if (window.currentOrderForRating.items && window.currentOrderForRating.items.length > 0) {
                    const item = window.currentOrderForRating.items[0];
                    console.log('First item:', item);
                    console.log('Item offering:', item.offering);
                    
                    if (item.offering) {
                        console.log('Offering properties:', Object.keys(item.offering));
                        if (item.offering.service_provider_id) {
                            providerId = item.offering.service_provider_id;
                            console.log('Found provider ID in offering:', providerId);
                        }
                    }
                }
                // Fallback: check if order has service_provider_id directly
                if (!providerId && window.currentOrderForRating.service_provider_id) {
                    providerId = window.currentOrderForRating.service_provider_id;
                    console.log('Found provider ID in order:', providerId);
                }
            }

            console.log('Final provider ID:', providerId);
            console.log('Order ID being sent:', orderId);
            console.log('Current user should own this order');

            if (!providerId) {
                showPopupMessage('Error', 'Could not find service provider information. Please try again.', 'error');
                console.error('Order data:', window.currentOrderForRating);
                return;
            }

            const submitBtn = event.target;
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Submitting...';
            submitBtn.disabled = true;

            const requestBody = {
                service_provider_id: providerId,
                service_order_id: orderId,
                rating: rating,
                review_notes: reviewText
            };

            console.log('Request body being sent:', requestBody);

            try {
                const response = await fetch('/api/ratings', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(requestBody)
                });

                const result = await response.json();

                if (!response.ok) {
                    console.error('Rating API error:', result);
                    const debugMsg = result.debug_info ? '\n\nDebug: ' + result.debug_info : '';
                    throw new Error(result.message + debugMsg);
                }

                // Show success message in pop-up
                showPopupMessage('Thank You!', 'Your review has been submitted successfully.', 'success');

                // Close modals and refresh profile after 2 seconds
                setTimeout(() => {
                    closePopupMessage();
                    closeRatingModal();
                    closeBookingDetailsModal();
                    loadProfile();
                }, 2000);

            } catch (error) {
                showPopupMessage('Error', error.message, 'error');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }

        // Pop-up Message Functions
        function showPopupMessage(title, message, type = 'success') {
            const popupModal = document.getElementById('popupMessageModal');
            const popupTitle = document.getElementById('popupTitle');
            const popupMessage = document.getElementById('popupMessage');
            const popupIcon = document.getElementById('popupIcon');
            
            // Set icon and colors based on type
            let iconClass = 'fa-check-circle';
            let iconColor = 'text-green-600';
            let bgColor = 'bg-green-50';
            
            if (type === 'error') {
                iconClass = 'fa-exclamation-circle';
                iconColor = 'text-red-600';
                bgColor = 'bg-red-50';
            } else if (type === 'info') {
                iconClass = 'fa-info-circle';
                iconColor = 'text-blue-600';
                bgColor = 'bg-blue-50';
            }
            
            popupIcon.className = `fas ${iconClass} text-4xl ${iconColor}`;
            popupTitle.textContent = title;
            popupMessage.textContent = message;
            
            const bgDiv = popupModal.querySelector('.w-16.h-16');
            bgDiv.className = `w-16 h-16 ${bgColor} ${iconColor} rounded-full flex items-center justify-center mx-auto`;
            
            popupModal.classList.remove('hidden');
        }

        function closePopupMessage() {
            const popupModal = document.getElementById('popupMessageModal');
            if (popupModal) {
                popupModal.classList.add('hidden');
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
                                <p class="text-xs text-gray-500 font-medium">Orders</p>
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
        <!-- Pop-up Message Modal -->
        <div id="popupMessageModal" class="fixed inset-0 bg-black/50 z-[80] hidden flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl w-full max-w-sm shadow-xl overflow-hidden">
                <div class="p-8 text-center space-y-4">
                    <div class="w-16 h-16 bg-green-50 text-green-600 rounded-full flex items-center justify-center mx-auto">
                        <i id="popupIcon" class="fas fa-check-circle text-4xl"></i>
                    </div>
                    <h2 id="popupTitle" class="text-2xl font-bold text-gray-900"></h2>
                    <p id="popupMessage" class="text-gray-600"></p>
                </div>
                <div class="p-6 bg-gray-50 flex justify-center gap-3 border-t border-gray-100">
                    <button onclick="closePopupMessage()" class="py-2 px-8 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition">
                        OK
                    </button>
                </div>
            </div>
        </div>

        <!-- Rating Modal -->
        <div id="ratingModal" class="fixed inset-0 bg-black/50 z-[70] hidden flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl w-full max-w-md shadow-xl overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h2 class="text-xl font-bold text-gray-900">Rate & Review Service</h2>
                    <button onclick="closeRatingModal()" class="text-gray-400 hover:text-gray-600 transition">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="p-8 space-y-6">
                    <div class="text-center pb-4 border-b border-gray-100">
                        <p id="ratingOrderTitle" class="text-lg font-bold text-gray-900 capitalize"></p>
                        <p id="ratingOrderId" class="text-sm text-gray-500 mt-1"></p>
                    </div>
                    
                    <div class="text-center">
                        <p class="text-gray-600 font-medium mb-3">How was your experience?</p>
                        <div id="ratingStarContainer" class="flex justify-center gap-2">
                            <!-- Stars will be added by JavaScript -->
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Your Review (Optional)</label>
                        <textarea id="reviewNotesInput" placeholder="Share your feedback about the service quality, professionalism, and overall experience..." class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all resize-none h-24 text-gray-700 placeholder-gray-500"></textarea>
                    </div>

                    <input type="hidden" id="ratingInput" value="0">
                </div>
                <div class="p-6 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
                    <button onclick="closeRatingModal()" class="py-2 px-6 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition">Cancel</button>
                    <button onclick="submitRating()" class="py-2 px-6 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition flex items-center gap-2">
                        <i class="fas fa-paper-plane"></i> Submit Review
                    </button>
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
                <div class="p-6 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
                    <button id="openRatingModalBtn" onclick="openRatingModal()" class="py-3 px-6 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl transition hidden flex items-center gap-2">
                        <i class="fas fa-star"></i> Rate & Review
                    </button>
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