<?php
defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

include_once ABSPATH . 'wp-admin/includes/plugin.php';

//Titles & metas
//=================================================================================================
//THE Title Tag
function rankology_titles_the_title() {
    $variables = null;
    $variables = apply_filters('rankology_dyn_variables_fn', $variables);

    $post                                     = $variables['post'];
    $term                                     = $variables['term'];
    $rankology_titles_title_template           = $variables['rankology_titles_title_template'];
    $rankology_titles_description_template     = $variables['rankology_titles_description_template'];
    $rankology_paged                           = $variables['rankology_paged'];
    $the_author_meta                          = $variables['the_author_meta'];
    $sep                                      = $variables['sep'];
    $rankology_excerpt                         = $variables['rankology_excerpt'];
    $post_category                            = $variables['post_category'];
    $post_tag                                 = $variables['post_tag'];
    $get_search_query                         = $variables['get_search_query'];
    $woo_single_cat_html                      = $variables['woo_single_cat_html'];
    $woo_single_tag_html                      = $variables['woo_single_tag_html'];
    $woo_single_price                         = $variables['woo_single_price'];
    $woo_single_price_exc_tax                 = $variables['woo_single_price_exc_tax'];
    $woo_single_sku                           = $variables['woo_single_sku'];
    $author_bio                               = $variables['author_bio'];
    $rankology_get_the_excerpt                 = $variables['rankology_get_the_excerpt'];
    $rankology_titles_template_variables_array = $variables['rankology_titles_template_variables_array'];
    $rankology_titles_template_replace_array   = $variables['rankology_titles_template_replace_array'];
    $rankology_excerpt_length                  = $variables['rankology_excerpt_length'];
    $page_id                                  = get_option('page_for_posts');

    if (is_front_page() && is_home() && isset($post) && '' == get_post_meta($post->ID, '_rankology_titles_title', true)) { //HOMEPAGE
        if ('' !== rankology_get_service('TitleOption')->getHomeSiteTitle()) {
            $rankology_titles_the_title = esc_attr(rankology_get_service('TitleOption')->getHomeSiteTitle());

            $rankology_titles_title_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_the_title);
        }
    } elseif (is_front_page() && isset($post) && '' == get_post_meta($post->ID, '_rankology_titles_title', true)) { //STATIC HOMEPAGE
        if ('' !== rankology_get_service('TitleOption')->getHomeSiteTitle()) {
            $rankology_titles_the_title = esc_attr(rankology_get_service('TitleOption')->getHomeSiteTitle());

            $rankology_titles_title_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_the_title);
        }
    } elseif (is_home() && '' != get_post_meta($page_id, '_rankology_titles_title', true)) { //BLOG PAGE
        if (get_post_meta($page_id, '_rankology_titles_title', true)) { //IS METABOXE
            $rankology_titles_the_title = esc_attr(get_post_meta($page_id, '_rankology_titles_title', true));

            $rankology_titles_title_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_the_title);
        }
    } elseif (is_home() && ('posts' == get_option('show_on_front'))) { //YOUR LATEST POSTS
        include_once ABSPATH . 'wp-admin/includes/plugin.php';
        if (is_plugin_active('polylang/polylang.php') || is_plugin_active('polylang-pro/polylang.php')) {
        }
        if ('' !== rankology_get_service('TitleOption')->getHomeSiteTitle()) {
            $rankology_titles_the_title = esc_attr(rankology_get_service('TitleOption')->getHomeSiteTitle());

            $rankology_titles_title_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_the_title);
        }
    } elseif (function_exists('bp_is_group') && bp_is_group()) {
        if ('' !== rankology_get_service('TitleOption')->getTitleBpGroups()) {
            $rankology_titles_the_title = esc_attr(rankology_get_service('TitleOption')->getTitleBpGroups());

            $rankology_titles_title_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_the_title);
        }
    } elseif (is_singular()) { //IS SINGULAR
        //IS BUDDYPRESS ACTIVITY PAGE
        if (function_exists('bp_is_current_component') && true == bp_is_current_component('activity')) {
            $post->ID = buddypress()->pages->activity->id;
        }
        //IS BUDDYPRESS MEMBERS PAGE
        if (function_exists('bp_is_current_component') && true == bp_is_current_component('members')) {
            $post->ID = buddypress()->pages->members->id;
        }

        //IS BUDDYPRESS GROUPS PAGE
        if (function_exists('bp_is_current_component') && true == bp_is_current_component('groups')) {
            $post->ID = buddypress()->pages->groups->id;
        }

        if (get_post_meta($post->ID, '_rankology_titles_title', true)) { //IS METABOXE
            $rankology_titles_the_title = esc_attr(get_post_meta($post->ID, '_rankology_titles_title', true));

            preg_match_all('/%%_cf_(.*?)%%/', $rankology_titles_the_title, $matches); //custom fields

            if ( ! empty($matches)) {
                $rankology_titles_cf_template_variables_array = [];
                $rankology_titles_cf_template_replace_array   = [];

                foreach ($matches['0'] as $key => $value) {
                    $rankology_titles_cf_template_variables_array[] = $value;
                }

                foreach ($matches['1'] as $key => $value) {
                    $custom_field = esc_attr(get_post_meta($post->ID, $value, true));
                    $rankology_titles_cf_template_replace_array[] = apply_filters('rankology_titles_custom_field', $custom_field, $value);
                }
            }

            preg_match_all('/%%_ct_(.*?)%%/', $rankology_titles_the_title, $matches2); //custom terms taxonomy

            if ( ! empty($matches2)) {
                $rankology_titles_ct_template_variables_array = [];
                $rankology_titles_ct_template_replace_array   = [];

                foreach ($matches2['0'] as $key => $value) {
                    $rankology_titles_ct_template_variables_array[] = $value;
                }

                foreach ($matches2['1'] as $key => $value) {
                    $term = wp_get_post_terms($post->ID, $value);
                    if ( ! is_wp_error($term)) {
                        $terms                                       = esc_attr($term[0]->name);
                        $rankology_titles_ct_template_replace_array[] = apply_filters('rankology_titles_custom_tax', $terms, $value);
                    }
                }
            }

            preg_match_all('/%%_ucf_(.*?)%%/', $rankology_titles_the_title, $matches3); //user meta

            if ( ! empty($matches3)) {
                $rankology_titles_ucf_template_variables_array = [];
                $rankology_titles_ucf_template_replace_array   = [];

                foreach ($matches3['0'] as $key => $value) {
                    $rankology_titles_ucf_template_variables_array[] = $value;
                }

                foreach ($matches3['1'] as $key => $value) {
                    $user_meta = esc_attr(get_user_meta(get_current_user_id(), $value, true));
                    $rankology_titles_ucf_template_replace_array[] = apply_filters('rankology_titles_user_meta', $user_meta, $value);
                }
            }

            //Default
            $rankology_titles_title_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_the_title);

            //Custom fields
            if ( ! empty($matches) && ! empty($rankology_titles_cf_template_variables_array) && ! empty($rankology_titles_cf_template_replace_array)) {
                $rankology_titles_title_template = str_replace($rankology_titles_cf_template_variables_array, $rankology_titles_cf_template_replace_array, $rankology_titles_title_template);
            }

            //Custom terms taxonomy
            if ( ! empty($matches2) && ! empty($rankology_titles_ct_template_variables_array) && ! empty($rankology_titles_ct_template_replace_array)) {
                $rankology_titles_title_template = str_replace($rankology_titles_ct_template_variables_array, $rankology_titles_ct_template_replace_array, $rankology_titles_title_template);
            }

            //User meta
            if ( ! empty($matches3) && ! empty($rankology_titles_ucf_template_variables_array) && ! empty($rankology_titles_ucf_template_replace_array)) {
                $rankology_titles_title_template = str_replace($rankology_titles_ucf_template_variables_array, $rankology_titles_ucf_template_replace_array, $rankology_titles_title_template);
            }
        } else { //DEFAULT GLOBAL
            $rankology_titles_single_titles_option = esc_attr(rankology_get_service('TitleOption')->getSingleCptTitle($post->ID));

            preg_match_all('/%%_cf_(.*?)%%/', $rankology_titles_single_titles_option, $matches); //custom fields

            if ( ! empty($matches)) {
                $rankology_titles_cf_template_variables_array = [];
                $rankology_titles_cf_template_replace_array   = [];

                foreach ($matches['0'] as $key => $value) {
                    $rankology_titles_cf_template_variables_array[] = $value;
                }

                foreach ($matches['1'] as $key => $value) {
                    $rankology_titles_cf_template_replace_array[] = esc_attr(get_post_meta($post->ID, $value, true));
                }
            }

            preg_match_all('/%%_ct_(.*?)%%/', $rankology_titles_single_titles_option, $matches2); //custom terms taxonomy

            if ( ! empty($matches2)) {
                $rankology_titles_ct_template_variables_array = [];
                $rankology_titles_ct_template_replace_array   = [];

                foreach ($matches2['0'] as $key => $value) {
                    $rankology_titles_ct_template_variables_array[] = $value;
                }

                foreach ($matches2['1'] as $key => $value) {
                    $term = wp_get_post_terms($post->ID, $value);
                    if ( ! is_wp_error($term) && isset($term[0])) {
                        $terms                                       = esc_attr($term[0]->name);
                        $rankology_titles_ct_template_replace_array[] = apply_filters('rankology_titles_custom_tax', $terms, $value);
                    }
                }
            }

            preg_match_all('/%%_ucf_(.*?)%%/', $rankology_titles_single_titles_option, $matches3); //user meta

            if ( ! empty($matches3)) {
                $rankology_titles_ucf_template_variables_array = [];
                $rankology_titles_ucf_template_replace_array   = [];

                foreach ($matches3['0'] as $key => $value) {
                    $rankology_titles_ucf_template_variables_array[] = $value;
                }

                foreach ($matches3['1'] as $key => $value) {
                    $rankology_titles_ucf_template_replace_array[] = esc_attr(get_user_meta(get_current_user_id(), $value, true));
                }
            }

            //Default
            $rankology_titles_title_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_single_titles_option);

            //Custom fields
            if ( ! empty($matches) && ! empty($rankology_titles_cf_template_variables_array) && ! empty($rankology_titles_cf_template_replace_array)) {
                $rankology_titles_title_template = str_replace($rankology_titles_cf_template_variables_array, $rankology_titles_cf_template_replace_array, $rankology_titles_title_template);
            }

            //Custom terms taxonomy
            if ( ! empty($matches2) && ! empty($rankology_titles_ct_template_variables_array) && ! empty($rankology_titles_ct_template_replace_array)) {
                $rankology_titles_title_template = str_replace($rankology_titles_ct_template_variables_array, $rankology_titles_ct_template_replace_array, $rankology_titles_title_template);
            }

            //User meta
            if ( ! empty($matches3) && ! empty($rankology_titles_ucf_template_variables_array) && ! empty($rankology_titles_ucf_template_replace_array)) {
                $rankology_titles_title_template = str_replace($rankology_titles_ucf_template_variables_array, $rankology_titles_ucf_template_replace_array, $rankology_titles_title_template);
            }
        }
    } elseif (is_post_type_archive() && !is_search() && !is_tax() && rankology_get_service('TitleOption')->getArchivesCPTTitle()) { //IS POST TYPE ARCHIVE (!is_tax required for TEC, !is_search required for WC search box)
        $rankology_titles_archive_titles_option = esc_attr(rankology_get_service('TitleOption')->getArchivesCPTTitle());
        $rankology_titles_title_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_archive_titles_option);
    } elseif ((is_tax() || is_category() || is_tag()) && rankology_get_service('TitleOption')->getTaxTitle()) { //IS TAX
        $rankology_titles_tax_titles_option = esc_attr(rankology_get_service('TitleOption')->getTaxTitle());

        if (get_term_meta(get_queried_object()->{'term_id'}, '_rankology_titles_title', true)) {
            $rankology_titles_title_template = esc_attr(get_term_meta(get_queried_object()->{'term_id'}, '_rankology_titles_title', true));
            $rankology_titles_title_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_title_template);
        } else {
            $rankology_titles_title_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_tax_titles_option);
        }

        preg_match_all('/%%_cf_(.*?)%%/', $rankology_titles_title_template, $matches); //custom fields

        if ( ! empty($matches)) {
            $rankology_titles_cf_template_variables_array = [];
            $rankology_titles_cf_template_replace_array   = [];

            foreach ($matches['0'] as $key => $value) {
                $rankology_titles_cf_template_variables_array[] = $value;
            }

            foreach ($matches['1'] as $key => $value) {
                $rankology_titles_cf_template_replace_array[] = esc_attr(get_term_meta(get_queried_object()->{'term_id'}, $value, true));
            }
        }

        //Custom fields
        if ( ! empty($matches) && ! empty($rankology_titles_cf_template_variables_array) && ! empty($rankology_titles_cf_template_replace_array)) {
            $rankology_titles_title_template = str_replace($rankology_titles_cf_template_variables_array, $rankology_titles_cf_template_replace_array, $rankology_titles_title_template);
        }
    } elseif (is_author() && rankology_get_service('TitleOption')->getArchivesAuthorTitle()) { //IS AUTHOR
        $rankology_titles_archives_author_title_option = esc_attr(rankology_get_service('TitleOption')->getArchivesAuthorTitle());

        preg_match_all('/%%_ucf_(.*?)%%/', $rankology_titles_archives_author_title_option, $matches); //custom fields

        if ( ! empty($matches)) {
            $rankology_titles_cf_template_variables_array = [];
            $rankology_titles_cf_template_replace_array   = [];

            foreach ($matches['0'] as $key => $value) {
                $rankology_titles_cf_template_variables_array[] = $value;
            }

            foreach ($matches['1'] as $key => $value) {
                $rankology_titles_cf_template_replace_array[] = esc_attr(get_user_meta(get_current_user_id(), $value, true));
            }
        }

        //Default
        $rankology_titles_title_template = esc_attr(rankology_get_service('TitleOption')->getArchivesAuthorTitle());

        //User meta
        if ( ! empty($matches) && ! empty($rankology_titles_cf_template_variables_array) && ! empty($rankology_titles_cf_template_replace_array)) {
            $rankology_titles_title_template = str_replace($rankology_titles_cf_template_variables_array, $rankology_titles_cf_template_replace_array, $rankology_titles_title_template);
        }

        $rankology_titles_title_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_title_template);
    } elseif (is_date() && rankology_get_service('TitleOption')->getTitleArchivesDate()) { //IS DATE
        $rankology_titles_archives_date_title_option = esc_attr(rankology_get_service('TitleOption')->getTitleArchivesDate());

        $rankology_titles_title_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_archives_date_title_option);
    } elseif (is_search() && rankology_get_service('TitleOption')->getTitleArchivesSearch()) { //IS SEARCH
        $rankology_titles_archives_search_title_option = esc_attr(rankology_get_service('TitleOption')->getTitleArchivesSearch());

        $rankology_titles_title_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_archives_search_title_option);
    } elseif (is_404() && rankology_get_service('TitleOption')->getTitleArchives404()) { //IS 404
        $rankology_titles_archives_404_title_option = esc_attr(rankology_get_service('TitleOption')->getTitleArchives404());

        $rankology_titles_title_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_archives_404_title_option);
    }

    //Hook on Title tag - 'rankology_titles_title'
    if (has_filter('rankology_titles_title')) {
        $rankology_titles_title_template = apply_filters('rankology_titles_title', $rankology_titles_title_template);
    }

    //Return Title tag
    return $rankology_titles_title_template;
}

