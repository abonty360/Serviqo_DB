<nav class="flex items-center justify-between px-8 py-4 bg-white border-b sticky top-0 z-50">
    
    <!-- Logo -->
    <a href="/" class="flex items-center space-x-2 hover:opacity-80 transition cursor-pointer">
        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
            <i class="fas fa-tools text-white text-xl"></i>
        </div>
        <span class="text-2xl font-bold text-gray-900 tracking-tight">Serviqo</span>
    </a>

    <!-- Center Links -->
    <div class="hidden md:flex ml-auto space-x-10 font-medium text-gray-600" id="centerLinks">
        <a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'text-green-600' : 'hover:text-green-600' }}">Services</a>
        <a href="{{ route('how-it-works') }}" class="{{ request()->routeIs('how-it-works') ? 'text-green-600' : 'hover:text-green-600' }}">How it Works</a>
        <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-green-600' : 'hover:text-green-600' }}">About</a>
    </div>

    <!-- Right Side (Dynamic) -->
    <div class="flex space-x-4 items-center" id="authButtons"></div>
</nav>

<script>
function getCachedUser() {
    const user = localStorage.getItem("user");
    return user ? JSON.parse(user) : null;
}

async function logoutUser() {
    const token = localStorage.getItem("token");

    try {
        const response = await fetch("/api/logout", {
            method: "POST",
            headers: {
                "Authorization": "Bearer " + token,
                "Content-Type": "application/json"
            }
        });
        
        if (response.ok) {
            console.log("Logout successful");
        } else {
            console.log("Logout failed:", response.status);
        }
    } catch (error) {
        console.log("Logout error:", error);
    }

    // Always clear local storage and redirect
    localStorage.removeItem("token");
    localStorage.removeItem("user");
    
    // Re-render navbar to update UI
    renderNavbar();
    
    // Redirect to login
    window.location.href = "/login";
}

function renderNavbar() {
    const container = document.getElementById("authButtons");
    const centerLinks = document.getElementById("centerLinks");
    if (!container) return;

    const token = localStorage.getItem("token");
    const user = getCachedUser();

    // Remove existing event listeners
    const existingBtn = document.getElementById("logoutBtn");
    if (existingBtn) {
        existingBtn.removeEventListener("click", logoutUser);
    }

   
    if (!token || !user) {
        if (centerLinks) centerLinks.style.display = "flex";
        
        container.innerHTML = `
            <a href="/login" class="px-7 py-2 text-green-600 font-semibold hover:bg-green-50 rounded-lg transition">Login</a>
            <a href="/signup" class="px-7 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 shadow-md transition">
                Sign Up
            </a>
        `;
        return;
    }

    // ✅ Admin user
    if (user.role === 'admin') {
        if (centerLinks) centerLinks.style.display = "none";
        
        container.innerHTML = `
            <a href="/admin/dashboard" class="hover:text-green-600 font-semibold text-sm">Dashboard</a>
            <a href="/admin/service_providers" class="hover:text-green-600 font-semibold text-sm">Providers</a>
            <a href="/admin/all_bookings" class="hover:text-green-600 font-semibold text-sm">Bookings</a>

            <a href="/profile" class="px-3 py-2 text-green-600 font-semibold hover:bg-green-50 rounded-lg transition">
                <i class="fas fa-user-circle text-xl"></i>
            </a>

            <button id="logoutBtn" class="px-5 py-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition">
                Logout
            </button>
        `;
        
        document.getElementById("logoutBtn").addEventListener("click", logoutUser);
        return;
    }

    // ✅ Customer user
    if (centerLinks) centerLinks.style.display = "flex";
    
    container.innerHTML = `
        <div class="relative" id="notificationContainer">
            <button id="notificationBell" class="p-2 text-gray-500 hover:text-green-600 relative transition">
                <i class="fas fa-bell text-xl"></i>
                <span id="notificationBadge" class="hidden absolute top-2 right-2 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">0</span>
            </button>
            <div id="notificationDropdown" class="hidden absolute right-0 mt-3 w-80 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden">
                <div class="p-4 border-b bg-gray-50/50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 text-sm">Notifications</h3>
                    <button onclick="markAllNotificationsRead()" class="text-[11px] text-green-600 font-semibold hover:text-green-700">Mark all as read</button>
                </div>
                <div id="notificationItems" class="max-h-[400px] overflow-y-auto">
                    <div class="p-8 text-center text-gray-400">
                        <i class="fas fa-spinner fa-spin mb-2"></i>
                        <p class="text-xs">Loading notifications...</p>
                    </div>
                </div>
                <div id="emptyNotifications" class="hidden p-10 text-center text-gray-400">
                    <i class="fas fa-bell-slash text-3xl mb-3 opacity-20"></i>
                    <p class="text-xs font-medium">No new notifications</p>
                </div>
            </div>
        </div>

        <a href="/profile" class="px-4 py-2 text-green-600 font-semibold hover:bg-green-50 rounded-lg transition">
            <i class="fas fa-user-circle text-xl"></i>
        </a>

        <button id="logoutBtn" class="px-5 py-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition">
            Logout
        </button>
    `;

    document.getElementById("logoutBtn").addEventListener("click", logoutUser);
    
    // Notification Toggle Logic
    const bell = document.getElementById("notificationBell");
    const dropdown = document.getElementById("notificationDropdown");
    
    if (bell && dropdown) {
        bell.onclick = (e) => {
            e.stopPropagation();
            dropdown.classList.toggle("hidden");
            if (!dropdown.classList.contains("hidden")) {
                fetchNotifications();
            }
        };
        
        document.addEventListener("click", (e) => {
            if (!dropdown.contains(e.target) && e.target !== bell) {
                dropdown.classList.add("hidden");
            }
        });
    }

    updateNotificationBadge();
}

