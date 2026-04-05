<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Serviqo</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-green: #22c55e;
            --dark-green: #16a34a;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    @include('components.navbar')

    <!-- Header -->
    <header class="bg-white border-b border-gray-100 py-16">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Complete Your Payment</h1>
            <p class="text-gray-600 text-lg">Secure your booking using mobile banking</p>
        </div>
    </header>

    <!-- Payment Section -->
    <section class="py-16 flex-grow">
        <div class="container mx-auto px-6">
            <div class="max-w-2xl mx-auto">

                <!-- Payment Card -->
                <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">

                    <!-- Order Info -->
                    <div class="bg-green-50 border border-green-100 p-6 rounded-2xl mb-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Order Details</h3>
                        <p class="text-gray-700"><strong>Order ID:</strong> <span id="orderId"></span></p>
                        <p class="text-gray-700 mt-2"><strong>Amount to Pay:</strong>
                            <span class="text-2xl font-bold text-green-600">৳<span id="amount"></span></span>
                        </p>
                    </div>

                    <!-- Payment Instructions -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">bKash Payment Instructions</h3>

                        <div class="space-y-4 text-gray-600 text-sm leading-relaxed">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-mobile-alt text-green-500 mt-1"></i>
                                <p>Open your <strong>bKash App</strong></p>
                            </div>

                            <div class="flex items-start gap-3">
                                <i class="fas fa-paper-plane text-green-500 mt-1"></i>
                                <p>Select <strong>Send Money</strong></p>
                            </div>

                            <div class="flex items-start gap-3">
                                <i class="fas fa-phone text-green-500 mt-1"></i>
                                <p>Send to number: <strong class="text-gray-900">01XXXXXXXXX</strong></p>
                            </div>

                            <div class="flex items-start gap-3">
                                <i class="fas fa-money-bill text-green-500 mt-1"></i>
                                <p>Enter exact amount: <strong>৳<span id="amount2"></span></strong></p>
                            </div>

                            <div class="flex items-start gap-3">
                                <i class="fas fa-hashtag text-green-500 mt-1"></i>
                                <p>
                                    In <strong>Reference</strong>, enter:
                                    <span class="font-bold text-gray-900" id="orderId2"></span>
                                </p>
                            </div>

                            <div class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-1"></i>
                                <p>Confirm and complete payment</p>
                            </div>
                        </div>
                    </div>

                    <!-- Notice -->
                    <div class="bg-yellow-50 border border-yellow-100 p-4 rounded-xl text-sm text-yellow-700">
                        ⚠️ Your order will be verified after payment. Please keep your transaction ID.
                    </div>

                    <!-- Back Button -->
                    <button onclick="window.location.href='/'"
                        class="w-full mt-6 py-4 bg-green-500 text-white font-bold rounded-xl hover:bg-green-600 transition-all shadow-lg shadow-green-200">
                        Back to Home
                    </button>

                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-auto">
        <div class="container mx-auto px-6 text-center">
            <p class="text-gray-400 text-sm">&copy; 2026 Serviqo. All rights reserved.</p>
        </div>
    </footer>

    <script>
        const orderId = localStorage.getItem("order_id");
        const amount = localStorage.getItem("amount");

        if (!orderId || !amount) {
            window.location.replace("/");
        }
        history.pushState(null, null, location.href);

        window.addEventListener("popstate", function () {
            window.location.replace("/");
        });
        document.getElementById("orderId").textContent = orderId;
        document.getElementById("orderId2").textContent = orderId;

        document.getElementById("amount").textContent = amount;
        document.getElementById("amount2").textContent = amount;

        localStorage.removeItem("order_id");
        localStorage.removeItem("amount");
    </script>

</body>

</html>