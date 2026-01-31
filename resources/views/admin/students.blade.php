@extends('admin.layout')

@section('title', 'Students Management')

@section('content')


<!-- Filters Section -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 mb-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-semibold text-gray-700 dark:text-gray-300 text-lg">Filter Students</h3>
        <button type="button" 
                onclick="toggleAdvancedFilters()"
                class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 text-sm font-medium flex items-center gap-2">
            <span id="toggleText">Show Advanced</span>
            <i id="toggleIcon" class="fas fa-chevron-down transition-transform"></i>
        </button>
    </div>
    
    <form method="GET" id="filterForm" class="space-y-6">
        <!-- Basic Filters -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Name, email, phone..."
                           class="w-full px-4 py-2.5 pl-10 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400 dark:focus:border-primary-400">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
            
            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                <select name="status" 
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400 dark:focus:border-primary-400">
                    <option value="">All Status</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="not_taken" {{ request('status') == 'not_taken' ? 'selected' : '' }}>Not Taken</option>
                </select>
            </div>
            
            <!-- Branch -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Branch</label>
                <select name="branch" 
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-border-primary-500 dark:focus:ring-primary-400 dark:focus:border-primary-400">
                    <option value="">All Branches</option>
                    @foreach($branches ?? [] as $branch)
                        <option value="{{ $branch }}" {{ request('branch') == $branch ? 'selected' : '' }}>
                            {{ $branch }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Level -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Level</label>
                <select name="level" 
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400 dark:focus:border-primary-400">
                    <option value="">All Levels</option>
                    <option value="Beginner" {{ request('level') == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                    <option value="Elementary" {{ request('level') == 'Elementary' ? 'selected' : '' }}>Elementary</option>
                    <option value="Intermediate" {{ request('level') == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                    <option value="Upper Intermediate" {{ request('level') == 'Upper Intermediate' ? 'selected' : '' }}>Upper Intermediate</option>
                    <option value="Advanced" {{ request('level') == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                </select>
            </div>
        </div>
        
        <!-- Advanced Filters -->
        <div id="advancedFilters" class="hidden space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Score Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Score Range</label>
                    <div class="flex items-center gap-2">
                        <input type="number" 
                               name="min_score" 
                               value="{{ request('min_score') }}"
                               placeholder="Min"
                               min="0" max="100"
                               class="flex-1 px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                        <span class="text-gray-500">to</span>
                        <input type="number" 
                               name="max_score" 
                               value="{{ request('max_score') }}"
                               placeholder="Max"
                               min="0" max="100"
                               class="flex-1 px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                    </div>
                </div>
                
                <!-- Date Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Registration Date</label>
                    <div class="flex items-center gap-2">
                        <input type="date" 
                               name="from_date" 
                               value="{{ request('from_date') }}"
                               class="flex-1 px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                        <span class="text-gray-500">to</span>
                        <input type="date" 
                               name="to_date" 
                               value="{{ request('to_date') }}"
                               class="flex-1 px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                    </div>
                </div>
                
                <!-- Sort Options -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sort By</label>
                    <div class="flex gap-2">
                        <select name="sort" 
                                class="flex-1 px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                            <option value="created_at" {{ request('sort', 'created_at') == 'created_at' ? 'selected' : '' }}>Registration Date</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                            <option value="score" {{ request('sort') == 'score' ? 'selected' : '' }}>Score</option>
                            <option value="level" {{ request('sort') == 'level' ? 'selected' : '' }}>Level</option>
                        </select>
                        <select name="order" 
                                class="w-32 px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                            <option value="desc" {{ request('order', 'desc') == 'desc' ? 'selected' : '' }}>Descending</option>
                            <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
            <button type="submit" 
                    class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-300 flex items-center justify-center gap-2">
                <i class="fas fa-filter"></i>
                Apply Filters
            </button>
            
            <a href="{{ route('admin.students') }}"
               class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 px-6 py-3 rounded-lg font-medium text-center transition-colors duration-300">
                Reset All
            </a>
            
            @if(($students->count() ?? 0) > 0)
            <div class="flex-1 flex justify-end gap-3">
                <a href="{{ route('admin.students.pdf') . '?' . http_build_query(request()->query()) }}"
                   target="_blank"
                   class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-300 flex items-center justify-center gap-2">
                    <i class="fas fa-file-pdf"></i>
                    Export PDF
                </a>
                
                <a href="{{ route('admin.students.export') . '?' . http_build_query(request()->query()) }}"
                   class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-300 flex items-center justify-center gap-2">
                    <i class="fas fa-file-csv"></i>
                    Export CSV
                </a>
            </div>
            @endif
        </div>
    </form>
    
    <!-- Active Filters Display -->
    @if(request()->anyFilled(['status', 'branch', 'level', 'search', 'min_score', 'max_score', 'from_date', 'to_date']))
    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex flex-wrap gap-2">
                <span class="text-sm text-gray-600 dark:text-gray-400">Active filters:</span>
                @foreach(request()->except(['page']) as $key => $value)
                    @if(!empty($value))
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-400 text-xs">
                        {{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}
                        <button type="button" 
                                onclick="removeFilter('{{ $key }}')"
                                class="ml-1 hover:text-primary-900 dark:hover:text-primary-300">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </span>
                    @endif
                @endforeach
            </div>
            <div class="text-sm text-gray-600 dark:text-gray-400">
                {{ $students->total() ?? 0 }} students found
            </div>
        </div>
    </div>
    @endif
</div>



<!-- Students Table -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h3 class="font-semibold text-gray-700 dark:text-gray-300">Students List</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Student</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Branch</th>
                    <th class="px6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Score</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Level</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($students ?? [] as $index => $student)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                        {{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}
                    </td>
                    
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900 dark:text-white">{{ $student->name ?? 'N/A' }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $student->email ?? 'N/A' }}</div>
                        @if($student->phone)
                        <div class="text-xs text-gray-400 dark:text-gray-500">{{ $student->phone }}</div>
                        @endif
                    </td>
                    
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400">
                            {{ $student->branch ?? '-' }}
                        </span>
                    </td>
                    
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($student->latestCompletedAttempt)
                            <div class="text-center">
                                <span class="font-bold text-lg text-gray-900 dark:text-white">
                                    {{ $student->latestCompletedAttempt->score ?? 0 }}
                                </span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">/100</span>
                            </div>
                        @else
                            <span class="text-gray-400 dark:text-gray-500">-</span>
                        @endif
                    </td>
                    
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($student->latestCompletedAttempt)
                            <span class="px-3 py-1 text-xs rounded-full 
                                @if(($student->latestCompletedAttempt->level ?? '') == 'Advanced') 
                                    bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-400
                                @elseif(($student->latestCompletedAttempt->level ?? '') == 'Intermediate')
                                    bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400
                                @else
                                    bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400
                                @endif">
                                {{ $student->latestCompletedAttempt->level ?? '-' }}
                            </span>
                        @else
                            <span class="text-gray-400 dark:text-gray-500">-</span>
                        @endif
                    </td>
                    
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($student->completed_test_attempts_count > 0)
                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 font-medium">
                                Completed
                            </span>
                        @elseif($student->inProgressTestAttempt)
                            <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 font-medium">
                                In Progress
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs rounded-full bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 font-medium">
                                Not Taken
                            </span>
                        @endif
                    </td>
                    
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        @if($student->latestCompletedAttempt)
                            {{ optional($student->latestCompletedAttempt->completed_at)->format('d M Y') ?? '-' }}
                        @else
                            {{ $student->created_at->format('d M Y') }}
                        @endif
                    </td>
                    
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="flex items-center gap-2">
                            <button onclick="viewStudent({{ $student->id }})" 
                                    class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors"
                                    title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button onclick="editStudent({{ $student->id }})" 
                                    class="p-2 text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/30 rounded-lg transition-colors"
                                    title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteStudent({{ $student->id }})" 
                                    class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors"
                                    title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center">
                        <div class="text-gray-400 dark:text-gray-500">
                            <i class="fas fa-user-slash text-4xl mb-4"></i>
                            <p class="text-lg font-medium">No students found</p>
                            <p class="text-sm mt-1">Try adjusting your filters or add new students</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if(($students->hasPages() ?? false) && ($students->total() ?? 0) > 0)
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-4">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="text-sm text-gray-600 dark:text-gray-400">
            Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} entries
        </div>
        
        <div class="flex items-center gap-2">
            <!-- Previous Button -->
            @if($students->onFirstPage())
                <span class="px-4 py-2 text-gray-400 dark:text-gray-600 border border-gray-300 dark:border-gray-700 rounded-lg cursor-not-allowed">
                    <i class="fas fa-chevron-left mr-2"></i> Previous
                </span>
            @else
                <a href="{{ $students->previousPageUrl() }}" 
                   class="px-4 py-2 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-chevron-left mr-2"></i> Previous
                </a>
            @endif
            
            <!-- Page Numbers -->
            @php
                $current = $students->currentPage();
                $last = $students->lastPage();
                $start = max(1, $current - 2);
                $end = min($last, $current + 2);
            @endphp
            
            @if($start > 1)
                <a href="{{ $students->url(1) }}" 
                   class="px-3 py-2 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    1
                </a>
                @if($start > 2)
                    <span class="px-2 text-gray-500">...</span>
                @endif
            @endif
            
            @for($page = $start; $page <= $end; $page++)
                @if($page == $current)
                    <span class="px-3 py-2 bg-primary-500 text-white border border-primary-500 rounded-lg">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $students->url($page) }}" 
                       class="px-3 py-2 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        {{ $page }}
                    </a>
                @endif
            @endfor
            
            @if($end < $last)
                @if($end < $last - 1)
                    <span class="px-2 text-gray-500">...</span>
                @endif
                <a href="{{ $students->url($last) }}" 
                   class="px-3 py-2 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    {{ $last }}
                </a>
            @endif
            
            <!-- Next Button -->
            @if($students->hasMorePages())
                <a href="{{ $students->nextPageUrl() }}" 
                   class="px-4 py-2 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Next <i class="fas fa-chevron-right ml-2"></i>
                </a>
            @else
                <span class="px-4 py-2 text-gray-400 dark:text-gray-600 border border-gray-300 dark:border-gray-700 rounded-lg cursor-not-allowed">
                    Next <i class="fas fa-chevron-right ml-2"></i>
                </span>
            @endif
        </div>
    </div>
</div>
@endif

<script>
// Students page specific JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize filters
    window.toggleAdvancedFilters = function() {
        const advancedFilters = document.getElementById('advancedFilters');
        const toggleText = document.getElementById('toggleText');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (advancedFilters.classList.contains('hidden')) {
            advancedFilters.classList.remove('hidden');
            toggleText.textContent = 'Hide Advanced';
            toggleIcon.classList.add('rotate-180');
        } else {
            advancedFilters.classList.add('hidden');
            toggleText.textContent = 'Show Advanced';
            toggleIcon.classList.remove('rotate-180');
        }
    };
    
    // Auto-submit filters on change (except search)
    document.querySelectorAll('select[name], input[name="from_date"], input[name="to_date"]').forEach(element => {
        element.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });
    
    // Debounced search
    let searchTimeout;
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 800);
        });
    }
    
    // Remove filter
    window.removeFilter = function(filterName) {
        const url = new URL(window.location);
        url.searchParams.delete(filterName);
        url.searchParams.set('page', '1');
        window.location.href = url.toString();
    };
    
    // Student actions
    window.viewStudent = function(id) {
        // Implement view student modal
        alert('View student ' + id);
    };
    
    window.editStudent = function(id) {
        // Implement edit student
        window.location.href = `/admin/students/${id}/edit`;
    };
    
    window.deleteStudent = function(id) {
        if (confirm('Are you sure you want to delete this student?')) {
            // Implement delete
            fetch(`/admin/students/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    window.location.reload();
                }
            });
        }
    };
});
</script>
@endsection