if (apply_filters('rankology_old_pre_get_document_title', true)) {
    $priority = apply_filters( 'rankology_titles_the_title_priority', 10 );
    add_filter('pre_get_document_title', 'rankology_titles_the_title', $priority);

    //Avoid TEC rewriting our title tag on Venue and Organizer pages
    if (is_plugin_active('the-events-calendar/the-events-calendar.php')) {
        if (
            function_exists('tribe_is_event') && tribe_is_event() ||
            function_exists('tribe_is_venue') && tribe_is_venue() ||
            function_exists('tribe_is_organizer') && tribe_is_organizer()
            // function_exists('tribe_is_month') && tribe_is_month() && is_tax() ||
            // function_exists('tribe_is_upcoming') && tribe_is_upcoming() && is_tax() ||
            // function_exists('tribe_is_past') && tribe_is_past() && is_tax() ||
            // function_exists('tribe_is_week') && tribe_is_week() && is_tax() ||
            // function_exists('tribe_is_day') && tribe_is_day() && is_tax() ||
            // function_exists('tribe_is_map') && tribe_is_map() && is_tax() ||
            // function_exists('tribe_is_photo') && tribe_is_photo() && is_tax()
        ) {
            add_filter('pre_get_document_title', 'rankology_titles_the_title', 20);
        }
    }
}

