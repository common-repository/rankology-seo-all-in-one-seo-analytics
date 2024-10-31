<?php

namespace Rankology\Actions\Front\Metas;

defined('ABSPATH') or exit('Cheatin&#8217; uh?');

use Rankology\Core\Hooks\ExecuteHooksFrontend;

class TitleMeta implements ExecuteHooksFrontend {

    public $tagsToStringService;
    
    public function __construct() {
        $this->tagsToStringService = rankology_get_service('TagsToString');
    }

    /**
     * 
     *
     * @return void
     */
    public function hooks() {
        add_filter('pre_get_document_title', [$this, 'render'], 10);
    }

    /**
     * 
     *
     * @return string
     *
     * @param mixed $variablesArray
     * @param mixed $variablesReplace
     */
    protected function getHomeTitleTemplate($variablesArray, $variablesReplace) {
        if ( ! function_exists('rankology_get_service')) {
            $titleOption = rankology_get_service('TitleOption')->getHomeSiteTitle();
            if (empty($titleOption)) {
                return '';
            }
            $titleOption   = esc_attr($titleOption);

            return str_replace($variablesArray, $variablesReplace, $titleOption);
        }

        $title   = rankology_get_service('TitleOption')->getHomeSiteTitle();
        $context = rankology_get_service('ContextPage')->getContext();

        return $this->tagsToStringService->replace($title, $context);
    }

