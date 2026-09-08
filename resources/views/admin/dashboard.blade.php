@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
    <div class="bg-gray-800 p-4 rounded border border-gray-700">
        <h2 class="text-sm font-medium text-gray-400">Total Members</h2>
        <p class="text-2xl font-semibold text-white mt-1">{{ $totalMembers }}</p>
    </div>
    <a href="{{ route('admin.branches.index') }}" class="bg-gray-800 hover:bg-gray-750 p-4 rounded border border-gray-700 transition group block">
        <div class="flex items-center justify-between">
            <h2 class="text-sm font-medium text-gray-400 group-hover:text-white">Branches</h2>
            <span class="text-xs text-red-400">View All &rarr;</span>
        </div>
        <p class="text-2xl font-semibold text-white mt-1">{{ $totalBranches }}</p>
    </a>
    <div class="bg-gray-800 p-4 rounded border border-gray-700">
        <h2 class="text-sm font-medium text-gray-400">Active Subscriptions</h2>
        <p class="text-2xl font-semibold text-white mt-1">{{ $activeSubscriptions }}</p>
    </div>
    <div class="bg-gray-800 p-4 rounded border border-gray-700">
        <h2 class="text-sm font-medium text-gray-400">Total Revenue</h2>
        <p class="text-2xl font-semibold text-white mt-1">${{ number_format($totalRevenue, 2) }}</p>
    </div>
    <div class="bg-gray-800 p-4 rounded border border-gray-700">
        <h2 class="text-sm font-medium text-gray-400">Pending Franchises</h2>
        <p class="text-2xl font-semibold text-white mt-1">{{ $pendingFranchise }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="lg:col-span-2 bg-gray-800 p-5 rounded-lg border border-gray-700">
        <h2 class="text-lg font-medium mb-4 text-white">Revenue (Last 6 Months)</h2>
        <!-- تمرير البيانات عبر data attributes لتجنب أخطاء Syntax داخل السكربت -->
        <canvas id="revenueChart"
                data-labels='@json($monthlyLabels)'
                data-revenue='@json($monthlyRevenue)'
                class="w-full h-64"></canvas>
    </div>

    <!-- Quick Branches Preview -->
    <div class="bg-gray-800 p-5 rounded-lg border border-gray-700 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-medium text-white">Branches Overview</h2>
                <a href="{{ route('admin.branches.create') }}" class="text-xs bg-red-600 hover:bg-red-500 text-white px-2.5 py-1 rounded transition">
                    + Add
                </a>
            </div>

            <div class="space-y-3">
                @forelse($dashboardBranches as $b)
                    <div class="flex items-center justify-between p-2.5 rounded bg-gray-700/50 hover:bg-gray-700 transition">
                        <div class="flex items-center gap-3">
                            <img src="{{ $b->image_url }}" alt="{{ $b->name }}" class="w-10 h-10 object-cover rounded shrink-0">
                            <div>
                                <div class="text-sm font-medium text-white">{{ $b->name }}</div>
                                <div class="text-xs text-gray-400">{{ $b->city }} &bull; {{ $b->members_count ?? 0 }} members</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs px-2 py-0.5 rounded {{ $b->is_active ? 'bg-green-900/60 text-green-300' : 'bg-red-900/60 text-red-300' }}">
                                {{ $b->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <a href="{{ route('admin.branches.edit', $b) }}" class="text-xs text-blue-400 hover:underline">
                                Edit
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 py-4 text-center">No branches added yet.</p>
                @endforelse
            </div>
        </div>

        <div class="pt-4 mt-4 border-t border-gray-700 text-right">
            <a href="{{ route('admin.branches.index') }}" class="text-xs text-red-400 hover:text-red-300 font-medium">
                View & Manage All Branches &rarr;
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const canvas = document.getElementById('revenueChart');
        if (!canvas) {
            console.error('revenueChart canvas element not found.');
            return;
        }

        if (typeof Chart === 'undefined') {
            console.error('Chart.js library is not loaded or undefined.');
            return;
        }

        // قراءة البيانات الممررة من الـ Canvas مباشرة
        const labelsData = JSON.parse(canvas.dataset.labels || '[]');
        const revenueData = JSON.parse(canvas.dataset.revenue || '[]');

        const ctx = canvas.getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labelsData,
                datasets: [{
                    label: 'Revenue',
                    data: revenueData,
                    borderColor: '#e11d48',
                    backgroundColor: 'rgba(225,29,72,0.2)',
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });
</script>
@endsection
