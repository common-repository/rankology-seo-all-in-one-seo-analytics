<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

use Rankology\Helpers\PagesAdmin;

class rankology_options
{
    /**
     * Holds the values to be used in the fields callbacks.
     */
    private $options;

    /**
     * Start up.
     */
    public function __construct()
    {
        require_once dirname(__FILE__) . '/admin-dyn-variables-helper.php'; //Dynamic variables

        add_action('admin_menu', [$this, 'add_plugin_page'], 10);
        add_action('admin_init', [$this, 'set_default_values'], 10);
        add_action('admin_init', [$this, 'page_init']);
        add_action('admin_init', [$this, 'rankology_feature_save'], 30);
        add_action('admin_init', [$this, 'rankology_feature_title'], 20);
        add_action('admin_init', [$this, 'load_sections'], 30);
        add_action('admin_init', [$this, 'load_callbacks'], 40);
        add_action('admin_init', [$this, 'pre_save_options'], 50);
    }

    public function rankology_feature_save()
    {
        $html = '';
        if (isset($_GET['settings-updated']) && 'true' === $_GET['settings-updated']) {
            $html .= '<div id="rankology-notice-save" class="rkseo-components-snackbar-list">';
        } else {
            $html .= '<div id="rankology-notice-save" class="rkseo-components-snackbar-list" style="display: none">';
        }
        $html .= '<div class="rkseo-components-snackbar">
                <div class="rkseo-components-snackbar__content">
                    <span class="dashicons dashicons-yes"></span>
                    ' . esc_html__('Your settings have been saved.', 'wp-rankology') . '
                </div>
            </div>
        </div>';

        return rankology_common_esc_str($html);
    }

    public function rankology_feature_title($feature)
    {
        global $title;

        $html = '<h1>' . $title;

        if (null !== $feature) {
            if ('1' == rankology_get_toggle_option($feature)) {
                $toggle = '1';
            } else {
                $toggle = '0';
            }

            $html .= '<input type="checkbox" name="toggle-' . $feature . '" id="toggle-' . $feature . '" class="toggle" data-toggle="' . $toggle . '">';
            $html .= '<label for="toggle-' . $feature . '"></label>';

            $html .= $this->rankology_feature_save();

            if ('1' == rankology_get_toggle_option($feature)) {
                $html .= '<span id="titles-state-default" class="feature-state">' . esc_html__('Click to disable this feature', 'wp-rankology') . '</span>';
                $html .= '<span id="titles-state" class="feature-state feature-state-off">' . esc_html__('Click to enable this feature', 'wp-rankology') . '</span>';
            } else {
                $html .= '<span id="titles-state-default" class="feature-state">' . esc_html__('Click to enable this feature', 'wp-rankology') . '</span>';
                $html .= '<span id="titles-state" class="feature-state feature-state-off">' . esc_html__('Click to disable this feature', 'wp-rankology') . '</span>';
            }
        }

        $html .= '</h1>';

        return rankology_common_esc_str($html);
    }