window.currentNotifications = [];

async function updateNotificationBadge() {
    const token = localStorage.getItem("token");
    if (!token) return;

    try {
        const response = await fetch("/api/notifications", {
            headers: { "Authorization": "Bearer " + token }
        });
        const notifications = await response.json();
        window.currentNotifications = Array.isArray(notifications) ? notifications : [];
        const unreadCount = window.currentNotifications.filter(n => !n.is_read).length;
        
        const badge = document.getElementById("notificationBadge");
        if (badge) {
            if (unreadCount > 0) {
                badge.textContent = unreadCount > 99 ? "99+" : unreadCount;
                badge.classList.remove("hidden");
            } else {
                badge.classList.add("hidden");
            }
        }
    } catch (e) {
        console.error("Badge update failed", e);
    }
}

async function fetchNotifications() {
    const token = localStorage.getItem("token");
    const itemsContainer = document.getElementById("notificationItems");
    const emptyState = document.getElementById("emptyNotifications");

    try {
        const response = await fetch("/api/notifications", {
            headers: { "Authorization": "Bearer " + token }
        });
        const notifications = await response.json();
        window.currentNotifications = Array.isArray(notifications) ? notifications : [];

        if (window.currentNotifications.length === 0) {
            itemsContainer.innerHTML = "";
            emptyState.classList.remove("hidden");
            return;
        }

        emptyState.classList.add("hidden");
        itemsContainer.innerHTML = window.currentNotifications.map(n => `
            <div onclick="markAsRead(${n.id})" class="p-4 border-b hover:bg-gray-50 cursor-pointer transition ${!n.is_read ? 'bg-green-50/30' : ''}">
                <div class="flex justify-between items-start mb-1">
                    <p class="text-sm font-bold ${!n.is_read ? 'text-green-800' : 'text-gray-700'}">${n.title}</p>
                    <span class="text-[10px] text-gray-400">${new Date(n.created_at).toLocaleDateString()}</span>
                </div>
                <p class="text-xs text-gray-500 leading-relaxed">${n.message}</p>
            </div>
        `).join("");

    } catch (e) {
        itemsContainer.innerHTML = `<div class="p-4 text-xs text-red-500">Failed to load notifications</div>`;
    }
}

async function markAsRead(id) {
    const token = localStorage.getItem("token");
    try {
        await fetch(`/api/notifications/${id}/read`, {
            method: "POST",
            headers: { "Authorization": "Bearer " + token }
        });
        
        // Show details if available
        const notification = (window.currentNotifications || []).find(n => n.id == id);
        const order = notification ? (notification.service_order || notification.serviceOrder) : null;

        if (notification && order) {
            openGlobalOrderDetails(order);
        }

        fetchNotifications();
        updateNotificationBadge();
    } catch (e) {
        console.error("Mark as read failed", e);
    }
}

