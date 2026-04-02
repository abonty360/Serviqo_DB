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

            // Store user data globally for the edit form
            window.currentUserData = user;
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
                                <p class="text-2xl font-bold text-green-600">12</p>
                                <p class="text-xs text-gray-500 font-medium">Bookings</p>
                            </div>
                            <div class="text-center p-3 bg-green-50 rounded-2xl">
                                <p class="text-2xl font-bold text-green-600">5</p>
                                <p class="text-xs text-gray-500 font-medium">Reviews</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-900 text-xl mb-6">Recent Activity</h3>

                        <div class="space-y-6">
                            <div class="flex items-start space-x-4 pb-6 border-b border-gray-50">
                                <div
                                    class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center shrink-0">
                                    <i class="fas fa-broom"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <h4 class="font-bold text-gray-900">Home Cleaning</h4>
                                        <span
                                            class="text-xs font-bold px-2 py-1 bg-green-100 text-green-600 rounded-lg">Completed</span>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">Your home cleaning service was completed on
                                        Oct 12, 2023.</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4 pb-6 border-b border-gray-50">
                                <div
                                    class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center shrink-0">
                                    <i class="fas fa-wrench"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <h4 class="font-bold text-gray-900">Plumbing Repair</h4>
                                        <span
                                            class="text-xs font-bold px-2 py-1 bg-yellow-100 text-yellow-600 rounded-lg">Pending</span>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">A professional is scheduled for tomorrow at
                                        10:00 AM.</p>
                                </div>
                            </div>
                        </div>

                        <button
                            class="w-full mt-6 py-3 text-green-600 font-bold hover:bg-green-50 rounded-xl transition">
                            View All Activities
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