@extends('admin.layout')

@section('title', 'Gallery Management')

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
                    onclick="switchGalleryTab('add')" 
                    id="gallery-tab-add"
                    class="tab-button active px-6 py-4 font-medium text-sm border-b-2 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                <i class="fas fa-plus mr-2"></i>
                Add Image
            </button>
            <button type="button" 
                    onclick="switchGalleryTab('list')" 
                    id="gallery-tab-list"
                    class="tab-button px-6 py-4 font-medium text-sm border-b-2 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                <i class="fas fa-images mr-2"></i>
                Gallery Images <span class="ml-2 px-2 py-1 text-xs rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">{{ $gallery->count() ?? 0 }}</span>
            </button>
        </div>
    </div>
</div>

<!-- Add Image Tab -->
<div id="gallery-tab-content-add" class="tab-content">
    <div class="max-w-3xl mx-auto">
        <div class="card-hover bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-gradient-to-r from-purple-100 to-pink-100 dark:from-purple-900/30 dark:to-pink-800/30 rounded-xl">
                    <i class="fas fa-image text-2xl text-purple-600 dark:text-purple-400"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Add Gallery Image</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Upload and categorize your images</p>
                </div>
            </div>

            <form method="POST" 
                  action="{{ route('admin.gallery.store') }}"
                  enctype="multipart/form-data"
                  class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Title
                        </label>
                        <input type="text" 
                               name="title" 
                               value="{{ old('title') }}"
                               class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:focus:ring-purple-400 dark:focus:border-purple-400"
                               placeholder="Image title">
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Category
                        </label>
                        <select name="category" 
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:focus:ring-purple-400 dark:focus:border-purple-400">
                            <option value="">Select Category</option>
                            <option value="Student Life" {{ old('category') == 'Student Life' ? 'selected' : '' }}>Student Life</option>
                            <option value="Events" {{ old('category') == 'Events' ? 'selected' : '' }}>Events</option>
                            <option value="Activities" {{ old('category') == 'Activities' ? 'selected' : '' }}>Activities</option>
                            <option value="Classroom" {{ old('category') == 'Classroom' ? 'selected' : '' }}>Classroom</option>
                            <option value="Sports" {{ old('category') == 'Sports' ? 'selected' : '' }}>Sports</option>
                            <option value="Culture" {{ old('category') == 'Culture' ? 'selected' : '' }}>Culture</option>
                            <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>

                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Image <span class="text-red-500">*</span>
                    </label>
                    
                    <!-- File Upload Area -->
                    <div class="mt-2">
                        <div id="gallery-dropzone" 
                             class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8 hover:border-purple-500 dark:hover:border-purple-400 transition-colors cursor-pointer bg-gray-50 dark:bg-gray-700/50">
                            <input type="file" 
                                   name="image" 
                                   required
                                   accept="image/*"
                                   id="gallery-image-input"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                   onchange="previewGalleryImage(event)">
                            
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <div class="mt-4 flex text-sm text-gray-600 dark:text-gray-400">
                                    <label class="relative cursor-pointer font-medium text-purple-600 dark:text-purple-400 hover:text-purple-500 dark:hover:text-purple-300">
                                        <span>Click to upload</span>
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2" id="gallery-file-name">
                                    PNG, JPG, GIF up to 5MB
                                </p>
                            </div>
                        </div>
                        
                        <!-- Image Preview -->
                        <div id="gallery-image-preview" class="mt-4 hidden">
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">Preview:</div>
                            <div class="flex flex-wrap gap-4">
                                <img id="gallery-preview-image" 
                                     class="w-48 h-48 rounded-lg object-cover border-4 border-gray-200 dark:border-gray-700 shadow-lg">
                                <div class="flex-1 min-w-[200px]">
                                    <div class="text-sm font-medium text-gray-800 dark:text-white mb-2" id="preview-title"></div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-3" id="preview-size"></div>
                                    <div class="text-xs">
                                        <button type="button" 
                                                onclick="removeGalleryPreview()"
                                                class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                            <i class="fas fa-times mr-1"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-6">
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-6 py-4 rounded-lg font-medium transition-all duration-300 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        Save Image
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Gallery List Tab -->
<div id="gallery-tab-content-list" class="tab-content hidden">
    <!-- Filter Buttons -->
    <div class="mb-6">
        <div class="flex flex-wrap gap-2">
            <button type="button" 
                    onclick="filterGallery('all')"
                    class="filter-button active px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                <i class="fas fa-layer-group mr-2"></i>
                All <span class="ml-1 px-1.5 py-0.5 text-xs rounded-full bg-gray-200 dark:bg-gray-600">{{ $gallery->count() ?? 0 }}</span>
            </button>
            
            @php
                $categories = $gallery->pluck('category')->unique()->filter()->values();
            @endphp
            
            @foreach($categories as $category)
                @php
                    $count = $gallery->where('category', $category)->count();
                @endphp
                <button type="button" 
                        onclick="filterGallery('{{ $category }}')"
                        class="filter-button px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                        data-category="{{ $category }}">
                    {{ $category }} <span class="ml-1 px-1.5 py-0.5 text-xs rounded-full bg-gray-200 dark:bg-gray-600">{{ $count }}</span>
                </button>
            @endforeach
        </div>
    </div>

    @if($gallery && $gallery->count() > 0)
        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($gallery as $item)
            <div class="gallery-item card-hover bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden"
                 data-category="{{ $item->category ?? 'Uncategorized' }}">
                <!-- Image -->
                <div class="relative overflow-hidden group">
                    <img src="{{ asset('storage/'.$item->image) }}" 
                         alt="{{ $item->title }}"
                         class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                        <div class="text-white">
                            <h4 class="font-bold text-lg">{{ $item->title ?? 'Untitled' }}</h4>
                            @if($item->category)
                            <div class="flex items-center gap-2 mt-2">
                                <span class="px-2 py-1 bg-purple-500/90 backdrop-blur-sm rounded text-xs">
                                    {{ $item->category }}
                                </span>
                                <span class="text-xs opacity-80">
                                    {{ $item->created_at->format('M d, Y') }}
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <h4 class="font-medium text-gray-800 dark:text-white truncate">
                                {{ $item->title ?? 'Untitled' }}
                            </h4>
                            @if($item->category)
                            <div class="flex items-center gap-2 mt-2">
                                <span class="px-2 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 text-xs rounded-full">
                                    {{ $item->category }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $item->created_at->format('M d, Y') }}
                                </span>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex items-center gap-2 ml-4">
                            <button type="button" 
                                    onclick="openEditGalleryModal({{ $item->id }}, '{{ $item->title }}', '{{ $item->category }}', '{{ asset('storage/'.$item->image) }}')"
                                    class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors"
                                    title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            
                            <form method="POST" 
                                  action="{{ route('admin.gallery.destroy', $item) }}"
                                  class="inline"
                                  onsubmit="return confirmDeleteGallery(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors"
                                        title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if(method_exists($gallery, 'links'))
        <div class="mt-8">
            {{ $gallery->links() }}
        </div>
        @endif
    @else
        <div class="text-center py-12">
            <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                <i class="fas fa-images text-4xl text-gray-400 dark:text-gray-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-2">No Images Yet</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                Start building your gallery by uploading images. Showcase student life, events, and activities.
            </p>
            <button type="button" 
                    onclick="switchGalleryTab('add')" 
                    class="px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white rounded-lg font-medium transition-all duration-300 flex items-center gap-2 mx-auto">
                <i class="fas fa-plus"></i>
                Add Your First Image
            </button>
        </div>
    @endif
