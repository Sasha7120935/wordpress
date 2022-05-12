jQuery(function ($) {
    $("#date-web4pro").on("change", function () {
        get_ajax_search()
    });
});
function get_ajax_search() {
    jQuery.ajax({
        url: web4pro.url,
        type: 'post',
        data: {
            action: 'web4pro_ajax_search',
            title: jQuery('#title-web4pro').val(),
            date: jQuery('#date-web4pro').val(),
            quantity: jQuery('#web4pro_filters').val()
        },
        success: function (data) {
            jQuery('#response').html(data);
        }
    });
    return false;
}
