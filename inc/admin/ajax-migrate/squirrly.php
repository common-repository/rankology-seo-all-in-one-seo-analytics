<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

///////////////////////////////////////////////////////////////////////////////////////////////////
//Squirrly migration
///////////////////////////////////////////////////////////////////////////////////////////////////
function rankology_squirrly_migration() {
    // Verify the AJAX nonce
    check_ajax_referer('rankology_squirrly_migrate_nonce', '_ajax_nonce', true);

    // Check user capabilities and ensure the request is coming from an admin
    if (current_user_can(rankology_capability('manage_options', 'migration')) && is_admin()) {
        // Initialize the offset variable
        $offset = 0;

        // Validate and sanitize the offset parameter
        if (isset($_POST['offset'])) {
            $offset = absint($_POST['offset']);
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'qss';
        $blog_id = get_current_blog_id();

        // Prepare and execute the SQL query securely
        $count_query = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE blog_id = %d LIMIT %d, 100", $blog_id, $offset), ARRAY_A);

        // Check if the query returned any results
        if (!empty($count_query)) {
            foreach ($count_query as $value) {
                $post_id = url_to_postid(esc_url_raw($value['URL']));

                if ($post_id !== 0 && !empty($value['seo'])) {
                    $seo = maybe_unserialize($value['seo']);

                    // Sanitize and update post meta data
                    if (!empty($seo['title'])) {
                        update_post_meta($post_id, '_rankology_titles_title', sanitize_text_field($seo['title']));
                    }
                    if (!empty($seo['description'])) {
                        update_post_meta($post_id, '_rankology_titles_desc', sanitize_text_field($seo['description']));
                    }
                    if (!empty($seo['og_title'])) {
                        update_post_meta($post_id, '_rankology_social_fb_title', sanitize_text_field($seo['og_title']));
                    }
                    if (!empty($seo['og_description'])) {
                        update_post_meta($post_id, '_rankology_social_fb_desc', sanitize_text_field($seo['og_description']));
                    }
                    if (!empty($seo['og_media'])) {
                        update_post_meta($post_id, '_rankology_social_fb_img', esc_url_raw($seo['og_media']));
                    }
                    if (!empty($seo['tw_title'])) {
                        update_post_meta($post_id, '_rankology_social_twitter_title', sanitize_text_field($seo['tw_title']));
                    }
                    if (!empty($seo['tw_description'])) {
                        update_post_meta($post_id, '_rankology_social_twitter_desc', sanitize_text_field($seo['tw_description']));
                    }
                    if (!empty($seo['tw_media'])) {
                        update_post_meta($post_id, '_rankology_social_twitter_img', esc_url_raw($seo['tw_media']));
                    }
                    if (!empty($seo['noindex']) && $seo['noindex'] == 1) {
                        update_post_meta($post_id, '_rankology_robots_index', 'yes');
                    }
                    if (!empty($seo['nofollow']) && $seo['nofollow'] == 1) {
                        update_post_meta($post_id, '_rankology_robots_follow', 'yes');
                    }
                    if (!empty($seo['canonical'])) {
                        update_post_meta($post_id, '_rankology_robots_canonical', esc_url_raw($seo['canonical']));
                    }
                }
            }
            $offset += 100;
        } else {
            $offset = 'done';
        }

        // Prepare the response data
        $data = ['offset' => $offset];
        wp_send_json_success($data);
    } else {
        wp_send_json_error(['message' => 'Unauthorized request']);
    }
    exit();
}
add_action('wp_ajax_rankology_squirrly_migration', 'rankology_squirrly_migration');