    /**
     * Add options page.
     */
    public function add_plugin_page()
    {
        if (has_filter('rankology_seo_admin_menu')) {
            $rankology_rkseo_seo_admin_menu['icon'] = '';
            $rankology_rkseo_seo_admin_menu['icon'] = apply_filters('rankology_seo_admin_menu', $rankology_rkseo_seo_admin_menu['icon']);
        } else {
            $rankology_rkseo_seo_admin_menu['icon'] = 'dashicons-chart-pie';
        }

        $rankology_rkseo_seo_admin_menu['title'] = esc_html__('Rankology', 'wp-rankology');
        if (has_filter('rankology_seo_admin_menu_title')) {
            $rankology_rkseo_seo_admin_menu['title'] = apply_filters('rankology_seo_admin_menu_title', $rankology_rkseo_seo_admin_menu['title']);
        }

        //SEO Dashboard page
        add_menu_page(esc_html__('Rankology Option Page', 'wp-rankology'), $rankology_rkseo_seo_admin_menu['title'], rankology_capability('manage_options', 'menu'), 'rankology-option', [$this, 'create_admin_page'], $rankology_rkseo_seo_admin_menu['icon'], 5);

        //SEO sub-pages
        add_submenu_page('rankology-option', esc_html__('Dashboard', 'wp-rankology'), esc_html__('Dashboard', 'wp-rankology'), rankology_capability('manage_options', 'menu'), 'rankology-option', [$this, 'create_admin_page']);
        add_submenu_page('rankology-option', esc_html__('Header Metas', 'wp-rankology'), esc_html__('Header Metas', 'wp-rankology'), rankology_capability('manage_options', PagesAdmin::TITLE_METAS), 'rankology-titles', [$this, 'rankology_titles_page']);
        add_submenu_page('rankology-option', esc_html__('Social Platforms', 'wp-rankology'), esc_html__('Social Platforms', 'wp-rankology'), rankology_capability('manage_options', PagesAdmin::SOCIAL_NETWORKS), 'rankology-social', [$this, 'rankology_social_page']);
        add_submenu_page('rankology-option', esc_html__('XML Sitemap', 'wp-rankology'), esc_html__('XML Sitemap', 'wp-rankology'), rankology_capability('manage_options', PagesAdmin::XML_HTML_SITEMAP), 'rankology-xml-sitemap', [$this, 'rankology_xml_sitemap_page']);
        add_submenu_page('rankology-option', esc_html__('Google Analytics', 'wp-rankology'), esc_html__('Google Analytics', 'wp-rankology'), rankology_capability('manage_options', PagesAdmin::ANALYTICS), 'rankology-google-analytics', [$this, 'rankology_google_analytics_page']);
        add_submenu_page('rankology-option', esc_html__('Search Engines Indexing', 'wp-rankology'), esc_html__('Search Engines Indexing', 'wp-rankology'), rankology_capability('manage_options', PagesAdmin::INSTANT_INDEXING), 'rankology-instant-indexing', [$this, 'rankology_instant_indexing_page']);
        add_submenu_page('rankology-option', esc_html__('Metaboxes & Columns', 'wp-rankology'), esc_html__('Metaboxes/Columns', 'wp-rankology'), rankology_capability('manage_options', PagesAdmin::ADVANCED), 'rankology-metaboxes', [$this, 'rankology_advanced_page']);
        add_submenu_page('rankology-option', esc_html__('Images Optimization / SEO', 'wp-rankology'), esc_html__('Image SEO', 'wp-rankology'), rankology_capability('manage_options', PagesAdmin::ADVANCED), 'rankology-imageseo', [$this, 'rankology_imageseo_page']);
        add_submenu_page('rankology-option', esc_html__('Import/Export', 'wp-rankology'), esc_html__('Import/Export', 'wp-rankology'), rankology_capability('manage_options', PagesAdmin::TOOLS), 'rankology-import-export', [$this, 'rankology_import_export_page']);

        if (method_exists(rankology_get_service('ToggleOption'), 'getToggleWhiteLabel')) {
            $white_label_toggle = rankology_get_service('ToggleOption')->getToggleWhiteLabel();
            if ('1' === $white_label_toggle) {
                if (method_exists('rankology_fno_get_service', 'getWhiteLabelHelpLinks') && '1' === rankology_fno_get_service('OptionPro')->getWhiteLabelHelpLinks()) {
                    return;
                }
            }
        }
    }

    //Admin Pages
    public function rankology_titles_page()
    {
        require_once dirname(__FILE__) . '/admin-pages/Titles.php';
    }

    public function rankology_xml_sitemap_page()
    {
        require_once dirname(__FILE__) . '/admin-pages/Sitemaps.php';
    }

    public function rankology_social_page()
    {
        require_once dirname(__FILE__) . '/admin-pages/Social.php';
    }

    public function rankology_google_analytics_page()
    {
        require_once dirname(__FILE__) . '/admin-pages/Analytics.php';
    }

    public function rankology_advanced_page()
    {
        require_once dirname(__FILE__) . '/admin-pages/Advanced.php';
    }

    public function rankology_imageseo_page()
    {
        require_once dirname(__FILE__) . '/admin-pages/ImageSEO.php';
    }

    public function rankology_import_export_page()
    {
        require_once dirname(__FILE__) . '/admin-pages/Tools.php';
    }

    public function rankology_instant_indexing_page()
    {
        require_once dirname(__FILE__) . '/admin-pages/InstantIndexing.php';
    }

    public function create_admin_page()
    {
        require_once dirname(__FILE__) . '/admin-pages/Main.php';
    }

    public function set_default_values()
    {
        if (defined('RANKOLOGY_WPMAIN_VERSION')) {
            return;
        }

        //IndewNow======================================================================================
        $rankology_instant_indexing_option_name = get_option('rankology_instant_indexing_option_name');

        //Init if option doesn't exist
        if (false === $rankology_instant_indexing_option_name) {
            $rankology_instant_indexing_option_name = [];

            if ('1' == rankology_get_toggle_option('instant-indexing')) {
                rankology_instant_indexing_generate_api_key_fn(true);
            }

            $rankology_instant_indexing_option_name['rankology_instant_indexing_automate_submission'] = '1';
        }

        //Check if the value is an array (important!)
        if (is_array($rankology_instant_indexing_option_name)) {
            add_option('rankology_instant_indexing_option_name', $rankology_instant_indexing_option_name);
        }
    }

