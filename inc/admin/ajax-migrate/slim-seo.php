<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

///////////////////////////////////////////////////////////////////////////////////////////////////
// Slim SEO migration
///////////////////////////////////////////////////////////////////////////////////////////////////
function rankology_slim_seo_migration() {
    // Check nonce for security
    check_ajax_referer('rankology_slim_seo_migrate_nonce', '_ajax_nonce', true);

    // Ensure the user has appropriate permissions
    if (current_user_can(rankology_capability('manage_options', 'migration')) && is_admin()) {
        // Sanitize and validate the 'offset' parameter
        $offset = isset($_POST['offset']) ? absint($_POST['offset']) : 0;

        global $wpdb;
        // Prepare and execute SQL queries with proper escaping
        $total_count_posts = (int) $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->posts WHERE 1=1"));
        $total_count_terms = (int) $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->terms WHERE 1=1"));

        $increment = 200;
        global $post;

        if ($offset > $total_count_posts) {
            wp_reset_query();
            $count_items = $total_count_posts;

            $args = [
                'hide_empty' => false,
                'fields'     => 'ids',
            ];
            $slim_seo_query_terms = get_terms($args);

            if ($slim_seo_query_terms) {
                foreach ($slim_seo_query_terms as $term_id) {
                    if ('' != get_term_meta($term_id, 'slim_seo', true)) {
                        $term_settings = get_term_meta($term_id, 'slim_seo', true);

                        // Sanitize and update term meta
                        if (!empty($term_settings['title'])) {
                            update_term_meta($term_id, '_rankology_titles_title', sanitize_text_field($term_settings['title']));
                        }
                        if (!empty($term_settings['description'])) {
                            update_term_meta($term_id, '_rankology_titles_desc', sanitize_textarea_field($term_settings['description']));
                        }
                        if (!empty($term_settings['noindex'])) {
                            update_term_meta($term_id, '_rankology_robots_index', 'yes');
                        }
                        if (!empty($term_settings['facebook_image'])) {
                            update_term_meta($term_id, '_rankology_social_fb_img', esc_url_raw($term_settings['facebook_image']));
                        }
                        if (!empty($term_settings['twitter_image'])) {
                            update_term_meta($term_id, '_rankology_social_twitter_img', esc_url_raw($term_settings['twitter_image']));
                        }
                    }
                }
            }
            $offset = 'done';
            wp_reset_query();
        } else {
            $args = [
                'posts_per_page' => $increment,
                'post_type'      => 'any',
                'post_status'    => 'any',
                'offset'         => $offset,
            ];

            $slim_seo_query = get_posts($args);

            if ($slim_seo_query) {
                foreach ($slim_seo_query as $post) {
                    if ('' != get_post_meta($post->ID, 'slim_seo', true)) {
                        $post_settings = get_post_meta($post->ID, 'slim_seo', true);

                        // Sanitize and update post meta
                        if (!empty($post_settings['title'])) {
                            update_post_meta($post->ID, '_rankology_titles_title', sanitize_text_field($post_settings['title']));
                        }
                        if (!empty($post_settings['description'])) {
                            update_post_meta($post->ID, '_rankology_titles_desc', sanitize_textarea_field($post_settings['description']));
                        }
                        if (!empty($post_settings['noindex'])) {
                            update_post_meta($post->ID, '_rankology_robots_index', 'yes');
                        }
                        if (!empty($post_settings['facebook_image'])) {
                            update_post_meta($post->ID, '_rankology_social_fb_img', esc_url_raw($post_settings['facebook_image']));
                        }
                        if (!empty($post_settings['twitter_image'])) {
                            update_post_meta($post->ID, '_rankology_social_twitter_img', esc_url_raw($post_settings['twitter_image']));
                        }
                    }
                }
            }
            $offset += $increment;

            if ($offset >= $total_count_posts) {
                $count_items = $total_count_posts;
            } else {
                $count_items = $offset;
            }
        }
        $data = [
            'count'  => $count_items,
            'total'  => $total_count_posts + $total_count_terms,
            'offset' => $offset,
        ];

        wp_send_json_success($data);
        exit();
    }
}
add_action('wp_ajax_rankology_slim_seo_migration', 'rankology_slim_seo_migration');
