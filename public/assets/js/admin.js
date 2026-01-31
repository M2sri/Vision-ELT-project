/* ============================================
   ACTIVITES SECTION JS
============================================ */

document.addEventListener('DOMContentLoaded', function () {
    // Tab switching functionality
    const tabs = document.querySelectorAll('.tab-btn');
    const panels = document.querySelectorAll('.tab-panel');
    
    function switchTab(tabId) {
        // Remove active from all tabs and panels
        tabs.forEach(tab => tab.classList.remove('active'));
        panels.forEach(panel => panel.classList.remove('active'));
        
        // Add active to selected tab and panel
        document.querySelector(`[data-tab="${tabId}"]`).classList.add('active');
        document.getElementById(tabId).classList.add('active');
        
        // Store active tab in sessionStorage
        sessionStorage.setItem('activeClubTab', tabId);
    }
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            const target = this.getAttribute('data-tab');
            switchTab(target);
        });
    });
    
    // Check for saved tab state
    const savedTab = sessionStorage.getItem('activeClubTab');
    if (savedTab && document.getElementById(savedTab)) {
        switchTab(savedTab);
    }
    
    // Tab switch buttons functionality
    document.querySelectorAll('.tab-switch-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            switchTab(targetTab);
        });
    });
    
    // Edit Club Modal functionality
    const editButtons = document.querySelectorAll('.edit-club-btn');
    const editModal = document.getElementById('editClubModal');
    const editForm = document.getElementById('editClubForm');
    const currentImage = document.getElementById('current_image');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const clubId = this.getAttribute('data-id');
            const clubTitle = this.getAttribute('data-title');
            const clubDuration = this.getAttribute('data-duration');
            const clubPlace = this.getAttribute('data-place');
            const clubDescription = this.getAttribute('data-description');
            const clubImage = this.getAttribute('data-image');
            
            // Set form action
            editForm.action = `/admin/club/items/${clubId}`;
            
            // Fill form fields
            document.getElementById('edit_title').value = clubTitle;
            document.getElementById('edit_duration').value = clubDuration;
            document.getElementById('edit_place').value = clubPlace;
            document.getElementById('edit_description').value = clubDescription;
            currentImage.src = clubImage;
            
            // Show modal
            editModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
    });
    
    // Close modal when clicking outside
    editModal.addEventListener('click', function(e) {
        if (e.target === editModal) {
            closeEditModal();
        }
    });
    
    // Escape key to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !editModal.classList.contains('hidden')) {
            closeEditModal();
        }
    });
});

function closeEditModal() {
    const editModal = document.getElementById('editClubModal');
    editModal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Form validation for image upload
document.querySelectorAll('input[type="file"]').forEach(input => {
    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            const maxSize = 2 * 1024 * 1024; // 2MB
            
            if (!validTypes.includes(file.type)) {
                alert('Please upload only image files (JPEG, PNG, GIF, WebP)');
                e.target.value = '';
                return;
            }
            
            if (file.size > maxSize) {
                alert('Image size should not exceed 2MB');
                e.target.value = '';
                return;
            }
        }
    });
});



/* ============================================
   TEACHERS SECTION JS
============================================ */
document.addEventListener('DOMContentLoaded', function () {
    // Tab switching functionality
    const tabs = document.querySelectorAll('.tab-btn');
    const panels = document.querySelectorAll('.tab-panel');
    
    function switchTab(tabId) {
        // Remove active from all tabs and panels
        tabs.forEach(tab => tab.classList.remove('active'));
        panels.forEach(panel => panel.classList.remove('active'));
        
        // Add active to selected tab and panel
        document.querySelector(`[data-tab="${tabId}"]`).classList.add('active');
        document.getElementById(tabId).classList.add('active');
        
        // Store active tab in sessionStorage
        sessionStorage.setItem('activeTeacherTab', tabId);
    }
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            const target = this.getAttribute('data-tab');
            switchTab(target);
        });
    });
    
    // Check for saved tab state
    const savedTab = sessionStorage.getItem('activeTeacherTab');
    if (savedTab && document.getElementById(savedTab)) {
        switchTab(savedTab);
    }
    
    // Tab switch buttons functionality
    document.querySelectorAll('.tab-switch-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            switchTab(targetTab);
        });
    });
    
    // File input display
    const fileInput = document.querySelector('input[type="file"]');
    const fileNameDisplay = document.getElementById('file-name');
    
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                fileNameDisplay.textContent = e.target.files[0].name;
            } else {
                fileNameDisplay.textContent = 'No file chosen';
            }
        });
    }
    
    // Edit Teacher Modal functionality
    const editButtons = document.querySelectorAll('.edit-teacher-btn');
    const editModal = document.getElementById('editTeacherModal');
    const editForm = document.getElementById('editTeacherForm');
    const currentTeacherImage = document.getElementById('current_teacher_image');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const teacherId = this.getAttribute('data-id');
            const teacherName = this.getAttribute('data-name');
            const teacherTitle = this.getAttribute('data-title');
            const teacherDescription = this.getAttribute('data-description');
            const teacherImage = this.getAttribute('data-image');
            
            // Set form action
            editForm.action = `/admin/teachers/${teacherId}`;
            
            // Fill form fields
            document.getElementById('edit_name').value = teacherName;
            document.getElementById('edit_title').value = teacherTitle;
            document.getElementById('edit_description').value = teacherDescription || '';
            currentTeacherImage.src = teacherImage;
            
            // Show modal
            editModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
    });
    
    // Close modal when clicking outside
    editModal.addEventListener('click', function(e) {
        if (e.target === editModal) {
            closeEditTeacherModal();
        }
    });
    
    // Escape key to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !editModal.classList.contains('hidden')) {
            closeEditTeacherModal();
        }
    });
});

