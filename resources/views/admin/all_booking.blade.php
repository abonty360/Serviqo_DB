@include('components.navbar')
<h1>Bookings</h1>
<div id="bookings">Loading...</div>

<script>
async function loadBookings() {
    const token = localStorage.getItem("token");

    if (!token) {
        window.location.href = "/login";
        return;
    }

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

        let html = "";

        if (bookings.length === 0) {
            html = "<p>No bookings found</p>";
        }

        document.getElementById("bookings").innerHTML = html;

    } catch {
        document.getElementById("bookings").innerText = "Error loading bookings";
    }
}

loadBookings();
</script>