    /**
     * 
     *
     * @return string
     */
    public function render() {
        $defaultHook = function_exists('rankology_get_service');

        if (apply_filters('rankology_old_pre_get_document_title', true)) {
            return;
        }

        $context = rankology_get_service('ContextPage')->getContext();

        $variables = apply_filters('rankology_dyn_variables_fn', null);

        $post                                     = $variables['post'];
        $titleTemplate                            = $variables['rankology_titles_title_template'];
        $rankology_titles_template_variables_array = $variables['rankology_titles_template_variables_array'];
        $rankology_titles_template_replace_array   = $variables['rankology_titles_template_replace_array'];
        $page_id                                  = get_option('page_for_posts');

        if (is_front_page() && is_home() && isset($post) && '' == get_post_meta($post->ID, '_rankology_titles_title', true)) { //HOMEPAGE
            if ( ! empty(rankology_get_service('TitleOption')->getHomeSiteTitle())) {
                $titleTemplate = $this->getHomeTitleTemplate($rankology_titles_template_variables_array, $rankology_titles_template_replace_array);
            }
        } elseif (is_front_page() && isset($post) && '' == get_post_meta($post->ID, '_rankology_titles_title', true)) { //STATIC HOMEPAGE
            if ( ! empty(rankology_get_service('TitleOption')->getHomeSiteTitle())) {
                $titleTemplate = $this->getHomeTitleTemplate($rankology_titles_template_variables_array, $rankology_titles_template_replace_array);
            }
        } elseif (is_home() && '' != get_post_meta($page_id, '_rankology_titles_title', true)) { //BLOG PAGE
            if (get_post_meta($page_id, '_rankology_titles_title', true)) { //IS METABOXE
                $titleOption   = esc_attr(get_post_meta($page_id, '_rankology_titles_title', true));
                $titleTemplate = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $titleOption);
            }
        } elseif (is_home() && ('posts' == get_option('show_on_front'))) { //YOUR LATEST POSTS
            if ( ! function_exists('rankology_get_service')) {
                if ( ! empty(rankology_get_service('TitleOption')->getHomeSiteTitle())) {
                    $titleOption = esc_attr(rankology_get_service('TitleOption')->getHomeSiteTitle());

                    $titleTemplate = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $titleOption);
                }
            } else {
                $title         = rankology_get_service('TitleOption')->getHomeSiteTitle();
                $titleTemplate = $this->tagsToStringService->replace($title, $context);
            }
        } elseif (function_exists('bp_is_group') && bp_is_group()) {
            if ('' !== rankology_get_service('TitleOption')->getTitleBpGroups()) {
                $titleOption = esc_attr(rankology_get_service('TitleOption')->getTitleBpGroups());

                $titleTemplate = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $titleOption);
            }
        } elseif (is_singular()) { //IS SINGULAR
            // Check Buddypress
            $buddyId = rankology_get_service('BuddyPressGetCurrentId')->getCurrentId();
            if ($buddyId) {
                $post->ID = $buddyId;
            }

            if (get_post_meta($post->ID, '_rankology_titles_title', true)) { //IS METABOXE
                $titleOption = esc_attr(get_post_meta($post->ID, '_rankology_titles_title', true));

                preg_match_all('/%%_cf_(.*?)%%/', $titleOption, $matches); //custom fields

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

                preg_match_all('/%%_ct_(.*?)%%/', $titleOption, $matches2); //custom terms taxonomy

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

                preg_match_all('/%%_ucf_(.*?)%%/', $titleOption, $matches3); //user meta

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
                $titleTemplate = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $titleOption);

                //Custom fields
                if ( ! empty($matches) && ! empty($rankology_titles_cf_template_variables_array) && ! empty($rankology_titles_cf_template_replace_array)) {
                    $titleTemplate = str_replace($rankology_titles_cf_template_variables_array, $rankology_titles_cf_template_replace_array, $titleTemplate);
                }

                //Custom terms taxonomy
                if ( ! empty($matches2) && ! empty($rankology_titles_ct_template_variables_array) && ! empty($rankology_titles_ct_template_replace_array)) {
                    $titleTemplate = str_replace($rankology_titles_ct_template_variables_array, $rankology_titles_ct_template_replace_array, $titleTemplate);
                }

                //User meta
                if ( ! empty($matches3) && ! empty($rankology_titles_ucf_template_variables_array) && ! empty($rankology_titles_ucf_template_replace_array)) {
                    $titleTemplate = str_replace($rankology_titles_ucf_template_variables_array, $rankology_titles_ucf_template_replace_array, $titleTemplate);
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
                $titleTemplate = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_single_titles_option);

                //Custom fields
                if ( ! empty($matches) && ! empty($rankology_titles_cf_template_variables_array) && ! empty($rankology_titles_cf_template_replace_array)) {
                    $titleTemplate = str_replace($rankology_titles_cf_template_variables_array, $rankology_titles_cf_template_replace_array, $titleTemplate);
                }

                //Custom terms taxonomy
                if ( ! empty($matches2) && ! empty($rankology_titles_ct_template_variables_array) && ! empty($rankology_titles_ct_template_replace_array)) {
                    $titleTemplate = str_replace($rankology_titles_ct_template_variables_array, $rankology_titles_ct_template_replace_array, $titleTemplate);
                }

                //User meta
                if ( ! empty($matches3) && ! empty($rankology_titles_ucf_template_variables_array) && ! empty($rankology_titles_ucf_template_replace_array)) {
                    $titleTemplate = str_replace($rankology_titles_ucf_template_variables_array, $rankology_titles_ucf_template_replace_array, $titleTemplate);
                }
            }
        } elseif (is_post_type_archive() && rankology_get_service('TitleOption')->getArchivesCPTTitle()) { //IS POST TYPE ARCHIVE
            $rankology_titles_archive_titles_option = esc_attr(rankology_get_service('TitleOption')->getArchivesCPTTitle());

            $titleTemplate = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_archive_titles_option);
        } elseif ((is_tax() || is_category() || is_tag()) && rankology_get_service('TitleOption')->getTaxTitle()) { //IS TAX
            $rankology_titles_tax_titles_option = esc_attr(rankology_get_service('TitleOption')->getTaxTitle());

            if (get_term_meta(get_queried_object()->{'term_id'}, '_rankology_titles_title', true)) {
                $titleTemplate = esc_attr(get_term_meta(get_queried_object()->{'term_id'}, '_rankology_titles_title', true));
                $titleTemplate = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $titleTemplate);
            } else {
                $titleTemplate = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_tax_titles_option);
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
            $titleTemplate = esc_attr(rankology_get_service('TitleOption')->getArchivesAuthorTitle());

            //Custom fields
            if ( ! empty($matches) && ! empty($rankology_titles_cf_template_variables_array) && ! empty($rankology_titles_cf_template_replace_array)) {
                $titleTemplate = str_replace($rankology_titles_cf_template_variables_array, $rankology_titles_cf_template_replace_array, $titleTemplate);
            }

            $titleTemplate = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $titleTemplate);
        } elseif (is_date() && rankology_get_service('TitleOption')->getTitleArchivesDate()) { //IS DATE
            $rankology_titles_archives_date_title_option = esc_attr(rankology_get_service('TitleOption')->getTitleArchivesDate());

            $titleTemplate = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_archives_date_title_option);
        } elseif (is_search() && rankology_get_service('TitleOption')->getTitleArchivesSearch()) { //IS SEARCH
            $rankology_titles_archives_search_title_option = esc_attr(rankology_get_service('TitleOption')->getTitleArchivesSearch());

            $titleTemplate = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_archives_search_title_option);
        } elseif (is_404() && rankology_get_service('TitleOption')->getTitleArchives404()) { //IS 404
            $rankology_titles_archives_404_title_option = esc_attr(rankology_get_service('TitleOption')->getTitleArchives404());

            $titleTemplate = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_titles_archives_404_title_option);
        }

        //Hook on Title tag - 'rankology_titles_title'
        if (has_filter('rankology_titles_title')) {
            $titleTemplate = apply_filters('rankology_titles_title', $titleTemplate);
        }

        //Return Title tag
        return $titleTemplate;
    }
}