//THE Meta Description
function rankology_titles_the_description_content() {
    $variables = null;
    $variables = apply_filters('rankology_dyn_variables_fn', $variables);

    $post 										                           = $variables['post'];
    $term 										                           = $variables['term'];
    $rankology_titles_title_template 			        = $variables['rankology_titles_title_template'];
    $rankology_titles_description_template 		   = $variables['rankology_titles_description_template'];
    $rankology_paged 							                    = $variables['rankology_paged'];
    $the_author_meta 							                   = $variables['the_author_meta'];
    $sep 										                            = $variables['sep'];
    $rankology_excerpt 							                  = $variables['rankology_excerpt'];
    $post_category 								                    = $variables['post_category'];
    $post_tag 									                        = $variables['post_tag'];
    $post_thumbnail_url 						                 = $variables['post_thumbnail_url'];
    $get_search_query 							                  = $variables['get_search_query'];
    $woo_single_cat_html 						                = $variables['woo_single_cat_html'];
    $woo_single_tag_html 						                = $variables['woo_single_tag_html'];
    $woo_single_price 							                  = $variables['woo_single_price'];
    $woo_single_price_exc_tax					             = $variables['woo_single_price_exc_tax'];
    $woo_single_sku 							                    = $variables['woo_single_sku'];
    $author_bio 								                       = $variables['author_bio'];
    $rankology_get_the_excerpt 					            = $variables['rankology_get_the_excerpt'];
    $rankology_titles_template_variables_array 	= $variables['rankology_titles_template_variables_array'];
    $rankology_titles_template_replace_array 	  = $variables['rankology_titles_template_replace_array'];
    $rankology_excerpt_length 					             = $variables['rankology_excerpt_length'];
    $page_id 									                         = get_option('page_for_posts');

    if (is_front_page() && is_home() && isset($post) && '' == get_post_meta($post->ID, '_rankology_titles_desc', true)) { //HOMEPAGE
        if ('' !== rankology_get_service('TitleOption')->getHomeDescriptionTitle()) { //IS GLOBAL
            $rankology_titles_the_description = esc_attr(rankology_get_service('TitleOption')->getHomeDescriptionTitle());

            $rankology_titles_description_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_the_description);
        }
    } elseif (is_front_page() && isset($post) && '' == get_post_meta($post->ID, '_rankology_titles_desc', true)) { //STATIC HOMEPAGE
        if ('' !== rankology_get_service('TitleOption')->getHomeDescriptionTitle() && '' == get_post_meta($post->ID, '_rankology_titles_desc', true)) { //IS GLOBAL
            $rankology_titles_the_description = esc_attr(rankology_get_service('TitleOption')->getHomeDescriptionTitle());

            $rankology_titles_description_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_the_description);
        }
    } elseif (is_home() && '' != get_post_meta($page_id, '_rankology_titles_desc', true)) { //BLOG PAGE
        if (get_post_meta($page_id, '_rankology_titles_desc', true)) {
            $rankology_titles_the_description_meta = esc_html(get_post_meta($page_id, '_rankology_titles_desc', true));
            $rankology_titles_the_description      = $rankology_titles_the_description_meta;

            $rankology_titles_description_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_the_description);
        }
    } elseif (is_home() && ('posts' == get_option('show_on_front'))) { //YOUR LATEST POSTS
        if ('' !== rankology_get_service('TitleOption')->getHomeDescriptionTitle()) { //IS GLOBAL
            $rankology_titles_the_description = esc_attr(rankology_get_service('TitleOption')->getHomeDescriptionTitle());

            $rankology_titles_description_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_the_description);
        }
    } elseif (function_exists('bp_is_group') && bp_is_group()) {
        if ('' !== rankology_get_service('TitleOption')->getBpGroupsDesc()) {
            $rankology_titles_the_description = esc_attr(rankology_get_service('TitleOption')->getBpGroupsDesc());

            $rankology_titles_description_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_the_description);
        }
    } elseif (is_singular()) { //IS SINGLE
        if (get_post_meta($post->ID, '_rankology_titles_desc', true)) { //IS METABOXE
            $rankology_titles_the_description = esc_attr(get_post_meta($post->ID, '_rankology_titles_desc', true));

            preg_match_all('/%%_cf_(.*?)%%/', $rankology_titles_the_description, $matches); //custom fields

            if ( ! empty($matches)) {
                $rankology_titles_cf_template_variables_array = [];
                $rankology_titles_cf_template_replace_array   = [];

                foreach ($matches['0'] as $key => $value) {
                    $rankology_titles_cf_template_variables_array[] = $value;
                }

                foreach ($matches['1'] as $key => $value) {
                    $custom_field = esc_attr(get_post_meta($post->ID, $value, true));
                    $rankology_titles_cf_template_replace_array[] = apply_filters('rankology_titles_custom_field', $custom_field, $value);
                }
            }

            preg_match_all('/%%_ct_(.*?)%%/', $rankology_titles_the_description, $matches2); //custom terms taxonomy

            if ( ! empty($matches2)) {
                $rankology_titles_ct_template_variables_array = [];
                $rankology_titles_ct_template_replace_array   = [];

                foreach ($matches2['0'] as $key => $value) {
                    $rankology_titles_ct_template_variables_array[] = $value;
                }

                foreach ($matches2['1'] as $key => $value) {
                    $term = wp_get_post_terms($post->ID, $value);
                    if ( ! is_wp_error($term)) {
                        $terms                                       = esc_attr($term[0]->name);
                        $rankology_titles_ct_template_replace_array[] = apply_filters('rankology_titles_custom_tax', $terms, $value);
                    }
                }
            }

            preg_match_all('/%%_ucf_(.*?)%%/', $rankology_titles_the_description, $matches3); //user meta

            if ( ! empty($matches3)) {
                $rankology_titles_ucf_template_variables_array = [];
                $rankology_titles_ucf_template_replace_array   = [];

                foreach ($matches3['0'] as $key => $value) {
                    $rankology_titles_ucf_template_variables_array[] = $value;
                }

                foreach ($matches3['1'] as $key => $value) {
                    $user_meta = esc_attr(get_user_meta(get_current_user_id(), $value, true));
                    $rankology_titles_ucf_template_replace_array[] = apply_filters('rankology_titles_user_meta', $user_meta, $value);
                }
            }

            //Default
            $rankology_titles_description_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_the_description);

            //Custom fields
            if ( ! empty($matches) && ! empty($rankology_titles_cf_template_variables_array) && ! empty($rankology_titles_cf_template_replace_array)) {
                $rankology_titles_description_template = str_replace($rankology_titles_cf_template_variables_array, $rankology_titles_cf_template_replace_array, $rankology_titles_description_template);
            }

            //Custom terms taxonomy
            if ( ! empty($matches2) && ! empty($rankology_titles_ct_template_variables_array) && ! empty($rankology_titles_ct_template_replace_array)) {
                $rankology_titles_description_template = str_replace($rankology_titles_ct_template_variables_array, $rankology_titles_ct_template_replace_array, $rankology_titles_description_template);
            }

            //User meta
            if ( ! empty($matches3) && ! empty($rankology_titles_ucf_template_variables_array) && ! empty($rankology_titles_ucf_template_replace_array)) {
                $rankology_titles_description_template = str_replace($rankology_titles_ucf_template_variables_array, $rankology_titles_ucf_template_replace_array, $rankology_titles_description_template);
            }
        } elseif ('' !== rankology_get_service('TitleOption')->getSingleCptDesc($post->ID)) { //IS GLOBAL
            $rankology_titles_the_description = esc_attr(rankology_get_service('TitleOption')->getSingleCptDesc($post->ID));

            preg_match_all('/%%_cf_(.*?)%%/', $rankology_titles_the_description, $matches); //custom fields

            if ( ! empty($matches)) {
                $rankology_titles_cf_template_variables_array = [];
                $rankology_titles_cf_template_replace_array   = [];

                foreach ($matches['0'] as $key => $value) {
                    $rankology_titles_cf_template_variables_array[] = $value;
                }

                foreach ($matches['1'] as $key => $value) {
                    $rankology_titles_cf_template_replace_array[] = esc_attr(get_post_meta($post->ID, $value, true));
                }
            }

            preg_match_all('/%%_ct_(.*?)%%/', $rankology_titles_the_description, $matches2); //custom terms taxonomy

            if ( ! empty($matches2)) {
                $rankology_titles_ct_template_variables_array = [];
                $rankology_titles_ct_template_replace_array   = [];

                foreach ($matches2['0'] as $key => $value) {
                    $rankology_titles_ct_template_variables_array[] = $value;
                }

                foreach ($matches2['1'] as $key => $value) {
                    $term = wp_get_post_terms($post->ID, $value);
                    if ( ! is_wp_error($term)) {
                        $terms                                       = esc_attr($term[0]->name);
                        $rankology_titles_ct_template_replace_array[] = apply_filters('rankology_titles_custom_tax', $terms, $value);
                    }
                }
            }

            preg_match_all('/%%_ucf_(.*?)%%/', $rankology_titles_the_description, $matches3); //user meta

            if ( ! empty($matches3)) {
                $rankology_titles_ucf_template_variables_array = [];
                $rankology_titles_ucf_template_replace_array   = [];

                foreach ($matches3['0'] as $key => $value) {
                    $rankology_titles_ucf_template_variables_array[] = $value;
                }

                foreach ($matches3['1'] as $key => $value) {
                    $rankology_titles_ucf_template_replace_array[] = esc_attr(get_user_meta(get_current_user_id(), $value, true));
                }
            }

            //Default
            $rankology_titles_description_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_the_description);

            //Custom fields
            if ( ! empty($matches) && ! empty($rankology_titles_cf_template_variables_array) && ! empty($rankology_titles_cf_template_replace_array)) {
                $rankology_titles_description_template = str_replace($rankology_titles_cf_template_variables_array, $rankology_titles_cf_template_replace_array, $rankology_titles_description_template);
            }

            //Custom terms taxonomy
            if ( ! empty($matches2) && ! empty($rankology_titles_ct_template_variables_array) && ! empty($rankology_titles_ct_template_replace_array)) {
                $rankology_titles_description_template = str_replace($rankology_titles_ct_template_variables_array, $rankology_titles_ct_template_replace_array, $rankology_titles_description_template);
            }

            //User meta
            if ( ! empty($matches3) && ! empty($rankology_titles_ucf_template_variables_array) && ! empty($rankology_titles_ucf_template_replace_array)) {
                $rankology_titles_description_template = str_replace($rankology_titles_ucf_template_variables_array, $rankology_titles_ucf_template_replace_array, $rankology_titles_description_template);
            }
        } else {
            setup_postdata($post);
            if ('' != $rankology_get_the_excerpt || '' != get_the_content()) { //DEFAULT EXCERPT OR THE CONTENT
                $rankology_titles_the_description = wp_trim_words(stripslashes_deep(wp_filter_nohtml_kses($rankology_get_the_excerpt)), $rankology_excerpt_length);

                $rankology_titles_description_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_the_description);
            }
        }
    } elseif (is_post_type_archive() && !is_search() && !is_tax() && rankology_get_service('TitleOption')->getArchivesCPTDesc()) { //IS POST TYPE ARCHIVE (!is_tax required for TEC, !is_search required for WC search box)
        $rankology_titles_the_description = esc_attr(rankology_get_service('TitleOption')->getArchivesCPTDesc($post->ID));

        $rankology_titles_description_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_the_description);
    } elseif ((is_tax() || is_category() || is_tag()) && rankology_get_service('TitleOption')->getTaxDesc()) { //IS TAX
        $rankology_titles_the_description = esc_attr(rankology_get_service('TitleOption')->getTaxDesc());

        if (get_term_meta(get_queried_object()->{'term_id'}, '_rankology_titles_desc', true)) {
            $rankology_titles_description_template = esc_attr(get_term_meta(get_queried_object()->{'term_id'}, '_rankology_titles_desc', true));
            $rankology_titles_description_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_description_template);
        } else {
            $rankology_titles_description_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_the_description);
        }

        preg_match_all('/%%_cf_(.*?)%%/', $rankology_titles_the_description, $matches); //custom fields

        if ( ! empty($matches)) {
            $rankology_titles_cf_template_variables_array = [];
            $rankology_titles_cf_template_replace_array   = [];

            foreach ($matches['0'] as $key => $value) {
                $rankology_titles_cf_template_variables_array[] = $value;
            }

            foreach ($matches['1'] as $key => $value) {
                $rankology_titles_cf_template_replace_array[] = esc_attr(get_term_meta(get_queried_object()->{'term_id'}, $value, true));
            }
        }

        //Custom fields
        if ( ! empty($matches) && ! empty($rankology_titles_cf_template_variables_array) && ! empty($rankology_titles_cf_template_replace_array)) {
            $rankology_titles_description_template = str_replace($rankology_titles_cf_template_variables_array, $rankology_titles_cf_template_replace_array, $rankology_titles_description_template);
        }
    } elseif (is_author() && rankology_get_service('TitleOption')->getArchivesAuthorDescription()) { //IS AUTHOR
        $rankology_titles_archives_author_desc_option = esc_attr(rankology_get_service('TitleOption')->getArchivesAuthorDescription());

        preg_match_all('/%%_ucf_(.*?)%%/', $rankology_titles_archives_author_desc_option, $matches); //custom fields

        if ( ! empty($matches)) {
            $rankology_titles_cf_template_variables_array = [];
            $rankology_titles_cf_template_replace_array   = [];

            foreach ($matches['0'] as $key => $value) {
                $rankology_titles_cf_template_variables_array[] = $value;
            }

            foreach ($matches['1'] as $key => $value) {
                $rankology_titles_cf_template_replace_array[] = esc_attr(get_user_meta(get_current_user_id(), $value, true));
            }
        }

        //Default
        $rankology_titles_description_template = esc_attr(rankology_get_service('TitleOption')->getArchivesAuthorDescription());

        //User meta
        if ( ! empty($matches) && ! empty($rankology_titles_cf_template_variables_array) && ! empty($rankology_titles_cf_template_replace_array)) {
            $rankology_titles_description_template = str_replace($rankology_titles_cf_template_variables_array, $rankology_titles_cf_template_replace_array, $rankology_titles_description_template);
        }

        $rankology_titles_description_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_description_template);
    } elseif (is_date() && rankology_get_service('TitleOption')->getArchivesDateDesc()) { //IS DATE
        $rankology_titles_the_description = esc_attr(rankology_get_service('TitleOption')->getArchivesDateDesc());

        $rankology_titles_description_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_the_description);
    } elseif (is_search() && rankology_get_service('TitleOption')->getArchivesSearchDesc()) { //IS SEARCH
        $rankology_titles_the_description = esc_attr(rankology_get_service('TitleOption')->getArchivesSearchDesc());

        $rankology_titles_description_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_the_description);
    } elseif (is_404() && rankology_get_service('TitleOption')->getArchives404Desc()) { //IS 404
        $rankology_titles_the_description = esc_attr(rankology_get_service('TitleOption')->getArchives404Desc());

        $rankology_titles_description_template = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_the_description);
    }
    //Hook on meta description - 'rankology_titles_desc'
    if (has_filter('rankology_titles_desc')) {
        $rankology_titles_description_template = apply_filters('rankology_titles_desc', $rankology_titles_description_template);
    }
    //Return meta desc tag
    return $rankology_titles_description_template;
}
function rankology_titles_the_description() {
    if ('' != rankology_titles_the_description_content()) {
        $html = '<meta name="description" content="' . rankology_titles_the_description_content() . '">';
        $html .= "\n";
        echo rankology_common_esc_str($html);
    }
}

