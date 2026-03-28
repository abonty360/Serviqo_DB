function renderNavbar() {

    const token = localStorage.getItem("token");
    const container = document.getElementById("authButtons");
    if (!container) return;

    if (token) {

        container.innerHTML = `
            <a href="/profile" class="px-7 py-2 text-green-600 font-semibold hover:bg-green-50 rounded-lg transition">
                <i class="fas fa-user-circle text-xl"></i> Profile
            </a>

            <button id="logoutBtn" class="px-7 py-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition">
                Logout
            </button>
        `;

        document.getElementById("logoutBtn").addEventListener("click", logoutUser);

    } else {

        container.innerHTML = `
            <a href="/login" class="px-7 py-2 text-green-600 font-semibold hover:bg-green-50 rounded-lg transition">Login</a>

            <a href="/signup" class="px-7 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 shadow-md transition">
                Sign Up
            </a>
        `;
    }
}

async function logoutUser() {

    const token = localStorage.getItem("token");

    await fetch("/api/logout", {
        method: "POST",
        headers: {
            "Authorization": "Bearer " + token,
            "Content-Type": "application/json"
        }
    });

    localStorage.removeItem("token");
    renderNavbar();
    window.location.href = "/login";
}
document.addEventListener("DOMContentLoaded", renderNavbar);
window.addEventListener("pageshow", renderNavbar);