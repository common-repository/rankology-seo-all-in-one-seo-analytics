<?php
defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

function rankology_do_real_preview()
{

    check_ajax_referer('rankology_real_preview_nonce', sanitize_key(wp_unslash($_GET['_ajax_nonce'])), true);

    if (current_user_can('edit_posts') && is_admin()) {
        //Get cookies
        $cookies = [];
        $arr_val = rankology_esc_cook_val();
        if (!empty($arr_val) && is_array($arr_val)) {
            foreach ($arr_val as $name => $value) {
                if ('PHPSESSID' !== $name) {
                    $cookies[] = new WP_Http_Cookie(['name' => $name, 'value' => $value]);
                }
            }
        }

        //Get post id
		
		$rankology_get_the_id = isset($_GET['post_id']) ? absint($_GET['post_id']) : 0;

		if ($rankology_get_the_id) {
			if ('yes' == get_post_meta($rankology_get_the_id, '_rankology_redirections_enabled', true)) {
				$data['title'] = esc_html__('A redirect is active for this URL. Turn it off to get the Google preview and content analysis.', 'wp-rankology');
			} else {
            $cookies = [];
            $arr_val = rankology_esc_cook_val();
            if (!empty($arr_val) && is_array($arr_val)) {
                foreach ($arr_val as $name => $value) {
                    if ('PHPSESSID' !== $name) {
                        $cookies[] = new WP_Http_Cookie(['name' => $name, 'value' => $value]);
                    }
                }
            }

            //Get post type
            if (isset($_GET['post_type'])) {
                $rankology_get_post_type = sanitize_text_field($_GET['post_type']);
            } else {
                $rankology_get_post_type = null;
            }

            //Origin
            if (isset($_GET['origin'])) {
                $rankology_origin = sanitize_text_field($_GET['origin']);
            }

            //Tax name
            if (isset($_GET['tax_name'])) {
                $rankology_tax_name = sanitize_text_field($_GET['tax_name']);
            }

            //Init
            $title      = '';
            $meta_desc  = '';
            $link       = '';
            $data       = [];

            //Save Target KWs
            if (! isset($_GET['is_elementor'])) {
                if (isset($_GET['rankology_analysis_target_kw'])) {
                    delete_post_meta($rankology_get_the_id, '_rankology_analysis_target_kw');
                    update_post_meta($rankology_get_the_id, '_rankology_analysis_target_kw', sanitize_text_field($_GET['rankology_analysis_target_kw']));
                }
            }

            //Fix Elementor
            if (isset($_GET['is_elementor']) && true == $_GET['is_elementor']) {
                $_GET['rankology_analysis_target_kw'] = get_post_meta($rankology_get_the_id, '_rankology_analysis_target_kw', true);
            }

            //Check if Oxygen is enabled for this post type
            $oxygen_metabox_enabled = get_option('oxygen_vsb_ignore_post_type_'.$rankology_get_post_type) ? false : true;

            //DOM
            $dom                     = new DOMDocument();
            $internalErrors          = libxml_use_internal_errors(true);
            $dom->preserveWhiteSpace = false;

            //Get source code
            $args = [
                'blocking'    => true,
                'timeout'     => 10,
                'sslverify'   => false,
            ];

            if (isset($cookies) && ! empty($cookies)) {
                //required to avoid 500 error with WP Bakery
                if (!class_exists( 'Vc_Manager' )) {
                    $args['cookies'] = $cookies;
                }
            }
            $args = apply_filters('rankology_real_preview_remote', $args);

            $data['title'] = $cookies;

            if ('post' == $rankology_origin) { //Default: post type
                //Oxygen / beTheme compatibility
                $theme = wp_get_theme();
                if (
                    (is_plugin_active('oxygen/functions.php') && function_exists('ct_template_output') && $oxygen_metabox_enabled === true)
                    ||
                    ('betheme' == $theme->template || 'Betheme' == $theme->parent_theme)
                ) {
                    $link = get_permalink((int) $rankology_get_the_id);
                    $link = add_query_arg('no_admin_bar', 1, $link);

                    $response = wp_remote_get($link, $args);
                    if (200 !== wp_remote_retrieve_response_code($response)) {
                        $link = get_permalink((int) $rankology_get_the_id);
                        $response = wp_remote_get($link, $args);
                    }
                } else {
                    $custom_args = ['no_admin_bar' => 1];

                    //Useful for Page / Theme builders
                    $custom_args = apply_filters('rankology_real_preview_custom_args', $custom_args);

					$link = add_query_arg('no_admin_bar', 1, get_preview_post_link((int) $rankology_get_the_id, $custom_args));

					$link = apply_filters('rankology_get_dom_link', $link, $rankology_get_the_id);

                    $response = wp_remote_get($link, $args);
                }
            } else { //Term taxonomy
                $link = get_term_link((int) $rankology_get_the_id, $rankology_tax_name);
                $response = wp_remote_get($link, $args);
            }

            //Check for error
            if (is_wp_error($response) || '404' == wp_remote_retrieve_response_code($response)) {
                $data['title'] = esc_html__('To get your Google snippet preview, publish your post!', 'wp-rankology');
            } elseif (is_wp_error($response) || '401' == wp_remote_retrieve_response_code($response)) {
                $data['title'] = esc_html__('Your site is protected by an authentication.', 'wp-rankology');
            } else {
                $response = wp_remote_retrieve_body($response);

                if ($dom->loadHTML('<?xml encoding="utf-8" ?>' . $response)) {
                    if (is_plugin_active('oxygen/functions.php') && function_exists('ct_template_output') && $oxygen_metabox_enabled === true) {
                        $data = get_post_meta($rankology_get_the_id, '_rankology_analysis_data', true) ? get_post_meta($rankology_get_the_id, '_rankology_analysis_data', true) : $data = [];

                        if (! empty($data)) {
                            $data = array_slice($data, 0, 3);
                        }
                    }

                    $data['link_preview'] = $link;

                    //Disable wptexturize
                    add_filter('run_wptexturize', '__return_false');

                    //Get post content (used for Words counter)
                    $rankology_get_the_content = get_post_field('post_content', $rankology_get_the_id);
                    $rankology_get_the_content = apply_filters('rankology_dom_analysis_get_post_content', $rankology_get_the_content);

                    //Cornerstone compatibility
                    if (is_plugin_active('cornerstone/cornerstone.php')) {
                        $rankology_get_the_content = get_post_field('post_content', $rankology_get_the_id);
                    }

                    //ThriveBuilder compatibility
                    if (is_plugin_active('thrive-visual-editor/thrive-visual-editor.php') && empty($rankology_get_the_content)) {
                        $rankology_get_the_content = get_post_meta($rankology_get_the_id, 'tve_updated_post', true);
                    }

                    //Zion Builder compatibility
                    if (is_plugin_active('zionbuilder/zionbuilder.php')) {
                        $rankology_get_the_content = $rankology_get_the_content . get_post_meta($rankology_get_the_id, '_zionbuilder_page_elements', true);
                    }

                    //BeTheme is activated
                    $theme = wp_get_theme();
                    if ('betheme' == $theme->template || 'Betheme' == $theme->parent_theme) {
                        $rankology_get_the_content = $rankology_get_the_content . get_post_meta($rankology_get_the_id, 'mfn-page-items-seo', true);
                    }

                    //Themify compatibility
                    if (defined('THEMIFY_DIR') && method_exists('ThemifyBuilder_Data_Manager', '_get_all_builder_text_content')) {
                        global $rankology_themify_builder;
                        $builder_data = $rankology_themify_builder->get_builder_data($rankology_get_the_id);
                        $plain_text   = \ThemifyBuilder_Data_Manager::_get_all_builder_text_content($builder_data);
                        $plain_text   = do_shortcode($plain_text);

                        if ('' != $plain_text) {
                            $rankology_get_the_content = $plain_text;
                        }
                    }

                    //Add WC product excerpt
                    if ('product' == $rankology_get_post_type) {
                        $rankology_get_the_content =  $rankology_get_the_content . get_the_excerpt($rankology_get_the_id);
                    }

                    $rankology_get_the_content = apply_filters('rankology_content_analysis_content', $rankology_get_the_content, $rankology_get_the_id);

                    if (defined('WP_DEBUG') && WP_DEBUG === true) {
                        $data['analyzed_content'] = $rankology_get_the_content;
                    }

                    //Bricks compatibility
                    if (defined('BRICKS_DB_EDITOR_MODE') && ('bricks' == $theme->template || 'Bricks' == $theme->parent_theme)) {
                        $page_sections = get_post_meta($rankology_get_the_id, BRICKS_DB_PAGE_CONTENT, true);
                        $editor_mode   = get_post_meta($rankology_get_the_id, BRICKS_DB_EDITOR_MODE, true);

                        if (is_array($page_sections) && 'wordpress' !== $editor_mode) {
                            $rankology_get_the_content = Bricks\Frontend::render_data($page_sections);
                        }
                    }

                    // Ensure 'rankology_analysis_target_kw' is set and not empty
                    if (isset($_GET['rankology_analysis_target_kw']) && !empty($_GET['rankology_analysis_target_kw'])) {
                        // Sanitize and normalize the input
                        $target_kw_raw = $_GET['rankology_analysis_target_kw'];
                        $data['target_kws'] = esc_html(strtolower(sanitize_text_field($target_kw_raw)));

                        // Process the keywords
                        $rankology_analysis_target_kw = array_filter(
                            explode(',', strtolower(get_post_meta($rankology_get_the_id, '_rankology_analysis_target_kw', true)))
                        );

                        // Apply any filters to the target keywords
                        $rankology_analysis_target_kw = apply_filters(
                            'rankology_content_analysis_target_keywords',
                            $rankology_analysis_target_kw,
                            $rankology_get_the_id
                        );

                        // Get the count of keywords usage
                        $data['target_kws_count'] = rankology_get_service('CountTargetKeywordsUse')->getCountByKeywords(
                            $rankology_analysis_target_kw,
                            $rankology_get_the_id
                        );
                    }


                    $xpath = new DOMXPath($dom);

                    //Title
                    $list = $dom->getElementsByTagName('title');
                    if ($list->length > 0) {
                        $title         = $list->item(0)->textContent;
                        $data['title'] = esc_attr(stripslashes_deep(wp_filter_nohtml_kses($title)));
                        if (isset($_GET['rankology_analysis_target_kw']) && ! empty($_GET['rankology_analysis_target_kw'])) {
                            foreach ($rankology_analysis_target_kw as $kw) {
                                if (preg_match_all('#\b(' . $kw . ')\b#iu', $data['title'], $m)) {
                                    $data['meta_title']['matches'][$kw][] = $m[0];
                                }
                            }
                        }
                    }

                    //Meta desc
                    $meta_description = $xpath->query('//meta[@name="description"]/@content');

                    foreach ($meta_description as $key=>$mdesc) {
                        $data['meta_desc'] = esc_attr(stripslashes_deep(wp_filter_nohtml_kses(wp_strip_all_tags($mdesc->nodeValue))));
                    }

                    if (isset($_GET['rankology_analysis_target_kw']) && ! empty($_GET['rankology_analysis_target_kw'])) {
                        if (! empty($meta_description)) {
                            foreach ($meta_description as $meta_desc) {
                                foreach ($rankology_analysis_target_kw as $kw) {
                                    if (preg_match_all('#\b(' . $kw . ')\b#iu', $meta_desc->nodeValue, $m)) {
                                        $data['meta_description']['matches'][$kw][] = $m[0];
                                    }
                                }
                            }
                        }
                    }

                    //OG:title
                    $og_title = $xpath->query('//meta[@property="og:title"]/@content');

                    if (! empty($og_title)) {
                        $data['og_title']['count'] = count($og_title);
                        foreach ($og_title as $key=>$mogtitle) {
                            $data['og_title']['values'][] = esc_attr(stripslashes_deep(wp_filter_nohtml_kses($mogtitle->nodeValue)));
                        }
                    }

                    //OG:description
                    $og_desc = $xpath->query('//meta[@property="og:description"]/@content');

                    if (! empty($og_desc)) {
                        $data['og_desc']['count'] = count($og_desc);
                        foreach ($og_desc as $key=>$mog_desc) {
                            $data['og_desc']['values'][] = esc_attr(stripslashes_deep(wp_filter_nohtml_kses($mog_desc->nodeValue)));
                        }
                    }

                    //OG:image
                    $og_img = $xpath->query('//meta[@property="og:image"]/@content');

                    if (! empty($og_img)) {
                        $data['og_img']['count'] = count($og_img);
                        foreach ($og_img as $key=>$mog_img) {
                            $data['og_img']['values'][] = esc_attr(stripslashes_deep(wp_filter_nohtml_kses($mog_img->nodeValue)));
                        }
                    }

                    //OG:url
                    $og_url = $xpath->query('//meta[@property="og:url"]/@content');

                    if (! empty($og_url)) {
                        $data['og_url']['count'] = count($og_url);
                        foreach ($og_url as $key=>$mog_url) {
                            $url                        = esc_attr(stripslashes_deep(wp_filter_nohtml_kses($mog_url->nodeValue)));
                            $data['og_url']['values'][] = $url;
                            $url                        = wp_parse_url($url);
                            $data['og_url']['host']     = $url['host'];
                        }
                    }

                    //OG:site_name
                    $og_site_name = $xpath->query('//meta[@property="og:site_name"]/@content');

                    if (! empty($og_site_name)) {
                        $data['og_site_name']['count'] = count($og_site_name);
                        foreach ($og_site_name as $key=>$mog_site_name) {
                            $data['og_site_name']['values'][] = esc_attr(stripslashes_deep(wp_filter_nohtml_kses($mog_site_name->nodeValue)));
                        }
                    }

                    //Twitter:title
                    $tw_title = $xpath->query('//meta[@name="twitter:title"]/@content');

                    if (! empty($tw_title)) {
                        $data['tw_title']['count'] = count($tw_title);
                        foreach ($tw_title as $key=>$mtw_title) {
                            $data['tw_title']['values'][] = esc_attr(stripslashes_deep(wp_filter_nohtml_kses($mtw_title->nodeValue)));
                        }
                    }

                    //Twitter:description
                    $tw_desc = $xpath->query('//meta[@name="twitter:description"]/@content');

                    if (! empty($tw_desc)) {
                        $data['tw_desc']['count'] = count($tw_desc);
                        foreach ($tw_desc as $key=>$mtw_desc) {
                            $data['tw_desc']['values'][] = esc_attr(stripslashes_deep(wp_filter_nohtml_kses($mtw_desc->nodeValue)));
                        }
                    }

                    //Twitter:image
                    $tw_img = $xpath->query('//meta[@name="twitter:image"]/@content');

                    if (! empty($tw_img)) {
                        $data['tw_img']['count'] = count($tw_img);
                        foreach ($tw_img as $key=>$mtw_img) {
                            $data['tw_img']['values'][] = esc_attr(stripslashes_deep(wp_filter_nohtml_kses($mtw_img->nodeValue)));
                        }
                    }

                    //Twitter:image:src
                    $tw_img = $xpath->query('//meta[@name="twitter:image:src"]/@content');

                    if (! empty($tw_img)) {
                        $count = null;
                        if (! empty($data['tw_img']['count'])) {
                            $count = $data['tw_img']['count'];
                        }

                        $data['tw_img']['count'] = count($tw_img) + $count;

                        foreach ($tw_img as $key=>$mtw_img) {
                            $data['tw_img']['values'][] = esc_attr(stripslashes_deep(wp_filter_nohtml_kses($mtw_img->nodeValue)));
                        }
                    }

                    //Canonical
                    $canonical = $xpath->query('//link[@rel="canonical"]/@href');

                    foreach ($canonical as $key=>$mcanonical) {
                        $data['canonical'] = esc_attr(stripslashes_deep(wp_filter_nohtml_kses($mcanonical->nodeValue)));
                    }

                    foreach ($canonical as $key=>$mcanonical) {
                        $data['all_canonical'][] = esc_attr(stripslashes_deep(wp_filter_nohtml_kses($mcanonical->nodeValue)));
                    }

                    //h1
                    $h1 = $xpath->query('//h1');
                    if (! empty($h1)) {
                        $data['h1']['nomatches']['count'] = count($h1);
                        if (isset($_GET['rankology_analysis_target_kw']) && ! empty($_GET['rankology_analysis_target_kw'])) {
                            foreach ($h1 as $heading1) {
                                foreach ($rankology_analysis_target_kw as $kw) {
                                    if (preg_match_all('#\b(' . $kw . ')\b#iu', $heading1->nodeValue, $m)) {
                                        $data['h1']['matches'][$kw][] = $m[0];
                                    }
                                }
                                $data['h1']['values'][] = esc_attr($heading1->nodeValue);
                            }
                        }
                    }

                    if (isset($_GET['rankology_analysis_target_kw']) && ! empty($_GET['rankology_analysis_target_kw'])) {
                        //h2
                        $h2 = $xpath->query('//h2');
                        if (! empty($h2)) {
                            foreach ($h2 as $heading2) {
                                foreach ($rankology_analysis_target_kw as $kw) {
                                    if (preg_match_all('#\b(' . $kw . ')\b#iu', $heading2->nodeValue, $m)) {
                                        $data['h2']['matches'][$kw][] = $m[0];
                                    }
                                }
                            }
                        }

                        //h3
                        $h3 = $xpath->query('//h3');
                        if (! empty($h3)) {
                            foreach ($h3 as $heading3) {
                                foreach ($rankology_analysis_target_kw as $kw) {
                                    if (preg_match_all('#\b(' . $kw . ')\b#iu', $heading3->nodeValue, $m)) {
                                        $data['h3']['matches'][$kw][] = $m[0];
                                    }
                                }
                            }
                        }

                        //Keywords density
                        if (! is_plugin_active('oxygen/functions.php') && ! function_exists('ct_template_output')) { //disable for Oxygen
                            foreach ($rankology_analysis_target_kw as $kw) {
                                if (preg_match_all('#\b(' . $kw . ')\b#iu', stripslashes_deep(wp_strip_all_tags($rankology_get_the_content)), $m)) {
                                    $data['kws_density']['matches'][$kw][] = $m[0];
                                }
                            }
                        }

                        //Keywords in permalink
                        $post    = get_post($rankology_get_the_id);
                        $kw_slug = urldecode($post->post_name);

                        if (is_plugin_active('permalink-manager-pro/permalink-manager.php')) {
                            global $rankology_permalink_manager_uris;
                            $kw_slug = urldecode($rankology_permalink_manager_uris[$rankology_get_the_id]);
                        }

                        $kw_slug = str_replace('-', ' ', $kw_slug);

                        if (isset($kw_slug)) {
                            foreach ($rankology_analysis_target_kw as $kw) {
                                if (preg_match_all('#\b(' . remove_accents($kw) . ')\b#iu', strip_tags($kw_slug), $m)) {
                                    $data['kws_permalink']['matches'][$kw][] = $m[0];
                                }
                            }
                        }
                    }

                    //Images
                    /*Standard images*/
                    $imgs = $xpath->query('//img');

                    if (! empty($imgs) && null != $imgs) {
                        //init
                        $img_without_alt = [];
                        $img_with_alt = [];
                        foreach ($imgs as $img) {
                            if ($img->hasAttribute('src')) {
                                if (! preg_match_all('#\b(avatar)\b#iu', $img->getAttribute('class'), $m)) {//Exclude avatars from analysis
                                    if ($img->hasAttribute('width') || $img->hasAttribute('height')) {
                                        if ($img->getAttribute('width') > 1 || $img->getAttribute('height') > 1) {//Ignore files with width and heigh <= 1
                                            if ('' === $img->getAttribute('alt') || ! $img->hasAttribute('alt')) {//if alt is empty or doesn't exist
                                                $img_without_alt[] .= $img->getAttribute('src');
                                            } else {
                                                $img_with_alt[] .= $img->getAttribute('src');
                                            }
                                        }
                                    } elseif ('' === $img->getAttribute('alt') || ! $img->hasAttribute('alt')) {//if alt is empty or doesn't exist
                                        $img_src = download_url($img->getAttribute('src'));
                                        if (false === is_wp_error($img_src)) {
                                            if (filesize($img_src) > 100) {//Ignore files under 100 bytes
                                                $img_without_alt[] .= $img->getAttribute('src');
                                            } else {
                                                $img_with_alt[] .= $img->getAttribute('src');
                                            }
                                            @unlink($img_src);
                                        }
                                    }
                                }
                            }
                            $data['img']['images']['without_alt'] = $img_without_alt;
                            $data['img']['images']['with_alt'] = $img_with_alt;
                        }
                    }

                    //Meta robots
                    $meta_robots = $xpath->query('//meta[@name="robots"]/@content');
                    if (! empty($meta_robots)) {
                        foreach ($meta_robots as $key=>$value) {
                            $data['meta_robots'][$key][] = esc_attr($value->nodeValue);
                        }
                    }

                    //nofollow links
                    $nofollow_links = $xpath->query("//a[contains(@rel, 'nofollow') and not(contains(@rel, 'ugc'))]");
                    if (! empty($nofollow_links)) {
                        foreach ($nofollow_links as $key=>$link) {
                            if (! preg_match_all('#\b(cancel-comment-reply-link)\b#iu', $link->getAttribute('id'), $m) && ! preg_match_all('#\b(comment-reply-link)\b#iu', $link->getAttribute('class'), $m)) {
                                $data['nofollow_links'][$key][$link->getAttribute('href')] = esc_attr($link->nodeValue);
                            }
                        }
                    }
                }

                //outbound links
                $site_url       = wp_parse_url(get_home_url(), PHP_URL_HOST);
                $outbound_links = $xpath->query("//a[not(contains(@href, '" . $site_url . "'))]");
                if (! empty($outbound_links)) {
                    foreach ($outbound_links as $key=>$link) {
                        if (! empty(wp_parse_url($link->getAttribute('href'), PHP_URL_HOST))) {
                            $data['outbound_links'][$key][$link->getAttribute('href')] = esc_attr($link->nodeValue);
                        }
                    }
                }

                //Internal links
                $permalink = get_permalink((int) $rankology_get_the_id);
                $args      = [
                    's'         => $permalink,
                    'post_type' => 'any',
                ];
                $internal_links = new WP_Query($args);

                if ($internal_links->have_posts()) {
                    $data['internal_links']['count'] = $internal_links->found_posts;

                    while ($internal_links->have_posts()) {
                        $internal_links->the_post();
                        $data['internal_links']['links'][get_the_ID()] = [get_the_permalink() => get_the_title()];
                    }
                }
                wp_reset_postdata();

                //Internal links for Oxygen Builder
                if (is_plugin_active('oxygen/functions.php') && function_exists('ct_template_output') && $oxygen_metabox_enabled === true) {
                    $args      = [
                        'posts_per_page' => -1,
                        'meta_query' => [
                            [
                                'key' => 'ct_builder_shortcodes',
                                'value' => $permalink,
                                'compare' => 'LIKE'
                            ]
                        ],
                        'post_type' => 'any',
                    ];

                    $internal_links = new WP_Query($args);

                    if ($internal_links->have_posts()) {
                        $data['internal_links']['count'] = $internal_links->found_posts;

                        while ($internal_links->have_posts()) {
                            $internal_links->the_post();
                            $data['internal_links']['links'][get_the_ID()] = [get_the_permalink() => get_the_title()];
                        }
                    }
                    wp_reset_postdata();
                }

                //Words Counter
                if (! is_plugin_active('oxygen/functions.php') && ! function_exists('ct_template_output')) { //disable for Oxygen
                    if ('' != $rankology_get_the_content) {
                        $data['words_counter'] = preg_match_all("/\p{L}[\p{L}\p{Mn}\p{Pd}'\x{2019}]*/u", normalize_whitespace(wp_strip_all_tags($rankology_get_the_content)), $matches);

                        if (! empty($matches[0])) {
                            $words_counter_unique = count(array_unique($matches[0]));
                        } else {
                            $words_counter_unique = '0';
                        }
                        $data['words_counter_unique'] = $words_counter_unique;
                    }
                }

                //Get schemas
                $json_ld = $xpath->query('//script[@type="application/ld+json"]');
                if (! empty($json_ld)) {
                    foreach ($json_ld as $node) {
                        $json = json_decode($node->nodeValue, true);
                        if (isset($json['@type'])) {
                            $data['json'][] = $json['@type'];
                        }
                    }
                }
            }

            libxml_use_internal_errors($internalErrors);
        }

        //Send data
        if (isset($data)) {
            //Oxygen builder
            if (get_post_meta($rankology_get_the_id, '_rankology_analysis_data_oxygen', true)) {
                $data2 = get_post_meta($rankology_get_the_id, '_rankology_analysis_data_oxygen', true);
                $data  = $data + $data2;
            }
            update_post_meta($rankology_get_the_id, '_rankology_analysis_data', $data);
            delete_post_meta($rankology_get_the_id, '_rankology_content_analysis_api');
        }

        //Re-enable QM
        remove_filter('user_has_cap', 'rankology_disable_qm', 10, 3);

        //Return
        wp_send_json_success($data);
    }
}
}
add_action('wp_ajax_rankology_do_real_preview', 'rankology_do_real_preview');

