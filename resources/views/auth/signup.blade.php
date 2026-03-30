<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviqo - Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/signup.css'])
</head>

<body class="flex items-center justify-center min-h-screen">

    <div
        class="bg-white rounded-2xl text-left overflow-hidden shadow-2xl sm:max-w-md sm:w-full border border-green-100 mx-auto my-8">
        <div class="bg-white px-8 pt-10 pb-8">
            <div class="text-center mb-8">
                <div
                    class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-plus text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">Create Account</h3>
                <p class="text-gray-500 mt-2">Join Serviqo today</p>
            </div>
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif
            <form id="registerFormElement" action="{{ route('customer.register') }}" method="POST" class="space-y-4"
                onsubmit="return validatePasswords()">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">First Name</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" name="fname" required
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                                    placeholder="First Name">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Last Name</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" name="lname" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                                placeholder="Last Name">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="email" required pattern="^[^@]+@[^@]+\.(com|org|net|edu|co|io|gov)$"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                            placeholder="name@example.com">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Phone Number</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <i class="fas fa-phone"></i>
                            </span>
                            <input type="tel" name="phone" required pattern="^(\+8801|01)[3-9][0-9]{8}$"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                                placeholder="+880 1XXX-XXXXXX">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Date of Birth</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            <input type="date" name="dob" required max="{{ now()->subYears(18)->format('Y-m-d') }}"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition text-gray-700">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Division</label>
                    <div class="relative">
                        <span
                            class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 pointer-events-none">
                            <i class="fas fa-map-marker-alt"></i>
                        </span>
                        <select name="city" required
                            class="block w-full pl-10 pr-10 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition appearance-none bg-white text-gray-700">
                            <option value="" disabled selected>Select Division</option>
                            <option value="Dhaka">Dhaka</option>
                            <option value="Chittagong">Chittagong</option>
                            <option value="Sylhet">Sylhet</option>
                            <option value="Barisal">Barisal</option>
                            <option value="Rangpur">Rangpur</option>
                            <option value="Rajshahi">Rajshahi</option>
                            <option value="Khulna">Khulna</option>
                        </select>
                        <div
                            class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                        <input type="hidden" name="division" id="divisionInput">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Region</label>
                    <div class="relative dropdown-container" id="regionContainer">
                        <button type="button" id="regionButton"
                            class="w-full pl-10 pr-10 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition bg-white text-gray-700 text-left flex items-center justify-between">
                            <span id="regionLabel">Select Region</span>
                            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                        </button>
                        <span
                            class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 pointer-events-none">
                            <i class="fas fa-globe"></i>
                        </span>
                        <div id="regionMenu"
                            class="hidden absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-xl max-h-60 overflow-y-auto">
                            <div id="regionOptionsList" class="p-1">
                                <div class="px-4 py-2 text-gray-400 text-sm">Please select a division first</div>
                            </div>
                        </div>
                        <input type="hidden" name="region" id="regionInput" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Full Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-home"></i>
                        </span>
                        <input type="text" name="address" required
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                            rows="2" placeholder="Street, Apartment, Zip Code">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" id="regPassword" name="password" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                                placeholder="Password">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Confirm Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="password_confirmation" id="regConfirmPassword" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                                placeholder="Confirm Password">
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-4 bg-green-500 text-white font-bold rounded-xl hover:bg-green-600 shadow-lg shadow-green-200 transition-all transform hover:-translate-y-0.5 mt-2">
                    Create Account
                </button>
                <p id="passwordError" class="text-red-500 text-sm hidden">Passwords do not match!</p>

            </form>

            <div class="mt-4 text-center border-t border-gray-100 pt-4">
                <p class="text-gray-600">Already have an account?
                    <a href="/login" class="font-bold text-green-600 hover:text-green-700">Login Now</a>
                </p>
                <div class="mt-4">
                    <a href="/guest" class="text-base font-bold text-green-600 hover:text-green-700 transition-colors">
                        Continue as Guest
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const regionData = {
            'Dhaka': ['Mirpur', 'Dhanmondi', 'Uttara', 'Gulshan', 'Banani', 'Mohammadpur', 'Tejgaon', 'Motijheel', 'Paltan', 'Savar', 'Keraniganj', 'Dohar'],
            'Chittagong': ["Cox's Bazar", 'Panchlaish', 'Halishahar', 'Pahartali', 'Chandgaon', 'Sitakunda', 'Rangunia', 'Sandwip', 'Mirsharai', 'Boalkhali'],
            'Sylhet': ['Zindabazar', 'Amberkhana', 'Tilagor', 'Noyashahar', 'Kumarpara', 'Moglabazar', 'Gowainghat', 'Beanibazar', 'Balaganj', 'Fenchuganj'],
            'Barisal': ['Sadatpur', 'Amtali', 'Agailjhara', 'Babuganj', 'Bakerganj', 'Banaripara', 'Gournadi', 'Hizla', 'Mehendiganj', 'Muladi', 'Wazirpur'],
            'Rangpur': ['Modern More', 'Kaunia', 'Gangachara', 'Pirgachha', 'Badarganj', 'Mithapukur', 'Pirganj', 'Rangpur Sadar', 'Taraganj', 'Pirgachha'],
            'Rajshahi': ['Motihar', 'Boalia', 'Paba', 'Durgapur', 'Bagha', 'Bagmara', 'Charghat', 'Godagari', 'Tanore', 'Puthia', 'Mohonpur'],
            'Khulna': ['Boyra', 'Khalishpur', 'Sonadanga', 'Daulatpur', 'Dumuria', 'Dighalia', 'Batiaghata', 'Phultala', 'Rupsha', 'Terokhada', 'Paikgachha']
        };

        function setupDropdown(buttonId, menuId, labelId, inputId, optionClass, onSelect) {
            const button = document.getElementById(buttonId);
            const menu = document.getElementById(menuId);
            const label = document.getElementById(labelId);
            const input = document.getElementById(inputId);

            button.addEventListener('click', (e) => {
                e.stopPropagation();
                document.querySelectorAll('[id$="Menu"]').forEach(m => {
                    if (m.id !== menuId) m.classList.add('hidden');
                });
                menu.classList.toggle('hidden');
            });

            menu.addEventListener('click', (e) => {
                const option = e.target.closest('.' + optionClass);
                if (option) {
                    const value = option.getAttribute('data-value');
                    label.textContent = value;
                    input.value = value;
                    menu.classList.add('hidden');
                    if (onSelect) onSelect(value);
                }
            });
        }

        document.addEventListener('click', () => {
            document.querySelectorAll('[id$="Menu"]').forEach(m => m.classList.add('hidden'));
        });

        const divisionSelect = document.querySelector('select[name="city"]');

        divisionSelect.addEventListener('change', function () {

            const division = this.value;
            const regionOptionsList = document.getElementById('regionOptionsList');
            const regions = regionData[division] || [];

            document.getElementById('regionLabel').textContent = 'Select Region';
            document.getElementById('regionInput').value = '';

            if (regions.length > 0) {
                regionOptionsList.innerHTML = regions.map(region => `
            <div class="region-option px-4 py-2 hover:bg-green-50 rounded-lg cursor-pointer transition text-gray-700" data-value="${region}">
                ${region}
            </div>
        `).join('');
            } else {
                regionOptionsList.innerHTML =
                    '<div class="px-4 py-2 text-gray-400 text-sm">No regions available</div>';
            }

        });

        setupDropdown('regionButton', 'regionMenu', 'regionLabel', 'regionInput', 'region-option');

        function validatePasswords() {
            const pass = document.getElementById('regPassword').value;
            const confirm = document.getElementById('regConfirmPassword').value;
            const errorElement = document.getElementById('passwordError');

            if (pass.length < 6) {
                errorElement.textContent = "Password must be at least 6 characters";
                errorElement.classList.remove('hidden');
                return false;
            }
            if (pass !== confirm) {
                errorElement.textContent = "Passwords do not match";
                errorElement.classList.remove('hidden');
                return false;
            }
            errorElement.classList.add('hidden');
            return true;
        }
    </script>
    <script>
        function redirectIfLoggedIn() {
            const token = localStorage.getItem("token");

            if (token) {
                window.location.replace("/");
            }
        }

        document.addEventListener("DOMContentLoaded", redirectIfLoggedIn);
        window.addEventListener("pageshow", redirectIfLoggedIn);
    </script>
</body>

</html>