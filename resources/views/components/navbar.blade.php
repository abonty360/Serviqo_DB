<nav class="flex items-center justify-between px-8 py-4 bg-white border-b sticky top-0 z-50">
    <a href="/" class="flex items-center space-x-2 hover:opacity-80 transition cursor-pointer">
        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
            <i class="fas fa-tools text-white text-xl"></i>
        </div>
        <span class="text-2xl font-bold text-gray-900 tracking-tight">Serviqo</span>
    </a>
    <div class="hidden md:flex ml-auto space-x-10 font-medium text-gray-600">
        <a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'text-green-600' : 'hover:text-green-600' }} transition">Services</a>
        <a href="#" class="hover:text-green-600 transition">How it Works</a>
    </div>
    <div class="flex space-x-4" id="authButtons"></div>
</nav>
<script src="{{ asset('js/navbar.js') }}"></script>