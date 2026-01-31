@extends('admin.layout')

@section('title', 'Teachers Management')

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
                    onclick="switchTab('add')" 
                    id="tab-add"
                    class="tab-button active px-6 py-4 font-medium text-sm border-b-2 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                <i class="fas fa-user-plus mr-2"></i>
                Add Teacher
            </button>
            <button type="button" 
                    onclick="switchTab('list')" 
                    id="tab-list"
                    class="tab-button px-6 py-4 font-medium text-sm border-b-2 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                <i class="fas fa-list mr-2"></i>
                Teachers List <span class="ml-2 px-2 py-1 text-xs rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">{{ $teachers->count() ?? 0 }}</span>
            </button>
        </div>
    </div>
</div>

<!-- Add Teacher Tab -->
<div id="tab-content-add" class="tab-content">
    <div class="max-w-3xl mx-auto">
        <div class="card-hover bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-gradient-to-r from-green-100 to-green-200 dark:from-green-900/30 dark:to-green-800/30 rounded-xl">
                    <i class="fas fa-user-plus text-2xl text-green-600 dark:text-green-400"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Add New Teacher</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Fill in the teacher's details below</p>
                </div>
            </div>

            <form method="POST" 
                  action="{{ route('admin.add-teachers.store') }}"
                  enctype="multipart/form-data"
                  class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Full Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               required
                               value="{{ old('name') }}"
                               class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:focus:ring-green-400 dark:focus:border-green-400"
                               placeholder="Enter full name">
                    </div>

                    <!-- Title/Position -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Title/Position <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               required
                               value="{{ old('title') }}"
                               class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:focus:ring-green-400 dark:focus:border-green-400"
                               placeholder="e.g., Senior Teacher, Professor">
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
                              placeholder="About the teacher...">{{ old('description') }}</textarea>
                </div>

                <!-- Profile Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Profile Image <span class="text-red-500">*</span>
                    </label>
                    
                    <!-- File Upload -->
                    <div class="mt-1 flex items-center justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-green-500 dark:hover:border-green-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                <label class="relative cursor-pointer rounded-md font-medium text-green-600 dark:text-green-400 hover:text-green-500 dark:hover:text-green-300">
                                    <span>Upload a file</span>
                                    <input type="file" 
                                           name="image" 
                                           required
                                           accept="image/*"
                                           class="sr-only"
                                           id="teacher-image-input"
                                           onchange="previewTeacherImage(event)">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400" id="teacher-file-name">
                                PNG, JPG, GIF up to 2MB. Recommended: 400×400px
                            </p>
                        </div>
                    </div>
                    
                    <!-- Image Preview -->
                    <div id="teacher-image-preview" class="mt-4 hidden">
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">Preview:</div>
                        <img id="teacher-preview-image" 
                             class="w-32 h-32 rounded-full object-cover border-4 border-gray-200 dark:border-gray-700 shadow-lg">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-6">
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-600 hover:to-teal-600 text-white px-6 py-4 rounded-lg font-medium transition-all duration-300 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        Save Teacher
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Teachers List Tab -->
<div id="tab-content-list" class="tab-content hidden">
    @if($teachers && $teachers->count() > 0)
        <div class="card-hover bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="font-semibold text-gray-700 dark:text-gray-300">All Teachers</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            {{ $teachers->count() }} teacher{{ $teachers->count() > 1 ? 's' : '' }} found
                        </p>
                    </div>
                    <button type="button" 
                            onclick="switchTab('add')" 
                            class="px-4 py-2 bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-600 hover:to-teal-600 text-white rounded-lg font-medium transition-colors duration-300 flex items-center gap-2">
                        <i class="fas fa-plus"></i>
                        Add New
                    </button>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Photo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name & Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($teachers as $teacher)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                            <!-- Photo -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-gray-200 dark:border-gray-700">
                                    <img src="{{ asset('storage/'.$teacher->image) }}" 
                                         alt="{{ $teacher->name }}"
                                         class="w-full h-full object-cover">
                                </div>
                            </td>
                            
                            <!-- Name & Title -->
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $teacher->name }}</div>
                                <div class="text-sm text-green-600 dark:text-green-400 font-medium mt-1">
                                    <i class="fas fa-briefcase mr-1"></i>
                                    {{ $teacher->title }}
                                </div>
                            </td>
                            
                            <!-- Description -->
                            <td class="px-6 py-4">
                                @if($teacher->description)
                                <div class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                    {{ $teacher->description }}
                                </div>
                                @else
                                <span class="text-gray-400 dark:text-gray-500 text-sm italic">No description</span>
                                @endif
                            </td>
                            
                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-3">
                                    <button type="button" 
                                            onclick="openEditTeacherModal({{ $teacher->id }}, '{{ $teacher->name }}', '{{ $teacher->title }}', '{{ $teacher->description }}', '{{ asset('storage/'.$teacher->image) }}')"
                                            class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors"
                                            title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <form method="POST" 
                                          action="{{ route('admin.add-teachers.destroy', $teacher) }}"
                                          class="inline"
                                          onsubmit="return confirmDelete(event)">
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
            
            <!-- Pagination (if needed) -->
            @if(method_exists($teachers, 'links'))
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $teachers->links() }}
            </div>
            @endif
        </div>
    @else
        <div class="text-center py-12">
            <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                <i class="fas fa-chalkboard-teacher text-4xl text-gray-400 dark:text-gray-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-2">No Teachers Yet</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                Start by adding your first teacher to the system. Teachers can be assigned to classes and activities.
            </p>
            <button type="button" 
                    onclick="switchTab('add')" 
                    class="px-6 py-3 bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-600 hover:to-teal-600 text-white rounded-lg font-medium transition-all duration-300 flex items-center gap-2 mx-auto">
                <i class="fas fa-plus"></i>
                Add Your First Teacher
            </button>
        </div>
    @endif
