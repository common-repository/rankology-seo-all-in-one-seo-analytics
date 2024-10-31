<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

///////////////////////////////////////////////////////////////////////////////////////////////////
//Display metabox in Custom Post Type
///////////////////////////////////////////////////////////////////////////////////////////////////
function rankology_display_date_snippet()
{
    if (rankology_get_service('TitleOption')->getSingleCptDate() === '1') {
        return '<div class="snippet-date">' . get_the_modified_date('M j, Y') . ' - </div>';
    }
}

function rankology_metaboxes_init()
{
    global $typenow;
    global $pagenow;

    $data_attr             = [];
    $data_attr['data_tax'] = '';
    $data_attr['termId']   = '';

    if ('post-new.php' == $pagenow || 'post.php' == $pagenow) {
        $data_attr['current_id'] = get_the_id();
        $data_attr['origin']     = 'post';
        $data_attr['title']      = get_the_title($data_attr['current_id']);
    } elseif ('term.php' == $pagenow || 'edit-tags.php' == $pagenow) {
        global $tag;
        $data_attr['current_id'] = $tag->term_id;
        $data_attr['termId']     = $tag->term_id;
        $data_attr['origin']     = 'term';
        $data_attr['data_tax']   = $tag->taxonomy;
        $data_attr['title']      = $tag->name;
    }

    $data_attr['isHomeId'] = get_option('page_on_front');
    if ('0' === $data_attr['isHomeId']) {
        $data_attr['isHomeId'] = '';
    }

    return $data_attr;
}