if (apply_filters('rankology_old_wp_head_description', true)) {
    add_action('wp_head', 'rankology_titles_the_description', 1);
}

//Advanced
//noindex single CPT
function rankology_titles_noindex_post_option() {
    $_rankology_robots_index = get_post_meta(get_the_ID(), '_rankology_robots_index', true);
    if ('yes' == $_rankology_robots_index) {
        return $_rankology_robots_index;
    }
}

function rankology_titles_noindex_bypass() {
    //init
    $rankology_titles_noindex ='';
    $page_id                 = get_option('page_for_posts');
    if (is_singular() && true === post_password_required()) { //if password required, set noindex
        $rankology_titles_noindex = 'noindex';
    } else {
        if (rankology_get_service('TitleOption')->getTitleNoIndex()) { //Global Advanced tab
            $rankology_titles_noindex = rankology_get_service('TitleOption')->getTitleNoIndex();
        } elseif (is_singular() && rankology_get_service('TitleOption')->getSingleCptNoIndex()) { //Single CPT Global
            $rankology_titles_noindex = rankology_get_service('TitleOption')->getSingleCptNoIndex();
        } elseif (is_singular() && rankology_titles_noindex_post_option()) { //Single CPT Metaboxe
            $rankology_titles_noindex = rankology_titles_noindex_post_option();
        } elseif (is_home() && '' != get_post_meta($page_id, '_rankology_robots_index', true)) { //BLOG PAGE
            $rankology_titles_noindex = get_post_meta($page_id, '_rankology_robots_index', true);
        } elseif (is_post_type_archive() && rankology_get_service('TitleOption')->getArchivesCPTNoIndex()) { //Is POST TYPE ARCHIVE
            $rankology_titles_noindex = rankology_get_service('TitleOption')->getArchivesCPTNoIndex();
        } elseif ((is_tax() || is_category() || is_tag()) && rankology_get_service('TitleOption')->getTaxNoIndex()) { //Is TAX
            $rankology_titles_noindex = rankology_get_service('TitleOption')->getTaxNoIndex();
        } elseif (is_author() && rankology_get_service('TitleOption')->getArchiveAuthorNoIndex()) { //Is Author archive
            $rankology_titles_noindex = rankology_get_service('TitleOption')->getArchiveAuthorNoIndex();
        } elseif (function_exists('bp_is_group') && bp_is_group() && rankology_get_service('TitleOption')->getBpGroupsNoIndex()) { //Is BuddyPress group single
            $rankology_titles_noindex = rankology_get_service('TitleOption')->getBpGroupsNoIndex();
        } elseif (is_date() && rankology_get_service('TitleOption')->getArchivesDateNoIndex()) { //Is Date archive
            $rankology_titles_noindex = rankology_get_service('TitleOption')->getArchivesDateNoIndex();
        } elseif (is_search() && rankology_get_service('TitleOption')->getArchivesSearchNoIndex()) {//Is Search
            $rankology_titles_noindex = rankology_get_service('TitleOption')->getArchivesSearchNoIndex();
        } elseif (is_paged() && rankology_get_service('TitleOption')->getPagedNoIndex()) {//Is paged archive
            $rankology_titles_noindex = rankology_get_service('TitleOption')->getPagedNoIndex();
        } elseif (is_404()) { //Is 404 page
            $rankology_titles_noindex = 'noindex';
        } elseif (is_attachment() && rankology_get_service('TitleOption')->getAttachmentsNoIndex()) {
            $rankology_titles_noindex = 'noindex';
        }
    }

    $rankology_titles_noindex = apply_filters('rankology_titles_noindex_bypass', $rankology_titles_noindex);

    //remove hreflang if noindex
    if ('1' == $rankology_titles_noindex || true == $rankology_titles_noindex) {
        //WPML
        add_filter('wpml_hreflangs', '__return_false');

        //MultilingualPress v2
        add_filter('multilingualpress.render_hreflang', '__return_false');

        //TranslatePress
        add_filter('trp-exclude-hreflang', '__return_true');
    }
    //Return noindex tag
    return $rankology_titles_noindex;
}