function closeEditTeacherModal() {
    const editModal = document.getElementById('editTeacherModal');
    editModal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Form validation for image upload
document.querySelectorAll('input[type="file"]').forEach(input => {
    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            const maxSize = 2 * 1024 * 1024; // 2MB
            
            if (!validTypes.includes(file.type)) {
                alert('Please upload only image files (JPEG, PNG, GIF, WebP)');
                e.target.value = '';
                return;
            }
            
            if (file.size > maxSize) {
                alert('Image size should not exceed 2MB');
                e.target.value = '';
                return;
            }
        }
    });
});




/* ============================================
   HIGHLIGHT SECTION JS
============================================ */

document.addEventListener('DOMContentLoaded', function () {
    // Tab switching functionality
    const tabs = document.querySelectorAll('.tab-btn');
    const panels = document.querySelectorAll('.tab-panel');
    
    function switchTab(tabId) {
        // Remove active from all tabs and panels
        tabs.forEach(tab => tab.classList.remove('active'));
        panels.forEach(panel => panel.classList.remove('active'));
        
        // Add active to selected tab and panel
        document.querySelector(`[data-tab="${tabId}"]`).classList.add('active');
        document.getElementById(tabId).classList.add('active');
        
        // Store active tab in sessionStorage
        sessionStorage.setItem('activeGalleryTab', tabId);
    }
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            const target = this.getAttribute('data-tab');
            switchTab(target);
        });
    });
    
    // Check for saved tab state
    const savedTab = sessionStorage.getItem('activeGalleryTab');
    if (savedTab && document.getElementById(savedTab)) {
        switchTab(savedTab);
    }
    
    // Tab switch buttons functionality
    document.querySelectorAll('.tab-switch-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            switchTab(targetTab);
        });
    });
    
    // Image upload preview
    const imageUpload = document.getElementById('image-upload');
    const imagePreviewContainer = document.getElementById('image-preview-container');
    const fileNameDisplay = document.getElementById('file-name');
    
    if (imageUpload) {
        imageUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                fileNameDisplay.textContent = file.name;
                
                // Clear previous previews
                imagePreviewContainer.innerHTML = '';
                
                // Create preview
                const reader = new FileReader();
                reader.onload = function(event) {
                    const previewDiv = document.createElement('div');
                    previewDiv.className = 'image-preview';
                    previewDiv.innerHTML = `
                        <img src="${event.target.result}" alt="Preview">
                        <button type="button" class="remove-preview">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    imagePreviewContainer.appendChild(previewDiv);
                    
                    // Add remove functionality
                    previewDiv.querySelector('.remove-preview').addEventListener('click', function() {
                        imageUpload.value = '';
                        imagePreviewContainer.innerHTML = '';
                        fileNameDisplay.textContent = 'PNG, JPG, GIF up to 5MB';
                    });
                };
                reader.readAsDataURL(file);
            }
        });
        
        // Drag and drop functionality
        const dropZone = imageUpload.closest('div[class*="border-dashed"]');
        if (dropZone) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                dropZone.classList.add('border-blue-500', 'bg-blue-50');
            }
            
            function unhighlight() {
                dropZone.classList.remove('border-blue-500', 'bg-blue-50');
            }
            
            dropZone.addEventListener('drop', function(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                imageUpload.files = files;
                const event = new Event('change', { bubbles: true });
                imageUpload.dispatchEvent(event);
            }, false);
        }
    }
    
    // Gallery filter functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Update active filter button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter gallery items
            galleryItems.forEach(item => {
                if (filter === 'all' || item.getAttribute('data-category') === filter) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                    }, 10);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(10px)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
    
    // Edit Gallery Modal functionality
    const editButtons = document.querySelectorAll('.edit-gallery-btn');
    const editModal = document.getElementById('editGalleryModal');
    const editForm = document.getElementById('editGalleryForm');
    const currentGalleryImage = document.getElementById('current_gallery_image');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-id');
            const itemTitle = this.getAttribute('data-title');
            const itemCategory = this.getAttribute('data-category');
            const itemImage = this.getAttribute('data-image');
            
            // Set form action
            editForm.action = `/admin/gallery/${itemId}`;
            
            // Fill form fields
            document.getElementById('edit_gallery_title').value = itemTitle || '';
            document.getElementById('edit_gallery_category').value = itemCategory || '';
            currentGalleryImage.src = itemImage;
            
            // Show modal
            editModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
    });
    
    // Close modal when clicking outside
    editModal.addEventListener('click', function(e) {
        if (e.target === editModal) {
            closeEditGalleryModal();
        }
    });
    
    // Escape key to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !editModal.classList.contains('hidden')) {
            closeEditGalleryModal();
        }
    });
});

function closeEditGalleryModal() {
    const editModal = document.getElementById('editGalleryModal');
    editModal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Form validation for image upload
document.querySelectorAll('input[type="file"]').forEach(input => {
    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            const maxSize = 5 * 1024 * 1024; // 5MB for gallery images
            
            if (!validTypes.includes(file.type)) {
                alert('Please upload only image files (JPEG, PNG, GIF, WebP)');
                e.target.value = '';
                return;
            }
            
            if (file.size > maxSize) {
                alert('Image size should not exceed 5MB');
                e.target.value = '';
                return;
            }
        }
    });
});