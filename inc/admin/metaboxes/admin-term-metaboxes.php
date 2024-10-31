<?php
defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

///////////////////////////////////////////////////////////////////////////////////////////////////
//Display metabox in Custom Taxonomy
///////////////////////////////////////////////////////////////////////////////////////////////////
function rankology_display_seo_term_metaboxe() {
    add_action('init', 'rankology_init_term_metabox', 11);

    function rankology_init_term_metabox() {
        $rankology_get_taxonomies = rankology_get_service('WordPressData')->getTaxonomies();
        $rankology_get_taxonomies = apply_filters('rankology_metaboxe_term_seo', $rankology_get_taxonomies);

        if ( ! empty($rankology_get_taxonomies)) {
            if (!empty(rankology_get_service('AdvancedOption')->getAppearanceMetaboxePosition())) {
                switch (rankology_get_service('AdvancedOption')->getAppearanceMetaboxePosition()) {
                    case 'high':
                        $priority = 1;
                        break;
                    case 'default':
                        $priority = 10;
                        break;
                    case 'low':
                        $priority = 100;
                        break;
                    default:
                        $priority = 10;
                        break;
                }
            } else {
                $priority = 10;
            }

            $priority = apply_filters('rankology_metaboxe_term_seo_priority', $priority);

            foreach ($rankology_get_taxonomies as $key => $value) {
                add_action($key . '_edit_form', 'rankology_tax', $priority, 2); //Edit term page
                add_action('edit_' . $key,   'rankology_tax_save_term', $priority, 2); //Edit save term
            }
        }
    }

    function rankology_tax($term) {
        wp_nonce_field(plugin_basename(__FILE__), 'rankology_cpt_nonce');

        global $typenow;

        //init
        $disabled = [];

        wp_enqueue_script('rankology-cpt-tabs-js', RANKOLOGY_ASSETS_DIR . '/js/rankology-metabox.js', ['jquery-ui-tabs'], RANKOLOGY_VERSION);

        if ('rankology_404' != $typenow) {
            //Tagify
            wp_enqueue_script('rankology-tagify-js', RANKOLOGY_ASSETS_DIR . '/js/tagify.min.js', ['jquery'], RANKOLOGY_VERSION, true);
            wp_register_style('rankology-tagify', RANKOLOGY_ASSETS_DIR . '/css/tagify.min.css', [], RANKOLOGY_VERSION);
            wp_enqueue_style('rankology-tagify');

            //Register Google Preview / Content Analysis JS
            wp_enqueue_script('rankology-cpt-counters-js', RANKOLOGY_ASSETS_DIR . '/js/rankology-counters.min.js', ['jquery', 'jquery-ui-tabs', 'jquery-ui-accordion', 'jquery-ui-autocomplete'], RANKOLOGY_VERSION);

            $rankology_real_preview = [
                'rankology_nonce'         => wp_create_nonce('rankology_real_preview_nonce'),
                'rankology_real_preview'  => admin_url('admin-ajax.php'),
                'i18n'                   => ['progress' => esc_html__('Analysis in progress...', 'wp-rankology')],
                'ajax_url'               => admin_url('admin-ajax.php'),
                'get_preview_meta_title' => wp_create_nonce('get_preview_meta_title'),
            ];
            wp_localize_script('rankology-cpt-counters-js', 'rankologyAjaxRealPreview', $rankology_real_preview);

            wp_enqueue_script('rankology-media-uploader-js', RANKOLOGY_ASSETS_DIR . '/js/rankology-media-uploader.js', ['jquery'], RANKOLOGY_VERSION, false);
            wp_enqueue_media();
        }

        $rankology_titles_title             = get_term_meta($term->term_id, '_rankology_titles_title', true);
        $rankology_titles_desc              = get_term_meta($term->term_id, '_rankology_titles_desc', true);

        $disabled['robots_index'] ='';
        if (rankology_get_service('TitleOption')->getTaxNoIndex() || rankology_get_service('TitleOption')->getTitleNoIndex()) {
            $rankology_robots_index              = 'yes';
            $disabled['robots_index']           = 'disabled';
        } else {
            $rankology_robots_index              = get_term_meta($term->term_id, '_rankology_robots_index', true);
        }

        $disabled['robots_follow'] ='';
        if (rankology_get_service('TitleOption')->getTaxNoFollow() || rankology_get_service('TitleOption')->getTitleNoFollow()) {
            $rankology_robots_follow             = 'yes';
            $disabled['robots_follow']          = 'disabled';
        } else {
            $rankology_robots_follow             = get_term_meta($term->term_id, '_rankology_robots_follow', true);
        }

        $disabled['archive'] ='';
        if (rankology_get_service('TitleOption')->getTitleNoArchive()) {
            $rankology_robots_archive            = 'yes';
            $disabled['archive']                = 'disabled';
        } else {
            $rankology_robots_archive            = get_term_meta($term->term_id, '_rankology_robots_archive', true);
        }

        $disabled['snippet'] ='';
        if (rankology_get_service('TitleOption')->getTitleNoSnippet()) {
            $rankology_robots_snippet            = 'yes';
            $disabled['snippet']                = 'disabled';
        } else {
            $rankology_robots_snippet            = get_term_meta($term->term_id, '_rankology_robots_snippet', true);
        }

        $disabled['imageindex'] ='';
        if (rankology_get_service('TitleOption')->getTitleNoImageIndex()) {
            $rankology_robots_imageindex         = 'yes';
            $disabled['imageindex']             = 'disabled';
        } else {
            $rankology_robots_imageindex         = get_term_meta($term->term_id, '_rankology_robots_imageindex', true);
        }

        $rankology_robots_canonical                  = get_term_meta($term->term_id, '_rankology_robots_canonical', true);
        $rankology_social_fb_title                   = get_term_meta($term->term_id, '_rankology_social_fb_title', true);
        $rankology_social_fb_desc                    = get_term_meta($term->term_id, '_rankology_social_fb_desc', true);
        $rankology_social_fb_img                     = get_term_meta($term->term_id, '_rankology_social_fb_img', true);
        $rankology_social_fb_img_attachment_id       = get_term_meta($term->term_id, '_rankology_social_fb_img_attachment_id', true);
        $rankology_social_fb_img_width               = get_term_meta($term->term_id, '_rankology_social_fb_img_width', true);
        $rankology_social_fb_img_height              = get_term_meta($term->term_id, '_rankology_social_fb_img_height', true);
        $rankology_social_twitter_title              = get_term_meta($term->term_id, '_rankology_social_twitter_title', true);
        $rankology_social_twitter_desc               = get_term_meta($term->term_id, '_rankology_social_twitter_desc', true);
        $rankology_social_twitter_img                = get_term_meta($term->term_id, '_rankology_social_twitter_img', true);
        $rankology_social_twitter_img_attachment_id  = get_term_meta($term->term_id, '_rankology_social_twitter_img_attachment_id', true);
        $rankology_social_twitter_img_width          = get_term_meta($term->term_id, '_rankology_social_twitter_img_width', true);
        $rankology_social_twitter_img_height         = get_term_meta($term->term_id, '_rankology_social_twitter_img_height', true);
        $rankology_redirections_enabled              = get_term_meta($term->term_id, '_rankology_redirections_enabled', true);
        $rankology_redirections_logged_status        = get_term_meta($term->term_id, '_rankology_redirections_logged_status', true);
        $rankology_redirections_type                 = get_term_meta($term->term_id, '_rankology_redirections_type', true);
        $rankology_redirections_value                = get_term_meta($term->term_id, '_rankology_redirections_value', true);

        require_once dirname(dirname(__FILE__)) . '/admin-dyn-variables-helper.php'; //Dynamic variables
        require_once dirname(__FILE__) . '/admin-metaboxes-form.php'; //Metaboxe HTML
    }

    function rankology_tax_save_term($term_id) {
        //Nonce
        if ( ! isset($_POST['rankology_cpt_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['rankology_cpt_nonce'])), plugin_basename(__FILE__))) {
            return $term_id;
        }

        //Taxonomy object
        $taxonomy = get_taxonomy(get_current_screen()->taxonomy);

        //Check permission
        if ( ! current_user_can($taxonomy->cap->edit_terms, $term_id)) {
            return $term_id;
        }

        $seo_tabs = [];
        $seo_tabs = json_decode(stripslashes(htmlspecialchars_decode(esc_html(sanitize_text_field($_POST['seo_tabs'])))));

        if (in_array('title-tab', $seo_tabs)) {
            if (!empty($_POST['rankology_titles_title'])) {
                update_term_meta($term_id, '_rankology_titles_title', esc_html(sanitize_text_field($_POST['rankology_titles_title'])));
            } else {
                delete_term_meta($term_id, '_rankology_titles_title');
            }
            if (!empty($_POST['rankology_titles_desc'])) {
                update_term_meta($term_id, '_rankology_titles_desc', esc_html(sanitize_text_field($_POST['rankology_titles_desc'])));
            } else {
                delete_term_meta($term_id, '_rankology_titles_desc');
            }
        }
        if (in_array('advanced-tab', $seo_tabs)) {
            if (isset($_POST['rankology_robots_index'])) {
                update_term_meta($term_id, '_rankology_robots_index', 'yes');
            } else {
                delete_term_meta($term_id, '_rankology_robots_index', '');
            }
            if (isset($_POST['rankology_robots_follow'])) {
                update_term_meta($term_id, '_rankology_robots_follow', 'yes');
            } else {
                delete_term_meta($term_id, '_rankology_robots_follow', '');
            }
            if (isset($_POST['rankology_robots_imageindex'])) {
                update_term_meta($term_id, '_rankology_robots_imageindex', 'yes');
            } else {
                delete_term_meta($term_id, '_rankology_robots_imageindex', '');
            }
            if (isset($_POST['rankology_robots_archive'])) {
                update_term_meta($term_id, '_rankology_robots_archive', 'yes');
            } else {
                delete_term_meta($term_id, '_rankology_robots_archive', '');
            }
            if (isset($_POST['rankology_robots_snippet'])) {
                update_term_meta($term_id, '_rankology_robots_snippet', 'yes');
            } else {
                delete_term_meta($term_id, '_rankology_robots_snippet', '');
            }
            if (!empty($_POST['rankology_robots_canonical'])) {
                update_term_meta($term_id, '_rankology_robots_canonical', esc_html(sanitize_text_field($_POST['rankology_robots_canonical'])));
            } else {
                delete_term_meta($term_id, '_rankology_robots_canonical');
            }
        }

        if (in_array('social-tab', $seo_tabs)) {
            //Facebook
            if (!empty($_POST['rankology_social_fb_title'])) {
                update_term_meta($term_id, '_rankology_social_fb_title', esc_html(sanitize_text_field($_POST['rankology_social_fb_title'])));
            } else {
                delete_term_meta($term_id, '_rankology_social_fb_title');
            }
            if (!empty($_POST['rankology_social_fb_desc'])) {
                update_term_meta($term_id, '_rankology_social_fb_desc', esc_html(sanitize_text_field($_POST['rankology_social_fb_desc'])));
            } else {
                delete_term_meta($term_id, '_rankology_social_fb_desc');
            }
            if (!empty($_POST['rankology_social_fb_img'])) {
                update_term_meta($term_id, '_rankology_social_fb_img', esc_html(sanitize_text_field($_POST['rankology_social_fb_img'])));
            }
            if (!empty($_POST['rankology_social_fb_img_attachment_id']) && !empty($_POST['rankology_social_fb_img'])) {
                update_term_meta($term_id, '_rankology_social_fb_img_attachment_id', esc_html(sanitize_text_field($_POST['rankology_social_fb_img_attachment_id'])));
            } else {
                delete_term_meta($term_id, '_rankology_social_fb_img_attachment_id');
            }
            if (!empty($_POST['rankology_social_fb_img_width']) && !empty($_POST['rankology_social_fb_img'])) {
                update_term_meta($term_id, '_rankology_social_fb_img_width', esc_html(sanitize_text_field($_POST['rankology_social_fb_img_width'])));
            } else {
                delete_term_meta($term_id, '_rankology_social_fb_img_width');
            }
            if (!empty($_POST['rankology_social_fb_img_height']) && !empty($_POST['rankology_social_fb_img'])) {
                update_term_meta($term_id, '_rankology_social_fb_img_height', esc_html(sanitize_text_field($_POST['rankology_social_fb_img_height'])));
            } else {
                delete_term_meta($term_id, '_rankology_social_fb_img_height');
            }

            //Twitter
            if (!empty($_POST['rankology_social_twitter_title'])) {
                update_term_meta($term_id, '_rankology_social_twitter_title', esc_html(sanitize_text_field($_POST['rankology_social_twitter_title'])));
            } else {
                delete_term_meta($term_id, '_rankology_social_twitter_title');
            }
            if (!empty($_POST['rankology_social_twitter_desc'])) {
                update_term_meta($term_id, '_rankology_social_twitter_desc', esc_html(sanitize_text_field($_POST['rankology_social_twitter_desc'])));
            } else {
                delete_term_meta($term_id, '_rankology_social_twitter_desc');
            }
            if (!empty($_POST['rankology_social_twitter_img'])) {
                update_term_meta($term_id, '_rankology_social_twitter_img', esc_html(sanitize_text_field($_POST['rankology_social_twitter_img'])));
            }
        }
        if (in_array('redirect-tab', $seo_tabs)) {
            if (isset($_POST['rankology_redirections_type'])) {
                update_term_meta($term_id, '_rankology_redirections_type', sanitize_text_field($_POST['rankology_redirections_type']));
            }
            if (isset($_POST['rankology_redirections_logged_status'])) {
                update_term_meta($term_id, '_rankology_redirections_logged_status', sanitize_text_field($_POST['rankology_redirections_logged_status']));
            }
            if (!empty($_POST['rankology_redirections_value'])) {
                update_term_meta($term_id, '_rankology_redirections_value', esc_html(sanitize_text_field($_POST['rankology_redirections_value'])));
            } else {
                delete_term_meta($term_id, '_rankology_redirections_value');
            }
            if (isset($_POST['rankology_redirections_enabled'])) {
                update_term_meta($term_id, '_rankology_redirections_enabled', 'yes');
            } else {
                delete_term_meta($term_id, '_rankology_redirections_enabled', '');
            }
        }

        do_action('rankology_seo_metabox_term_save', $term_id, rankology_esc_pst_val());
    }
}

if (is_user_logged_in()) {
    if (is_super_admin()) {
        echo rankology_display_seo_term_metaboxe();
    } else {
        global $wp_roles;

        //Get current user role
        if (isset(wp_get_current_user()->roles[0])) {
            $rankology_user_role = wp_get_current_user()->roles[0];

            //If current user role matchs values from Security settings then apply
            if (!empty(rankology_get_service('AdvancedOption')->getSecurityMetaboxRole())) {
                if (array_key_exists($rankology_user_role, rankology_get_service('AdvancedOption')->getSecurityMetaboxRole())) {
                    //do nothing
                } else {
                    echo rankology_display_seo_term_metaboxe();
                }
            } else {
                echo rankology_display_seo_term_metaboxe();
            }
        }
    }
}