//nofollow
//nofollow Global Avanced tab
function rankology_titles_nofollow_post_option() {
    $_rankology_robots_follow = get_post_meta(get_the_ID(), '_rankology_robots_follow', true);
    if ('yes' == $_rankology_robots_follow) {
        return $_rankology_robots_follow;
    }
}

function rankology_titles_nofollow_bypass() {
    //init
    $rankology_titles_nofollow ='';
    $page_id                  = get_option('page_for_posts');
    if (rankology_get_service('TitleOption')->getTitleNoFollow()) { //Single CPT Global Advanced tab
        $rankology_titles_nofollow = rankology_get_service('TitleOption')->getTitleNoFollow();
    } elseif (is_singular() && rankology_get_service('TitleOption')->getSingleCptNoFollow()) { //Single CPT Global
        $rankology_titles_nofollow = rankology_get_service('TitleOption')->getSingleCptNoFollow();
    } elseif (is_singular() && rankology_titles_nofollow_post_option()) { //Single CPT Metaboxe
        $rankology_titles_nofollow = rankology_titles_nofollow_post_option();
    } elseif (is_home() && '' != get_post_meta($page_id, '_rankology_robots_follow', true)) { //BLOG PAGE
        $rankology_titles_nofollow = get_post_meta($page_id, '_rankology_robots_follow', true);
    } elseif (is_post_type_archive() && rankology_get_service('TitleOption')->getArchivesCPTNoFollow()) { //IS POST TYPE ARCHIVE
        $rankology_titles_nofollow = rankology_get_service('TitleOption')->getArchivesCPTNoFollow();
    } elseif ((is_tax() || is_category() || is_tag()) && rankology_get_service('TitleOption')->getTaxNoFollow()) { //IS TAX
        $rankology_titles_nofollow = rankology_get_service('TitleOption')->getTaxNoFollow();
    }

    return $rankology_titles_nofollow;
}

