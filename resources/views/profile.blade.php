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