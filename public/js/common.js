$(function () {
    // Search
    $('#customerSearch').on('click', function() {
        window.location = $(this).data('endpoint') + '?search=' + $('#customerSearchCriteria').val();
    });

    // Delete Customer
    $('body').delegate('.customer-delete', 'click', function () {
        if (confirm('Think again?')) {
            $('body').append("<form action='" + $(this).data('form-action') + "' method='POST' id='deleteForm' style='display: none;'>");
            $('#deleteForm').submit();
        }
    });

    // Show details modal
    $('.customer-show').on('click', function() {
        $('.modal-body').load($(this).data('href'), function(){
            $('#customerModal').modal('show');
        });
    });

    // Tooltips
    $('[data-toggle="tooltip"]').tooltip()
})
