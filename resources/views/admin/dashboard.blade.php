@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-gray-800 p-4 rounded">
        <h2 class="text-sm font-medium text-gray-400">Total Members</h2>
        <p class="text-2xl font-semibold text-white">{{ $totalMembers }}</p>
    </div>
    <div class="bg-gray-800 p-4 rounded">
        <h2 class="text-sm font-medium text-gray-400">Active Subscriptions</h2>
        <p class="text-2xl font-semibold text-white">{{ $activeSubscriptions }}</p>
    </div>
    <div class="bg-gray-800 p-4 rounded">
        <h2 class="text-sm font-medium text-gray-400">Total Revenue</h2>
        <p class="text-2xl font-semibold text-white">${{ number_format($totalRevenue, 2) }}</p>
    </div>
    <div class="bg-gray-800 p-4 rounded">
        <h2 class="text-sm font-medium text-gray-400">Pending Franchises</h2>
        <p class="text-2xl font-semibold text-white">{{ $pendingFranchise }}</p>
    </div>
</div>

<div class="bg-gray-800 p-4 rounded">
    <h2 class="text-lg font-medium mb-4">Revenue (Last 6 Months)</h2>
    <canvas id="revenueChart" class="w-full h-64"></canvas>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($monthlyLabels),
                datasets: [{
                    label: 'Revenue',
                    data: @json($monthlyRevenue),
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
