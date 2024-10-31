<?php

defined('ABSPATH') or exit('Please don’t call the plugin directly. Thanks :)');

///////////////////////////////////////////////////////////////////////////////////////////////////
/* wpSEO migration
* 
* @author Team Rankology 
*/
///////////////////////////////////////////////////////////////////////////////////////////////////
function rankology_wpseo_migration() {
    // Verify the nonce for AJAX request
    check_ajax_referer('rankology_wpseo_migrate_nonce', '_ajax_nonce', true);

    // Ensure the user has the right capability and is in the admin area
    if (current_user_can(rankology_capability('manage_options', 'migration')) && is_admin()) {
        // Sanitize and validate offset
        $offset = isset($_POST['offset']) ? absint($_POST['offset']) : 0;

        global $wpdb;

        // Total counts of posts and terms
        $total_count_posts = (int) $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'publish'");
        $total_count_terms = (int) $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->terms");

        $increment = 200;

        if ($offset > $total_count_posts) {
            wp_reset_query();
            $count_items = $total_count_posts;

            $args = [
                'hide_empty' => false,
                'fields'     => 'ids',
            ];
            $wpseo_query_terms = get_terms($args);

            if ($wpseo_query_terms) {
                foreach ($wpseo_query_terms as $term_id) {
                    foreach (['title', 'desc', 'og_title', 'og_desc', 'og_image', 'canonical', 'redirect'] as $type) {
                        $option_key = "wpseo_category_{$term_id}_{$type}";
                        $meta_key = "_rankology_" . ($type === 'desc' ? 'titles_' : '') . ($type === 'redirect' ? 'redirections_value' : "social_{$type}");

                        $value = get_option($option_key);
                        if (!empty($value)) {
                            update_term_meta($term_id, $meta_key, $value);
                            if ($type === 'redirect') {
                                update_term_meta($term_id, '_rankology_redirections_enabled', 'yes');
                            }
                        }
                    }

                    // Handle robots meta
                    $robots = get_option("wpseo_category_{$term_id}_robots");
                    if (in_array($robots, ['3', '4', '5'], true)) {
                        update_term_meta($term_id, '_rankology_robots_index', 'yes');
                    }
                    if ($robots === '2') {
                        update_term_meta($term_id, '_rankology_robots_follow', 'yes');
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

            $wpseo_query = get_posts($args);

            if ($wpseo_query) {
                foreach ($wpseo_query as $post) {
                    foreach (['title', 'description', 'og_title', 'og_description', 'og_image', 'keyword_0', 'canonical', 'redirect'] as $type) {
                        $meta_key = "_wpseo_edit_" . str_replace('_', '', $type);
                        $rankology_meta_key = "_rankology_" . ($type === 'description' ? 'titles_' : '') . ($type === 'redirect' ? 'redirections_value' : ($type === 'keyword_0' ? 'analysis_target_kw' : "social_{$type}"));

                        $value = get_post_meta($post->ID, $meta_key, true);
                        if (!empty($value)) {
                            update_post_meta($post->ID, $rankology_meta_key, $value);
                            if ($type === 'redirect') {
                                update_post_meta($post->ID, '_rankology_redirections_enabled', 'yes');
                            }
                        }
                    }

                    // Handle robots meta
                    $robots = get_post_meta($post->ID, '_wpseo_edit_robots', true);
                    if (in_array($robots, ['3', '4', '5'], true)) {
                        update_post_meta($post->ID, '_rankology_robots_index', 'yes');
                    }
                    if ($robots === '2') {
                        update_post_meta($post->ID, '_rankology_robots_follow', 'yes');
                    }
                }
            }
            $offset += $increment;

            $count_items = ($offset >= $total_count_posts) ? $total_count_posts : $offset;
        }

        $data = [
            'count'  => $count_items,
            'total'  => $total_count_posts + $total_count_terms,
            'offset' => $offset,
        ];

        wp_send_json_success($data);
        exit();
    }

    wp_send_json_error(['message' => 'Permission denied or invalid request.']);
}
add_action('wp_ajax_rankology_wpseo_migration', 'rankology_wpseo_migration');