//date in SERPs
function rankology_titles_single_cpt_date_hook() {
    if ( ! is_front_page() && ! is_home()) {
        if (is_singular() && '1' === rankology_get_service('TitleOption')->getSingleCptDate()) {
            $rankology_get_current_pub_post_date = get_the_date('c');
            $rankology_get_current_up_post_date  = get_the_modified_date('c');
            $html                               = '<meta property="article:published_time" content="' . $rankology_get_current_pub_post_date . '">';
            $html .= "\n";

            $html = apply_filters('rankology_titles_article_published_time', $html);

            echo rankology_common_esc_str($html);

            $html = '<meta property="article:modified_time" content="' . $rankology_get_current_up_post_date . '">';
            $html .= "\n";

            $html = apply_filters('rankology_titles_article_modified_time', $html);

            echo rankology_common_esc_str($html);

            $html = '<meta property="og:updated_time" content="' . $rankology_get_current_up_post_date . '">';
            $html .= "\n";

            $html = apply_filters('rankology_titles_og_updated_time', $html);

            echo rankology_common_esc_str($html);
        }
    }
}
add_action('wp_head', 'rankology_titles_single_cpt_date_hook', 1);

//thumbnail in Google Custom Search
function rankology_titles_single_cpt_thumb_gcs() {
    if ( ! is_front_page() && ! is_home()) {
        if (is_singular() && '1' === rankology_get_service('TitleOption')->getSingleCptThumb()) {
            if (get_the_post_thumbnail_url(get_the_ID())) {
                $html = '<meta name="thumbnail" content="' . get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') . '">';
                $html .= "\n";

                $html = apply_filters('rankology_titles_gcs_thumbnail', $html);

                echo rankology_common_esc_str($html);
            }
        }
    }
}
add_action('wp_head', 'rankology_titles_single_cpt_thumb_gcs', 1);

//noarchive
function rankology_titles_noarchive_post_option() {
    $_rankology_robots_archive = get_post_meta(get_the_ID(), '_rankology_robots_archive', true);
    if ('yes' == $_rankology_robots_archive) {
        return $_rankology_robots_archive;
    }
}

function rankology_titles_noarchive_bypass() {
    $page_id = get_option('page_for_posts');
    if (rankology_get_service('TitleOption')->getTitleNoArchive()) {
        return rankology_get_service('TitleOption')->getTitleNoArchive();
    } elseif (is_singular() && rankology_titles_noarchive_post_option()) {
        return rankology_titles_noarchive_post_option();
    } elseif (is_home() && '' != get_post_meta($page_id, '_rankology_robots_archive', true)) { //BLOG PAGE
        return get_post_meta($page_id, '_rankology_robots_archive', true);
    } elseif (is_tax() || is_category() || is_tag()) {
        if ('yes' == get_term_meta(get_queried_object()->{'term_id'}, '_rankology_robots_archive', true)) {
            return get_term_meta(get_queried_object()->{'term_id'}, '_rankology_robots_archive', true);
        }
    }
}

