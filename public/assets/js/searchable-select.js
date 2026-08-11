document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 on any element with the 'select2-search' class
    if (typeof jQuery !== 'undefined' && typeof jQuery.fn.select2 !== 'undefined') {
        $('.select2-search').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: 'Search and select...',
            allowClear: true
        });

        // Specific initialization for multiple select
        $('.select2-multiple').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: 'Search and select multiple...',
            allowClear: true,
            closeOnSelect: false
        });

        // Single select with free-type (taggable, single choice)
        $('.select2-tags').select2({
            theme: 'bootstrap-5',
            width: '100%',
            tags: true,
            allowClear: true,
            placeholder: 'Select or type a name'
        });

        // Notify other scripts that Select2 is ready
        document.dispatchEvent(new Event('select2:ready'));
    }
});
