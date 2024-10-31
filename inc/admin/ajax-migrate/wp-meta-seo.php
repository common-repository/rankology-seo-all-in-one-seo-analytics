<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

///////////////////////////////////////////////////////////////////////////////////////////////////
/* WP Meta SEO migration
* 
* @author Team Rankology 
*/
///////////////////////////////////////////////////////////////////////////////////////////////////
function rankology_wp_meta_seo_migration() {
    check_ajax_referer('rankology_meta_seo_migrate_nonce', '_ajax_nonce', true);

    if (current_user_can(rankology_capability('manage_options', 'migration')) && is_admin()) {
        $offset = isset($_POST['offset']) ? absint($_POST['offset']) : 0;

        global $wpdb;

        $total_count_posts = (int) $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE 1=1");
        $total_count_terms = (int) $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->terms WHERE 1=1");

        $increment = 200;

        if ($offset > $total_count_posts) {
            // Process terms if offset exceeds total posts
            $args = array(
                'hide_empty' => false,
                'fields'     => 'ids',
            );
            $wp_meta_seo_query_terms = get_terms($args);

            if ($wp_meta_seo_query_terms && !is_wp_error($wp_meta_seo_query_terms)) {
                foreach ($wp_meta_seo_query_terms as $term_id) {
                    $meta_title = get_term_meta($term_id, 'wpms_category_metatitle', true);
                    $meta_desc = get_term_meta($term_id, 'wpms_category_metadesc', true);

                    if (!empty($meta_title)) {
                        update_term_meta($term_id, '_rankology_titles_title', sanitize_text_field($meta_title));
                    }
                    if (!empty($meta_desc)) {
                        update_term_meta($term_id, '_rankology_titles_desc', sanitize_text_field($meta_desc));
                    }
                }
            }
            $offset = 'done';
        } else {
            // Process posts based on offset
            $args = array(
                'posts_per_page' => $increment,
                'post_type'      => 'any',
                'post_status'    => 'any',
                'offset'         => $offset,
            );

            $wp_meta_seo_query = get_posts($args);

            if ($wp_meta_seo_query) {
                foreach ($wp_meta_seo_query as $post) {
                    $meta_title = get_post_meta($post->ID, '_metaseo_metatitle', true);
                    $meta_desc = get_post_meta($post->ID, '_metaseo_metadesc', true);
                    $fb_title = get_post_meta($post->ID, '_metaseo_metaopengraph-title', true);
                    $fb_desc = get_post_meta($post->ID, '_metaseo_metaopengraph-desc', true);
                    $fb_image = get_post_meta($post->ID, '_metaseo_metaopengraph-image', true);
                    $twitter_title = get_post_meta($post->ID, '_metaseo_metatwitter-title', true);
                    $twitter_desc = get_post_meta($post->ID, '_metaseo_metatwitter-desc', true);
                    $twitter_image = get_post_meta($post->ID, '_metaseo_metatwitter-image', true);

                    if (!empty($meta_title)) {
                        update_post_meta($post->ID, '_rankology_titles_title', sanitize_text_field($meta_title));
                    }
                    if (!empty($meta_desc)) {
                        update_post_meta($post->ID, '_rankology_titles_desc', sanitize_text_field($meta_desc));
                    }
                    if (!empty($fb_title)) {
                        update_post_meta($post->ID, '_rankology_social_fb_title', sanitize_text_field($fb_title));
                    }
                    if (!empty($fb_desc)) {
                        update_post_meta($post->ID, '_rankology_social_fb_desc', sanitize_text_field($fb_desc));
                    }
                    if (!empty($fb_image)) {
                        update_post_meta($post->ID, '_rankology_social_fb_img', sanitize_text_field($fb_image));
                    }
                    if (!empty($twitter_title)) {
                        update_post_meta($post->ID, '_rankology_social_twitter_title', sanitize_text_field($twitter_title));
                    }
                    if (!empty($twitter_desc)) {
                        update_post_meta($post->ID, '_rankology_social_twitter_desc', sanitize_text_field($twitter_desc));
                    }
                    if (!empty($twitter_image)) {
                        update_post_meta($post->ID, '_rankology_social_twitter_img', sanitize_text_field($twitter_image));
                    }
                }
            }
            $offset += $increment;
        }

        // Prepare JSON response
        $data = array(
            'count' => $offset,
            'total' => $total_count_posts + $total_count_terms,
            'offset' => $offset,
        );

        wp_send_json_success($data);
        exit();
    }
}
add_action('wp_ajax_rankology_wp_meta_seo_migration', 'rankology_wp_meta_seo_migration');