</div>

<!-- Edit Gallery Modal -->
<div id="editGalleryModal" class="fixed inset-0 bg-gray-900/80 dark:bg-gray-900/90 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-gradient-to-r from-blue-100 to-blue-200 dark:from-blue-900/30 dark:to-blue-800/30 rounded-lg">
                            <i class="fas fa-edit text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Edit Gallery Image</h3>
                    </div>
                    <button type="button" 
                            onclick="closeEditGalleryModal()"
                            class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Form -->
            <form id="editGalleryForm" 
                  method="POST" 
                  enctype="multipart/form-data"
                  class="p-6 space-y-6">
                @csrf
                @method('PUT')
                
                <input type="hidden" name="gallery_id" id="edit_gallery_id">
                
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Title
                    </label>
                    <input type="text" 
                           name="title" 
                           id="edit_gallery_title"
                           class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400">
                </div>
                
                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Category
                    </label>
                    <select name="category" 
                            id="edit_gallery_category"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400">
                        <option value="">Select Category</option>
                        <option value="Student Life">Student Life</option>
                        <option value="Events">Events</option>
                        <option value="Activities">Activities</option>
                        <option value="Classroom">Classroom</option>
                        <option value="Sports">Sports</option>
                        <option value="Culture">Culture</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                
                <!-- Current Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Current Image
                    </label>
                    <div class="relative rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                        <img id="current_gallery_image" 
                             src=""
                             alt="Current Image"
                             class="w-full h-64 object-cover">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                            <div class="text-white text-sm" id="current_gallery_title"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Change Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Change Image (Optional)
                    </label>
                    <div class="flex items-center justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-blue-500 dark:hover:border-blue-400 transition-colors cursor-pointer"
                         onclick="document.getElementById('edit_gallery_image_input').click()">
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
                               id="edit_gallery_image_input"
                               accept="image/*"
                               class="sr-only"
                               onchange="previewEditGalleryImage(event)">
                    </div>
                    
                    <!-- New Image Preview -->
                    <div id="edit_gallery_image_preview" class="mt-4 hidden">
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">New Image Preview:</div>
                        <img id="edit_gallery_preview_image" 
                             class="w-48 h-48 rounded-lg object-cover border-4 border-blue-200 dark:border-blue-700">
                    </div>
                </div>
                
                <!-- Modal Actions -->
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" 
                            onclick="closeEditGalleryModal()"
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
// Gallery Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tabs
    const galleryTabs = document.querySelectorAll('[id^="gallery-tab-"]');
    const galleryTabContents = document.querySelectorAll('[id^="gallery-tab-content-"]');
    
    window.switchGalleryTab = function(tabName) {
        // Hide all tabs
        galleryTabContents.forEach(content => {
            content.classList.add('hidden');
        });
        
        // Remove active class from all buttons
        galleryTabs.forEach(tab => {
            tab.classList.remove('active', 'border-purple-500', 'text-purple-600', 'dark:text-purple-400');
            tab.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
        });
        
        // Show selected tab
        const tabContent = document.getElementById(`gallery-tab-content-${tabName}`);
        if (tabContent) {
            tabContent.classList.remove('hidden');
        }
        
        // Activate selected button
        const tabButton = document.getElementById(`gallery-tab-${tabName}`);
        if (tabButton) {
            tabButton.classList.add('active', 'border-purple-500', 'text-purple-600', 'dark:text-purple-400');
            tabButton.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
        }
    };
    
    // Gallery image preview for add form
    window.previewGalleryImage = function(event) {
        const input = event.target;
        const fileName = document.getElementById('gallery-file-name');
        const preview = document.getElementById('gallery-image-preview');
        const previewImage = document.getElementById('gallery-preview-image');
        const previewTitle = document.getElementById('preview-title');
        const previewSize = document.getElementById('preview-size');
        const dropzone = document.getElementById('gallery-dropzone');
        
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
    
    window.removeGalleryPreview = function() {
        const preview = document.getElementById('gallery-image-preview');
        const dropzone = document.getElementById('gallery-dropzone');
        const input = document.getElementById('gallery-image-input');
        
        preview.classList.add('hidden');
        dropzone.classList.remove('hidden');
        input.value = '';
        document.getElementById('gallery-file-name').textContent = 'PNG, JPG, GIF up to 5MB';
    };
    
    // Filter gallery by category
    window.filterGallery = function(category) {
        const filterButtons = document.querySelectorAll('.filter-button');
        const galleryItems = document.querySelectorAll('.gallery-item');
        
        // Update active filter button
        filterButtons.forEach(button => {
            if (category === 'all') {
                button.classList.remove('active', 'bg-purple-100', 'dark:bg-purple-900/30', 'text-purple-700', 'dark:text-purple-400');
                if (button.textContent.includes('All')) {
                    button.classList.add('active', 'bg-purple-100', 'dark:bg-purple-900/30', 'text-purple-700', 'dark:text-purple-400');
                }
            } else if (button.dataset.category === category) {
                button.classList.add('active', 'bg-purple-100', 'dark:bg-purple-900/30', 'text-purple-700', 'dark:text-purple-400');
            } else {
                button.classList.remove('active', 'bg-purple-100', 'dark:bg-purple-900/30', 'text-purple-700', 'dark:text-purple-400');
            }
        });
        
        // Filter gallery items
        galleryItems.forEach(item => {
            if (category === 'all' || item.dataset.category === category) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
    };
    
    // Confirm delete
    window.confirmDeleteGallery = function(event) {
        if (!confirm('Are you sure you want to delete this image? This action cannot be undone.')) {
            event.preventDefault();
            return false;
        }
        return true;
    };
    
    // Drag and drop functionality
    const dropzone = document.getElementById('gallery-dropzone');
    if (dropzone) {
        dropzone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-purple-500', 'bg-purple-50', 'dark:bg-purple-900/20');
        });
        
        dropzone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('border-purple-500', 'bg-purple-50', 'dark:bg-purple-900/20');
        });
        
        dropzone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-purple-500', 'bg-purple-50', 'dark:bg-purple-900/20');
            
            const input = document.getElementById('gallery-image-input');
            if (e.dataTransfer.files.length) {
                input.files = e.dataTransfer.files;
                const event = new Event('change', { bubbles: true });
                input.dispatchEvent(event);
            }
        });
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

