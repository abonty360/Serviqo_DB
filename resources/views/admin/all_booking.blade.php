<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Bookings - Admin - Serviqo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 text-gray-800 min-h-screen">

  @include('components.navbar')
      <div class="container mx-auto px-6 py-12">
        <div class="max-w-6xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">All Service Bookings</h1>
                    <p class="text-gray-500 mt-1">Manage and monitor all customer service requests</p>
                </div>
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                    Admin Portal
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Booking History</h2>
                    <button onclick="loadBookings()" class="text-green-600 hover:text-green-700 font-semibold text-sm flex items-center gap-2">
                        <i class="fas fa-sync-alt"></i> Refresh List
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="pb-4 font-bold text-gray-600 text-sm">Order ID</th>
                                <th class="pb-4 font-bold text-gray-600 text-sm">Customer</th>
                                <th class="pb-4 font-bold text-gray-600 text-sm">Service</th>
                                <th class="pb-4 font-bold text-gray-600 text-sm">Date & Time</th>
                                <th class="pb-4 font-bold text-gray-600 text-sm">Total</th>
                                <th class="pb-4 font-bold text-gray-600 text-sm">Status</th>
                            </tr>
                        </thead>
                        <tbody id="bookingsTableBody">
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400">Loading bookings...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        const token = localStorage.getItem("token");

        if (!token) {
            window.location.href = "/login";
        }
            async function loadBookings() {
            const tableBody = document.getElementById("bookingsTableBody");
            
            try {
                const res = await fetch("/api/admin/all_bookings", {
                    headers: {
                        Authorization: "Bearer " + token
                    }
                });

                      if (res.status === 401) {
                    localStorage.removeItem("token");
                    window.location.href = "/login";
                    return;
                }

            const bookings = await res.json();

                 if (bookings.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="6" class="py-8 text-center text-gray-400">No bookings found.</td></tr>`;
                    return;
                }

                        tableBody.innerHTML = bookings.map(booking => {
                    const customerName = booking.customer ? `${booking.customer.fname} ${booking.customer.lname}` : 'Guest';
                    const serviceName = booking.items && booking.items[0] && booking.items[0].offering && booking.items[0].offering.sub_service 
                        ? booking.items[0].offering.sub_service.service_name 
                        : 'N/A';
                    
                    const date = new Date(booking.scheduled_datetime).toLocaleString();
                    
                    let statusClass = "bg-gray-100 text-gray-600";
                    if (booking.status === 'Order Confirmed') statusClass = "bg-green-100 text-green-600";
                    if (booking.status === 'completed') statusClass = "bg-blue-100 text-blue-600";
                    if (booking.status === 'cancelled') statusClass = "bg-red-100 text-red-600";
                 return `
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                            <td class="py-4 text-sm font-medium text-gray-900">#${booking.id}</td>
                            <td class="py-4 text-sm text-gray-600">${customerName}</td>
                            <td class="py-4 text-sm text-gray-600 capitalize">${serviceName}</td>
                            <td class="py-4 text-sm text-gray-600">${date}</td>
                            <td class="py-4 text-sm font-bold text-gray-900">$${booking.total_amount}</td>
                            <td class="py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold ${statusClass}">
                                    ${booking.status}
                                </span>
                            </td>
                        </tr>
                    `;
                }).join('');
               } catch (err) {
                tableBody.innerHTML = `<tr><td colspan="6" class="py-8 text-center text-red-400">Error loading bookings.</td></tr>`;
                console.error("Error loading bookings:", err);
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
            loadBookings();
        });
    </script>
</body>

</html>