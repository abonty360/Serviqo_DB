<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Service Providers - Serviqo</title>
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
</head>

<body class="bg-gray-50 text-gray-800 min-h-screen">

    @include('components.navbar')

    <div class="container mx-auto px-6 py-12">
        <div class="max-w-6xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Service Providers</h1>
                    <p class="text-gray-500 mt-1">Manage and monitor all registered service providers</p>
                </div>
                <div class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">
                    Admin Portal
                </div>
            </div>

            <!-- Providers Table Card -->
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-8 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider">Provider Info</th>
                                <th class="px-8 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider">Contact</th>
                                <th class="px-8 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider">Location</th>
                                <th class="px-8 py-5 text-sm font-bold text-gray-600 uppercase tracking-wider text-center">Rating</th>
                            </tr>
                        </thead>
                        <tbody id="providersList" class="divide-y divide-gray-50">
                            <!-- Skeleton Loading -->
                            <tr class="animate-pulse">
                                <td colspan="4" class="px-8 py-10 text-center text-gray-400">
                                    <i class="fas fa-spinner fa-spin mr-2"></i> Loading providers...
                                </td>
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

        async function loadProviders() {
            try {
                const res = await fetch("/api/admin/providers", {
                    headers: {
                        Authorization: "Bearer " + token,
                        "Accept": "application/json"
                    }
                });

                if (res.status === 401) {
                    localStorage.removeItem("token");
                    window.location.href = "/login";
                    return;
                }
 window.addEventListener("pageshow", function (event) {
            if (event.persisted) {
                if (!localStorage.getItem("token")) {
                    window.location.replace("/login");
                }
            }
        });

                const providers = await res.json();
                const list = document.getElementById("providersList");

                if (!providers || providers.length === 0) {
                    list.innerHTML = `
                        <tr>
                            <td colspan="4" class="px-8 py-12 text-center text-gray-500 italic">
                                No service providers found.
                            </td>
                        </tr>
                    `;
                    return;
                }

                let html = "";
                providers.forEach(p => {
                    html += `
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center font-bold mr-4">
                                        ${p.full_name ? p.full_name.charAt(0) : '?'}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">${p.full_name || 'Unnamed'}</div>
                                        <div class="text-xs text-gray-400">NID: ${p.nid || 'N/A'}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-sm text-gray-700 font-medium">${p.email}</div>
                                <div class="text-xs text-gray-400">${p.phone}</div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-sm text-gray-700 font-medium">${p.city}</div>
                                <div class="text-xs text-gray-400">${p.service_area ? p.service_area.area_name : 'Unknown Area'}</div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <div class="inline-flex items-center px-3 py-1 bg-yellow-50 text-yellow-700 rounded-full text-xs font-bold">
                                    <i class="fas fa-star mr-1"></i> ${p.rating || '0.0'}
                                </div>
                            </td>
                        </tr>
                    `;
                });

                list.innerHTML = html;

            } catch (err) {
                console.error("Error:", err);
                document.getElementById("providersList").innerHTML = `
                    <tr>
                        <td colspan="4" class="px-8 py-12 text-center text-red-500">
                            <i class="fas fa-exclamation-triangle mr-2"></i> Failed to load providers. Please try again.
                        </td>
                    </tr>
                `;
            }
        }

        loadProviders();
    </script>
</body>

</html>