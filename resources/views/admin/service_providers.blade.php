@include('components.navbar')
<h1>Service Providers</h1>

<div id="providers">Loading...</div>

<script>
async function loadProviders() {
    const token = localStorage.getItem("token");

    if (!token) {
        window.location.href = "/login";
        return;
    }

    try {
        const res = await fetch("/api/admin/providers", {
            headers: {
                Authorization: "Bearer " + token
            }
        });

        if (res.status === 401) {
            localStorage.removeItem("token");
            window.location.href = "/login";
            return;
        }

        const providers = await res.json();

        let html = "";

        providers.forEach(p => {
            html += `<p>${p.fname} ${p.lname}</p>`;
        });

        document.getElementById("providers").innerHTML = html;

    } catch {
        document.getElementById("providers").innerText = "Error loading providers";
    }
}

loadProviders();
</script>