<!DOCTYPE html>
<html lang="en" x-data="{ mobileSidebarOpen: false }" @keydown.window.escape="mobileSidebarOpen = false">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') – Gym Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-900 text-white font-sans">

    <div class="flex min-h-screen">
        <!-- Mobile backdrop overlay -->
        <div x-show="mobileSidebarOpen"
            x-cloak
            @click="mobileSidebarOpen = false"
            class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"></div>

        <!-- Sidebar -->
        <aside :class="mobileSidebarOpen ? 'fixed inset-y-0 left-0 z-50 flex flex-col' : 'hidden md:flex md:flex-col'"
            class="bg-gray-800 w-64 flex-shrink-0">
            <div class="p-4 flex items-center justify-between">
                <h2 class="text-xl font-bold text-red-500">Gym Admin</h2>
                <button @click="mobileSidebarOpen = false" class="text-gray-400 hover:text-white md:hidden" aria-label="Close sidebar">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="mt-4 space-y-2 flex-1 overflow-y-auto">
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
            <div class="p-4 border-t border-gray-700">
                <a href="{{ route('home') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-400 hover:text-white bg-gray-900/40 hover:bg-gray-700 rounded transition">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    <span>Visit Website</span>
                </a>
            </div>
        </aside>

        <!-- Main content -->
        <main class="flex-1 overflow-y-auto p-6">
            <header class="flex justify-between items-center mb-6">
                <div class="flex items-center space-x-3">
                    <button @click="mobileSidebarOpen = !mobileSidebarOpen" class="text-gray-400 hover:text-white focus:outline-none md:hidden" aria-label="Open sidebar">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="text-2xl font-semibold">@yield('title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-800 hover:bg-gray-700 text-gray-200 hover:text-white text-sm rounded border border-gray-700 transition">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        <span>View Website</span>
                    </a>
                    <span class="text-gray-300">{{ Auth::user()->name }}</span>
                    <a href="{{ route('logout') }}" class="text-gray-300 hover:text-white">Logout</a>
                </div>
            </header>

            @if (session('success'))
            <div class="bg-green-600/90 border border-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif
            @if (session('error'))
            <div class="bg-red-600/90 border border-red-500 text-white p-3 rounded mb-4">
                {{ session('error') }}
            </div>
            @endif
            @if ($errors->any())
            <div class="bg-red-600/90 border border-red-500 text-white p-4 rounded mb-4">
                <p class="font-bold mb-1">Please fix the following errors:</p>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Confirmation modal (Alpine.js) -->
    <div x-data="{ show: false, message: '', formUrl: '' }"
        x-show="show"
        x-cloak
        id="delete-modal"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-gray-800 p-6 rounded shadow-lg w-96">
            <p class="mb-4 text-white" x-text="message"></p>
            <form :action="formUrl" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end space-x-3">
                    <button type="button" @click="show = false" class="px-4 py-2 bg-gray-600 hover:bg-gray-500 rounded text-white">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded text-white">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('click', function(e) {
            const target = e.target.closest('[data-confirm]');
            if (target) {
                e.preventDefault();
                const modalEl = document.getElementById('delete-modal');
                if (modalEl && window.Alpine) {
                    const data = Alpine.$data(modalEl);
                    data.message = target.dataset.confirmMessage || 'Are you sure you want to delete this item?';
                    data.formUrl = target.dataset.confirmAction || target.getAttribute('href');
                    data.show = true;
                }
            }
        });
    </script>
</body>

</html>
