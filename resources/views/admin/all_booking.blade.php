<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Bookings - Admin - Serviqo</title>
    <script>
        (function() {
            if (!localStorage.getItem("token")) {
                document.documentElement.style.display = 'none';
                window.location.replace("/login");
            }
        })();
        window.addEventListener("pageshow", function(e) {
            if (e.persisted && !localStorage.getItem("token")) {
                document.documentElement.style.display = 'none';
                window.location.replace("/login");
            }
        });
    </script>
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

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-10 right-10 z-[100] transform transition-all duration-300 translate-y-20 opacity-0 pointer-events-none">
        <div id="toastContent" class="flex items-center gap-3 px-6 py-4 rounded-2xl shadow-2xl text-white font-bold min-w-[300px]">
            <div id="toastIconContainer" class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                <i id="toastIcon" class="fas"></i>
            </div>
            <span id="toastMessage" class="flex-1"></span>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="fixed inset-0 bg-black/60 z-[150] hidden flex items-center justify-center p-4 backdrop-blur-sm">
        <div id="confirmModalContent" class="bg-white rounded-3xl w-full max-w-sm shadow-2xl overflow-hidden transform transition-all scale-95 opacity-0">
            <div class="p-8 text-center">
                <div class="w-20 h-20 bg-yellow-50 text-yellow-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-question text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Confirmation</h3>
                <p id="confirmModalMessage" class="text-gray-500 font-medium"></p>
            </div>
            <div class="p-6 bg-gray-50/50 flex gap-3">
                <button id="confirmCancelBtn" class="flex-1 py-4 text-gray-600 font-bold rounded-2xl hover:bg-gray-200 transition">Cancel</button>
                <button id="confirmApproveBtn" class="flex-1 py-4 bg-green-500 text-white font-bold rounded-2xl hover:bg-green-600 transition shadow-lg shadow-green-200">Confirm</button>
            </div>
        </div>
    </div>

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
                                <th class="px-4 py-3">Payment Method</th>
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
                <div class="mt-4 flex justify-end">
                    <div id="pendingPagination" class="flex items-center gap-2"></div>
                </div>
            </div>

            <!-- Completed & Others Section -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-check-circle text-green-500"></i> Booking History
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
                                <th class="px-4 py-3">Payment Method</th>
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
                <div class="mt-4 flex justify-end">
                    <div id="historyPagination" class="flex items-center gap-2"></div>
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

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const content = document.getElementById('toastContent');
            const icon = document.getElementById('toastIcon');
            const msg = document.getElementById('toastMessage');

            msg.textContent = message;
            
            if (type === 'success') {
                content.className = 'flex items-center gap-4 px-6 py-4 rounded-2xl shadow-2xl text-white font-bold min-w-[300px] bg-green-500 border border-green-600';
                icon.className = 'fas fa-check-circle text-lg';
            } else {
                content.className = 'flex items-center gap-4 px-6 py-4 rounded-2xl shadow-2xl text-white font-bold min-w-[300px] bg-red-500 border border-red-600';
                icon.className = 'fas fa-exclamation-circle text-lg';
            }

            toast.classList.remove('translate-y-20', 'opacity-0', 'pointer-events-none');
            toast.classList.add('translate-y-0', 'opacity-100');

            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-20', 'opacity-0', 'pointer-events-none');
            }, 3000);
        }

        function showConfirm(message) {
            return new Promise((resolve) => {
                const modal = document.getElementById('confirmModal');
                const content = document.getElementById('confirmModalContent');
                const msg = document.getElementById('confirmModalMessage');
                const cancelBtn = document.getElementById('confirmCancelBtn');
                const approveBtn = document.getElementById('confirmApproveBtn');

                msg.textContent = message;
                modal.classList.remove('hidden', 'flex');
                modal.classList.add('flex');
                
                setTimeout(() => {
                    content.classList.remove('scale-95', 'opacity-0');
                    content.classList.add('scale-100', 'opacity-100');
                }, 10);

                const closeModal = (result) => {
                    content.classList.remove('scale-100', 'opacity-100');
                    content.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                        resolve(result);
                    }, 200);
                };

                approveBtn.onclick = () => closeModal(true);
                cancelBtn.onclick = () => closeModal(false);
                modal.onclick = (e) => { if (e.target === modal) closeModal(false); };
            });
        }

        async function updateBookingStatus(id, status) {
            const confirmed = await showConfirm(`Are you sure you want to ${status === 'Order Confirmed' ? 'approve' : 'decline'} this booking?`);
            if (!confirmed) return;

            try {
                const res = await fetch(`/api/admin/bookings/${id}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status })
                });

                const result = await res.json();

                if (res.ok) {
                    showToast('Booking status updated!');
                    loadBookings();
                } else {
                    let errorMessage = result.message || 'Failed to update status';
                    if (result.error) {
                        errorMessage += '\n' + result.error;
                    }
                    showToast(errorMessage, 'error');
                    console.error('Error response:', result);
                }
            } catch (err) {
                console.error('Error:', err);
                showToast('An error occurred: ' + err.message, 'error');
            }
        }

        async function updatePaymentStatus(id, payment_status) {
            const confirmed = await showConfirm(`Are you sure you want to mark this payment as ${payment_status}?`);
            if (!confirmed) return;

            try {
                const res = await fetch(`/api/admin/bookings/${id}/payment-status`, {
                    method: 'PATCH',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ payment_status })
                });

                const result = await res.json();

                if (res.ok) {
                    showToast('Payment status updated!');
                    loadBookings();
                } else {
                    let errorMessage = result.message || 'Failed to update payment status';
                    if (result.error) {
                        errorMessage += '\n' + result.error;
                    }
                    showToast(errorMessage, 'error');
                    console.error('Error response:', result);
                }
            } catch (err) {
                console.error('Error:', err);
                showToast('An error occurred: ' + err.message, 'error');
            }
        }

        async function assignProvider(id, provider_id) {
            if (!provider_id) return;
            try {
                const res = await fetch(`/api/admin/bookings/${id}/assign`, {
                    method: 'PATCH',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ 
                        provider_id: provider_id,
                        status: 'assigned'
                    })
                });

                if (res.ok) {
                    showToast('Provider assigned successfully!');
                    loadBookings();
                } else {
                    showToast('Failed to update provider status.', 'error');
                }
            } catch (err) {
                console.error(err);
                showToast('An error occurred.', 'error');
            }
        }

        async function loadBookings() {
            const pendingBody = document.getElementById("pendingTableBody");
            const historyBody = document.getElementById("historyTableBody");
            
            try {
                // Fetch providers first to ensure the list is available for rendering
                await fetchProviders();

                const res = await fetch("/api/admin/all_bookings", {
                    headers: { Authorization: "Bearer " + token }
                });

                if (res.status === 401) {
                    localStorage.removeItem("token");
                    window.location.href = "/login";
                    return;
                }

                const bookings = await res.json();

                const pending = bookings.filter(b => b.status === 'Pending' || b.status === 'pending');
                const history = bookings.filter(b => b.status !== 'Pending' && b.status !== 'pending');

                // Store for client-side pagination
                window.pendingBookings = pending || [];
                window.historyBookings = history || [];
                window.pendingPage = 1;
                window.historyPage = 1;
                window.bookingsPageSize = 10;

                renderPendingPage(1);
                renderHistoryPage(1);

            } catch (err) {
                pendingBody.innerHTML = historyBody.innerHTML = `<tr><td colspan="9" class="py-8 text-center text-red-400">Error loading data.</td></tr>`;
            }
        }

        function renderPending(bookings) {
            return bookings.map(b => {
                const customerName = b.customer ? `${b.customer.fname} ${b.customer.lname}` : 'Guest';
                const location = b.customer ? `${b.customer.city}, ${b.customer.address || ''}` : 'N/A';
                
                const currentProvider = b.items && b.items[0] && b.items[0].offering ? b.items[0].offering.provider : null;
                const customerCity = b.customer ? b.customer.city : '';
                
                // Get all required sub-service IDs for this order
                const requiredSubServiceIds = b.items ? b.items.map(item => item.offering ? item.offering.sub_service_id : null).filter(id => id !== null) : [];

                // Filter providers that match the customer's city AND have ALL the required sub-services
                const matchingProviders = providersList.filter(p => {
                    // Check city match
                    const cityMatch = p.city === customerCity;
                    if (!cityMatch) return false;

                    // Check if provider has all required sub-services
                    const providerSubServiceIds = p.offerings ? p.offerings.map(o => o.sub_service_id) : [];
                    return requiredSubServiceIds.every(id => providerSubServiceIds.includes(id));
                });

                let providerOptions = `<option value="">Select Provider</option>`;
                matchingProviders.forEach(p => {
                    const isSelected = currentProvider && currentProvider.id === p.id;
                    providerOptions += `<option value="${p.id}" ${isSelected ? 'selected' : ''}>${p.full_name}</option>`;
                });

                const paymentMethod = b.payments && b.payments[0] ? b.payments[0].payment_method.toLowerCase() : '';
                const paymentMethodDisplay = paymentMethod === 'cash' ? 'COD' : (paymentMethod === 'mobile_banking' ? 'Mobile Banking' : 'N/A');
                
                let paymentStatusText = b.payment_status;
                let paymentStatusClass = b.payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700';

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
                                <span class="text-xs font-bold text-gray-800">${paymentMethodDisplay}</span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase w-fit ${paymentStatusClass}">
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
                                    ${providerOptions}
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
                const paymentMethodDisplay = paymentMethod === 'cash' ? 'COD' : (paymentMethod === 'mobile_banking' ? 'Mobile Banking' : 'N/A');
                
                let paymentStatusText = b.payment_status;
                let paymentStatusClass = b.payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700';

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
                            <div class="flex flex-col gap-1">
                                <span class="text-xs font-bold text-gray-800">${paymentMethodDisplay}</span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase w-fit ${paymentStatusClass}">
                                    ${paymentStatusText}
                                </span>
                            </div>
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

        // --- Pagination helpers for bookings ---
        function paginate(array, page, size) {
            const start = (page - 1) * size;
            return array.slice(start, start + size);
        }

        function renderPendingPage(page) {
            window.pendingPage = page;
            const items = paginate(window.pendingBookings || [], page, window.bookingsPageSize || 10);
            const pendingBody = document.getElementById('pendingTableBody');
            pendingBody.innerHTML = items.length ? renderPending(items) : `<tr><td colspan="9" class="py-8 text-center text-gray-400">No pending bookings.</td></tr>`;
            renderBookingsPagination('pending');
        }

        function renderHistoryPage(page) {
            window.historyPage = page;
            const items = paginate(window.historyBookings || [], page, window.bookingsPageSize || 10);
            const historyBody = document.getElementById('historyTableBody');
            historyBody.innerHTML = items.length ? renderHistory(items) : `<tr><td colspan="7" class="py-8 text-center text-gray-400">No booking history.</td></tr>`;
            renderBookingsPagination('history');
        }

        function renderBookingsPagination(type) {
            const total = type === 'pending' ? (window.pendingBookings || []).length : (window.historyBookings || []).length;
            const page = type === 'pending' ? (window.pendingPage || 1) : (window.historyPage || 1);
            const size = window.bookingsPageSize || 10;
            const totalPages = Math.max(1, Math.ceil(total / size));
            const container = document.getElementById(type === 'pending' ? 'pendingPagination' : 'historyPagination');
            if (!container) return;

            let html = '';
            html += `<button onclick="${type === 'pending' ? 'renderPendingPage' : 'renderHistoryPage'}(${Math.max(1, page - 1)})" class="px-3 py-1 rounded bg-gray-100 hover:bg-gray-200">&laquo; Prev</button>`;
            html += `<span class="px-3 text-sm text-gray-600">Page ${page} of ${totalPages}</span>`;
            html += `<button onclick="${type === 'pending' ? 'renderPendingPage' : 'renderHistoryPage'}(${Math.min(totalPages, page + 1)})" class="px-3 py-1 rounded bg-gray-100 hover:bg-gray-200">Next &raquo;</button>`;

            container.innerHTML = html;
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