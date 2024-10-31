<?php
namespace Rankology\Thirds\WooCommerce;

if (!defined('ABSPATH')) {
    exit;
}

class WooCommerceAnalyticsService
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_footer', array($this, 'output_add_to_cart_script')); // Hook to wp_footer to output inline script
        add_action('wp_footer', array($this, 'output_single_add_to_cart_script')); // Hook to wp_footer to output inline script
    }

    /**
     * Enqueue JavaScript file and localize script data.
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script('rankology-woo-analytics', plugin_dir_url(__FILE__) . 'assets/js/woo-analytics.js', array('jquery'), null, true);

        // Localize script with data
        wp_localize_script('rankology-woo-analytics', 'rankologyWooAnalyticsData', array(
            'ajax_add_to_cart_class' => '.ajax_add_to_cart', // Define your class for ajax add to cart buttons
            'single_add_to_cart_class' => '.single_add_to_cart_button', // Define your class for single add to cart buttons
            'product_id' => esc_js($product->get_id()), // Example product ID, replace with dynamic ID if needed
            'items_purchased' => $this->prepare_items_purchased_data(), // Prepare items purchased data
        ));
    }

    /**
     * Prepare data for items purchased.
     */
    private function prepare_items_purchased_data()
    {
        global $product;

        $items_purchased = array(
            'id' => esc_js($product->get_id()),
            'name' => esc_js($product->get_title()),
            'list_name' => esc_js(get_the_title()),
            'quantity' => (float) esc_js(1),
            'price' => (float) esc_js($product->get_price()),
            'category' => $this->get_product_categories(),
        );

        return apply_filters('rankology_items_purchased_data', $items_purchased);
    }

    /**
     * Get product categories.
     */
    private function get_product_categories()
    {
        global $product;

        $categories_out = array();
        $categories = get_the_terms($product->get_id(), 'product_cat');

        if ($categories) {
            foreach ($categories as $category) {
                $categories_out[] = $category->name;
            }
        }

        return implode('/', $categories_out);
    }

    /**
     * Output JavaScript for adding to cart event.
     */
    public function output_add_to_cart_script()
    {
        $inline_script = "
            document.addEventListener('DOMContentLoaded', function() {
                document.addEventListener('click', function(event) {
                    if (!event.target.matches(rankologyWooAnalyticsData.ajax_add_to_cart_class)) {
                        return;
                    }

                    var id = null;
                    const namedItem = event.target.attributes.getNamedItem('data-product_id');

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
            });
        ";

        wp_add_inline_script('rankology-woo-analytics', $inline_script);
    }

    /**
     * Output JavaScript for single add to cart event.
     */
    public function output_single_add_to_cart_script()
    {
        $inline_script = "
            document.addEventListener('DOMContentLoaded', function() {
                document.addEventListener('click', function(event) {
                    if (!event.target.matches(rankologyWooAnalyticsData.single_add_to_cart_class)) {
                        return;
                    }

                    const quantity = document.querySelector('input.qty').value || '1';
                    const formProductVariation = document.querySelector('form[data-product_variations]');
                    const variationItem = document.querySelector('.variation_id');

                    let price = rankologyWooAnalyticsData.items_purchased.price;

                    if (formProductVariation && variationItem) {
                        try {
                            const variations = JSON.parse(formProductVariation.dataset.product_variations);
                            const variationId = variationItem.value;

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
        ";

        wp_add_inline_script('rankology-woo-analytics', $inline_script);
    }

    /**
     * Output JavaScript for remove from cart event.
     *
     * @param string $sprintf
     * @param string $cart_item_key
     * @return string
     */
    public function output_remove_from_cart_script($sprintf, $cart_item_key)
    {
        global $woocommerce;

        foreach ($woocommerce->cart->get_cart() as $key => $item) {
            if ($key == $cart_item_key) {
                $product = wc_get_product($item['product_id']);
                $items_purchased['quantity'] = (float) $item['quantity'];
            }
        }

        if ($product) {
            $items_purchased = array(
                'id' => esc_js($product->get_id()),
                'name' => esc_js($product->get_title()),
                'list_name' => esc_js(get_the_title()),
                'price' => (float) esc_js($product->get_price()),
                'category' => $this->get_product_categories(),
            );

            $inline_script = "
                document.addEventListener('DOMContentLoaded', function() {
                    document.addEventListener('click', function(event) {
                        if (!event.target.matches('.product-remove .remove')) {
                            return;
                        }

                        gtag('event', 'remove_from_cart', {'items': [ " . wp_json_encode($items_purchased) . " ]});
                    });
                });
            ";

            wp_add_inline_script('rankology-woo-analytics', $inline_script);
        }

        return apply_filters('rankology_gtag_ec_remove_from_cart_ev', $sprintf);
    }

    /**
     * Output JavaScript for update cart or checkout event.
     */
    public function output_update_cart_checkout_script()
    {
        global $woocommerce;
        $final = array();

        foreach ($woocommerce->cart->get_cart() as $key => $item) {
            $product = wc_get_product($item['product_id']);

            if ($product) {
                $items_purchased = array(
                    'id' => esc_js($product->get_id()),
                    'name' => esc_js($product->get_title()),
                    'list_name' => esc_js(get_the_title()),
                    'quantity' => (float) esc_js($item['quantity']),
                    'price' => (float) esc_js($product->get_price()),
                    'category' => $this->get_product_categories(),
                );

                $final[] = $items_purchased;
            }
        }

        $inline_script = "
            document.addEventListener('DOMContentLoaded', function() {
                document.addEventListener('click', function(event) {
                    if (!event.target.matches('.actions .button')) {
                        return;
                    }

                    gtag('event', 'remove_from_cart', {'items': " . wp_json_encode($final) . "});
                });
            });
        ";

        wp_add_inline_script('rankology-woo-analytics', $inline_script);
    }
}
?>
