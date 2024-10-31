<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

/**
 * Handles the migration of Rankologyor settings.
 *
 * @return void
 */
function rankology_rankologyor_migration() {
    // Verify nonce for security
    check_ajax_referer('rankology_rankologyor_migrate_nonce', '_ajax_nonce', true);

    // Check user permissions and if we are in admin area
    if (!current_user_can(rankology_capability('manage_options', 'migration')) || !is_admin()) {
        wp_send_json_error(['message' => 'Insufficient permissions.']);
        exit;
    }

    // Initialize variables
    $offset = isset($_POST['offset']) ? absint($_POST['offset']) : 0;
    global $wpdb;

    // Get the total count of posts
    $total_count_posts = (int) $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts");

    $increment = 200;

    if ($offset > $total_count_posts) {
        wp_reset_query();
        wp_send_json_success(['offset' => 'done', 'total' => $total_count_posts, 'count' => $total_count_posts]);
        exit;
    }

    // Prepare and execute the query
    $args = [
        'posts_per_page' => $increment,
        'post_type'      => 'any',
        'post_status'    => 'any',
        'offset'         => $offset,
    ];

    $posts = get_posts($args);
    $updated_count = 0;

    if ($posts) {
        foreach ($posts as $post) {
            $seop_settings = get_post_meta($post->ID, '_seop_settings', true);

            if (!empty($seop_settings)) {
                update_post_meta($post->ID, '_rankology_titles_title', sanitize_text_field($seop_settings['meta_title'] ?? ''));
                update_post_meta($post->ID, '_rankology_titles_desc', sanitize_textarea_field($seop_settings['meta_description'] ?? ''));
                update_post_meta($post->ID, '_rankology_social_fb_title', sanitize_text_field($seop_settings['fb_title'] ?? ''));
                update_post_meta($post->ID, '_rankology_social_fb_desc', sanitize_textarea_field($seop_settings['fb_description'] ?? ''));
                update_post_meta($post->ID, '_rankology_social_fb_img', esc_url_raw($seop_settings['fb_img'] ?? ''));
                update_post_meta($post->ID, '_rankology_social_twitter_title', sanitize_text_field($seop_settings['tw_title'] ?? ''));
                update_post_meta($post->ID, '_rankology_social_twitter_desc', sanitize_textarea_field($seop_settings['tw_description'] ?? ''));
                update_post_meta($post->ID, '_rankology_social_twitter_img', esc_url_raw($seop_settings['tw_image'] ?? ''));

                // Import Robots Meta Tags
                if (!empty($seop_settings['meta_rules'])) {
                    $robots = explode('#|#|#', sanitize_text_field($seop_settings['meta_rules']));
                    $robots_mapping = [
                        'noindex'      => '_rankology_robots_index',
                        'nofollow'     => '_rankology_robots_follow',
                        'noarchive'    => '_rankology_robots_archive',
                        'nosnippet'    => '_rankology_robots_snippet',
                        'noimageindex' => '_rankology_robots_imageindex',
                    ];
                    
                    foreach ($robots_mapping as $rule => $meta_key) {
                        if (in_array($rule, $robots, true)) {
                            update_post_meta($post->ID, $meta_key, 'yes');
                        }
                    }
                }

                // Import Target Keywords
                $keywords = array_filter([
                    get_post_meta($post->ID, '_seop_kw_1', true),
                    get_post_meta($post->ID, '_seop_kw_2', true),
                    get_post_meta($post->ID, '_seop_kw_3', true),
                ]);

                if (!empty($keywords)) {
                    update_post_meta($post->ID, '_rankology_analysis_target_kw', implode(',', array_map('sanitize_text_field', $keywords)));
                }

                // Import Canonical URL
                update_post_meta($post->ID, '_rankology_robots_canonical', esc_url_raw($seop_settings['meta_canonical'] ?? ''));

                // Import Redirect URL
                if (!empty($seop_settings['meta_redirect'])) {
                    update_post_meta($post->ID, '_rankology_redirections_value', esc_url_raw($seop_settings['meta_redirect']));
                    update_post_meta($post->ID, '_rankology_redirections_enabled', 'yes');
                }
                
                $updated_count++;
            }
        }
    }

    // Update offset for next batch
    $offset += $increment;

    // Prepare the response
    $data = [
        'offset' => $offset >= $total_count_posts ? 'done' : $offset,
        'total'  => $total_count_posts,
        'count'  => $updated_count,
    ];

    wp_send_json_success($data);
    exit;
}
add_action('wp_ajax_rankology_rankologyor_migration', 'rankology_rankologyor_migration');
