@include('components.navbar')

<h1>Admin Dashboard</h1>

<div id="dashboardContent">Loading...</div>

<script>
    async function loadDashboard() {
        const token = localStorage.getItem("token");

        if (!token) {
            window.location.href = "/login";
            return;
        }

        try {
            const res = await fetch("/api/admin/dashboard", {
                headers: {
                    Authorization: "Bearer " + token
                }
            });

            if (res.status === 401) {
                localStorage.removeItem("token");
                window.location.href = "/login";
                return;
            }

            const user = await res.json();

            document.getElementById("dashboardContent").innerHTML = `
            <p>Welcome ${user.fname} ${user.lname}</p>
        `;

        } catch (err) {
            document.getElementById("dashboardContent").innerText = "Error loading dashboard";
        }
    }
    window.addEventListener("pageshow", function (event) {
        if (event.persisted) {
            const token = localStorage.getItem("token");

            if (!token) {
                window.location.replace("/login");
            }
        }
    });
    loadDashboard();
</script>