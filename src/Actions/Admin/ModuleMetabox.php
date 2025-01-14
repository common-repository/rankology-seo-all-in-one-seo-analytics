<?php

namespace Rankology\Actions\Admin;

if (! defined('ABSPATH')) {
    exit;
}

use Rankology\Core\Hooks\ExecuteHooks;

class ModuleMetabox implements ExecuteHooks
{
    /**
     * 
     *
     * @return void
     */
    public function hooks()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue']);
        add_action('init', [$this, 'enqueue']);

        if (current_user_can(rankology_capability('edit_posts'))) {
            add_action('wp_enqueue_scripts', [$this, 'enqueueFrontend']);
        }
    }

    /**
     * 
     *
     * @return void
     *
     * @param mixed $argsLocalize
     */
    protected function enqueueModule($argsLocalize = [])
    {
        if (! rankology_get_service('EnqueueModuleMetabox')->canEnqueue()) {
            return;
        }

        //AMP compatibility
        if ( function_exists( 'amp_is_request' ) && amp_is_request() ) {
            return;
        }

        //Bricks builder compatibility
        if (function_exists('bricks_is_builder_call') && bricks_is_builder_call() === true) {
            return;
        }

        $isGutenberg = false;
        if(function_exists('get_current_screen')){
            $currentScreen = get_current_screen();
            if($currentScreen && method_exists($currentScreen,'is_block_editor')){
                $isGutenberg = true === get_current_screen()->is_block_editor();
            }
        }

        $dependencies = ['jquery-ui-datepicker'];
        if ($isGutenberg) {
            $dependencies = array_merge($dependencies, ['wp-components', 'wp-edit-post', 'wp-plugins']);
        }

        wp_enqueue_media();
        wp_enqueue_script('rankology-metabox', RANKOLOGY_URL_PUBLIC . '/metaboxe.js', $dependencies, uniqid(), true);
        $value = wp_create_nonce('rankology_rest');

        $tags = rankology_get_service('TagsToString')->getTagsAvailable([
            'without_classes' => [
                '\Rankology\Tags\PostThumbnailUrlHeight',
                '\Rankology\Tags\PostThumbnailUrlWidth',

            ],
            'without_classes_pos' => ['\Rankology\Tags\Schema', '\Rankology_Fno\Tags\Schema']
        ]);


        $getLocale = get_locale();
        if (!empty($getLocale)) {
            $locale       = substr($getLocale, 0, 2);
            $country_code = substr($getLocale, -2);
        } else {
            $locale       = 'en';
            $country_code = 'US';
        }

        $settingsAdvanced = rankology_get_service('AdvancedOption');
        $user = wp_get_current_user();
        $roles = ( array ) $user->roles;

        $postId = is_singular() ? get_the_ID() : null;
        $postType = null;
        if($postId){
            $postType = get_post_type($postId);
        }

        $args = array_merge([
            'RANKOLOGY_URL_PUBLIC'       => RANKOLOGY_URL_PUBLIC,
            'RANKOLOGY_URL_ASSETS'     => RANKOLOGY_URL_ASSETS,
            'SITENAME'                => get_bloginfo('name'),
            'SITEURL'                 => site_url(),
            'ADMIN_URL_TITLES'        => admin_url('admin.php?page=rankology-titles#tab=tab_rankology_titles_single'),
            'TAGS'                    => array_values($tags),
            'REST_URL'                => rest_url(),
            'NONCE'                   => wp_create_nonce('wp_rest'),
            'POST_ID'                 => $postId,
            'POST_TYPE'               => $postType,
            'IS_GUTENBERG'            => apply_filters('rankology_module_metabox_is_gutenberg', $isGutenberg),
            'SELECTOR_GUTENBERG'      => apply_filters('rankology_module_metabox_selector_gutenberg', '.edit-post-header .edit-post-header-toolbar__left'),
            'TOGGLE_MOBILE_PREVIEW' => apply_filters('rankology_toggle_mobile_preview', 1),
            'GOOGLE_SUGGEST' => [
                'ACTIVE'        => apply_filters('rankology_ui_metabox_google_suggest', false),
                'LOCALE'       => $locale,
                'COUNTRY_CODE' => $country_code,
            ],
            'USER_ROLES' => array_values($roles),
            'ROLES_BLOCKED' => [
                'GLOBAL' => $settingsAdvanced->getSecurityMetaboxRole(),
                'CONTENT_ANALYSIS' => $settingsAdvanced->getSecurityMetaboxRoleContentAnalysis()
            ],
            'OPTIONS' => [
                "AI" => rankology_get_service('ToggleOption')->getToggleAi() === "1" ? true : false,
            ],
            'TABS' => [
                'SCHEMAS' => apply_filters('rankology_active_schemas_manual_universal_metabox', false)
            ],
            'SUB_TABS' => [
                'GOOGLE_NEWS' => apply_filters('rankology_active_google_news', false),
                'VIDEO_SITEMAP' => apply_filters('rankology_active_video_sitemap', false),
                'INSPECT_URL' => apply_filters('rankology_active_inspect_url', false),
                'INTERNAL_LINKING' => apply_filters('rankology_active_internal_linking', false),
                'SCHEMA_MANUAL' =>  apply_filters('rankology_active_schemas', false)
            ],
            'FAVICON' => get_site_icon_url(32),
            'BEACON_SVG' => '',
        ], $argsLocalize);

        wp_localize_script('rankology-metabox', 'RANKOLOGY_DATA', $args);
        wp_localize_script('rankology-metabox', 'RANKOLOGY_I18N', rankology_get_service('I18nUniversalMetabox')->getTranslations());
    }

    /**
     * 
     *
     * @return void
     */
    public function enqueueFrontend()
    {
        $this->enqueueModule(['POST_ID' => get_the_ID()]);
    }

    /**
     * 
     *
     * @param string $page
     *
     * @return void
     */
    public function enqueue($page)
    {
        if (! in_array($page, ['post.php'], true)) {
            return;
        }
        $this->enqueueModule();
    }

    /**
     * 
     *
     * @return void
     */
    public function enqueueElementor()
    {
        $this->enqueueModule();
    }
}
