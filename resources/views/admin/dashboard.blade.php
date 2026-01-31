@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="p-3 bg-gradient-to-r from-primary-500 to-blue-500 rounded-xl shadow-lg">
                    <i class="fas fa-tachometer-alt text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 dark:text-white">
                        Dashboard Overview
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        Welcome back, <span class="font-semibold text-primary-600 dark:text-primary-400">{{ auth()->user()->name ?? 'Admin' }}</span>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="flex flex-wrap items-center gap-3">
            <div class="bg-white dark:bg-gray-800 px-4 py-2 rounded-lg shadow border border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <i class="far fa-calendar-alt text-primary-500"></i>
                    <span class="text-sm font-medium">{{ now()->format('l, F j, Y') }}</span>
                </div>
            </div>
            
            <button onclick="toggleTheme()" 
                    class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                <i class="fas fa-moon dark:hidden"></i>
                <i class="fas fa-sun hidden dark:inline"></i>
            </button>
        </div>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Students -->
    <div class="card-hover bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-medium mb-1">Total Students</p>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['total_students'] ?? 0 }}</h2>
            </div>
            <div class="p-3 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/30 dark:to-blue-800/30 rounded-xl">
                <i class="fas fa-user-graduate text-2xl text-blue-600 dark:text-blue-400"></i>
            </div>
        </div>
        <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-500 dark:text-gray-400">Recent growth</span>
                <span class="font-semibold text-green-600 dark:text-green-400">
                    <i class="fas fa-arrow-up mr-1"></i>
                    +{{ $stats['recent_growth'] ?? 0 }} this week
                </span>
            </div>
        </div>
    </div>

    <!-- Total Kids -->
    <div class="card-hover bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-medium mb-1">Total Kids</p>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['kids']['total'] ?? 0 }}</h2>
            </div>
            <div class="p-3 bg-gradient-to-br from-purple-100 to-purple-200 dark:from-purple-900/30 dark:to-purple-800/30 rounded-xl">
                <i class="fas fa-child text-2xl text-purple-600 dark:text-purple-400"></i>
            </div>
        </div>
        <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-500 dark:text-gray-400">Recent growth</span>
                <span class="font-semibold text-green-600 dark:text-green-400">
                    <i class="fas fa-arrow-up mr-1"></i>
                    +{{ $stats['recent_kids_growth'] ?? 0 }} this week
                </span>
            </div>
        </div>
    </div>

    <!-- Completed Tests -->
    <div class="card-hover bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-medium mb-1">Completed Tests</p>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['completed_tests'] ?? 0 }}</h2>
            </div>
            <div class="p-3 bg-gradient-to-br from-green-100 to-green-200 dark:from-green-900/30 dark:to-green-800/30 rounded-xl">
                <i class="fas fa-check-circle text-2xl text-green-600 dark:text-green-400"></i>
            </div>
        </div>
        <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-500 dark:text-gray-400">Completion Rate</span>
                <span class="font-semibold {{ ($stats['completion_rate'] ?? 0) > 70 ? 'text-green-600 dark:text-green-400' : (($stats['completion_rate'] ?? 0) > 40 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
                    {{ $stats['completion_rate'] ?? 0 }}%
                </span>
            </div>
        </div>
    </div>

    <!-- Pending Tests -->
    <div class="card-hover bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-medium mb-1">Pending Tests</p>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['pending_tests'] ?? 0 }}</h2>
            </div>
            <div class="p-3 bg-gradient-to-br from-orange-100 to-orange-200 dark:from-orange-900/30 dark:to-orange-800/30 rounded-xl">
                <i class="fas fa-clock text-2xl text-orange-600 dark:text-orange-400"></i>
            </div>
        </div>
    </div>
</div>

