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

    // ❌ Not logged in (Guest)
    if (!token || !user) {
        // Show center links for guests
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
        // Hide center links for admin
        if (centerLinks) centerLinks.style.display = "none";
        
        container.innerHTML = `
            <a href="/admin/dashboard" class="hover:text-green-600">Dashboard</a>
            <a href="/admin/providers" class="hover:text-green-600">Providers</a>
            <a href="/admin/all_bookings" class="hover:text-green-600">Bookings</a>

            <a href="/profile" class="px-4 py-2 text-green-600 font-semibold hover:bg-green-50 rounded-lg transition">
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
    // Show center links for customers
    if (centerLinks) centerLinks.style.display = "flex";
    
    container.innerHTML = `
        <a href="/profile" class="px-4 py-2 text-green-600 font-semibold hover:bg-green-50 rounded-lg transition">
            <i class="fas fa-user-circle text-xl"></i>
        </a>

        <button id="logoutBtn" class="px-5 py-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition">
            Logout
        </button>
    `;

    document.getElementById("logoutBtn").addEventListener("click", logoutUser);
}

// run
document.addEventListener("DOMContentLoaded", renderNavbar);
window.addEventListener("pageshow", renderNavbar);
</script>