$(document).ready(function() {
    // Use the correct offcanvas ID from your HTML
    const offcanvasId = $('#offcanvasRight');
    
    // Open the offcanvas form for creating or editing menu types
    $('.edit-menu-btn, .add-menu-btn').on('click', function(e) {
        e.preventDefault();
        const menuId = $(this).data('id');
        resetForm();
        
        if (menuId) {
            // Editing existing menu
            $.ajax({
                url: `/admin/get-menu-type/${menuId}`,
                type: 'GET',
                success: function(response) {
                    $('#menu-type-form #menu_id').val(response.id);
                    $('#menu-type-form input[name="name"]').val(response.name);
                    $('#menu-type-form textarea[name="description"]').val(response.description);
                    if (response.image) {
                        $('#current-image-preview').attr('src', `/storage/${response.image}`).show();
                        $('#current-image-container').show();
                    }
                    $('#offcanvasRightLabel').text('Edit Menu');
                    $('#saveMenuBtn').text('Update Menu');
                    
                    // Use Bootstrap 5's built-in method to show offcanvas
                    var offcanvasElement = document.getElementById('offcanvasRight');
                    var bsOffcanvas = new bootstrap.Offcanvas(offcanvasElement);
                    bsOffcanvas.show();
                },
                error: function(xhr) {
                    showAlert('error', 'Failed to load menu data');
                }
            });
        } else {
            // Creating new menu
            $('#offcanvasRightLabel').text('Add New Menu');
            $('#saveMenuBtn').text('Create Menu');
            
            // For the "+" button, we can let the data-bs-toggle handle showing the offcanvas
            // Only manually trigger it for other add buttons without the attribute
            if (!$(this).attr('data-bs-toggle')) {
                var offcanvasElement = document.getElementById('offcanvasRight');
                var bsOffcanvas = new bootstrap.Offcanvas(offcanvasElement);
                bsOffcanvas.show();
            }
        }
    });
    
    // Save menu (create or update)
    $('#menu-type-form').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const menuId = $('#menu_id').val();
        const url = '/admin/store-or-update';
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Close offcanvas - safer approach to get the offcanvas instance
                var offcanvasElement = document.getElementById('offcanvasRight');
                var bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
                if (bsOffcanvas) {
                    bsOffcanvas.hide();
                }
                
                
                success(response.message);
                
                window.location.href = window.location.origin + '/admin/menu/'+response.menu.id;

            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                let errorMessage = 'Error saving menu';
                
                if (errors) {
                    errorMessage = Object.values(errors).flat().join('<br>');
                }
                
                showAlert('error', errorMessage);
            }
        });
    });
    
    // Delete menu
    $('.delete-menu-btn').on('click', function(e) {
        e.preventDefault();
        
        const menuId = $(this).data('id');
        const menuName = $(this).data('name');
        
        if (confirm(`Are you sure you want to delete "${menuName}"?`)) {
            $.ajax({
                url: `/admin/delete/${menuId}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    showAlert('success', response.message);
                    
                    // Remove the menu card from the UI
                    $(`#menu-card-${menuId}`).fadeOut(300, function() {
                        $(this).remove();
                    });
                },
                error: function(xhr) {
                    showAlert('error', 'Failed to delete menu');
                }
            });
        }
    });
    
    // Reset form when offcanvas is closed
    $('#offcanvasRight').on('hidden.bs.offcanvas', function() {
        resetForm();
    });
    
    // Handle image preview
    $('#menu-image').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#new-image-preview').attr('src', e.target.result).show();
                $('#new-image-container').show();
            }
            reader.readAsDataURL(file);
        }
    });
    
    // Helper functions
    function resetForm() {
        $('#menu-type-form')[0].reset();
        $('#menu_id').val('');
        $('#current-image-preview').attr('src', '').hide();
        $('#new-image-preview').attr('src', '').hide();
        $('#current-image-container').hide();
        $('#new-image-container').hide();
        $('#menu-type-form .error').text('');
    }
    
    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        
        // Remove any existing alerts
        $('.alert-message').remove();
        
        // Create and show the alert
        const alert = `
            <div class="alert ${alertClass} alert-message alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        $('.card-header').after(alert);
        
        // Auto-dismiss after 5 seconds
        setTimeout(function() {
            $('.alert-message').alert('close');
        }, 5000);
    }
});