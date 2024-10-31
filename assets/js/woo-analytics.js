jQuery(document).ready(function($) {
    $(document).on('click', rankologyWooAnalyticsData.ajax_add_to_cart_class, function(event) {
        var id = null;
        const namedItem = event.target.attributes.getNamedItem('data-product_id');
        if (!event.target.matches(rankologyWooAnalyticsData.ajax_add_to_cart_class)) {
            return;
        }
        if (!namedItem) {
            try {
                id = getParameterByName('add-to-cart', new URL(event.target.href).search);
            } catch (e) {}
        } else {
            id = namedItem.value;
        }
        if (id != rankologyWooAnalyticsData.product_id) {
            return;
        }
        gtag('event', 'add_to_cart', {'items': [ rankologyWooAnalyticsData.items_purchased ]});
    });

    $(document).on('click', rankologyWooAnalyticsData.single_add_to_cart_class, function(event) {
        const quantity = $('input.qty').val() || '1';
        const formProductVariation = $('form[data-product_variations]');
        const variationItem = $('.variation_id');
        let price = rankologyWooAnalyticsData.items_purchased.price;
        if (formProductVariation.length && variationItem.length) {
            try {
                const variations = JSON.parse(formProductVariation.data('product_variations'));
                const variationId = variationItem.val();
                for (const variation of variations) {
                    if (variation.variation_id == Number(variationId)) {
                        price = variation.display_price;
                    }
                }
            } catch (e) {}
        }
        gtag('event', 'add_to_cart', {
            'items': [{
                'id': rankologyWooAnalyticsData.items_purchased.id,
                'name': rankologyWooAnalyticsData.items_purchased.name,
                'list_name': rankologyWooAnalyticsData.items_purchased.list_name,
                'quantity': quantity,
                'price': price,
                'category': rankologyWooAnalyticsData.items_purchased.category
            }]
        });
    });
});

function getParameterByName(name, url) {
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}
