@extends('admin.layout')

@section('title', 'Activities Management')

@section('content')
<!-- Alerts -->
@if(session('success'))
<div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 rounded-lg">
    <div class="flex items-center">
        <i class="fas fa-check-circle text-green-500 mr-3"></i>
        <div>
            <p class="font-medium text-green-800 dark:text-green-400">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

@if($errors->any())
<div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 rounded-lg">
    <div class="flex items-center">
        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
        <div>
            <p class="font-medium text-red-800 dark:text-red-400 mb-2">Please fix the following errors:</p>
            <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-300">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<!-- Tabs Navigation -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 mb-6">
    <div class="border-b border-gray-200 dark:border-gray-700">
        <div class="flex">
            <button type="button" 
                    onclick="switchActivityTab('settings')" 
                    id="activity-tab-settings"
                    class="tab-button active px-6 py-4 font-medium text-sm border-b-2 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                <i class="fas fa-cog mr-2"></i>
                Section Settings
            </button>
            <button type="button" 
                    onclick="switchActivityTab('add')" 
                    id="activity-tab-add"
                    class="tab-button px-6 py-4 font-medium text-sm border-b-2 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                <i class="fas fa-plus mr-2"></i>
                Add Activity
            </button>
            <button type="button" 
                    onclick="switchActivityTab('list')" 
                    id="activity-tab-list"
                    class="tab-button px-6 py-4 font-medium text-sm border-b-2 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                <i class="fas fa-list mr-2"></i>
                Activities List <span class="ml-2 px-2 py-1 text-xs rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">{{ $clubs->count() ?? 0 }}</span>
            </button>
        </div>
    </div>
</div>