<!-- Kids Performance -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Kids Completed Tests -->
    <div class="card-hover bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
            <i class="fas fa-star text-primary-500"></i>
            Kids Completed Tests
        </h3>
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-4xl font-bold text-gray-800 dark:text-white">{{ $stats['kids']['completed_tests'] ?? 0 }}</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Out of {{ $stats['kids']['total'] ?? 0 }} kids</p>
            </div>
            <div class="p-4 bg-gradient-to-br from-pink-100 to-pink-200 dark:from-pink-900/30 dark:to-pink-800/30 rounded-xl">
                <i class="fas fa-medal text-3xl text-pink-600 dark:text-pink-400"></i>
            </div>
        </div>
        <div class="space-y-2">
            @php
                $kidsCompletionRate = ($stats['kids']['total'] ?? 0) > 0 
                    ? round((($stats['kids']['completed_tests'] ?? 0) / ($stats['kids']['total'] ?? 1)) * 100, 1)
                    : 0;
            @endphp
            <div class="flex justify-between text-sm">
                <span class="text-gray-600 dark:text-gray-400">Completion Rate</span>
                <span class="font-semibold {{ $kidsCompletionRate > 70 ? 'text-green-600 dark:text-green-400' : ($kidsCompletionRate > 40 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
                    {{ $kidsCompletionRate }}%
                </span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div class="bg-gradient-to-r from-pink-400 to-pink-600 h-2 rounded-full" 
                     style="width: {{ $kidsCompletionRate }}%"></div>
            </div>
        </div>
    </div>

    <!-- Kids Pending Tests -->
    <div class="card-hover bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
            <i class="fas fa-hourglass-half text-yellow-500"></i>
            Kids Pending Tests
        </h3>
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-4xl font-bold text-gray-800 dark:text-white">{{ $stats['kids']['pending_tests'] ?? 0 }}</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Needs attention</p>
            </div>
            <div class="p-4 bg-gradient-to-br from-amber-100 to-amber-200 dark:from-amber-900/30 dark:to-amber-800/30 rounded-xl">
                <i class="fas fa-exclamation-triangle text-3xl text-amber-600 dark:text-amber-400"></i>
            </div>
        </div>
        <div class="space-y-2">
            @php
                $kidsPendingRate = ($stats['kids']['total'] ?? 0) > 0 
                    ? round((($stats['kids']['pending_tests'] ?? 0) / ($stats['kids']['total'] ?? 1)) * 100, 1)
                    : 0;
            @endphp
            <div class="flex justify-between text-sm">
                <span class="text-gray-600 dark:text-gray-400">Pending Rate</span>
                <span class="font-semibold {{ $kidsPendingRate > 50 ? 'text-red-600 dark:text-red-400' : ($kidsPendingRate > 20 ? 'text-yellow-600 dark:text-yellow-400' : 'text-green-600 dark:text-green-400') }}">
                    {{ $kidsPendingRate }}%
                </span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div class="bg-gradient-to-r from-amber-400 to-amber-600 h-2 rounded-full" 
                     style="width: {{ $kidsPendingRate }}%"></div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="card-hover bg-white dark:bg-gray-800 p-5 rounded-xl shadow border border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-gradient-to-br from-indigo-100 to-indigo-200 dark:from-indigo-900/30 dark:to-indigo-800/30 rounded-lg">
                <i class="fas fa-building text-indigo-600 dark:text-indigo-400"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total Branches</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['branch_count'] ?? 0 }}</p>
            </div>
        </div>
    </div>
    
    <div class="card-hover bg-white dark:bg-gray-800 p-5 rounded-xl shadow border border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-gradient-to-br from-yellow-100 to-yellow-200 dark:from-yellow-900/30 dark:to-yellow-800/30 rounded-lg">
                <i class="fas fa-calendar-day text-yellow-600 dark:text-yellow-400"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Today's Tests</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['today_tests'] ?? 0 }}</p>
            </div>
        </div>
    </div>
    
    <div class="card-hover bg-white dark:bg-gray-800 p-5 rounded-xl shadow border border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/30 dark:to-blue-800/30 rounded-lg">
                <i class="fas fa-trophy text-blue-600 dark:text-blue-400"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Advanced Students</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['score_distribution']['advanced'] ?? 0 }}</p>
            </div>
        </div>
    </div>
    
    <div class="card-hover bg-white dark:bg-gray-800 p-5 rounded-xl shadow border border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-gradient-to-br from-green-100 to-green-200 dark:from-green-900/30 dark:to-green-800/30 rounded-lg">
                <i class="fas fa-chart-line text-green-600 dark:text-green-400"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Intermediate</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['score_distribution']['intermediate'] ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

<script>
// Dashboard specific JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltips = document.querySelectorAll('[data-tooltip]');
    tooltips.forEach(element => {
        element.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'absolute z-50 px-3 py-2 text-sm bg-gray-900 text-white rounded-lg shadow-lg';
            tooltip.textContent = this.dataset.tooltip;
            document.body.appendChild(tooltip);
            
            const rect = this.getBoundingClientRect();
            tooltip.style.top = `${rect.top - tooltip.offsetHeight - 10}px`;
            tooltip.style.left = `${rect.left + rect.width / 2 - tooltip.offsetWidth / 2}px`;
            
            this._tooltip = tooltip;
        });
        
        element.addEventListener('mouseleave', function() {
            if (this._tooltip) {
                this._tooltip.remove();
            }
        });
    });
    

</script>
@endsection