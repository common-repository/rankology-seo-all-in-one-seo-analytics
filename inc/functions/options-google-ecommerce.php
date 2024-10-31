<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

if (is_plugin_active('woocommerce/woocommerce.php')) {
    // Measure Purchases
    $purchasesOptions = rankology_get_service('GoogleAnalyticsOption')->getPurchases();
    if (!$purchasesOptions) {
        return;
    }

    if (function_exists('is_order_received_page') && is_order_received_page()) {
        global $wp;
        $order_id = isset($wp->query_vars['order-received']) ? $wp->query_vars['order-received'] : 0;

        if (0 < $order_id && 1 != get_post_meta($order_id, '_rankology_ga_tracked', true)) {
            $order = wc_get_order($order_id);

            //Check it's a real order
            if (is_bool($order)) {
                return;
            }

            //Check order status
            $status = ['completed', 'processing'];
            $status = apply_filters('rankology_gtag_ec_status', $status);

            if (method_exists($order, 'get_status') && (in_array($order->get_status(), $status))) {
                $items_purchased = [];
                foreach ($order->get_items() as $item) {
                    // Get Product object
                    $_product = wc_get_product($item->get_product_id());

                    if ( ! is_a($_product, 'WC_Product')) {
                        continue;
                    }

                    // init vars
                    $item_id        = $_product->get_id();
                    $variation_id   = 0;
                    $variation_data = null;
                    $categories_js  = null;
                    $categories_out = [];
                    $variant_js     = null;

                    // Set data
                    $items_purchased['id']       = esc_js($item_id);
                    $items_purchased['name']     = esc_js($item->get_name());
                    $items_purchased['quantity'] = (float) esc_js($item->get_quantity());
                    $items_purchased['price']    = (float) esc_js($order->get_item_total($item));

                    // Categories and Variations
                    $categories = get_the_terms($item_id, 'product_cat');
                    if ($item->get_variation_id()) {
                        $variation_id   = $item->get_variation_id();
                        $variation_data = wc_get_product_variation_attributes($variation_id);
                    }

                    // Variations
                    if (is_array($variation_data) && ! empty($variation_data)) {
                        $variant_js = esc_js(wc_get_formatted_variation($variation_data, true));
                        $categories = get_the_terms($item_id, 'product_cat');
                        $item_id    = $variation_id;

                        $items_purchased['variant'] = esc_js($variant_js);
                    }
                    // Categories
                    if ($categories) {
                        foreach ($categories as $category) {
                            $categories_out[] = $category->name;
                        }
                        $categories_js = esc_js(implode('/', $categories_out));

                        $items_purchased['category'] = esc_js($categories_js);
                    }

                    $final[] = $items_purchased;
                }

                $global_purchase = [
                    'transaction_id' => esc_js($order_id),
                    'affiliation'    => esc_js(get_bloginfo('name')),
                    'value'          => (float) esc_js($order->get_total()),
                    'currency'       => esc_js($order->get_currency()),
                    'tax'            => (float) esc_js($order->get_total_tax()),
                    'shipping'       => (float) esc_js($order->get_shipping_total()),
                    'items'          => $final,
                ];

                $rankology_google_analytics_click_event['purchase_tracking'] = 'gtag(\'event\', \'purchase\',';
                $rankology_google_analytics_click_event['purchase_tracking'] .= json_encode($global_purchase);
                $rankology_google_analytics_click_event['purchase_tracking'] .= ');';
                $rankology_google_analytics_click_event['purchase_tracking'] = apply_filters('rankology_gtag_ec_purchases_ev', $rankology_google_analytics_click_event['purchase_tracking']);

                update_post_meta($order_id, '_rankology_ga_tracked', true);
            }
        }
    }
}