<!-- Section Settings Tab -->
<div id="activity-tab-content-settings" class="tab-content">
    <div class="max-w-2xl mx-auto">
        <div class="card-hover bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-gradient-to-r from-orange-100 to-yellow-100 dark:from-orange-900/30 dark:to-yellow-800/30 rounded-xl">
                    <i class="fas fa-cog text-2xl text-orange-600 dark:text-orange-400"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Section Settings</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Configure the activities section display</p>
                </div>
            </div>

            <form method="POST" 
                  action="{{ route('admin.club.section') }}"
                  class="space-y-6">
                @csrf

                <!-- Section Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Section Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title"
                           value="{{ old('title', $section->title ?? '') }}"
                           required
                           class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:focus:ring-orange-400 dark:focus:border-orange-400"
                           placeholder="e.g., Our Activities, Club Events">
                </div>

                <!-- CTA Text -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Call-to-Action Text
                    </label>
                    <input type="text" 
                           name="cta_text"
                           value="{{ old('cta_text', $section->cta_text ?? '') }}"
                           class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:focus:ring-orange-400 dark:focus:border-orange-400"
                           placeholder="e.g., View All Activities">
                </div>

                <!-- CTA Link -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Call-to-Action Link
                    </label>
                    <input type="text" 
                           name="cta_link"
                           value="{{ old('cta_link', $section->cta_link ?? '') }}"
                           class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:focus:ring-orange-400 dark:focus:border-orange-400"
                           placeholder="e.g., /activities">
                </div>

                <!-- Enable Section -->
                <div class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <input type="checkbox" 
                           id="is_active"
                           name="is_active" 
                           value="1"
                           {{ ($section->is_active ?? true) ? 'checked' : '' }}
                           class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Enable this section on the website
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-6">
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white px-6 py-4 rounded-lg font-medium transition-all duration-300 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Activity Tab -->
<div id="activity-tab-content-add" class="tab-content hidden">
    <div class="max-w-2xl mx-auto">
        <div class="card-hover bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-gradient-to-r from-green-100 to-teal-100 dark:from-green-900/30 dark:to-teal-800/30 rounded-xl">
                    <i class="fas fa-plus-circle text-2xl text-green-600 dark:text-green-400"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Add New Activity</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Create a new club activity or event</p>
                </div>
            </div>

            <form method="POST" 
                  action="{{ route('admin.club.items') }}"
                  enctype="multipart/form-data"
                  class="space-y-6">
                @csrf

                <!-- Activity Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Activity Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           required
                           value="{{ old('title') }}"
                           class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:focus:ring-green-400 dark:focus:border-green-400"
                           placeholder="e.g., English Speaking Club, Debate Competition">
                </div>

                <!-- Duration & Place -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Duration
                        </label>
                        <input type="text" 
                               name="duration"
                               value="{{ old('duration') }}"
                               class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:focus:ring-green-400 dark:focus:border-green-400"
                               placeholder="e.g., 2 hours, Every Saturday">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Place/Location
                        </label>
                        <input type="text" 
                               name="place"
                               value="{{ old('place') }}"
                               class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:focus:ring-green-400 dark:focus:border-green-400"
                               placeholder="e.g., Main Hall, Online, Room 101">
                    </div>
                </div>

                <!-- Activity Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Activity Image <span class="text-red-500">*</span>
                    </label>
                    
                    <!-- File Upload Area -->
                    <div class="mt-2">
                        <div id="activity-dropzone" 
                             class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8 hover:border-green-500 dark:hover:border-green-400 transition-colors cursor-pointer bg-gray-50 dark:bg-gray-700/50">
                            <input type="file" 
                                   name="image" 
                                   required
                                   accept="image/*"
                                   id="activity-image-input"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                   onchange="previewActivityImage(event)">
                            
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <div class="mt-4 flex text-sm text-gray-600 dark:text-gray-400">
                                    <label class="relative cursor-pointer font-medium text-green-600 dark:text-green-400 hover:text-green-500 dark:hover:text-green-300">
                                        <span>Click to upload</span>
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2" id="activity-file-name">
                                    PNG, JPG, GIF up to 5MB • Recommended: 400×300px
                                </p>
                            </div>
                        </div>
                        
                        <!-- Image Preview -->
                        <div id="activity-image-preview" class="mt-4 hidden">
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">Preview:</div>
                            <div class="flex flex-wrap gap-4">
                                <img id="activity-preview-image" 
                                     class="w-48 h-48 rounded-lg object-cover border-4 border-gray-200 dark:border-gray-700 shadow-lg">
                                <div class="flex-1 min-w-[200px]">
                                    <div class="text-sm font-medium text-gray-800 dark:text-white mb-2" id="activity-preview-title"></div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-3" id="activity-preview-size"></div>
                                    <div class="text-xs">
                                        <button type="button" 
                                                onclick="removeActivityPreview()"
                                                class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                            <i class="fas fa-times mr-1"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Description
                    </label>
                    <textarea name="description" 
                              rows="4"
                              class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:focus:ring-green-400 dark:focus:border-green-400"
                              placeholder="Describe the activity, its purpose, and what participants can expect...">{{ old('description') }}</textarea>
                </div>

                <!-- Submit Button -->
                <div class="pt-6">
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-600 hover:to-teal-600 text-white px-6 py-4 rounded-lg font-medium transition-all duration-300 flex items-center justify-center gap-2">
                        <i class="fas fa-plus-circle"></i>
                        Add Activity
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Activities List Tab -->
<div id="activity-tab-content-list" class="tab-content hidden">
    @if($clubs && $clubs->count() > 0)
        <div class="card-hover bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="font-semibold text-gray-700 dark:text-gray-300">All Activities</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            {{ $clubs->count() }} activit{{ $clubs->count() === 1 ? 'y' : 'ies' }} found
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" 
                                onclick="switchActivityTab('add')" 
                                class="px-4 py-2 bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-600 hover:to-teal-600 text-white rounded-lg font-medium transition-colors duration-300 flex items-center gap-2">
                            <i class="fas fa-plus"></i>
                            Add New
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Image</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Activity Details</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Duration & Place</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($clubs as $club)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                            <!-- Image -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="w-16 h-16 rounded-lg overflow-hidden border-2 border-gray-200 dark:border-gray-700">
                                    <img src="{{ asset('storage/'.$club->image) }}" 
                                         alt="{{ $club->title }}"
                                         class="w-full h-full object-cover">
                                </div>
                            </td>
                            
                            <!-- Activity Details -->
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $club->title }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    Added: {{ $club->created_at->format('M d, Y') }}
                                </div>
                            </td>
                            
                            <!-- Duration & Place -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($club->duration)
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400">
                                        <i class="fas fa-clock mr-1"></i> {{ $club->duration }}
                                    </span>
                                </div>
                                @endif
                                @if($club->place)
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                        <i class="fas fa-map-marker-alt mr-1"></i> {{ $club->place }}
                                    </span>
                                </div>
                                @endif
                            </td>
                            
                            <!-- Description -->
                            <td class="px-6 py-4">
                                @if($club->description)
                                <div class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                    {{ $club->description }}
                                </div>
                                @else
                                <span class="text-gray-400 dark:text-gray-500 text-sm italic">No description</span>
                                @endif
                            </td>
                            
                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-3">
                                    <button type="button" 
                                            onclick="openEditClubModal({{ $club->id }}, '{{ $club->title }}', '{{ $club->duration }}', '{{ $club->place }}', '{{ $club->description }}', '{{ asset('storage/'.$club->image) }}')"
                                            class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors"
                                            title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <form method="POST" 
                                          action="{{ route('admin.club.items.destroy', $club) }}"
                                          class="inline"
                                          onsubmit="return confirmDeleteActivity(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if(method_exists($clubs, 'links'))
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $clubs->links() }}
            </div>
            @endif
        </div>
    @else
        <div class="text-center py-12">
            <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                <i class="fas fa-calendar-alt text-4xl text-gray-400 dark:text-gray-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-2">No Activities Yet</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                Start by adding your first activity. Showcase club events, workshops, and student activities.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <button type="button" 
                        onclick="switchActivityTab('add')" 
                        class="px-6 py-3 bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-600 hover:to-teal-600 text-white rounded-lg font-medium transition-all duration-300 flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    Add First Activity
                </button>
                <button type="button" 
                        onclick="switchActivityTab('settings')" 
                        class="px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg font-medium transition-colors duration-300 flex items-center gap-2">
                    <i class="fas fa-cog"></i>
                    Configure Section
                </button>
            </div>
        </div>
    @endif