function rankology_display_seo_metaboxe()
{
    add_action('add_meta_boxes', 'rankology_init_metabox');
    function rankology_init_metabox()
    {
        if (rankology_get_service('AdvancedOption')->getAppearanceMetaboxePosition() !== null) {
            $metaboxe_position = rankology_get_service('AdvancedOption')->getAppearanceMetaboxePosition();
        } else {
            $metaboxe_position = 'default';
        }

        $rankology_get_post_types = rankology_get_service('WordPressData')->getPostTypes();

        $rankology_get_post_types = apply_filters('rankology_metaboxe_seo', $rankology_get_post_types);

        if (!empty($rankology_get_post_types) && !rankology_get_service('EnqueueModuleMetabox')->canEnqueue()) {
            foreach ($rankology_get_post_types as $key => $value) {
                add_meta_box('rankology_cpt', esc_html__('On-Page SEO', 'wp-rankology'), 'rankology_cpt', $key, 'normal', $metaboxe_position);
            }
        }
        add_meta_box('rankology_cpt', esc_html__('On-Page SEO', 'wp-rankology'), 'rankology_cpt', 'rankology_404', 'normal', $metaboxe_position);
    }

    function rankology_cpt($post)
    {
        global $typenow;
        global $wp_version;
        $prefix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
        wp_nonce_field(plugin_basename(__FILE__), 'rankology_cpt_nonce');

        //init
        $disabled = [];

        wp_enqueue_script('rankology-cpt-tabs-js', RANKOLOGY_ASSETS_DIR . '/js/rankology-metabox' . $prefix . '.js', ['jquery-ui-tabs'], RANKOLOGY_VERSION);

        if ('rankology_404' != $typenow) {
            wp_enqueue_script('jquery-ui-accordion');

            //Tagify
            wp_enqueue_script('rankology-tagify-js', RANKOLOGY_ASSETS_DIR . '/js/tagify.min.js', ['jquery'], RANKOLOGY_VERSION, true);
            wp_register_style('rankology-tagify', RANKOLOGY_ASSETS_DIR . '/css/tagify.min.css', [], RANKOLOGY_VERSION);
            wp_enqueue_style('rankology-tagify');

            //Register Google Preview / Content Analysis JS
            wp_enqueue_script('rankology-cpt-counters-js', RANKOLOGY_ASSETS_DIR . '/js/rankology-counters' . $prefix . '.js', ['jquery', 'jquery-ui-tabs', 'jquery-ui-accordion'], RANKOLOGY_VERSION, true);

            //If Gutenberg ON
            if (function_exists('get_current_screen')) {
                $get_current_screen = get_current_screen();
                if (isset($get_current_screen->is_block_editor)) {
                    if ($get_current_screen->is_block_editor) {
                        wp_enqueue_script('rankology-block-editor-js', RANKOLOGY_ASSETS_DIR . '/js/rankology-block-editor' . $prefix . '.js', ['jquery'], RANKOLOGY_VERSION, true);
                        if (version_compare($wp_version, '5.8', '>=')) {
                            global $pagenow;

                            if (('post' == $typenow || 'product' == $typenow) && ('post.php' == $pagenow || 'post-new.php' == $pagenow)) {
                                wp_enqueue_script('rankology-primary-category-js', RANKOLOGY_URL_PUBLIC . '/editor/primary-category-select/index.js', ['wp-hooks'], RANKOLOGY_VERSION, true);
                            }
                        }
                    }
                }
            }

            wp_enqueue_script('rankology-cpt-video-sitemap-js', RANKOLOGY_ASSETS_DIR . '/js/rankology-sitemap-video' . $prefix . '.js', ['jquery', 'jquery-ui-accordion'], RANKOLOGY_VERSION);

            $rankology_real_preview = [
                'rankology_nonce'         => wp_create_nonce('rankology_real_preview_nonce'), // @
                'rankology_real_preview'  => admin_url('admin-ajax.php'), // @
                'i18n'                   => ['progress'  => esc_html__('Analysis in progress...', 'wp-rankology')],
                'ajax_url'               => admin_url('admin-ajax.php'),
                'get_preview_meta_title' => wp_create_nonce('get_preview_meta_title'),
            ];
            wp_localize_script('rankology-cpt-counters-js', 'rankologyAjaxRealPreview', $rankology_real_preview);

            wp_enqueue_script('rankology-media-uploader-js', RANKOLOGY_ASSETS_DIR . '/js/rankology-media-uploader' . $prefix . '.js', ['jquery'], RANKOLOGY_VERSION, false);
            wp_enqueue_media();
        }

        $rankology_titles_title                  = get_post_meta($post->ID, '_rankology_titles_title', true);
        $rankology_titles_desc                   = get_post_meta($post->ID, '_rankology_titles_desc', true);

        $disabled['robots_index'] = '';
        if (rankology_get_service('TitleOption')->getSingleCptNoIndex() || rankology_get_service('TitleOption')->getTitleNoIndex() || true === post_password_required($post->ID)) {
            $rankology_robots_index              = 'yes';
            $disabled['robots_index']           = 'disabled';
        } else {
            $rankology_robots_index              = get_post_meta($post->ID, '_rankology_robots_index', true);
        }

        $disabled['robots_follow'] = '';
        if (rankology_get_service('TitleOption')->getSingleCptNoFollow() || rankology_get_service('TitleOption')->getTitleNoFollow()) {
            $rankology_robots_follow             = 'yes';
            $disabled['robots_follow']          = 'disabled';
        } else {
            $rankology_robots_follow             = get_post_meta($post->ID, '_rankology_robots_follow', true);
        }

        $disabled['archive'] = '';
        if (rankology_get_service('TitleOption')->getTitleNoArchive()) {
            $rankology_robots_archive            = 'yes';
            $disabled['archive']                = 'disabled';
        } else {
            $rankology_robots_archive            = get_post_meta($post->ID, '_rankology_robots_archive', true);
        }

        $disabled['snippet'] = '';
        if (rankology_get_service('TitleOption')->getTitleNoSnippet()) {
            $rankology_robots_snippet            = 'yes';
            $disabled['snippet']                = 'disabled';
        } else {
            $rankology_robots_snippet            = get_post_meta($post->ID, '_rankology_robots_snippet', true);
        }

        $disabled['imageindex'] = '';
        if (rankology_get_service('TitleOption')->getTitleNoImageIndex()) {
            $rankology_robots_imageindex         = 'yes';
            $disabled['imageindex']             = 'disabled';
        } else {
            $rankology_robots_imageindex         = get_post_meta($post->ID, '_rankology_robots_imageindex', true);
        }

        $rankology_robots_canonical              = get_post_meta($post->ID, '_rankology_robots_canonical', true);
        $rankology_robots_primary_cat            = get_post_meta($post->ID, '_rankology_robots_primary_cat', true);
        $rankology_social_fb_title               = get_post_meta($post->ID, '_rankology_social_fb_title', true);
        $rankology_social_fb_desc                = get_post_meta($post->ID, '_rankology_social_fb_desc', true);
        $rankology_social_fb_img                 = get_post_meta($post->ID, '_rankology_social_fb_img', true);
        $rankology_social_fb_img_attachment_id   = get_post_meta($post->ID, '_rankology_social_fb_img_attachment_id', true);
        $rankology_social_fb_img_width           = get_post_meta($post->ID, '_rankology_social_fb_img_width', true);
        $rankology_social_fb_img_height          = get_post_meta($post->ID, '_rankology_social_fb_img_height', true);
        $rankology_social_twitter_title          = get_post_meta($post->ID, '_rankology_social_twitter_title', true);
        $rankology_social_twitter_desc           = get_post_meta($post->ID, '_rankology_social_twitter_desc', true);
        $rankology_social_twitter_img            = get_post_meta($post->ID, '_rankology_social_twitter_img', true);
        $rankology_social_twitter_img_attachment_id            = get_post_meta($post->ID, '_rankology_social_twitter_img_attachment_id', true);
        $rankology_social_twitter_img_width      = get_post_meta($post->ID, '_rankology_social_twitter_img_width', true);
        $rankology_social_twitter_img_height     = get_post_meta($post->ID, '_rankology_social_twitter_img_height', true);
        $rankology_redirections_enabled          = get_post_meta($post->ID, '_rankology_redirections_enabled', true);
        $rankology_redirections_enabled_regex    = get_post_meta($post->ID, '_rankology_redirections_enabled_regex', true);
        $rankology_redirections_logged_status    = get_post_meta($post->ID, '_rankology_redirections_logged_status', true);
        $rankology_redirections_type             = get_post_meta($post->ID, '_rankology_redirections_type', true);
        $rankology_redirections_value            = get_post_meta($post->ID, '_rankology_redirections_value', true);
        $rankology_redirections_param            = get_post_meta($post->ID, '_rankology_redirections_param', true);

        require_once dirname(dirname(__FILE__)) . '/admin-dyn-variables-helper.php'; //Dynamic variables

        require_once dirname(__FILE__) . '/admin-metaboxes-form.php'; //Metaboxe HTML

        do_action('rankology_seo_metabox_init');
    }

    add_action('save_post', 'rankology_save_metabox', 10, 2);

    function rankology_save_metabox($post_id, $post)
    {
        // Verify nonce
        if (!isset($_POST['rankology_cpt_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['rankology_cpt_nonce'])), plugin_basename(__FILE__))) {
            return $post_id;
        }

        // Check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        // Check post type and user capabilities
        $post_type = get_post_type_object($post->post_type);
        if (!current_user_can($post_type->cap->edit_post, $post_id)) {
            return $post_id;
        }

        if ('attachment' !== get_post_type($post_id)) {
            $seo_tabs = isset($_POST['seo_tabs']) ? json_decode(stripslashes(htmlspecialchars_decode(sanitize_text_field($_POST['seo_tabs']))), true) : [];

            if (in_array('title-tab', $seo_tabs)) {
                if (!empty($_POST['rankology_titles_title'])) {
                    update_post_meta($post_id, '_rankology_titles_title', sanitize_text_field($_POST['rankology_titles_title']));
                } else {
                    delete_post_meta($post_id, '_rankology_titles_title');
                }
                if (!empty($_POST['rankology_titles_desc'])) {
                    update_post_meta($post_id, '_rankology_titles_desc', sanitize_textarea_field($_POST['rankology_titles_desc']));
                } else {
                    delete_post_meta($post_id, '_rankology_titles_desc');
                }
            }

            if (in_array('advanced-tab', $seo_tabs)) {
                if (isset($_POST['rankology_robots_index'])) {
                    update_post_meta($post_id, '_rankology_robots_index', 'yes');
                } else {
                    delete_post_meta($post_id, '_rankology_robots_index');
                }
                if (isset($_POST['rankology_robots_follow'])) {
                    update_post_meta($post_id, '_rankology_robots_follow', 'yes');
                } else {
                    delete_post_meta($post_id, '_rankology_robots_follow');
                }
                if (isset($_POST['rankology_robots_imageindex'])) {
                    update_post_meta($post_id, '_rankology_robots_imageindex', 'yes');
                } else {
                    delete_post_meta($post_id, '_rankology_robots_imageindex');
                }
                if (isset($_POST['rankology_robots_archive'])) {
                    update_post_meta($post_id, '_rankology_robots_archive', 'yes');
                } else {
                    delete_post_meta($post_id, '_rankology_robots_archive');
                }
                if (isset($_POST['rankology_robots_snippet'])) {
                    update_post_meta($post_id, '_rankology_robots_snippet', 'yes');
                } else {
                    delete_post_meta($post_id, '_rankology_robots_snippet');
                }
                if (!empty($_POST['rankology_robots_canonical'])) {
                    update_post_meta($post_id, '_rankology_robots_canonical', esc_url_raw($_POST['rankology_robots_canonical']));
                } else {
                    delete_post_meta($post_id, '_rankology_robots_canonical');
                }
                if (!empty($_POST['rankology_robots_primary_cat'])) {
                    update_post_meta($post_id, '_rankology_robots_primary_cat', sanitize_text_field($_POST['rankology_robots_primary_cat']));
                } else {
                    delete_post_meta($post_id, '_rankology_robots_primary_cat');
                }
            }

            if (in_array('social-tab', $seo_tabs)) {
                // Facebook
                if (!empty($_POST['rankology_social_fb_title'])) {
                    update_post_meta($post_id, '_rankology_social_fb_title', sanitize_text_field($_POST['rankology_social_fb_title']));
                } else {
                    delete_post_meta($post_id, '_rankology_social_fb_title');
                }
                if (!empty($_POST['rankology_social_fb_desc'])) {
                    update_post_meta($post_id, '_rankology_social_fb_desc', sanitize_textarea_field($_POST['rankology_social_fb_desc']));
                } else {
                    delete_post_meta($post_id, '_rankology_social_fb_desc');
                }
                if (!empty($_POST['rankology_social_fb_img'])) {
                    update_post_meta($post_id, '_rankology_social_fb_img', esc_url_raw($_POST['rankology_social_fb_img']));
                } else {
                    delete_post_meta($post_id, '_rankology_social_fb_img');
                }
                if (!empty($_POST['rankology_social_fb_img_attachment_id']) && !empty($_POST['rankology_social_fb_img'])) {
                    update_post_meta($post_id, '_rankology_social_fb_img_attachment_id', absint($_POST['rankology_social_fb_img_attachment_id']));
                } else {
                    delete_post_meta($post_id, '_rankology_social_fb_img_attachment_id');
                }
                if (!empty($_POST['rankology_social_fb_img_width']) && !empty($_POST['rankology_social_fb_img'])) {
                    update_post_meta($post_id, '_rankology_social_fb_img_width', absint($_POST['rankology_social_fb_img_width']));
                } else {
                    delete_post_meta($post_id, '_rankology_social_fb_img_width');
                }
                if (!empty($_POST['rankology_social_fb_img_height']) && !empty($_POST['rankology_social_fb_img'])) {
                    update_post_meta($post_id, '_rankology_social_fb_img_height', absint($_POST['rankology_social_fb_img_height']));
                } else {
                    delete_post_meta($post_id, '_rankology_social_fb_img_height');
                }

                // Twitter
                if (!empty($_POST['rankology_social_twitter_title'])) {
                    update_post_meta($post_id, '_rankology_social_twitter_title', sanitize_text_field($_POST['rankology_social_twitter_title']));
                } else {
                    delete_post_meta($post_id, '_rankology_social_twitter_title');
                }
                if (!empty($_POST['rankology_social_twitter_desc'])) {
                    update_post_meta($post_id, '_rankology_social_twitter_desc', sanitize_textarea_field($_POST['rankology_social_twitter_desc']));
                } else {
                    delete_post_meta($post_id, '_rankology_social_twitter_desc');
                }
                if (!empty($_POST['rankology_social_twitter_img'])) {
                    update_post_meta($post_id, '_rankology_social_twitter_img', esc_url_raw($_POST['rankology_social_twitter_img']));
                } else {
                    delete_post_meta($post_id, '_rankology_social_twitter_img');
                }
                if (!empty($_POST['rankology_social_twitter_img_attachment_id']) && !empty($_POST['rankology_social_twitter_img'])) {
                    update_post_meta($post_id, '_rankology_social_twitter_img_attachment_id', absint($_POST['rankology_social_twitter_img_attachment_id']));
                } else {
                    delete_post_meta($post_id, '_rankology_social_twitter_img_attachment_id');
                }
                if (!empty($_POST['rankology_social_twitter_img_width']) && !empty($_POST['rankology_social_twitter_img'])) {
                    update_post_meta($post_id, '_rankology_social_twitter_img_width', absint($_POST['rankology_social_twitter_img_width']));
                } else {
                    delete_post_meta($post_id, '_rankology_social_twitter_img_width');
                }
                if (!empty($_POST['rankology_social_twitter_img_height']) && !empty($_POST['rankology_social_twitter_img'])) {
                    update_post_meta($post_id, '_rankology_social_twitter_img_height', absint($_POST['rankology_social_twitter_img_height']));
                } else {
                    delete_post_meta($post_id, '_rankology_social_twitter_img_height');
                }
            }

            if (in_array('redirect-tab', $seo_tabs)) {
                if (isset($_POST['rankology_redirections_type'])) {
                    update_post_meta($post_id, '_rankology_redirections_type', sanitize_text_field($_POST['rankology_redirections_type']));
                }
                if (!empty($_POST['rankology_redirections_value'])) {
                    update_post_meta($post_id, '_rankology_redirections_value', esc_url_raw($_POST['rankology_redirections_value']));
                } else {
                    delete_post_meta($post_id, '_rankology_redirections_value');
                }
                if (isset($_POST['rankology_redirections_param'])) {
                    update_post_meta($post_id, '_rankology_redirections_param', sanitize_text_field($_POST['rankology_redirections_param']));
                }
                if (isset($_POST['rankology_redirections_enabled'])) {
                    update_post_meta($post_id, '_rankology_redirections_enabled', 'yes');
                } else {
                    delete_post_meta($post_id, '_rankology_redirections_enabled');
                }
                if (isset($_POST['rankology_redirections_enabled_regex'])) {
                    update_post_meta($post_id, '_rankology_redirections_enabled_regex', 'yes');
                } else {
                    delete_post_meta($post_id, '_rankology_redirections_enabled_regex');
                }
                if (isset($_POST['rankology_redirections_logged_status'])) {
                    update_post_meta($post_id, '_rankology_redirections_logged_status', sanitize_text_field($_POST['rankology_redirections_logged_status']));
                } else {
                    delete_post_meta($post_id, '_rankology_redirections_logged_status');
                }
            }

            if (did_action('elementor/loaded')) {
                $elementor = get_post_meta($post_id, '_elementor_page_settings', true);

                if (!empty($elementor)) {
                    if (isset($_POST['rankology_titles_title'])) {
                        $elementor['_rankology_titles_title'] = sanitize_text_field($_POST['rankology_titles_title']);
                    }
                    if (isset($_POST['rankology_titles_desc'])) {
                        $elementor['_rankology_titles_desc'] = sanitize_textarea_field($_POST['rankology_titles_desc']);
                    }
                    if (isset($_POST['rankology_robots_index'])) {
                        $elementor['_rankology_robots_index'] = 'yes';
                    } else {
                        $elementor['_rankology_robots_index'] = '';
                    }
                    if (isset($_POST['rankology_robots_follow'])) {
                        $elementor['_rankology_robots_follow'] = 'yes';
                    } else {
                        $elementor['_rankology_robots_follow'] = '';
                    }
                    if (isset($_POST['rankology_robots_imageindex'])) {
                        $elementor['_rankology_robots_imageindex'] = 'yes';
                    } else {
                        $elementor['_rankology_robots_imageindex'] = '';
                    }
                    if (isset($_POST['rankology_robots_archive'])) {
                        $elementor['_rankology_robots_archive'] = 'yes';
                    } else {
                        $elementor['_rankology_robots_archive'] = '';
                    }
                    if (isset($_POST['rankology_robots_snippet'])) {
                        $elementor['_rankology_robots_snippet'] = 'yes';
                    } else {
                        $elementor['_rankology_robots_snippet'] = '';
                    }
                    if (isset($_POST['rankology_robots_canonical'])) {
                        $elementor['_rankology_robots_canonical'] = esc_url_raw($_POST['rankology_robots_canonical']);
                    }
                    if (isset($_POST['rankology_robots_primary_cat'])) {
                        $elementor['_rankology_robots_primary_cat'] = sanitize_text_field($_POST['rankology_robots_primary_cat']);
                    }
                    if (isset($_POST['rankology_social_fb_title'])) {
                        $elementor['_rankology_social_fb_title'] = sanitize_text_field($_POST['rankology_social_fb_title']);
                    }
                    if (isset($_POST['rankology_social_fb_desc'])) {
                        $elementor['_rankology_social_fb_desc'] = sanitize_textarea_field($_POST['rankology_social_fb_desc']);
                    }
                    if (isset($_POST['rankology_social_fb_img'])) {
                        $elementor['_rankology_social_fb_img'] = esc_url_raw($_POST['rankology_social_fb_img']);
                    }
                    if (isset($_POST['rankology_social_twitter_title'])) {
                        $elementor['_rankology_social_twitter_title'] = sanitize_text_field($_POST['rankology_social_twitter_title']);
                    }
                    if (isset($_POST['rankology_social_twitter_desc'])) {
                        $elementor['_rankology_social_twitter_desc'] = sanitize_textarea_field($_POST['rankology_social_twitter_desc']);
                    }
                    if (isset($_POST['rankology_social_twitter_img'])) {
                        $elementor['_rankology_social_twitter_img'] = esc_url_raw($_POST['rankology_social_twitter_img']);
                    }
                    if (isset($_POST['rankology_redirections_type'])) {
                        $elementor['_rankology_redirections_type'] = sanitize_text_field($_POST['rankology_redirections_type']);
                    }
                    if (isset($_POST['rankology_redirections_value'])) {
                        $elementor['_rankology_redirections_value'] = esc_url_raw($_POST['rankology_redirections_value']);
                    }
                    if (isset($_POST['rankology_redirections_param'])) {
                        $elementor['_rankology_redirections_param'] = sanitize_text_field($_POST['rankology_redirections_param']);
                    }
                    if (isset($_POST['rankology_redirections_enabled'])) {
                        $elementor['_rankology_redirections_enabled'] = 'yes';
                    } else {
                        $elementor['_rankology_redirections_enabled'] = '';
                    }
                    update_post_meta($post_id, '_elementor_page_settings', $elementor);
                }
            }

            do_action('rankology_seo_metabox_save', $post_id, $seo_tabs);
        }
    }
}

function rankology_display_ca_metaboxe()
{
    add_action('add_meta_boxes', 'rankology_init_ca_metabox');
    function rankology_init_ca_metabox()
    {
        if (rankology_get_service('AdvancedOption')->getAppearanceMetaboxePosition() !== null) {
            $metaboxe_position = rankology_get_service('AdvancedOption')->getAppearanceMetaboxePosition();
        } else {
            $metaboxe_position = 'default';
        }

        $rankology_get_post_types = rankology_get_service('WordPressData')->getPostTypes();

        $rankology_get_post_types = apply_filters('rankology_metaboxe_content_analysis', $rankology_get_post_types);

        if (!empty($rankology_get_post_types) && !rankology_get_service('EnqueueModuleMetabox')->canEnqueue()) {
            foreach ($rankology_get_post_types as $key => $value) {
                add_meta_box('rankology_content_analysis', esc_html__('Content overview', 'wp-rankology'), 'rankology_content_analysis', $key, 'normal', $metaboxe_position);
            }
        }
    }

    function rankology_content_analysis($post)
    {
        $prefix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
        wp_nonce_field(plugin_basename(__FILE__), 'rankology_content_analysis_nonce');

        //Tagify
        wp_enqueue_script('rankology-tagify-js', RANKOLOGY_ASSETS_DIR . '/js/tagify.min.js', ['jquery'], RANKOLOGY_VERSION, true);
        wp_register_style('rankology-tagify', RANKOLOGY_ASSETS_DIR . '/css/tagify.min.css', [], RANKOLOGY_VERSION);
        wp_enqueue_style('rankology-tagify');

        wp_enqueue_script('rankology-cpt-counters-js', RANKOLOGY_ASSETS_DIR . '/js/rankology-counters' . $prefix . '.js', ['jquery', 'jquery-ui-tabs', 'jquery-ui-accordion', 'jquery-ui-autocomplete'], RANKOLOGY_VERSION);
        $rankology_real_preview = [
            'rankology_nonce'         => wp_create_nonce('rankology_real_preview_nonce'),
            'rankology_real_preview'  => admin_url('admin-ajax.php'),
            'i18n'                   => ['progress' => esc_html__('Analysis in progress...', 'wp-rankology')],
            'ajax_url'               => admin_url('admin-ajax.php'),
            'get_preview_meta_title' => wp_create_nonce('get_preview_meta_title'),
        ];
        wp_localize_script('rankology-cpt-counters-js', 'rankologyAjaxRealPreview', $rankology_real_preview);

        $rankology_inspect_url = [
            'rankology_nonce'            => wp_create_nonce('rankology_inspect_url_nonce'),
            'rankology_inspect_url'      => admin_url('admin-ajax.php'),
        ];
        wp_localize_script('rankology-cpt-counters-js', 'rankologyAjaxInspectUrl', $rankology_inspect_url);

        $rankology_analysis_target_kw            = get_post_meta($post->ID, '_rankology_analysis_target_kw', true);
        $rankology_analysis_data                 = get_post_meta($post->ID, '_rankology_analysis_data', true);
        $rankology_titles_title                  = get_post_meta($post->ID, '_rankology_titles_title', true);
        $rankology_titles_desc                   = get_post_meta($post->ID, '_rankology_titles_desc', true);

        if (rankology_get_service('TitleOption')->getSingleCptNoIndex() || rankology_get_service('TitleOption')->getTitleNoIndex() || true === post_password_required($post->ID)) {
            $rankology_robots_index              = 'yes';
        } else {
            $rankology_robots_index              = get_post_meta($post->ID, '_rankology_robots_index', true);
        }

        if (rankology_get_service('TitleOption')->getSingleCptNoFollow() || rankology_get_service('TitleOption')->getTitleNoFollow()) {
            $rankology_robots_follow             = 'yes';
        } else {
            $rankology_robots_follow             = get_post_meta($post->ID, '_rankology_robots_follow', true);
        }

        if (rankology_get_service('TitleOption')->getTitleNoArchive()) {
            $rankology_robots_archive            = 'yes';
        } else {
            $rankology_robots_archive            = get_post_meta($post->ID, '_rankology_robots_archive', true);
        }

        if (rankology_get_service('TitleOption')->getTitleNoSnippet()) {
            $rankology_robots_snippet            = 'yes';
        } else {
            $rankology_robots_snippet            = get_post_meta($post->ID, '_rankology_robots_snippet', true);
        }

        if (rankology_get_service('TitleOption')->getTitleNoImageIndex()) {
            $rankology_robots_imageindex         = 'yes';
        } else {
            $rankology_robots_imageindex         = get_post_meta($post->ID, '_rankology_robots_imageindex', true);
        }

        require_once dirname(__FILE__) . '/admin-metaboxes-content-analysis-form.php'; //Metaboxe HTML
    }

    add_action('save_post', 'rankology_save_ca_metabox', 10, 2);
	function rankology_save_ca_metabox($post_id, $post)
	{
		// Nonce
		if (!isset($_POST['rankology_content_analysis_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['rankology_content_analysis_nonce'])), plugin_basename(__FILE__))) {
			return $post_id;
		}

		// Post type object
		$post_type = get_post_type_object($post->post_type);

		// Check permission
		if (!current_user_can($post_type->cap->edit_post, $post_id)) {
			return $post_id;
		}

		if ('attachment' !== get_post_type($post_id)) {
			if (isset($_POST['rankology_analysis_target_kw'])) {
				$sanitized_keyword = sanitize_text_field($_POST['rankology_analysis_target_kw']);
				update_post_meta($post_id, '_rankology_analysis_target_kw', $sanitized_keyword);

				if (did_action('elementor/loaded')) {
					$elementor = get_post_meta($post_id, '_elementor_page_settings', true);

					if (!empty($elementor)) {
						$elementor['_rankology_analysis_target_kw'] = $sanitized_keyword;
						update_post_meta($post_id, '_elementor_page_settings', $elementor);
					}
				}
			}
		}
	}

    //Save metabox values in elementor
    add_action('save_post', 'rankology_update_elementor_fields', 999, 2);
    function rankology_update_elementor_fields($post_id, $post)
    {
        do_action('rankology/page-builders/elementor/save_meta', $post_id);
    }
}

if (is_user_logged_in()) {
    if (is_super_admin()) {
        echo rankology_display_seo_metaboxe();
        echo rankology_display_ca_metaboxe();
    } else {
        global $wp_roles;
        $user = wp_get_current_user();
        //Get current user role
        if (isset($user->roles) && is_array($user->roles) && !empty($user->roles)) {
            $rankology_user_role = current($user->roles);

            //If current user role matchs values from Security settings then apply -- SEO Metaboxe
            if (!empty(rankology_get_service('AdvancedOption')->getSecurityMetaboxRole())) {
                if (array_key_exists($rankology_user_role, rankology_get_service('AdvancedOption')->getSecurityMetaboxRole())) {
                    //do nothing
                } else {
                    echo rankology_display_seo_metaboxe();
                }
            } else {
                echo rankology_display_seo_metaboxe();
            }

            //If current user role matchs values from Security settings then apply -- SEO Content Analysis
            if (!empty(rankology_get_service('AdvancedOption')->getSecurityMetaboxRoleContentAnalysis())) {
                if (array_key_exists($rankology_user_role, rankology_get_service('AdvancedOption')->getSecurityMetaboxRoleContentAnalysis())) {
                    //do nothing
                } else {
                    echo rankology_display_ca_metaboxe();
                }
            } else {
                echo rankology_display_ca_metaboxe();
            }
        }
    }
}
