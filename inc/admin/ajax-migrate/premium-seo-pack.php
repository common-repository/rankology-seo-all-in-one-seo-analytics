<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

///////////////////////////////////////////////////////////////////////////////////////////////////
/* Premium SEO Pack migration
* 
* @author Team Rankology 
*/
///////////////////////////////////////////////////////////////////////////////////////////////////
function rankology_premium_seo_pack_migration() {
    check_ajax_referer('rankology_premium_seo_pack_migrate_nonce', '_ajax_nonce', true);

    if (current_user_can(rankology_capability('manage_options', 'migration')) && is_admin()) {
        $offset = isset($_POST['offset']) ? absint($_POST['offset']) : 0;

        global $wpdb;

        $total_count_posts = (int) $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE 1=1");
        $total_count_terms = (int) $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->terms WHERE 1=1");

        $increment = 200;

        if ($offset > $total_count_posts) {
            // Import taxonomy SEO data
            $premium_query_terms = get_option('psp_taxonomy_seo');

            if ($premium_query_terms) {
                foreach ($premium_query_terms as $taxonomies => $taxonomie) {
                    foreach ($taxonomie as $term_id => $term_value) {
                        if (!empty($term_value['psp_meta']['title'])) {
                            update_term_meta($term_id, '_rankology_titles_title', sanitize_text_field($term_value['psp_meta']['title']));
                        }
                        // Add similar sanitization for other fields
                    }
                }
            }

            $offset = 'done'; // Ensure $offset is sanitized if used in further operations
        } else {
            // Query posts and import post meta
            $args = array(
                'posts_per_page' => $increment,
                'post_type'      => 'any',
                'post_status'    => 'any',
                'offset'         => $offset,
            );

            $premium_query = get_posts($args);

            if ($premium_query) {
                foreach ($premium_query as $post) {
                    $psp_meta = get_post_meta($post->ID, 'psp_meta', true);

                    if (!empty($psp_meta)) {
                        if (!empty($psp_meta['title'])) {
                            update_post_meta($post->ID, '_rankology_titles_title', sanitize_text_field($psp_meta['title']));
                        }
                        // Add similar sanitization for other fields
                    }
                }
            }

            $offset += $increment;
        }

        // Prepare and send JSON response
        $data = array(
            'count' => min($offset, $total_count_posts),
            'total' => $total_count_posts + $total_count_terms,
            'offset' => $offset,
        );

        wp_send_json_success($data);
        exit;
    }
}
add_action('wp_ajax_rankology_premium_seo_pack_migration', 'rankology_premium_seo_pack_migration');