</div>

<!-- Edit Activity Modal -->
<div id="editClubModal" class="fixed inset-0 bg-gray-900/80 dark:bg-gray-900/90 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-gradient-to-r from-blue-100 to-blue-200 dark:from-blue-900/30 dark:to-blue-800/30 rounded-lg">
                            <i class="fas fa-edit text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Edit Activity</h3>
                    </div>
                    <button type="button" 
                            onclick="closeEditClubModal()"
                            class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Form -->
            <form id="editClubForm" 
                  method="POST" 
                  enctype="multipart/form-data"
                  class="p-6 space-y-6">
                @csrf
                @method('PUT')
                
                <input type="hidden" name="club_id" id="edit_club_id">
                
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Activity Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="edit_club_title"
                           required
                           class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400">
                </div>
                
                <!-- Duration & Place -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Duration
                        </label>
                        <input type="text" 
                               name="duration" 
                               id="edit_club_duration"
                               class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400"
                               placeholder="e.g., 2 hours">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Place/Location
                        </label>
                        <input type="text" 
                               name="place" 
                               id="edit_club_place"
                               class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400"
                               placeholder="e.g., Main Hall">
                    </div>
                </div>
                
                <!-- Current Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Current Image
                    </label>
                    <div class="relative rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                        <img id="current_club_image" 
                             src=""
                             alt="Current Image"
                             class="w-full h-48 object-cover">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                            <div class="text-white text-sm" id="current_club_title"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Change Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Change Image (Optional)
                    </label>
                    <div class="flex items-center justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-blue-500 dark:hover:border-blue-400 transition-colors cursor-pointer"
                         onclick="document.getElementById('edit_club_image_input').click()">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                <span class="text-blue-600 dark:text-blue-400 font-medium">Click to upload</span>
                                <span class="ml-1">or drag and drop</span>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                PNG, JPG, GIF up to 5MB
                            </p>
                        </div>
                        <input type="file" 
                               name="image" 
                               id="edit_club_image_input"
                               accept="image/*"
                               class="sr-only"
                               onchange="previewEditClubImage(event)">
                    </div>
                    
                    <!-- New Image Preview -->
                    <div id="edit_club_image_preview" class="mt-4 hidden">
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">New Image Preview:</div>
                        <img id="edit_club_preview_image" 
                             class="w-48 h-48 rounded-lg object-cover border-4 border-blue-200 dark:border-blue-700">
                    </div>
                </div>
                
                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Description
                    </label>
                    <textarea name="description" 
                              id="edit_club_description"
                              rows="3"
                              class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400"></textarea>
                </div>
                
                <!-- Modal Actions -->
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" 
                            onclick="closeEditClubModal()"
                            class="px-5 py-2.5 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg font-medium transition-colors duration-300">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg font-medium transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-save"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Activities Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tabs
    const activityTabs = document.querySelectorAll('[id^="activity-tab-"]');
    const activityTabContents = document.querySelectorAll('[id^="activity-tab-content-"]');
    
    window.switchActivityTab = function(tabName) {
        // Hide all tabs
        activityTabContents.forEach(content => {
            content.classList.add('hidden');
        });
        
        // Remove active class from all buttons
        activityTabs.forEach(tab => {
            tab.classList.remove('active', 'border-orange-500', 'text-orange-600', 'dark:text-orange-400');
            tab.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
        });
        
        // Show selected tab
        const tabContent = document.getElementById(`activity-tab-content-${tabName}`);
        if (tabContent) {
            tabContent.classList.remove('hidden');
        }
        
        // Activate selected button
        const tabButton = document.getElementById(`activity-tab-${tabName}`);
        if (tabButton) {
            tabButton.classList.add('active', 'border-orange-500', 'text-orange-600', 'dark:text-orange-400');
            tabButton.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
        }
    };
    
    // Activity image preview for add form
    window.previewActivityImage = function(event) {
        const input = event.target;
        const fileName = document.getElementById('activity-file-name');
        const preview = document.getElementById('activity-image-preview');
        const previewImage = document.getElementById('activity-preview-image');
        const previewTitle = document.getElementById('activity-preview-title');
        const previewSize = document.getElementById('activity-preview-size');
        const dropzone = document.getElementById('activity-dropzone');
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            fileName.textContent = file.name;
            previewTitle.textContent = file.name;
            previewSize.textContent = formatFileSize(file.size);
            
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                preview.classList.remove('hidden');
                dropzone.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    };
    
    window.removeActivityPreview = function() {
        const preview = document.getElementById('activity-image-preview');
        const dropzone = document.getElementById('activity-dropzone');
        const input = document.getElementById('activity-image-input');
        
        preview.classList.add('hidden');
        dropzone.classList.remove('hidden');
        input.value = '';
        document.getElementById('activity-file-name').textContent = 'PNG, JPG, GIF up to 5MB • Recommended: 400×300px';
    };
    
    // Confirm delete
    window.confirmDeleteActivity = function(event) {
        if (!confirm('Are you sure you want to delete this activity? This action cannot be undone.')) {
            event.preventDefault();
            return false;
        }
        return true;
    };
    
    // Drag and drop functionality
    const dropzone = document.getElementById('activity-dropzone');
    if (dropzone) {
        dropzone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-green-500', 'bg-green-50', 'dark:bg-green-900/20');
        });
        
        dropzone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('border-green-500', 'bg-green-50', 'dark:bg-green-900/20');
        });
        
        dropzone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-green-500', 'bg-green-50', 'dark:bg-green-900/20');
            
            const input = document.getElementById('activity-image-input');
            if (e.dataTransfer.files.length) {
                input.files = e.dataTransfer.files;
                const event = new Event('change', { bubbles: true });
                input.dispatchEvent(event);
            }
        });
    }
});