///////////////////////////////////////////////////////////////////////////////////////////////////
//Dashboard toggle features
///////////////////////////////////////////////////////////////////////////////////////////////////
function rankology_toggle_features()
{
    check_ajax_referer('rankology_toggle_features_nonce', sanitize_key(wp_unslash($_POST['_ajax_nonce'])), true);

    if (current_user_can(rankology_capability('manage_options', 'dashboard')) && is_admin()) {
        if (isset($_POST['feature']) && isset($_POST['feature_value'])) {
            $rankology_toggle_options = get_option('rankology_toggle');
            $feature = sanitize_key($_POST['feature']);
            $feature_value = sanitize_text_field($_POST['feature_value']);
            $rankology_toggle_options[$feature] = $feature_value;
            update_option('rankology_toggle', $rankology_toggle_options, 'yes', false);
        }
        exit();
    }
}

add_action('wp_ajax_rankology_toggle_features', 'rankology_toggle_features');

///////////////////////////////////////////////////////////////////////////////////////////////////
//Dashboard Display Panel
///////////////////////////////////////////////////////////////////////////////////////////////////
function rankology_display()
{
    check_ajax_referer('rankology_display_nonce', sanitize_key(wp_unslash($_POST['_ajax_nonce'])), true);
    
    if (current_user_can(rankology_capability('manage_options', 'dashboard')) && is_admin()) {
        $rankology_advanced_option_name = get_option('rankology_advanced_option_name');

        // Notifications Center
        if (isset($_POST['notifications_center'])) {
            $notifications_center = sanitize_text_field($_POST['notifications_center']);
            if ('1' === $notifications_center) {
                $rankology_advanced_option_name['rankology_advanced_appearance_notifications'] = $notifications_center;
            } else {
                unset($rankology_advanced_option_name['rankology_advanced_appearance_notifications']);
            }
            update_option('rankology_advanced_option_name', $rankology_advanced_option_name, false);
        }

        // News Panel
        if (isset($_POST['news_center'])) {
            $news_center = sanitize_text_field($_POST['news_center']);
            if ('1' === $news_center) {
                $rankology_advanced_option_name['rankology_advanced_appearance_news'] = $news_center;
            } else {
                unset($rankology_advanced_option_name['rankology_advanced_appearance_news']);
            }
            update_option('rankology_advanced_option_name', $rankology_advanced_option_name, false);
        }

        // Tools Panel
        if (isset($_POST['tools_center'])) {
            $tools_center = sanitize_text_field($_POST['tools_center']);
            if ('1' === $tools_center) {
                $rankology_advanced_option_name['rankology_advanced_appearance_seo_tools'] = $tools_center;
            } else {
                unset($rankology_advanced_option_name['rankology_advanced_appearance_seo_tools']);
            }
            update_option('rankology_advanced_option_name', $rankology_advanced_option_name, false);
        }
        
        exit();
    }
}