</div>

<!-- Edit Teacher Modal -->
<div id="editTeacherModal" class="fixed inset-0 bg-gray-900/80 dark:bg-gray-900/90 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-gradient-to-r from-blue-100 to-blue-200 dark:from-blue-900/30 dark:to-blue-800/30 rounded-lg">
                            <i class="fas fa-edit text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Edit Teacher</h3>
                    </div>
                    <button type="button" 
                            onclick="closeEditTeacherModal()"
                            class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Form -->
            <form id="editTeacherForm" 
                  method="POST" 
                  enctype="multipart/form-data"
                  class="p-6 space-y-6">
                @csrf
                @method('PUT')
                
                <input type="hidden" name="teacher_id" id="edit_teacher_id">
                
                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="edit_teacher_name"
                           required
                           class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400">
                </div>
                
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Title/Position <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="edit_teacher_title"
                           required
                           class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400">
                </div>
                
                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Description
                    </label>
                    <textarea name="description" 
                              id="edit_teacher_description"
                              rows="3"
                              class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400"></textarea>
                </div>
                
                <!-- Current Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Current Image
                    </label>
                    <div class="flex items-center gap-4">
                        <img id="current_teacher_image" 
                             src=""
                             alt="Current Image"
                             class="w-20 h-20 rounded-full object-cover border-4 border-gray-200 dark:border-gray-700">
                        <div class="flex-1">
                            <div class="text-sm text-gray-600 dark:text-gray-400">Click the image to view full size</div>
                        </div>
                    </div>
                </div>
                
                <!-- Change Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Change Image (Optional)
                    </label>
                    <div class="flex items-center justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-blue-500 dark:hover:border-blue-400 transition-colors cursor-pointer"
                         onclick="document.getElementById('edit_teacher_image_input').click()">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                <span class="text-blue-600 dark:text-blue-400 font-medium">Click to upload</span>
                                <span class="ml-1">or drag and drop</span>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400" id="edit_teacher_file_name">
                                PNG, JPG, GIF up to 2MB
                            </p>
                        </div>
                        <input type="file" 
                               name="image" 
                               id="edit_teacher_image_input"
                               accept="image/*"
                               class="sr-only"
                               onchange="previewEditTeacherImage(event)">
                    </div>
                    
                    <!-- New Image Preview -->
                    <div id="edit_teacher_image_preview" class="mt-4 hidden">
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">New Image Preview:</div>
                        <img id="edit_teacher_preview_image" 
                             class="w-20 h-20 rounded-full object-cover border-4 border-blue-200 dark:border-blue-700">
                    </div>
                </div>
                
                <!-- Modal Actions -->
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" 
                            onclick="closeEditTeacherModal()"
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
// Teachers Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tabs
    const tabs = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    window.switchTab = function(tabName) {
        // Hide all tabs
        tabContents.forEach(content => {
            content.classList.add('hidden');
        });
        
        // Remove active class from all buttons
        tabs.forEach(tab => {
            tab.classList.remove('active', 'border-green-500', 'text-green-600', 'dark:text-green-400');
            tab.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
        });
        
        // Show selected tab
        const tabContent = document.getElementById(`tab-content-${tabName}`);
        if (tabContent) {
            tabContent.classList.remove('hidden');
        }
        
        // Activate selected button
        const tabButton = document.getElementById(`tab-${tabName}`);
        if (tabButton) {
            tabButton.classList.add('active', 'border-green-500', 'text-green-600', 'dark:text-green-400');
            tabButton.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
        }
    };
    
    // Teacher image preview for add form
    window.previewTeacherImage = function(event) {
        const input = event.target;
        const fileName = document.getElementById('teacher-file-name');
        const preview = document.getElementById('teacher-image-preview');
        const previewImage = document.getElementById('teacher-preview-image');
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            fileName.textContent = file.name;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    };
    
    // Confirm delete
    window.confirmDelete = function(event) {
        if (!confirm('Are you sure you want to delete this teacher? This action cannot be undone.')) {
            event.preventDefault();
            return false;
        }
        return true;
    };
});

