//GA Enhanced Ecommerce
jQuery(document).ready(function ($) {
    jQuery(document.body).on('updated_cart_totals wc_cart_emptied removed_from_cart added_to_cart', function () {
        $.ajax({
            method: 'GET',
            url: rankologyAjaxAnalytics.rankology_analytics,
            data: {
                action: 'rankology_after_update_cart',
                _ajax_nonce: rankologyAjaxAnalytics.rankology_nonce,
            },
            success: function (data) {
                jQuery('body').append(data.data);
            },
        });
    });
});
