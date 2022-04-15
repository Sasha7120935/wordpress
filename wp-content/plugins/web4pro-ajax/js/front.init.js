jQuery(function ($) {
    $('#filter').submit(function () {
        var filter = $('#filter');
        $.ajax({
            url: filter.attr('action'),
            data: filter.serialize(),
            type: filter.attr('method'),
            beforeSend: function (xhr) {
                filter.find('button').text('Search...');
            },
            success: function (data) {
                filter.find('button').text('Search');
               let e = $('#response').html(data);
                console.log(e)
            }
        });
        return false;
    });
});
