<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

///////////////////////////////////////////////////////////////////////////////////////////////////
/* Platinum SEO migration
* 
* @author Team Rankology 
*/
///////////////////////////////////////////////////////////////////////////////////////////////////
function rankology_platinum_seo_migration() {
    check_ajax_referer('rankology_platinum_seo_migrate_nonce', sanitize_key(wp_unslash($_POST['_ajax_nonce'])), true);

    if (current_user_can(rankology_capability('manage_options', 'migration')) && is_admin()) {
        if (isset($_POST['offset']) && isset($_POST['offset'])) {
            $offset = absint($_POST['offset']);
        }

        global $wpdb;

        $total_count_posts = (int) $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM $wpdb->posts WHERE %s", '1=1'));
        $total_count_terms = (int) $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM $wpdb->terms WHERE %s", '1=1'));

        $increment = 200;
        global $post;

        if ($offset > $total_count_posts) {
            wp_reset_query();
            $count_items = $total_count_posts;

            $args = [
                'hide_empty' => false,
            ];
            $platinum_seo_query_terms = get_terms($args);

            if ($platinum_seo_query_terms) {
                foreach ($platinum_seo_query_terms as $term) {
                    if ( ! is_wp_error($term)) {
                        $tax = 'taxonomy';
                        if ('category' === $term->taxonomy) {
                            $tax = 'category';
                        }
                        if ('' != get_term_meta($term->term_id, 'prankology_rkseo_' . $tax . '_seo_metas_' . $term->term_id, true) || '' != get_term_meta($term->$term_id, 'prankology_rkseo_' . $tax . '_social_metas_' . $term->term_id, true)) {
                            $term_settings        = get_term_meta($term->term_id, 'prankology_rkseo_' . $tax . '_seo_metas_' . $term->term_id, true);
                            $term_social_settings = get_term_meta($term->term_id, 'prankology_rkseo_' . $tax . '_social_metas_' . $term->term_id, true);

                            if ( ! empty($term_settings['title'])) { //Import title tag
                                update_term_meta($term->term_id, '_rankology_titles_title', $term_settings['title']);
                            }
                            if ( ! empty($term_settings['description'])) { //Import meta desc
                                update_term_meta($term->term_id, '_rankology_titles_desc', $term_settings['description']);
                            }
                            if ( ! empty($term_social_settings['fb_title'])) { //Import Facebook Title
                                update_term_meta($term->term_id, '_rankology_social_fb_title', $term_social_settings['fb_title']);
                                update_term_meta($term->term_id, '_rankology_social_twitter_title', $term_social_settings['fb_title']);
                            }
                            if ( ! empty($term_social_settings['fb_description'])) { //Import Facebook Desc
                                update_term_meta($term->term_id, '_rankology_social_fb_desc', $term_social_settings['fb_description']);
                                update_term_meta($term->term_id, '_rankology_social_twitter_desc', $term_social_settings['fb_description']);
                            }
                            if ( ! empty($term_social_settings['fb_image'])) { //Import Facebook Image
                                update_term_meta($term->term_id, '_rankology_social_fb_img', $term_social_settings['fb_image']);
                                update_term_meta($term->term_id, '_rankology_social_twitter_img', $term_social_settings['fb_image']);
                            }
                            if ( ! empty($term_settings['canonical_url'])) { //Import Canonical URL
                                update_term_meta($term->term_id, '_rankology_robots_canonical', $term_settings['canonical_url']);
                            }
                            if ( ! empty($term_settings['redirect_to_url'])) { //Import Redirect URL
                                update_term_meta($term->term_id, '_rankology_redirections_value', $term_settings['redirect_to_url']);
                                update_term_meta($term->term_id, '_rankology_redirections_enabled', 'yes');
                                if ( ! empty($term_settings['redirect_status_code'])) {
                                    $status = $term_settings['redirect_status_code'];
                                    if ('303' === $term_settings['redirect_status_code']) {
                                        $status = '301';
                                    }

                                    update_term_meta($term->term_id, '_rankology_redirections_type', $status);
                                }
                            }
                            if ( ! empty($term_settings['noindex'])) { //Import Robots NoIndex
                                update_term_meta($term->term_id, '_rankology_robots_index', 'yes');
                            }
                            if ( ! empty($term_settings['nofollow'])) { //Import Robots NoFollow
                                update_term_meta($term->term_id, '_rankology_robots_follow', 'yes');
                            }
                            if ( ! empty($term_settings['noarchive'])) { //Import Robots NoArchive
                                update_term_meta($term->term_id, '_rankology_robots_archive', 'yes');
                            }
                            if ( ! empty($term_settings['nosnippet'])) { //Import Robots NoSnippet
                                update_term_meta($term->term_id, '_rankology_robots_snippet', 'yes');
                            }
                            if ( ! empty($term_settings['noimageindex'])) { //Import Robots NoImageIndex
                                update_term_meta($term->term_id, '_rankology_robots_imageindex', 'yes');
                            }
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

            $platinum_seo_query = get_posts($args);

            if ($platinum_seo_query) {
                foreach ($platinum_seo_query as $post) {
                    if ('' != get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_title', true)) { //Import title tag
                        update_post_meta($post->ID, '_rankology_titles_title', get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_title', true));
                    }
                    if ('' != get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_description', true)) { //Import meta desc
                        update_post_meta($post->ID, '_rankology_titles_desc', get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_description', true));
                    }
                    if ('' != get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_fb_title', true)) { //Import Facebook Title
                        update_post_meta($post->ID, '_rankology_social_fb_title', get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_fb_title', true));
                        update_post_meta($post->ID, '_rankology_social_twitter_title', get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_fb_title', true));
                    }
                    if ('' != get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_fb_description', true)) { //Import Facebook Desc
                        update_post_meta($post->ID, '_rankology_social_fb_desc', get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_fb_description', true));
                        update_post_meta($post->ID, '_rankology_social_twitter_desc', get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_fb_description', true));
                    }
                    if ('' != get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_fb_image', true)) { //Import Facebook Image
                        update_post_meta($post->ID, '_rankology_social_fb_img', get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_fb_image', true));
                        update_post_meta($post->ID, '_rankology_social_twitter_img', get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_fb_image', true));
                    }
                    if ('' != get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_keywords', true)) { //Import Target Keyword
                        update_post_meta($post->ID, '_rankology_analysis_target_kw', get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_keywords', true));
                    }
                    if ('' != get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_canonical_url', true)) { //Import Canonical URL
                        update_post_meta($post->ID, '_rankology_robots_canonical', get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_canonical_url', true));
                    }
                    if ('' != get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_redirect_to_url', true)) { //Import Redirect URL
                        update_post_meta($post->ID, '_rankology_redirections_value', get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_redirect_to_url', true));
                        update_post_meta($post->ID, '_rankology_redirections_enabled', 'yes'); //Enable the redirect

                        if ('' != get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_redirect_status_code', true)) {
                            $status = get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_redirect_status_code', true);
                            if ('303' === get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_redirect_status_code', true)) {
                                $status = '301';
                            }

                            update_term_meta($post->ID, '_rankology_redirections_type', $status);
                        }
                    }
                    if ('' != get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_noindex', true)) { //Import Robots NoIndex
                        update_post_meta($post->ID, '_rankology_robots_index', 'yes');
                    }
                    if ('' != get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_nofollow', true)) { //Import Robots NoFollow
                        update_post_meta($post->ID, '_rankology_robots_follow', 'yes');
                    }
                    if ('' != get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_noarchive', true)) { //Import Robots NoArchive
                        update_post_meta($post->ID, '_rankology_robots_archive', 'yes');
                    }
                    if ('' != get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_nosnippet', true)) { //Import Robots NoSnippet
                        update_post_meta($post->ID, '_rankology_robots_snippet', 'yes');
                    }
                    if ('' != get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_noimageidx', true)) { //Import Robots NoImageIndex
                        update_post_meta($post->ID, '_rankology_robots_imageindex', 'yes');
                    }
                    if ('' != get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_keywords', true)) { //Import Target Keywords
                        update_post_meta($post->ID, '_rankology_analysis_target_kw', get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_keywords', true));
                    }
                    if ('' != get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_preferred_term', true)) { //Import Primary category
                        if ('category' == get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_preferred_taxonomy', true) || 'product_cat' == get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_preferred_taxonomy', true)) {
                            update_post_meta($post->ID, '_rankology_robots_primary_cat', get_metadata('platinumseo', $post->ID, '_techblissonline_prankology_rkseo_preferred_term', true));
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
        $data           = [];

        $data['count']          = $count_items;
        $data['total']          = $total_count_posts + $total_count_terms;

        $data['offset'] = $offset;
        wp_send_json_success($data);
        exit();
    }
}
add_action('wp_ajax_rankology_platinum_seo_migration', 'rankology_platinum_seo_migration');
