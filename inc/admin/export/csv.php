<?php
if ( ! defined('ABSPATH')) {
	exit;
}

///////////////////////////////////////////////////////////////////////////////////////////////////
//Export Rankology metadata to CSV
///////////////////////////////////////////////////////////////////////////////////////////////////
//WPML compatibility
add_filter('rankology_metadata_query_args', function ($args, $rankology_get_post_types, $increment, $offset) {
    if (defined('ICL_SITEPRESS_VERSION')) {
        global $sitepress, $rankology_sitepress_settings;

        $rankology_sitepress_settings['auto_adjust_ids'] = 0;
        remove_filter('terms_clauses', [$sitepress, 'terms_clauses']);
        remove_filter('category_link', [$sitepress, 'category_link_adjust_id'], 1);
    }
    return $args;
}, 10, 4);

function rankology_metadata_export() {
    check_ajax_referer('rankology_export_csv_metadata_nonce', sanitize_key(wp_unslash($_POST['_ajax_nonce'])), true);

    if ( ! is_admin()) {
        wp_send_json_error();

        return;
    }

    if ( ! current_user_can(rankology_capability('manage_options', 'migration'))) {
        wp_send_json_error();

        return;
    }

	if (isset($_POST['offset'])) {
		$offset = absint($_POST['offset']);
	}

	$post_export = '';
	if (isset($_POST['post_export'])) {
		$post_export = sanitize_text_field($_POST['post_export']);
	}

	$term_export = '';
	if (isset($_POST['term_export'])) {
		$term_export = sanitize_text_field($_POST['term_export']);
	}

    //Get post types
    $rankology_get_post_types = [];
    $postTypes = rankology_get_service('WordPressData')->getPostTypes();
    foreach ($postTypes as $rankology_cpt_key => $rankology_cpt_value) {
        $rankology_get_post_types[] = $rankology_cpt_key;
    }

    //Get taxonomies
    $rankology_get_taxonomies = [];
    foreach (rankology_get_service('WordPressData')->getTaxonomies() as $rankology_tax_key => $rankology_tax_value) {
        $rankology_get_taxonomies[] = $rankology_tax_key;
    }

    global $wpdb;
    global $post;

    //Count posts
    $count_items = 0;
    $i     = 1;
    $sql   = '(';
    $count = count($rankology_get_post_types);
    foreach ($rankology_get_post_types as $cpt) {
        $sql .= '(post_type = "' . $cpt . '")';

        if ($i < $count) {
            $sql .= ' OR ';
        }

        ++$i;
    }
    $sql .= ')';

    $total_count_posts = (int) $wpdb->get_var($wpdb->prepare("SELECT count(*)
    FROM {$wpdb->posts}
    WHERE %s
    AND (post_status = 'publish' OR post_status = 'pending' OR post_status = 'draft' OR post_status = 'auto-draft' OR post_status = 'future' OR post_status = 'private' OR post_status = 'inherit' OR post_status = 'trash') "), $sql);

    //Count terms
    $total_count_terms = (int) $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM $wpdb->terms WHERE %s", '1=1'));

    $increment = 200;

    $csv          = '';
    $csv          = get_option('rankology_metadata_csv');
    $download_url = '';

    $settings['id']              = 		[];
    $settings['post_title']      =		[];
    $settings['url']             =		[];
    $settings['slug']            =		[];
    $settings['meta_title']      =		[];
    $settings['meta_desc']       =		[];
    $settings['fb_title']        =		[];
    $settings['fb_desc']         =		[];
    $settings['fb_img']          =		[];
    $settings['tw_title']        =		[];
    $settings['tw_desc']         =		[];
    $settings['tw_img']          =		[];
    $settings['noindex']         =		[];
    $settings['nofollow']        =		[];
    $settings['noimageindex']    =		[];
    $settings['noarchive']       =		[];
    $settings['nosnippet']       =		[];
    $settings['canonical_url']   =      [];
    $settings['primary_cat']     =      [];
    $settings['redirect_active'] =      [];
    $settings['redirect_status'] =      [];
    $settings['redirect_type']   =      [];
    $settings['redirect_url']    =		[];
    $settings['target_kw']       =		[];

    $metas_key = [
        'meta_title' => '_rankology_titles_title',
        'meta_desc' => '_rankology_titles_desc',
        'fb_title' => '_rankology_social_fb_title',
        'fb_desc' => '_rankology_social_fb_desc',
        'fb_img' => '_rankology_social_fb_img',
        'tw_title' => '_rankology_social_twitter_title',
        'tw_desc' => '_rankology_social_twitter_desc',
        'tw_img' => '_rankology_social_twitter_img',
        'noindex' => '_rankology_robots_index',
        'nofollow' => '_rankology_robots_follow',
        'noimageindex' => '_rankology_robots_imageindex',
        'noarchive' => '_rankology_robots_archive',
        'nosnippet' => '_rankology_robots_snippet',
        'canonical_url' => '_rankology_robots_canonical',
        'primary_cat' => '_rankology_robots_primary_cat',
        'redirect_active' => '_rankology_redirections_enabled',
        'redirect_status' => '_rankology_redirections_logged_status',
        'redirect_type' => '_rankology_redirections_type',
        'redirect_url' => '_rankology_redirections_value',
        'target_kw' => '_rankology_analysis_target_kw',
    ];

    //Posts
    if ('done' != $post_export) {
        if ($offset > $total_count_posts) {
            wp_reset_query();
            $count_items = $total_count_posts;
            //Reset offset once Posts export is done
            $offset = 0;
            update_option('rankology_metadata_csv', $csv, false);
            $post_export = 'done';
        } else {
            $args = [
                'post_type'      => $rankology_get_post_types,
                'posts_per_page' => $increment,
                'offset'         => $offset,
                'post_status'    => 'any',
                'order'          => 'DESC',
                'orderby'        => 'date',
            ];
            $args       = apply_filters('rankology_metadata_query_args', $args, $rankology_get_post_types, $increment, $offset);
            $meta_query = get_posts($args);

            if ($meta_query) {
                // The Loop
                foreach ($meta_query as $post) {
                    array_push($settings['id'], $post->ID);

                    array_push($settings['post_title'], $post->post_title);

                    array_push($settings['url'], get_permalink($post));

                    array_push($settings['slug'], $post->post_name);

                    foreach($metas_key as $key => $meta_key) {
                        if (get_post_meta($post->ID, $meta_key, true)) {
                            array_push($settings[$key], get_post_meta($post->ID, $meta_key, true));
                        } else {
                            array_push($settings[$key], '');
                        }
                    }

                    $csv[] = array_merge(
                        $settings['id'],
                        $settings['post_title'],
                        $settings['url'],
                        $settings['slug'],
                        $settings['meta_title'],
                        $settings['meta_desc'],
                        $settings['fb_title'],
                        $settings['fb_desc'],
                        $settings['fb_img'],
                        $settings['tw_title'],
                        $settings['tw_desc'],
                        $settings['tw_img'],
                        $settings['noindex'],
                        $settings['nofollow'],
                        $settings['noimageindex'],
                        $settings['noarchive'],
                        $settings['nosnippet'],
                        $settings['canonical_url'],
                        $settings['primary_cat'],
                        $settings['redirect_active'],
                        $settings['redirect_status'],
                        $settings['redirect_type'],
                        $settings['redirect_url'],
                        $settings['target_kw']
                    );

                    //Clean arrays
                    $settings['id']              =	[];
                    $settings['post_title']      =	[];
                    $settings['url']             =	[];
                    $settings['slug']            =	[];
                    $settings['meta_title']      =	[];
                    $settings['meta_desc']       =	[];
                    $settings['fb_title']        =	[];
                    $settings['fb_desc']         =	[];
                    $settings['fb_img']          =	[];
                    $settings['tw_title']        =	[];
                    $settings['tw_desc']         =	[];
                    $settings['tw_img']          =	[];
                    $settings['noindex']         =	[];
                    $settings['nofollow']        =	[];
                    $settings['noimageindex']    =	[];
                    $settings['noarchive']       =	[];
                    $settings['nosnippet']       =	[];
                    $settings['canonical_url']   =	[];
                    $settings['primary_cat']     =	[];
                    $settings['redirect_active'] =	[];
                    $settings['redirect_status'] =  [];
                    $settings['redirect_type']   =	[];
                    $settings['redirect_url']    =	[];
                    $settings['target_kw']       =	[];
                }
            }
            $offset += $increment;

            if ($offset >= $total_count_posts) {
                $count_items = $total_count_posts;
            } else {
                $count_items = $offset;
            }

            update_option('rankology_metadata_csv', $csv, false);
        }
    } elseif ('done' != $term_export) {
        //Terms
        if ($offset > $total_count_terms) {
            $count_items = $total_count_terms + $total_count_posts;
            update_option('rankology_metadata_csv', $csv, false);
            $post_export = 'done';
            $term_export = 'done';
        } else {
            $args = [
                'taxonomy'   => $rankology_get_taxonomies,
                'taxonomy'   => 'type',
                'number'     => $increment,
                'offset'     => $offset,
                'order'      => 'DESC',
                'orderby'    => 'date',
                'hide_empty' => false,
            ];

            $args = apply_filters('rankology_metadata_query_terms_args', $args, $rankology_get_taxonomies, $increment, $offset);

            $meta_query = get_terms($args);

            if ($meta_query) {
                // The Loop
                foreach ($meta_query as $term) {
                    if ( is_wp_error($term)) {
                        continue;
                    }
                    if ( !is_object($term)) {
                        continue;
                    }
                    array_push($settings['id'], $term->term_id);

                    array_push($settings['post_title'], $term->name);

                    array_push($settings['url'], get_term_link($term));

                    array_push($settings['slug'], $term->slug);

                    foreach($metas_key as $key => $meta_key) {
                        if (get_term_meta($term->term_id, $meta_key, true)) {
                            array_push($settings[$key], get_term_meta($term->term_id, $meta_key, true));
                        } else {
                            array_push($settings[$key], '');
                        }
                    }

                    $csv[] = array_merge(
                        $settings['id'],
                        $settings['post_title'],
                        $settings['url'],
                        $settings['slug'],
                        $settings['meta_title'],
                        $settings['meta_desc'],
                        $settings['fb_title'],
                        $settings['fb_desc'],
                        $settings['fb_img'],
                        $settings['tw_title'],
                        $settings['tw_desc'],
                        $settings['tw_img'],
                        $settings['noindex'],
                        $settings['nofollow'],
                        $settings['noimageindex'],
                        $settings['noarchive'],
                        $settings['nosnippet'],
                        $settings['canonical_url'],
                        $settings['primary_cat'],
                        $settings['redirect_active'],
                        $settings['redirect_status'],
                        $settings['redirect_type'],
                        $settings['redirect_url'],
                        $settings['target_kw']
                    );

                    //Clean arrays
                    $settings['id']              = [];
                    $settings['post_title']      = [];
                    $settings['url']             = [];
                    $settings['slug']            = [];
                    $settings['meta_title']      = [];
                    $settings['meta_desc']       = [];
                    $settings['fb_title']        = [];
                    $settings['fb_desc']         = [];
                    $settings['fb_img']          = [];
                    $settings['tw_title']        = [];
                    $settings['tw_desc']         = [];
                    $settings['tw_img']          = [];
                    $settings['noindex']         = [];
                    $settings['nofollow']        = [];
                    $settings['noimageindex']    = [];
                    $settings['noarchive']       = [];
                    $settings['nosnippet']       = [];
                    $settings['canonical_url']   = [];
                    $settings['primary_cat']     = [];
                    $settings['redirect_active'] = [];
                    $settings['redirect_status'] = [];
                    $settings['redirect_type']   = [];
                    $settings['redirect_url']    = [];
                    $settings['target_kw']       = [];
                }
            }

            $offset += $increment;

            if ($offset >= $total_count_terms) {
                $count_items = $total_count_terms + $total_count_posts;
            } elseif ($offset === 200) {
                $count_items = $total_count_posts + 200;
            } else {
                $count_items += $offset;
            }
            $post_export = 'done';
            update_option('rankology_metadata_csv', $csv, false);
        }
    } else {
        $post_export = 'done';
        $term_export = 'done';
    }

    //Create download URL
    if ('done' == $post_export && 'done' == $term_export) {
        $all_get_data = rankology_esc_pst_val();
        $args = array_merge($all_get_data, [
            'nonce'           => wp_create_nonce('rankology_csv_batch_export_nonce'),
            'page'            => 'rankology-import-export',
            'rankology_action' => 'rankology_download_batch_export',
        ]);

        $download_url = add_query_arg($args, admin_url('admin.php'));

        $offset = 'done';
    }

    //Return data to JSON
    $data                   = [];

    $data['count']          = $count_items;
    $data['total']          = $total_count_posts + $total_count_terms;

    $data['offset']         = $offset;
    $data['url']            = $download_url;
    $data['post_export']    = $post_export;
    $data['term_export']    = $term_export;
    wp_send_json_success($data);
}

add_action('wp_ajax_rankology_metadata_export', 'rankology_metadata_export');
