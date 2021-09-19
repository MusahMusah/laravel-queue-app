$(document).ready(function() {
    $('#queueJob').click(function() {
        $.ajax({
            url: $(this).data('href'),
            method: 'GET',
            dataType: 'JSON',
            success: function(data) {
                Swal.fire('Your job is submitted. You will be notified when the task is completed')
            },
            error: function() {
                alert('Error Occured Please Try again later!')
            }
        })
    })
})