// Edit Activity Modal Functions
window.openEditClubModal = function(id, title, duration, place, description, imageUrl) {
    const modal = document.getElementById('editClubModal');
    const form = document.getElementById('editClubForm');
    
    // Set form action
    form.action = `/admin/club/items/${id}`;
    
    // Fill form fields
    document.getElementById('edit_club_id').value = id;
    document.getElementById('edit_club_title').value = title || '';
    document.getElementById('edit_club_duration').value = duration || '';
    document.getElementById('edit_club_place').value = place || '';
    document.getElementById('edit_club_description').value = description || '';
    document.getElementById('current_club_image').src = imageUrl;
    document.getElementById('current_club_title').textContent = title || 'Untitled';
    
    // Reset new image preview
    const previewDiv = document.getElementById('edit_club_image_preview');
    const previewImg = document.getElementById('edit_club_preview_image');
    previewDiv.classList.add('hidden');
    previewImg.src = '';
    
    // Show modal
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
};

window.closeEditClubModal = function() {
    const modal = document.getElementById('editClubModal');
    modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
};

window.previewEditClubImage = function(event) {
    const input = event.target;
    const preview = document.getElementById('edit_club_image_preview');
    const previewImage = document.getElementById('edit_club_preview_image');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
};

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('editClubModal');
    const modalContent = document.querySelector('#editClubModal > div');
    
    if (modal && !modal.classList.contains('hidden') && 
        modalContent && !modalContent.contains(event.target) && 
        event.target !== modal) {
        closeEditClubModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeEditClubModal();
    }
});

// Format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}
</script>

<style>
.tab-button {
    transition: all 0.2s ease;
    position: relative;
}

.tab-button.active {
    border-bottom-color: transparent;
}

.tab-button.active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #F97316, #EAB308);
    border-radius: 3px 3px 0 0;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Custom checkbox styling */
input[type="checkbox"] {
    cursor: pointer;
}

input[type="checkbox"]:checked {
    background-color: #F97316;
    border-color: #F97316;
}
</style>
@endsection