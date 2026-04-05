<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Bookings - Admin - Serviqo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #10b981;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 min-h-screen">

  @include('components.navbar')
      <div class="container mx-auto px-4 py-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">All Service Bookings</h1>
                    <p class="text-gray-500 mt-1">Manage and monitor all customer service requests</p>
                </div>
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                    Admin Portal
                </div>
            </div>

             <!-- Pending Bookings Section -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 p-6 mb-8">
                <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-clock text-yellow-500"></i> Pending Bookings
                    </h2>
                    <button onclick="loadBookings()" class="text-green-600 hover:text-green-700 font-semibold text-sm flex items-center gap-2">
                        <i class="fas fa-sync-alt"></i> Refresh 
                    </button>
                </div>

               <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left">
                        <thead>
                       <tr class="bg-gray-50 text-gray-600 text-xs font-bold uppercase tracking-wider">
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Customer (ID)</th>
                                <th class="px-4 py-3">Location</th>
                                <th class="px-4 py-3">Order Date</th>
                                <th class="px-4 py-3">Scheduled Date</th>
                                <th class="px-4 py-3">Total</th>
                                <th class="px-4 py-3">Payment</th>
                                <th class="px-4 py-3">Provider</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                            <tbody id="pendingTableBody" class="text-sm divide-y divide-gray-100">
                            <tr>
                                 <td colspan="9" class="py-8 text-center text-gray-400">Loading bookings...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Booking History Section -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-history text-blue-500"></i> Booking History
                    </h2>
                </div>

                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 text-xs font-bold uppercase tracking-wider">
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Customer</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Scheduled Date</th>
                                <th class="px-4 py-3">Total</th>
                                <th class="px-4 py-3">Payment</th>
                                <th class="px-4 py-3">Provider</th>
                            </tr>
                        </thead>
                        <tbody id="historyTableBody" class="text-sm divide-y divide-gray-100">
                            <tr>
                                 <td colspan="7" class="py-8 text-center text-gray-400">Loading history...</td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        const token = localStorage.getItem("token");
        let providersList = [];

        if (!token) {
            window.location.href = "/login";
        }

        async function fetchProviders() {
            try {
                const res = await fetch("/api/admin/providers", {
                    headers: { Authorization: "Bearer " + token }
                });
                providersList = await res.json();
            } catch (err) {
                console.error("Error fetching providers:", err);
            }
        }

        async function updateBookingStatus(id, status) {
            if (!confirm(`Are you sure you want to ${status === 'Order Confirmed' ? 'approve' : 'decline'} this booking?`)) return;

            try {
                const res = await fetch(`/api/admin/bookings/${id}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ status })
                });

                if (res.ok) {
                    alert('Booking status updated!');
                    loadBookings();
                } else {
                    alert('Failed to update status.');
                }
            } catch (err) {
                console.error(err);
            }
        }

        async function updatePaymentStatus(id, payment_status) {
            if (!confirm(`Are you sure you want to mark this payment as ${payment_status}?`)) return;

            try {
                const res = await fetch(`/api/admin/bookings/${id}/payment-status`, {
                    method: 'PATCH',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ payment_status })
                });

                if (res.ok) {
                    alert('Payment status updated!');
                    loadBookings();
                } else {
                    alert('Failed to update payment status.');
                }
            } catch (err) {
                console.error(err);
            }
        }

        async function assignProvider(id, status) {
            if (!status) return;
            try {
                const res = await fetch(`/api/admin/bookings/${id}/assign`, {
                    method: 'PATCH',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ status })
                });

                if (res.ok) {
                    alert('Provider status updated!');
                    loadBookings();
                } else {
                    alert('Failed to update provider status.');
                }
            } catch (err) {
                console.error(err);
            }
        }

        async function loadBookings() {
            const pendingBody = document.getElementById("pendingTableBody");
            const historyBody = document.getElementById("historyTableBody");

            try {
                const res = await fetch("/api/admin/all_bookings", {
                   headers: { Authorization: "Bearer " + token }
                });

                if (res.status === 401) {
                    localStorage.removeItem("token");
                    window.location.href = "/login";
                    return;
                }

                if (!res.ok) throw new Error('Failed to fetch bookings');

                const bookings = await res.json();

                const pending = bookings.filter(b => b.status === 'Pending' || b.status === 'pending');
                const history = bookings.filter(b => b.status !== 'Pending' && b.status !== 'pending');
                
                pendingBody.innerHTML = pending.length ? renderPending(pending) : `<tr><td colspan="9" class="py-8 text-center text-gray-400">No pending bookings.</td></tr>`;
                historyBody.innerHTML = history.length ? renderHistory(history) : `<tr><td colspan="7" class="py-8 text-center text-gray-400">No booking history.</td></tr>`;
            } catch (err) {
                console.error("Error loading bookings:", err);
                pendingBody.innerHTML = `<tr><td colspan="9" class="py-8 text-center text-red-400">Error loading data: ${err.message}</td></tr>`;
                historyBody.innerHTML = `<tr><td colspan="7" class="py-8 text-center text-red-400">Error loading data.</td></tr>`;
            }
        }

        function renderPending(bookings) {
            return bookings.map(b => {
                const customerName = b.customer ? `${b.customer.fname} ${b.customer.lname}` : 'Guest';
                const location = b.customer ? `${b.customer.city}, ${b.customer.address || ''}` : 'N/A';
                
                const provider = b.items && b.items[0] && b.items[0].offering ? b.items[0].offering.provider : null;
                const isAssigned = provider && provider.email === 'provider@example.com'; 

                const paymentMethod = b.payments && b.payments[0] ? b.payments[0].payment_method.toLowerCase() : '';
                let paymentStatusText = b.payment_status;
                let paymentStatusClass = b.payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700';

                if (paymentMethod === 'mobile_banking' && b.payment_status !== 'paid') {
                    paymentStatusText = 'pending payment';
                    paymentStatusClass = 'bg-yellow-100 text-yellow-700';
                } else if (paymentMethod === 'cash') {
                    paymentStatusText = 'paid';
                    paymentStatusClass = 'bg-green-100 text-green-700';
                }
          
                return `
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-4 font-medium text-gray-900">#${b.id}</td>
                        <td class="px-4 py-4">
                            <div class="font-semibold text-gray-800">${customerName}</div>
                            <div class="text-xs text-gray-500">ID: ${b.customer_id}</div>
                        </td>
                        <td class="px-4 py-4 text-xs text-gray-600 max-w-[150px] truncate">${location}</td>
                        <td class="px-4 py-4 text-xs text-gray-600">${new Date(b.created_at).toLocaleString()}</td>
                        <td class="px-4 py-4 text-xs font-semibold text-blue-600">${new Date(b.scheduled_datetime).toLocaleString()}</td>
                        <td class="px-4 py-4 font-bold text-gray-900">$${b.total_amount}</td>
                        <td class="px-4 py-4">
                            <div class="flex flex-col gap-1">
                                <span class="px-2 py-1 rounded text-[10px] font-bold uppercase ${paymentStatusClass} w-fit">
                                    ${paymentStatusText}
                                </span>
                                ${paymentMethod === 'mobile_banking' && b.payment_status !== 'paid' ? `
                                    <button onclick="updatePaymentStatus(${b.id}, 'paid')" class="text-[9px] text-green-600 hover:text-green-700 font-bold underline text-left">
                                        Approve Payment
                                    </button>
                                ` : ''}
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex flex-col gap-1">
                                <select onchange="assignProvider(${b.id}, this.value)" class="text-[11px] border rounded p-1 w-full bg-white outline-none focus:border-green-500">
                                    <option value="not_assigned" ${!isAssigned ? 'selected' : ''}>Not Assigned</option>
                                    <option value="assigned" ${isAssigned ? 'selected' : ''}>Assigned</option>
                                </select>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="updateBookingStatus(${b.id}, 'Order Confirmed')" class="bg-green-500 hover:bg-green-600 text-white p-2 rounded shadow-sm transition" title="Approve">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button onclick="updateBookingStatus(${b.id}, 'cancelled')" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded shadow-sm transition" title="Decline">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function renderHistory(bookings) {
            return bookings.map(b => {
                const customerName = b.customer ? `${b.customer.fname} ${b.customer.lname}` : 'Guest';
                const provider = b.items && b.items[0] && b.items[0].offering && b.items[0].offering.provider 
                                    ? b.items[0].offering.provider.full_name : null;
                
                let statusClass = "bg-gray-100 text-gray-600";
                if (b.status === 'Order Confirmed') statusClass = "bg-green-100 text-green-600";
                if (b.status === 'completed') statusClass = "bg-blue-100 text-blue-600";
                if (b.status === 'cancelled') statusClass = "bg-red-100 text-red-600";

                const paymentMethod = b.payments && b.payments[0] ? b.payments[0].payment_method.toLowerCase() : '';
                let paymentStatusText = b.payment_status;
                let paymentStatusClass = b.payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700';

                if (paymentMethod === 'mobile_banking' && b.payment_status !== 'paid') {
                    paymentStatusText = 'pending payment';
                    paymentStatusClass = 'bg-yellow-100 text-yellow-700';
                } else if (paymentMethod === 'cash') {
                    paymentStatusText = 'paid';
                    paymentStatusClass = 'bg-green-100 text-green-700';
                }

                return `
                    <tr class="hover:bg-gray-50 transition border-b border-gray-50">
                        <td class="px-4 py-4 font-medium text-gray-900">#${b.id}</td>
                        <td class="px-4 py-4 text-gray-600">${customerName}</td>
                        <td class="px-4 py-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase ${statusClass}">
                                ${b.status}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-xs text-gray-600">${new Date(b.scheduled_datetime).toLocaleString()}</td>
                        <td class="px-4 py-4 font-bold text-gray-900">$${b.total_amount}</td>
                        <td class="px-4 py-4">
                            <span class="px-2 py-1 rounded text-[10px] font-bold uppercase ${paymentStatusClass}">
                                ${paymentStatusText}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            ${provider 
                                ? `<div class="flex flex-col">
                                     <span class="text-[10px] font-bold text-green-600 uppercase">Assigned</span>
                                     <span class="text-xs text-gray-700 font-medium">${provider}</span>
                                   </div>`
                                : `<span class="text-[10px] font-bold text-red-500 uppercase">Not Assigned</span>`
                            }
                        </td>
                    </tr>
                `;
            }).join('');
        }
        document.addEventListener("DOMContentLoaded", () => {
            fetchProviders();
            loadBookings();
        });
    </script>
</body>

</html>