<?php

namespace Rankology\Actions\Admin\Importer;

defined('ABSPATH') or exit('Cheatin&#8217; uh?');

use Rankology\Core\Hooks\ExecuteHooksBackend;
use Rankology\Thirds\AIO\Tags;

class AIO implements ExecuteHooksBackend
{

    public $tagsAIO;

    public function __construct()
    {
        $this->tagsAIO = new Tags();
    }

    /**
     * 
     *
     * @return void
     */
    public function hooks()
    {
        add_action('wp_ajax_rankology_aio_migration', [$this, 'process']);
    }

    /**
     * 
     *
     * @param int $offset
     * @param int $increment
     */
    protected function migratePostQuery($offset, $increment) {
        global $wpdb;
        $args = [
            'posts_per_page' => $increment,
            'post_type'      => 'any',
            'post_status'    => 'any',
            'offset'         => $offset,
        ];
    
        $aio_query = get_posts($args);
    
        if (!$aio_query) {
            $offset += $increment;
            return $offset;
        }
    
        $getPostMetas = [
            '_rankology_titles_title'         => '_aioseo_title',
            '_rankology_titles_desc'          => '_aioseo_description',
            '_rankology_social_fb_title'      => '_aioseo_og_title',
            '_rankology_social_fb_desc'       => '_aioseo_og_description',
            '_rankology_social_twitter_title' => '_aioseo_twitter_title',
            '_rankology_social_twitter_desc'  => '_aioseo_twitter_description',
        ];
    
        foreach ($aio_query as $post) {
            foreach ($getPostMetas as $key => $value) {
                $metaAIO = get_post_meta($post->ID, $value, true);
                if (!empty($metaAIO)) {
                    update_post_meta($post->ID, $key, $this->tagsAIO->replaceTags($metaAIO));
                }
            }
    
            // Canonical URL
            $canonical_url = $wpdb->prepare(
                "SELECT p.canonical_url, p.post_id
                FROM {$wpdb->prefix}aioseo_posts p
                WHERE p.post_id = %d AND %s",
                $post->ID, '1=1'
            );
            $canonical_url = $wpdb->get_results($canonical_url, ARRAY_A);
    
            if (!empty($canonical_url[0]['canonical_url'])) {
                update_post_meta($post->ID, '_rankology_robots_canonical', $canonical_url[0]['canonical_url']);
            }
    
            // OG Image
            $og_img_url = $wpdb->prepare(
                "SELECT p.og_image_custom_url, p.post_id
                FROM {$wpdb->prefix}aioseo_posts p
                WHERE %s AND p.og_image_type = 'custom_image' AND p.post_id = %d",
                '1=1', $post->ID
            );
            $og_img_url = $wpdb->get_results($og_img_url, ARRAY_A);
    
            if (!empty($og_img_url[0]['og_image_custom_url'])) {
                update_post_meta($post->ID, '_rankology_social_fb_img', $og_img_url[0]['og_image_custom_url']);
            } elseif ('' != get_post_meta($post->ID, '_aioseop_opengraph_settings', true)) {
                $_aioseop_opengraph_settings = get_post_meta($post->ID, '_aioseop_opengraph_settings', true);
                if (isset($_aioseop_opengraph_settings['aioseop_opengraph_settings_image'])) {
                    update_post_meta($post->ID, '_rankology_social_fb_img', $_aioseop_opengraph_settings['aioseop_opengraph_settings_customimg']);
                }
            }
    
            // Twitter Image
            $tw_img_url = $wpdb->prepare(
                "SELECT p.twitter_image_custom_url, p.post_id
                FROM {$wpdb->prefix}aioseo_posts p
                WHERE %s AND p.twitter_image_type = 'custom_image' AND p.post_id = %d",
                '1=1', $post->ID
            );
            $tw_img_url = $wpdb->get_results($tw_img_url, ARRAY_A);
    
            if (!empty($tw_img_url[0]['twitter_image_custom_url'])) {
                update_post_meta($post->ID, '_rankology_social_twitter_img', $tw_img_url[0]['twitter_image_custom_url']);
            } elseif ('' != get_post_meta($post->ID, '_aioseop_opengraph_settings', true)) {
                $_aioseop_opengraph_settings = get_post_meta($post->ID, '_aioseop_opengraph_settings', true);
                if (isset($_aioseop_opengraph_settings['aioseop_opengraph_settings_customimg_twitter'])) {
                    update_post_meta($post->ID, '_rankology_social_twitter_img', $_aioseop_opengraph_settings['aioseop_opengraph_settings_customimg_twitter']);
                }
            }
    
            // Meta robots "noindex"
            $robots_noindex = $wpdb->prepare(
                "SELECT p.robots_noindex, p.post_id
                FROM {$wpdb->prefix}aioseo_posts p
                WHERE %s AND p.post_id = %d",
                '1=1', $post->ID
            );
            $robots_noindex = $wpdb->get_results($robots_noindex, ARRAY_A);
    
            if (!empty($robots_noindex[0]['robots_noindex']) && '1' === $robots_noindex[0]['robots_noindex']) {
                update_post_meta($post->ID, '_rankology_robots_index', 'yes');
            } elseif ('on' == get_post_meta($post->ID, '_aioseop_noindex', true)) {
                update_post_meta($post->ID, '_rankology_robots_index', 'yes');
            }
    
            // Meta robots "nofollow"
            $robots_nofollow = $wpdb->prepare(
                "SELECT p.robots_nofollow, p.post_id
                FROM {$wpdb->prefix}aioseo_posts p
                WHERE %s AND p.post_id = %d",
                '1=1', $post->ID
            );
            $robots_nofollow = $wpdb->get_results($robots_nofollow, ARRAY_A);
    
            if (!empty($robots_nofollow[0]['robots_nofollow']) && '1' === $robots_nofollow[0]['robots_nofollow']) {
                update_post_meta($post->ID, '_rankology_robots_follow', 'yes');
            } elseif ('on' == get_post_meta($post->ID, '_aioseop_nofollow', true)) {
                update_post_meta($post->ID, '_rankology_robots_follow', 'yes');
            }
    
            // Meta robots "noimageindex"
            $robots_noimageindex = $wpdb->prepare(
                "SELECT p.robots_noimageindex, p.post_id
                FROM {$wpdb->prefix}aioseo_posts p
                WHERE %s AND p.post_id = %d",
                '1=1', $post->ID
            );
            $robots_noimageindex = $wpdb->get_results($robots_noimageindex, ARRAY_A);
    
            if (!empty($robots_noimageindex[0]['robots_noimageindex']) && '1' === $robots_noimageindex[0]['robots_noimageindex']) {
                update_post_meta($post->ID, '_rankology_robots_imageindex', 'yes');
            }
    
            // Meta robots "nosnippet"
            $robots_nosnippet = $wpdb->prepare(
                "SELECT p.robots_nosnippet, p.post_id
                FROM {$wpdb->prefix}aioseo_posts p
                WHERE %s AND p.post_id = %d",
                '1=1', $post->ID
            );
            $robots_nosnippet = $wpdb->get_results($robots_nosnippet, ARRAY_A);
    
            if (!empty($robots_nosnippet[0]['robots_nosnippet']) && '1' === $robots_nosnippet[0]['robots_nosnippet']) {
                update_post_meta($post->ID, '_rankology_robots_snippet', 'yes');
            }
    
            // Meta robots "noarchive"
            $robots_noarchive = $wpdb->prepare(
                "SELECT p.robots_noarchive, p.post_id
                FROM {$wpdb->prefix}aioseo_posts p
                WHERE %s AND p.post_id = %d",
                '1=1', $post->ID
            );
            $robots_noarchive = $wpdb->get_results($robots_noarchive, ARRAY_A);
    
            if (!empty($robots_noarchive[0]['robots_noarchive']) && '1' === $robots_noarchive[0]['robots_noarchive']) {
                update_post_meta($post->ID, '_rankology_robots_archive', 'yes');
            }
    
            // Target keywords
            $keyphrases = $wpdb->prepare(
                "SELECT p.keyphrases, p.post_id
                FROM {$wpdb->prefix}aioseo_posts p
                WHERE %s AND p.post_id = %d",
                '1=1', $post->ID
            );
            $keyphrases = $wpdb->get_results($keyphrases, ARRAY_A);
    
            if (!empty($keyphrases)) {
                $keyphrases = json_decode($keyphrases[0]['keyphrases']);
    
                if (isset($keyphrases->focus->keyphrase)) {
                    $keyphrases = $keyphrases->focus->keyphrase;
    
                    if ('' != $keyphrases) {
                        update_post_meta($post->ID, '_rankology_analysis_target_kw', $keyphrases);
                    }
                }
            }
        }
    
        $offset += $increment;
        return $offset;
    }
    

    /**
     * 
     */
    public function process()
    {
        // Check AJAX nonce
        $nonce = isset($_POST['_ajax_nonce']) ? sanitize_text_field($_POST['_ajax_nonce']) : '';
        check_ajax_referer('rankology_aio_migrate_nonce', $nonce, true);

        // Check if user is logged in and has the required capability
        if (!is_admin() || !current_user_can(rankology_capability('manage_options', 'migration'))) {
            wp_send_json_error();
            return;
        }

        // Sanitize and validate offset
        $offset = isset($_POST['offset']) ? absint($_POST['offset']) : 0;

        global $wpdb;
        // Count total posts
        $total_count_posts = (int) $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE 1=1");

        $increment = 200;
        global $post;

        // Check if offset exceeds total post count
        if ($offset > $total_count_posts) {
            $offset = 'done';
        } else {
            // Migrate posts with the given offset
            $offset = $this->migratePostQuery($offset, $increment);
        }

        // Prepare response data
        $data = ['offset' => $offset];

        // Trigger custom action
        do_action('rankology_third_importer_aio', $offset, $increment);

        // Send JSON response
        wp_send_json_success($data);
        exit();
    }
}
