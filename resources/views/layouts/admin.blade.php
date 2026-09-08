<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: false }" @keydown.window.escape="sidebarOpen = false">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') – Gym Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
</head>
<body class="bg-gray-900 text-white font-sans">
<!-- Mobile top bar removed to avoid duplicate header -->

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="bg-gray-800 w-64 hidden md:block flex-shrink-0" x-show="sidebarOpen" @click.away="sidebarOpen = false">
            <div class="p-4 flex items-center justify-between">
                <h2 class="text-xl font-bold text-red-500">Gym Admin</h2>
                <button @click="sidebarOpen = false" class="text-gray-400 md:hidden">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <nav class="mt-4 space-y-2">
                <x-admin-nav-link href="{{ route('admin.dashboard') }}" icon="home" :active="request()->routeIs('admin.dashboard')">Overview</x-admin-nav-link>
                <x-admin-nav-link href="{{ route('admin.branches.index') }}" icon="building" :active="request()->routeIs('admin.branches.*')">Branches</x-admin-nav-link>
                <x-admin-nav-link href="{{ route('admin.membership-plans.index') }}" icon="clipboard-list" :active="request()->routeIs('admin.membership-plans.*')">Membership Plans</x-admin-nav-link>
                <x-admin-nav-link href="{{ route('admin.gym-classes.index') }}" icon="calendar" :active="request()->routeIs('admin.gym-classes.*')">Classes</x-admin-nav-link>
                <x-admin-nav-link href="{{ route('admin.trainers.index') }}" icon="user-group" :active="request()->routeIs('admin.trainers.*')">Team</x-admin-nav-link>
                <x-admin-nav-link href="{{ route('admin.partners.index') }}" icon="handshake" :active="request()->routeIs('admin.partners.*')">Partners</x-admin-nav-link>
                <x-admin-nav-link href="{{ route('admin.subscriptions.index') }}" icon="receipt-tax" :active="request()->routeIs('admin.subscriptions.*')">Subscriptions</x-admin-nav-link>
                <x-admin-nav-link href="{{ route('admin.members.index') }}" icon="users" :active="request()->routeIs('admin.members.*')">Clients</x-admin-nav-link>
                <x-admin-nav-link href="{{ route('admin.users.index') }}" icon="user-circle" :active="request()->routeIs('admin.users.*')">Users</x-admin-nav-link>
                <x-admin-nav-link href="{{ route('admin.franchise-applications.index') }}" icon="office-building" :active="request()->routeIs('admin.franchise-applications.*')">Franchise Applications</x-admin-nav-link>
                <x-admin-nav-link href="{{ route('admin.contact-messages.index') }}" icon="mail" :active="request()->routeIs('admin.contact-messages.*')">Contact Messages</x-admin-nav-link>
            </nav>
        </aside>

        <!-- Main content -->
        <main class="flex-1 overflow-y-auto p-6">
            <header class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold">@yield('title', 'Dashboard')</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-300">{{ Auth::user()->name }}</span>
                    <a href="{{ route('logout') }}" class="text-gray-300 hover:text-white">Logout</a>
                </div>
            </header>
            @if (session('success'))
                <div class="bg-green-600 text-white p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>
    <!-- Confirmation modal (Alpine.js) -->
    <div x-data="{ show:false, message:'', form:'' }" x-show="show" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-gray-800 p-6 rounded shadow-lg w-96">
            <p class="mb-4" x-text="message"></p>
            <form :action="form" method="POST" x-ref="form">
                @csrf
                @method('DELETE')
                <div class="flex justify-end space-x-3">
                    <button type="button" @click="show=false" class="px-4 py-2 bg-gray-600 rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 rounded">Delete</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        // Global helper for delete confirmation links
        document.addEventListener('click', function (e) {
            if (e.target.matches('[data-confirm]')) {
                e.preventDefault();
                const modal = e.target.closest('[x-data]').__x;
                modal.message = e.target.dataset.confirmMessage || 'Are you sure?';
                modal.form = e.target.getAttribute('href');
                modal.show = true;
            }
        });
    </script>
</body>
</html>
