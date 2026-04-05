<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Serviqo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 text-gray-800 min-h-screen">

    @include('components.navbar')

    <div class="container mx-auto px-6 py-12">
        <div class="max-w-6xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
                    <p class="text-gray-500 mt-1" id="welcomeMessage">Welcome back!</p>
                </div>
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                    Admin Portal
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Quick Stats -->
                <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100 flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-4">
                        <i class="fas fa-calendar-check text-2xl"></i>
                    </div>
                    <h3 class="text-gray-500 font-medium mb-1">Total Bookings</h3>
                    <p class="text-3xl font-bold text-gray-900" id="totalBookingsCount">...</p>
                    <a href="/admin/all_bookings" class="mt-4 text-blue-600 hover:text-blue-700 text-sm font-bold">View All &rarr;</a>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100 flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mb-4">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <h3 class="text-gray-500 font-medium mb-1">Service Providers</h3>
                    <p class="text-3xl font-bold text-gray-900">...</p>
                    <a href="/admin/service_providers" class="mt-4 text-green-600 hover:text-green-700 text-sm font-bold">Manage &rarr;</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const token = localStorage.getItem("token");

        if (!token) {
            window.location.href = "/login";
        }

        async function loadDashboard() {
            try {
                const res = await fetch("/api/admin/dashboard", {
                    headers: {
                        Authorization: "Bearer " + token
                    }
                });

                if (res.status === 401) {
                    localStorage.removeItem("token");
                    window.location.replace = "/login";
                    return;
                }

                const user = await res.json();
                document.getElementById("welcomeMessage").textContent = `Welcome back, ${user.fname} ${user.lname}!`;

                const bookingsRes = await fetch("/api/admin/all_bookings", {
                    headers: { Authorization: "Bearer " + token }
                });
                const bookings = await bookingsRes.json();
                document.getElementById("totalBookingsCount").textContent = bookings.length;

            } catch (err) {
                console.error("Error loading dashboard info:", err);
            }
        }

        window.addEventListener("pageshow", function (event) {
            if (event.persisted) {
                if (!localStorage.getItem("token")) {
                    window.location.replace("/login");
                }
            }
        });

        document.addEventListener("DOMContentLoaded", () => {
            loadDashboard();
        });
    </script>
</body>

</html>