//nosnippet
function rankology_titles_nosnippet_post_option() {
    $_rankology_robots_snippet = get_post_meta(get_the_ID(), '_rankology_robots_snippet', true);
    if ('yes' == $_rankology_robots_snippet) {
        return $_rankology_robots_snippet;
    }
}

function rankology_titles_nosnippet_bypass() {
    $page_id = get_option('page_for_posts');
    if (rankology_get_service('TitleOption')->getTitleNoSnippet()) {
        return rankology_get_service('TitleOption')->getTitleNoSnippet();
    } elseif (is_singular() && rankology_titles_nosnippet_post_option()) {
        return rankology_titles_nosnippet_post_option();
    } elseif (is_home() && '' != get_post_meta($page_id, '_rankology_robots_snippet', true)) { //BLOG PAGE
        return get_post_meta($page_id, '_rankology_robots_snippet', true);
    } elseif (is_tax() || is_category() || is_tag()) {
        if ('yes' == get_term_meta(get_queried_object()->{'term_id'}, '_rankology_robots_snippet', true)) {
            return get_term_meta(get_queried_object()->{'term_id'}, '_rankology_robots_snippet', true);
        }
    }
}

//noimageindex
function rankology_titles_noimageindex_post_option() {
    $_rankology_robots_imageindex = get_post_meta(get_the_ID(), '_rankology_robots_imageindex', true);
    if ('yes' == $_rankology_robots_imageindex) {
        return $_rankology_robots_imageindex;
    }
}

function rankology_titles_noimageindex_bypass() {
    if (rankology_get_service('TitleOption')->getTitleNoImageIndex()) {
        return rankology_get_service('TitleOption')->getTitleNoImageIndex();
    } elseif (is_singular() && rankology_titles_noimageindex_post_option()) {
        return rankology_titles_noimageindex_post_option();
    } elseif (is_tax() || is_category() || is_tag()) {
        $queried_object = get_queried_object();
        if (null != $queried_object) {
            if ('yes' == get_term_meta($queried_object->term_id, '_rankology_robots_imageindex', true)) {
                return get_term_meta($queried_object->term_id, '_rankology_robots_imageindex', true);
            }
        }
    }
}

//Polylang
function rankology_remove_hreflang_polylang($hreflangs) {
    $hreflangs = [];

    return $hreflangs;
}

if ('0' != get_option('blog_public')) {// Discourage search engines from indexing this site is OFF
    function rankology_titles_advanced_robots_hook() {
        $rankology_comma_array = [];

        if ('' != rankology_titles_noindex_bypass()) {
            $rankology_titles_noindex = 'noindex';
            //Hook on meta robots noindex - 'rankology_titles_noindex'
            if (has_filter('rankology_titles_noindex')) {
                $rankology_titles_noindex = apply_filters('rankology_titles_noindex', $rankology_titles_noindex);
            }
            array_push($rankology_comma_array, $rankology_titles_noindex);
        }
        if ('' != rankology_titles_nofollow_bypass()) {
            $rankology_titles_nofollow = 'nofollow';
            //Hook on meta robots nofollow - 'rankology_titles_nofollow'
            if (has_filter('rankology_titles_nofollow')) {
                $rankology_titles_nofollow = apply_filters('rankology_titles_nofollow', $rankology_titles_nofollow);
            }
            array_push($rankology_comma_array, $rankology_titles_nofollow);
        }
        if ('' != rankology_titles_noarchive_bypass()) {
            $rankology_titles_noarchive = 'noarchive';
            //Hook on meta robots noarchive - 'rankology_titles_noarchive'
            if (has_filter('rankology_titles_noarchive')) {
                $rankology_titles_noarchive = apply_filters('rankology_titles_noarchive', $rankology_titles_noarchive);
            }
            array_push($rankology_comma_array, $rankology_titles_noarchive);
        }
        if ('' != rankology_titles_noimageindex_bypass()) {
            $rankology_titles_noimageindex = 'noimageindex';
            //Hook on meta robots noimageindex - 'rankology_titles_noimageindex'
            if (has_filter('rankology_titles_noimageindex')) {
                $rankology_titles_noimageindex = apply_filters('rankology_titles_noimageindex', $rankology_titles_noimageindex);
            }
            array_push($rankology_comma_array, $rankology_titles_noimageindex);
        }
        if ('' != rankology_titles_nosnippet_bypass()) {
            $rankology_titles_nosnippet = 'nosnippet';
            //Hook on meta robots nosnippet - 'rankology_titles_nosnippet'
            if (has_filter('rankology_titles_nosnippet')) {
                $rankology_titles_nosnippet = apply_filters('rankology_titles_nosnippet', $rankology_titles_nosnippet);
            }
            array_push($rankology_comma_array, $rankology_titles_nosnippet);
        }

        //remove hreflang tag from Polylang if noindex
        if (in_array('noindex', $rankology_comma_array)) {
            add_filter('pll_rel_hreflang_attributes', 'rankology_remove_hreflang_polylang');
        }

        if ( ! in_array('noindex', $rankology_comma_array) && ! in_array('nofollow', $rankology_comma_array)) {
            $rankology_titles_max_snippet = 'index, follow';
            array_unshift($rankology_comma_array, $rankology_titles_max_snippet);
        }

        if (in_array('nofollow', $rankology_comma_array) && ! in_array('noindex', $rankology_comma_array)) {
            $rankology_titles_max_snippet = 'index';
            array_unshift($rankology_comma_array, $rankology_titles_max_snippet);
        }

        if (in_array('noindex', $rankology_comma_array) && ! in_array('nofollow', $rankology_comma_array)) {
            $rankology_titles_max_snippet = 'follow';
            array_unshift($rankology_comma_array, $rankology_titles_max_snippet);
        }

        //Default meta robots
        $rankology_titles_robots = '<meta name="robots" content="';

        $rankology_comma_array = apply_filters('rankology_titles_robots_attrs', $rankology_comma_array);

        $rankology_comma_count = count($rankology_comma_array);
        for ($i = 0; $i < $rankology_comma_count; ++$i) {
            $rankology_titles_robots .= $rankology_comma_array[$i];
            if ($i < ($rankology_comma_count - 1)) {
                $rankology_titles_robots .= ', ';
            }
        }

        $rankology_titles_robots .= '">';
        $rankology_titles_robots .= "\n";

        //new meta robots
        if ( ! in_array('noindex', $rankology_comma_array)) {
            $rankology_titles_max_snippet = 'max-snippet:-1, max-image-preview:large, max-video-preview:-1';
            array_push($rankology_comma_array, $rankology_titles_max_snippet);

            //Googlebot
            $rankology_titles_robots .= '<meta name="googlebot" content="';

            $rankology_comma_array = apply_filters('rankology_titles_robots_attrs', $rankology_comma_array);

            $rankology_comma_count = count($rankology_comma_array);
            for ($i = 0; $i < $rankology_comma_count; ++$i) {
                $rankology_titles_robots .= $rankology_comma_array[$i];
                if ($i < ($rankology_comma_count - 1)) {
                    $rankology_titles_robots .= ', ';
                }
            }

            $rankology_titles_robots .= '">';
            $rankology_titles_robots .= "\n";

            //Bingbot
            $rankology_titles_robots .= '<meta name="bingbot" content="';

            $rankology_comma_array = apply_filters('rankology_titles_robots_attrs', $rankology_comma_array);

            $rankology_comma_count = count($rankology_comma_array);
            for ($i = 0; $i < $rankology_comma_count; ++$i) {
                $rankology_titles_robots .= $rankology_comma_array[$i];
                if ($i < ($rankology_comma_count - 1)) {
                    $rankology_titles_robots .= ', ';
                }
            }

            $rankology_titles_robots .= '">';
            $rankology_titles_robots .= "\n";
        }
        //Hook on meta robots all - 'rankology_titles_robots'
        if (has_filter('rankology_titles_robots')) {
            $rankology_titles_robots = apply_filters('rankology_titles_robots', $rankology_titles_robots);
        }
        echo rankology_common_esc_str($rankology_titles_robots);
    }
    add_action('wp_head', 'rankology_titles_advanced_robots_hook', 1);
}