// Edit Gallery Modal Functions
window.openEditGalleryModal = function(id, title, category, imageUrl) {
    const modal = document.getElementById('editGalleryModal');
    const form = document.getElementById('editGalleryForm');
    
    // Set form action
    form.action = `/admin/gallery/${id}`;
    
    // Fill form fields
    document.getElementById('edit_gallery_id').value = id;
    document.getElementById('edit_gallery_title').value = title || '';
    document.getElementById('edit_gallery_category').value = category || '';
    document.getElementById('current_gallery_image').src = imageUrl;
    document.getElementById('current_gallery_title').textContent = title || 'Untitled';
    
    // Reset new image preview
    const previewDiv = document.getElementById('edit_gallery_image_preview');
    const previewImg = document.getElementById('edit_gallery_preview_image');
    previewDiv.classList.add('hidden');
    previewImg.src = '';
    
    // Show modal
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
};

window.closeEditGalleryModal = function() {
    const modal = document.getElementById('editGalleryModal');
    modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
};

window.previewEditGalleryImage = function(event) {
    const input = event.target;
    const preview = document.getElementById('edit_gallery_image_preview');
    const previewImage = document.getElementById('edit_gallery_preview_image');
    
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
    const modal = document.getElementById('editGalleryModal');
    const modalContent = document.querySelector('#editGalleryModal > div');
    
    if (modal && !modal.classList.contains('hidden') && 
        modalContent && !modalContent.contains(event.target) && 
        event.target !== modal) {
        closeEditGalleryModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeEditGalleryModal();
    }
});
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
    background: linear-gradient(90deg, #8B5CF6, #EC4899);
    border-radius: 3px 3px 0 0;
}

.filter-button.active {
    background: linear-gradient(135deg, #8B5CF6, #EC4899) !important;
    color: white !important;
}

.filter-button.active span {
    background: rgba(255, 255, 255, 0.2) !important;
    color: white !important;
}

.gallery-item {
    animation: fadeInUp 0.3s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endsection