    public function page_init()
    {

        register_setting(
            'rankology_option_group', // Option group
            'rankology_option_name', // Option name
            [$this, 'sanitize'] // Sanitize
        );

        register_setting(
            'rankology_titles_option_group', // Option group
            'rankology_titles_option_name', // Option name
            [$this, 'sanitize'] // Sanitize
        );

        register_setting(
            'rankology_xml_sitemap_option_group', // Option group
            'rankology_xml_sitemap_option_name', // Option name
            [$this, 'sanitize'] // Sanitize
        );

        register_setting(
            'rankology_social_option_group', // Option group
            'rankology_social_option_name', // Option name
            [$this, 'sanitize'] // Sanitize
        );

        register_setting(
            'rankology_google_analytics_option_group', // Option group
            'rankology_google_analytics_option_name', // Option name
            [$this, 'sanitize'] // Sanitize
        );

        register_setting(
            'rankology_advanced_option_group', // Option group
            'rankology_advanced_option_name', // Option name
            [$this, 'sanitize'] // Sanitize
        );

        register_setting(
            'rankology_tools_option_group', // Option group
            'rankology_tools_option_name', // Option name
            [$this, 'sanitize'] // Sanitize
        );

        register_setting(
            'rankology_import_export_option_group', // Option group
            'rankology_import_export_option_name', // Option name
            [$this, 'sanitize'] // Sanitize
        );

        register_setting(
            'rankology_instant_indexing_option_group', // Option group
            'rankology_instant_indexing_option_name', // Option name
            [$this, 'sanitize'] // Sanitize
        );

        require_once dirname(__FILE__) . '/settings/Titles.php';
        require_once dirname(__FILE__) . '/settings/Sitemaps.php';
        require_once dirname(__FILE__) . '/settings/Social.php';
        require_once dirname(__FILE__) . '/settings/Analytics.php';
        require_once dirname(__FILE__) . '/settings/ImageSEO.php';
        require_once dirname(__FILE__) . '/settings/Advanced.php';
        require_once dirname(__FILE__) . '/settings/InstantIndexing.php';
    }

    public function sanitize($input)
    {
        require_once dirname(__FILE__) . '/sanitize/Sanitize.php';

        // Sanitize and validate the option page value
        $option_val = isset($_POST['option_page']) ? sanitize_text_field($_POST['option_page']) : '';

        // Ensure the sanitized value is as expected
        if ($option_val === 'rankology_advanced_option_group') {
            // Initialize the input array if not set
            if (!isset($input['rankology_advanced_appearance_universal_metabox_disable'])) {
                $input['rankology_advanced_appearance_universal_metabox_disable'] = '';
            }
        }

        return rankology_sanitize_options_fields($input);
    }

    public function load_sections()
    {
        require_once dirname(__FILE__) . '/sections/Titles.php';
        require_once dirname(__FILE__) . '/sections/Sitemaps.php';
        require_once dirname(__FILE__) . '/sections/Social.php';
        require_once dirname(__FILE__) . '/sections/Analytics.php';
        require_once dirname(__FILE__) . '/sections/ImageSEO.php';
        require_once dirname(__FILE__) . '/sections/Advanced.php';
        require_once dirname(__FILE__) . '/sections/InstantIndexing.php';
    }

    public function load_callbacks()
    {
        require_once dirname(__FILE__) . '/callbacks/Titles.php';
        require_once dirname(__FILE__) . '/callbacks/Sitemaps.php';
        require_once dirname(__FILE__) . '/callbacks/Social.php';
        require_once dirname(__FILE__) . '/callbacks/Analytics.php';
        require_once dirname(__FILE__) . '/callbacks/ImageSEO.php';
        require_once dirname(__FILE__) . '/callbacks/Advanced.php';
        require_once dirname(__FILE__) . '/callbacks/InstantIndexing.php';
    }

    public function pre_save_options()
    {
        add_filter('pre_update_option_rankology_instant_indexing_option_name', [$this, 'pre_rankology_instant_indexing_option_name'], 10, 2);
    }

    public function pre_rankology_instant_indexing_option_name($new_value, $old_value)
    {
        //If we are saving data from SEO, Google Search Console tab, we have to save all Indexing options!
        if (!array_key_exists('rankology_instant_indexing_bing_api_key', $new_value)) {
            $options = get_option('rankology_instant_indexing_option_name');
            $options['rankology_instant_indexing_google_api_key'] = $new_value['rankology_instant_indexing_google_api_key'];
            return $options;
        }
        return $new_value;
    }
}

if (is_admin()) {
    $my_settings_page = new rankology_options();
}