if (apply_filters('rankology_fallback_woocommerce_analytics', false)) {
    if (is_plugin_active('woocommerce/woocommerce.php')) {

        // ADD TO CART
        if (rankology_get_service('GoogleAnalyticsOption')->getAddToCart()) {

            // Listing page
            add_action('woocommerce_after_shop_loop_item', 'rankology_loop_add_to_cart');
            function rankology_loop_add_to_cart() {
                global $product;

                // Prepare data
                $items_purchased = array(
                    'id'        => esc_js($product->get_id()),
                    'name'      => esc_js($product->get_title()),
                    'list_name' => esc_js(get_the_title()),
                    'quantity'  => 1, // Assuming a single item is added from the loop
                    'price'     => (float) esc_js($product->get_price()),
                );

                // Extract categories
                $categories = get_the_terms($product->get_id(), 'product_cat');
                if ($categories) {
                    $categories_out = array();
                    foreach ($categories as $category) {
                        $categories_out[] = $category->name;
                    }
                    $items_purchased['category'] = esc_js(implode('/', $categories_out));
                }

                // Localize the script data
                wp_enqueue_script('rankology-add-to-cart-loop', '', [], null, true);
                wp_add_inline_script('rankology-add-to-cart-loop', "jQuery('.ajax_add_to_cart').unbind().click( function(){
                    gtag('event', 'add_to_cart', {'items': [ " . wp_json_encode($items_purchased) . " ]});
                });");

                // Allow further modifications via filter
                apply_filters('rankology_gtag_ec_add_to_cart_archive_ev', $items_purchased);
            }

            // Single product page
            add_action('woocommerce_after_add_to_cart_button', 'rankology_single_add_to_cart');
            function rankology_single_add_to_cart() {
                global $product;

                // Prepare data
                $items_purchased = array(
                    'id'        => esc_js($product->get_id()),
                    'name'      => esc_js($product->get_title()),
                    'list_name' => esc_js(get_the_title()),
                    'quantity'  => "jQuery('input.qty').val() ? jQuery('input.qty').val() : '1'",
                    'price'     => (float) esc_js($product->get_price()),
                );

                // Extract categories
                $categories = get_the_terms($product->get_id(), 'product_cat');
                if ($categories) {
                    $categories_out = array();
                    foreach ($categories as $category) {
                        $categories_out[] = $category->name;
                    }
                    $items_purchased['category'] = esc_js(implode('/', $categories_out));
                }

                // Localize the script data
                wp_enqueue_script('rankology-add-to-cart-single', '', [], null, true);
                // Localize the script data for the add-to-cart event
                wp_add_inline_script('rankology-add-to-cart-single', "
                    jQuery('.single_add_to_cart_button').click(function(){
                        gtag('event', 'add_to_cart', {
                            'items': [ " . wp_json_encode($items_purchased) . " ]
                        });
                    });
                ");
                // Allow further modifications via filter
                apply_filters('rankology_gtag_ec_add_to_cart_single_ev', $items_purchased);
            }
        }

        // REMOVE FROM CART
        if (rankology_get_service('GoogleAnalyticsOption')->getRemoveFromCart()) {
            // Cart page
            add_filter('woocommerce_cart_item_remove_link', 'rankology_cart_remove_from_cart', 10, 2);
            function rankology_cart_remove_from_cart($sprintf, $cart_item_key) {
                global $woocommerce;

                // Find the product in the cart
                foreach ($woocommerce->cart->get_cart() as $key => $item) {
                    if ($key === $cart_item_key) {
                        $product = wc_get_product($item['product_id']);
                        if ($product) {
                            // Prepare data
                            $items_purchased = array(
                                'id'        => esc_js($product->get_id()),
                                'name'      => esc_js($product->get_title()),
                                'list_name' => esc_js(get_the_title()),
                                'quantity'  => (float) esc_js($item['quantity']),
                                'price'     => (float) esc_js($product->get_price()),
                            );

                            // Extract categories
                            $categories = get_the_terms($product->get_id(), 'product_cat');
                            if ($categories) {
                                $categories_out = array();
                                foreach ($categories as $category) {
                                    if (is_object($category) && property_exists($category, 'name')) {
                                        $categories_out[] = $category->name;
                                    } elseif (is_array($category) && isset($category['name'])) {
                                        $categories_out[] = $category['name'];
                                    }
                                }
                                $items_purchased['category'] = esc_js(implode('/', $categories_out));
                            }

                            // Add inline script
                            $sprintf .= "<script>
                                jQuery('.product-remove .remove').unbind().click(function(){
                                    gtag('event', 'remove_from_cart', {'items': [ " . json_encode($items_purchased) . " ]});
                                });
                            </script>";
                        }
                    }
                }

                // Allow further modifications via filter
                $sprintf = apply_filters('rankology_gtag_ec_remove_from_cart_ev', $sprintf);

                return $sprintf;
            }
        }

        // UPDATE CART (cart / checkout pages)
        if (rankology_get_service('GoogleAnalyticsOption')->getAddToCart() && rankology_get_service('GoogleAnalyticsOption')->getRemoveFromCart()) {
            // Enqueue the script and localize data
            add_action('woocommerce_cart_actions', 'rankology_enqueue_gtag_events');
            function rankology_enqueue_gtag_events() {
                global $woocommerce;

                // Enqueue a script for the cart update events
                wp_enqueue_script('rankology-gtag-events', plugins_url('/assets/js/rankology-gtag-events.js', __FILE__), array('jquery'), null, true);

                // Prepare data
                $final = array();
                foreach ($woocommerce->cart->get_cart() as $item) {
                    $product = wc_get_product($item['product_id']);
                    if ($product) {
                        $items_purchased = array(
                            'id'        => esc_js($product->get_id()),
                            'name'      => esc_js($product->get_title()),
                            'list_name' => esc_js(get_the_title()),
                            'quantity'  => (float) esc_js($item['quantity']),
                            'price'     => (float) esc_js($product->get_price()),
                        );

                        // Extract categories
                        $categories = get_the_terms($product->get_id(), 'product_cat');
                        if ($categories) {
                            $categories_out = array();
                            foreach ($categories as $category) {
                                $categories_out[] = $category->name;
                            }
                            $items_purchased['category'] = esc_js(implode('/', $categories_out));
                        }

                        $final[] = $items_purchased;
                    }
                }

                // Localize the script with the cart items data
                wp_localize_script('rankology-gtag-events', 'rankology_cart_items', $final);
            }
        }
    }
}