add_action('wp_ajax_rankology_display', 'rankology_display');

///////////////////////////////////////////////////////////////////////////////////////////////////
//Dashboard hide notices
///////////////////////////////////////////////////////////////////////////////////////////////////
function rankology_hide_notices()
{
    check_ajax_referer('rankology_hide_notices_nonce', sanitize_key(wp_unslash($_POST['_ajax_nonce'])), true);

    if (current_user_can(rankology_capability('manage_options', 'dashboard')) && is_admin()) {
        if (isset($_POST['notice']) && isset($_POST['notice_value'])) {
            $notice = sanitize_text_field($_POST['notice']);
            $notice_value = sanitize_text_field($_POST['notice_value']);

            $rankology_notices_options = get_option('rankology_notices');
            $rankology_notices_options[$notice] = $notice_value;

            update_option('rankology_notices', $rankology_notices_options, 'yes', false);
        }
        exit();
    }
}

add_action('wp_ajax_rankology_hide_notices', 'rankology_hide_notices');

///////////////////////////////////////////////////////////////////////////////////////////////////
//Regenerate Video XML Sitemap
///////////////////////////////////////////////////////////////////////////////////////////////////
function rankology_video_xml_sitemap_regenerate()
{
    check_ajax_referer('rankology_video_regenerate_nonce', '_ajax_nonce', true);

    if (current_user_can(rankology_capability('manage_options', 'migration')) && is_admin()) {
        if (isset($_POST['offset'])) {
            $offset = absint($_POST['offset']);
        } else {
            $offset = 0; // Set default offset if not provided
        }

        $cpt = ['any'];
        $cpt_string = '';

        $post_types_list = rankology_get_service('SitemapOption')->getPostTypesList();
        if (!empty($post_types_list)) {
            $cpt = [];
            foreach ($post_types_list as $cpt_key => $cpt_value) {
                foreach ($cpt_value as $_cpt_key => $_cpt_value) {
                    if ('1' == $_cpt_value) {
                        $cpt[] = $_cpt_key;
                    }
                }
            }

            $cpt = array_map('esc_sql', $cpt);
            $cpt_placeholders = implode(',', array_fill(0, count($cpt), '%s'));
            $cpt_string = implode(',', array_map([$wpdb, 'prepare'], $cpt));
        }

        global $wpdb;

        // Prepare the query with placeholders for post_type
        $prepre_qry = $wpdb->prepare(
            "SELECT count(*) FROM {$wpdb->posts} WHERE post_status IN ('pending', 'draft', 'publish', 'future') AND post_type IN ($cpt_placeholders)",
            ...$cpt
        );
        $total_count_posts = (int) $wpdb->get_var($prepre_qry);

        $increment = 1;
        global $post;

        $data = [];

        if ($offset > $total_count_posts) {
            wp_reset_query();
            $count_items = $total_count_posts;
            $offset = 'done';
        } else {
            $args = [
                'posts_per_page' => $increment,
                'post_type'      => $cpt,
                'post_status'    => ['pending', 'draft', 'publish', 'future'],
                'offset'         => $offset,
            ];

            $video_query = new WP_Query($args);

            if ($video_query->have_posts()) {
                while ($video_query->have_posts()) {
                    $video_query->the_post();
                    rankology_fno_video_xml_sitemap($post->ID, $post);
                }
            }
            $offset += $increment;
        }

        $data['total'] = $total_count_posts;

        if ($offset >= $total_count_posts) {
            $data['count'] = $total_count_posts;
        } else {
            $data['count'] = $offset;
        }

        $data['offset'] = $offset;

        // Clear cache
        delete_transient('_rankology_sitemap_ids_video');

        wp_send_json_success($data);
        exit();
    }
}

add_action('wp_ajax_rankology_video_xml_sitemap_regenerate', 'rankology_video_xml_sitemap_regenerate');

require_once __DIR__ . '/ajax-migrate/smart-crawl.php';
require_once __DIR__ . '/ajax-migrate/rankologyfy.php';
require_once __DIR__ . '/ajax-migrate/slim-seo.php';
require_once __DIR__ . '/ajax-migrate/platinum.php';
require_once __DIR__ . '/ajax-migrate/wpseo.php';
require_once __DIR__ . '/ajax-migrate/premium-seo-pack.php';
require_once __DIR__ . '/ajax-migrate/wp-meta-seo.php';
require_once __DIR__ . '/ajax-migrate/seo-ultimate.php';
require_once __DIR__ . '/ajax-migrate/squirrly.php';
require_once __DIR__ . '/ajax-migrate/seo-framework.php';
require_once __DIR__ . '/ajax-migrate/yoast.php';
require_once __DIR__ . '/export/csv.php';