function openGlobalOrderDetails(order) {
    const modal = document.getElementById('globalOrderDetailsModal');
    if (!modal) return;

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

    let icon = 'fa-check-circle';
    let statusColor = 'bg-green-100 text-green-600';

    if (order.status === 'cancelled') {
        icon = 'fa-times-circle';
        statusColor = 'bg-red-100 text-red-600';
    } else if (order.status === 'Pending' || order.status === 'pending') {
        icon = 'fa-clock';
        statusColor = 'bg-yellow-100 text-yellow-600';
    }
    
    let dateObj = new Date(order.scheduled_datetime);
    let dateText = isNaN(dateObj) ? order.scheduled_datetime : dateObj.toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit'});

    document.getElementById('globalDetailsTitle').textContent = displayServiceName;
    document.getElementById('globalDetailsIcon').className = `fas ${icon} text-2xl`;
    document.getElementById('globalDetailsStatus').textContent = order.status;
    document.getElementById('globalDetailsStatus').className = `inline-block mt-2 px-3 py-1 text-sm font-bold rounded-lg capitalize ${statusColor}`;
    document.getElementById('globalDetailsDate').textContent = dateText;
    document.getElementById('globalDetailsOrderId').textContent = "#" + String(order.id).padStart(5, '0');
    document.getElementById('globalDetailsPayment').textContent = order.payment_status;
    document.getElementById('globalDetailsTotal').textContent = "৳" + order.total_amount;

    modal.classList.remove('hidden');
}

function closeGlobalOrderDetails() {
    document.getElementById('globalOrderDetailsModal').classList.add('hidden');
}

async function markAllNotificationsRead() {
    const token = localStorage.getItem("token");
    try {
        await fetch(`/api/notifications/read-all`, {
            method: "POST",
            headers: { "Authorization": "Bearer " + token }
        });
        fetchNotifications();
        updateNotificationBadge();
    } catch (e) {
        console.error("Mark all as read failed", e);
    }
}

document.addEventListener("DOMContentLoaded", () => {
    if (!document.getElementById('globalOrderDetailsModal')) {
        const modalHtml = `
            <div id="globalOrderDetailsModal" class="fixed inset-0 bg-black/50 z-[100] hidden flex items-center justify-center p-4">
                <div class="bg-white rounded-3xl w-full max-w-md shadow-xl overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                        <h2 class="text-xl font-bold text-gray-900">Order Details</h2>
                        <button onclick="closeGlobalOrderDetails()" class="text-gray-400 hover:text-gray-600 transition">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <div class="p-8 space-y-6">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-50 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i id="globalDetailsIcon" class="fas fa-tools text-2xl"></i>
                            </div>
                            <h3 id="globalDetailsTitle" class="text-2xl font-bold text-gray-900 capitalize"></h3>
                            <p id="globalDetailsStatus" class="inline-block mt-2 px-3 py-1 text-sm font-bold rounded-lg"></p>
                        </div>
                        
                        <div class="space-y-4 pt-4 border-t border-gray-100">
                            <div class="flex justify-between items-start">
                                <span class="text-gray-500 font-medium">Scheduled For</span>
                                <span id="globalDetailsDate" class="text-gray-900 font-semibold text-right max-w-[60%]"></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium">Order ID</span>
                                <span id="globalDetailsOrderId" class="text-gray-900 font-semibold"></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium">Payment Status</span>
                                <span id="globalDetailsPayment" class="text-gray-900 font-semibold capitalize"></span>
                            </div>
                            <div class="pt-4 border-t border-gray-100 flex justify-between items-center mt-2">
                                <span class="text-gray-900 font-bold">Total Amount</span>
                                <span id="globalDetailsTotal" class="text-xl font-bold text-green-600"></span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-100 bg-gray-50 flex justify-end">
                        <button onclick="closeGlobalOrderDetails()" class="w-full py-3 bg-green-500 text-white font-bold rounded-xl hover:bg-green-600 transition">Got it</button>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', modalHtml);
    }

    renderNavbar();
    setInterval(() => {
        const token = localStorage.getItem("token");
        const user = getCachedUser();
        if (token && user && user.role !== 'admin') {
            updateNotificationBadge();
        }
    }, 10000);
});
window.addEventListener("pageshow", renderNavbar);
</script>