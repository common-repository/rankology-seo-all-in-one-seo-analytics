<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

///////////////////////////////////////////////////////////////////////////////////////////////////
/* SEO Ultimate migration
* 
* @author Team Rankology 
*/
///////////////////////////////////////////////////////////////////////////////////////////////////
function rankology_seo_ultimate_migration() {
    check_ajax_referer('rankology_seo_ultimate_migrate_nonce', sanitize_key(wp_unslash($_POST['_ajax_nonce'])), true);

    if (current_user_can(rankology_capability('manage_options', 'migration')) && is_admin()) {
        if (isset($_POST['offset']) && isset($_POST['offset'])) {
            $offset = absint($_POST['offset']);
        }

        global $wpdb;

        $total_count_posts = (int) $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM $wpdb->posts WHERE %s", '1=1'));

        $increment = 200;
        global $post;

        if ($offset > $total_count_posts) {
            $offset = 'done';
            wp_reset_query();
        } else {
            $args = [
                'posts_per_page' => $increment,
                'post_type'      => 'any',
                'post_status'    => 'any',
                'offset'         => $offset,
            ];

            $su_query = get_posts($args);

            if ($su_query) {
                foreach ($su_query as $post) {
                    if ('' != get_post_meta($post->ID, '_su_title', true)) { //Import title tag
                        update_post_meta($post->ID, '_rankology_titles_title', get_post_meta($post->ID, '_su_title', true));
                    }
                    if ('' != get_post_meta($post->ID, '_su_description', true)) { //Import meta desc
                        update_post_meta($post->ID, '_rankology_titles_desc', get_post_meta($post->ID, '_su_description', true));
                    }
                    if ('' != get_post_meta($post->ID, '_su_og_title', true)) { //Import Facebook Title
                        update_post_meta($post->ID, '_rankology_social_fb_title', get_post_meta($post->ID, '_su_og_title', true));
                    }
                    if ('' != get_post_meta($post->ID, '_su_og_description', true)) { //Import Facebook Desc
                        update_post_meta($post->ID, '_rankology_social_fb_desc', get_post_meta($post->ID, '_su_og_description', true));
                    }
                    if ('' != get_post_meta($post->ID, '_su_og_image', true)) { //Import Facebook Image
                        update_post_meta($post->ID, '_rankology_social_fb_img', get_post_meta($post->ID, '_su_og_image', true));
                    }
                    if ('1' == get_post_meta($post->ID, '_su_meta_robots_noindex', true)) { //Import Robots NoIndex
                        update_post_meta($post->ID, '_rankology_robots_index', 'yes');
                    }
                    if ('1' == get_post_meta($post->ID, '_su_meta_robots_nofollow', true)) { //Import Robots NoFollow
                        update_post_meta($post->ID, '_rankology_robots_follow', 'yes');
                    }
                }
            }
            $offset += $increment;
        }
        $data           = [];
        $data['offset'] = $offset;

        $data['total'] = $total_count_posts;

        if ($offset >= $total_count_posts) {
            $data['count'] = $total_count_posts;
        } else {
            $data['count'] = $offset;
        }

        wp_send_json_success($data);
        exit();
    }
}
add_action('wp_ajax_rankology_seo_ultimate_migration', 'rankology_seo_ultimate_migration');