// Edit Teacher Modal Functions
window.openEditTeacherModal = function(id, name, title, description, imageUrl) {
    const modal = document.getElementById('editTeacherModal');
    const form = document.getElementById('editTeacherForm');
    
    // Set form action
    form.action = `/admin/add-teachers/${id}`;
    
    // Fill form fields
    document.getElementById('edit_teacher_id').value = id;
    document.getElementById('edit_teacher_name').value = name;
    document.getElementById('edit_teacher_title').value = title;
    document.getElementById('edit_teacher_description').value = description || '';
    document.getElementById('current_teacher_image').src = imageUrl;
    
    // Reset new image preview
    const previewDiv = document.getElementById('edit_teacher_image_preview');
    const previewImg = document.getElementById('edit_teacher_preview_image');
    previewDiv.classList.add('hidden');
    previewImg.src = '';
    
    // Show modal
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
};

window.closeEditTeacherModal = function() {
    const modal = document.getElementById('editTeacherModal');
    modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
};

window.previewEditTeacherImage = function(event) {
    const input = event.target;
    const fileName = document.getElementById('edit_teacher_file_name');
    const preview = document.getElementById('edit_teacher_image_preview');
    const previewImage = document.getElementById('edit_teacher_preview_image');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        fileName.textContent = file.name;
        
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
    const modal = document.getElementById('editTeacherModal');
    const modalContent = document.querySelector('#editTeacherModal > div');
    
    if (modal && !modal.classList.contains('hidden') && 
        modalContent && !modalContent.contains(event.target) && 
        event.target !== modal) {
        closeEditTeacherModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeEditTeacherModal();
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
    background: linear-gradient(90deg, #10B981, #0D9488);
    border-radius: 3px 3px 0 0;
}

.tab-content {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection