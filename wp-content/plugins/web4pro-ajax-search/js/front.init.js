jQuery(function ($) {
    $('#filter').submit(function () {
        let filter = $(this);
        $.ajax({
            url: filter.attr('action'),
            data: filter.serialize(),
            type: filter.attr('method'),
            success: function (data) {
                 $('#response').html(data);
            }
        });
        return false;
    });
});