//nositelinkssearchbox
if (rankology_get_service('TitleOption')->getNoSiteLinksSearchBox() ==='1') {
    function rankology_titles_nositelinkssearchbox_hook() {
        echo '<meta name="google" content="nositelinkssearchbox">';
        echo "\n";
    }
    add_action('wp_head', 'rankology_titles_nositelinkssearchbox_hook', 2);
}

//link rel prev/next
if (rankology_get_service('TitleOption')->getPagedRel()) {
    function rankology_titles_paged_rel_hook() {
        global $paged;
        if (get_previous_posts_link()) { ?>
			<link rel="prev" href="<?php echo get_pagenum_link($paged - 1); ?>">
		<?php }
        if (get_next_posts_link()) { ?>
			<link rel="next" href="<?php echo get_pagenum_link($paged + 1); ?>">
		<?php }
    }
    add_action('wp_head', 'rankology_titles_paged_rel_hook', 9);
}

//canonical
function rankology_titles_canonical_post_option() {
    $_rankology_robots_canonical = get_post_meta(get_the_ID(), '_rankology_robots_canonical', true);
    if ('' != $_rankology_robots_canonical) {
        return $_rankology_robots_canonical;
    }
}

function rankology_titles_canonical_term_option() {
    $queried_object = get_queried_object();
    $termId         =  null !== $queried_object ? $queried_object->term_id : '';
    if ( ! empty($termId)) {
        $_rankology_robots_canonical = get_term_meta($termId, '_rankology_robots_canonical', true);
        if ('' != $_rankology_robots_canonical) {
            return $_rankology_robots_canonical;
        }
    }
}

if (function_exists('rankology_titles_noindex_bypass') && '1' != rankology_titles_noindex_bypass() && 'yes' != rankology_titles_noindex_bypass()) {//Remove Canonical if noindex
    $page_id = get_option('page_for_posts');
    if (is_singular() && rankology_titles_canonical_post_option()) { //CUSTOM SINGLE CANONICAL
        function rankology_titles_canonical_post_hook() {
            $rankology_titles_canonical = '<link rel="canonical" href="' . htmlspecialchars(urldecode(rankology_titles_canonical_post_option())) . '">';
            //Hook on post canonical URL - 'rankology_titles_canonical'
            if (has_filter('rankology_titles_canonical')) {
                $rankology_titles_canonical = apply_filters('rankology_titles_canonical', $rankology_titles_canonical);
            }
            echo rankology_common_esc_str($rankology_titles_canonical) . "\n";
        }
        add_action('wp_head', 'rankology_titles_canonical_post_hook', 1);
    } elseif (is_home() && '' != get_post_meta($page_id, '_rankology_robots_canonical', true)) { //BLOG PAGE
        function rankology_titles_canonical_post_hook() {
            $page_id                   = get_option('page_for_posts');
            $rankology_titles_canonical = '<link rel="canonical" href="' . htmlspecialchars(urldecode(get_post_meta($page_id, '_rankology_robots_canonical', true))) . '">';
            //Hook on post canonical URL - 'rankology_titles_canonical'
            if (has_filter('rankology_titles_canonical')) {
                $rankology_titles_canonical = apply_filters('rankology_titles_canonical', $rankology_titles_canonical);
            }
            echo rankology_common_esc_str($rankology_titles_canonical) . "\n";
        }
        add_action('wp_head', 'rankology_titles_canonical_post_hook', 1, 1);
    } elseif ((is_tax() || is_category() || is_tag()) && rankology_titles_canonical_term_option()) { //CUSTOM TERM CANONICAL
        function rankology_titles_canonical_term_hook() {
            $rankology_titles_canonical = '<link rel="canonical" href="' . htmlspecialchars(urldecode(rankology_titles_canonical_term_option())) . '">';
            //Hook on post canonical URL - 'rankology_titles_canonical'
            if (has_filter('rankology_titles_canonical')) {
                $rankology_titles_canonical = apply_filters('rankology_titles_canonical', $rankology_titles_canonical);
            }
            echo rankology_common_esc_str($rankology_titles_canonical) . "\n";
        }
        add_action('wp_head', 'rankology_titles_canonical_term_hook', 1);
    } elseif ( ! is_404()) { //DEFAULT CANONICAL
        function rankology_titles_canonical_hook() {
            global $wp;

            $current_url = user_trailingslashit(home_url(add_query_arg([], $wp->request)));

            if (is_search()) {
                $rankology_titles_canonical = '<link rel="canonical" href="' . htmlspecialchars(urldecode(get_home_url() . '/search/' . get_search_query())) . '">';
            } elseif (is_paged() && is_singular()) {//Paginated pages
                $rankology_titles_canonical = '<link rel="canonical" href="' . htmlspecialchars(urldecode(get_permalink())) . '">';
            } elseif (is_paged()) {
                $rankology_titles_canonical = '<link rel="canonical" href="' . htmlspecialchars(urldecode($current_url)) . '">';
            } elseif (is_singular()) {
                $rankology_titles_canonical = '<link rel="canonical" href="' . htmlspecialchars(urldecode(get_permalink())) . '">';
            } else {
                $rankology_titles_canonical = '<link rel="canonical" href="' . htmlspecialchars(urldecode($current_url)) . '">';
            }
            //Hook on post canonical URL - 'rankology_titles_canonical'
            if (has_filter('rankology_titles_canonical')) {
                $rankology_titles_canonical = apply_filters('rankology_titles_canonical', $rankology_titles_canonical);
            }
            echo rankology_common_esc_str($rankology_titles_canonical) . "\n";
        }
        add_action('wp_head', 'rankology_titles_canonical_hook', 1);
    }
}
