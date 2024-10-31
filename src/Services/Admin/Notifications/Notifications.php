<?php

namespace Rankology\Services\Admin\Notifications;

defined('ABSPATH') || exit;

class Notifications {
    public function generateAllNotifications() {
        $alerts_info = 0;
        $alerts_low = 0;
        $alerts_medium = 0;
        $alerts_high = 0;

        $status = false;
        if ('1' !== rankology_get_service('NoticeOption')->getNoticeReview()) {
            $alerts_info++;
            $status = true;
        }
        $args[] = [
            'id'     => 'notice-review',
            'title'  => esc_html__('You like Rankology? Please help us by rating us 5 stars!', 'wp-rankology'),
            'desc'   => esc_html__('Support the development and improvement of the plugin by taking 15 seconds of your time to leave us a user review on the official WordPress plugins repository. Thank you!', 'wp-rankology'),
            'impact' => [
                'info' => esc_html__('Information', 'wp-rankology'),
            ],
            'link' => [
                'en'       => 'https://wordpress.org/support/view/plugin-reviews/wp-rankology?rate=5#postform',
                'title'    => esc_html__('Rate us!', 'wp-rankology'),
                'external' => true,
            ],
            'deleteable' => true,
            'status' => $status ? $status : false,
        ];

        $status = false;
        $theme                     = wp_get_theme();
        if ('bricks' == $theme->template || 'Bricks' == $theme->parent_theme) {
            $bricks_options = get_option('bricks_global_settings');
            if (!empty($bricks_options)) {

                if (empty($bricks_options['disableSeo'])) {
                    $alerts_high++;
                    $status = true;

                    $args[] = [
                        'id'     => 'notice-bricks-seo',
                        'title'  => esc_html__('Bricks theme is not correctly setup for SEO!', 'wp-rankology'),
                        'desc'   => esc_html__('You must disable "Bricks SEO meta tags" option from Bricks settings (Bricks, Settings page) to avoid any SEO issues.', 'wp-rankology'),
                        'impact' => [
                            'high' => esc_html__('High impact', 'wp-rankology'),
                        ],
                        'link' => [
                            'en'       => admin_url('admin.php?page=bricks-settings'),
                            'title'    => esc_html__('Fix this!', 'wp-rankology'),
                            'external' => false,
                        ],
                        'deleteable' => false,
                        'status' => $status ? $status : false,
                    ];
                }

                $status = false;

                if (empty($bricks_options['disableOpenGraph'])) {
                    $alerts_high++;
                    $status = true;

                    $args[] = [
                        'id'     => 'notice-bricks-og',
                        'title'  => esc_html__('Bricks theme is not correctly setup for social sharing!', 'wp-rankology'),
                        'desc'   => esc_html__('You must disable "Bricks Open Graph meta tags" option from Bricks settings (Bricks, Settings page) to avoid any social sharing issues.', 'wp-rankology'),
                        'impact' => [
                            'high' => esc_html__('High impact', 'wp-rankology'),
                        ],
                        'link' => [
                            'en'       => admin_url('admin.php?page=bricks-settings'),
                            'title'    => esc_html__('Fix this!', 'wp-rankology'),
                            'external' => false,
                        ],
                        'deleteable' => false,
                        'status' => $status ? $status : false,
                    ];
                }
            }
        }

        $status = false;
        if ('1' !== rankology_get_service('NoticeOption')->getNoticeUSM() && '1' !== rankology_get_service('AdvancedOption')->getAccessUniversalMetaboxGutenberg() ) {
            $alerts_info++;
            $status = true;
        }
        $args[] = [
            'id'     => 'notice-usm',
            'title'  => esc_html__('Enable our universal SEO metabox for the Block Editor', 'wp-rankology'),
            'desc'   => esc_html__('By default, our new SEO metabox is disabled for Gutenberg. Test it without further delay!', 'wp-rankology'),
            'impact' => [
                'info' => esc_html__('Wizard', 'wp-rankology'),
            ],
            'link' => [
                'en'       => admin_url('admin.php?page=rankology-advanced#tab=tab_rankology_advanced_appearance'),
                'title'    => esc_html__('Activate it', 'wp-rankology'),
                'external' => false,
            ],
            'deleteable' => true,
            'status' => $status ? $status : false,
        ];

        $status = false;
        if ('1' != rankology_get_service('NoticeOption')->getNoticeWizard()) {
            $alerts_info++;
            $status = true;
        }
        $args[] = [
            'id'     => 'notice-wizard',
            'title'  => esc_html__('Configure Rankology in a few minutes with our installation wizard', 'wp-rankology'),
            'desc'   => esc_html__('The best way to quickly setup Rankology on your site.', 'wp-rankology'),
            'impact' => [
                'info' => esc_html__('Wizard', 'wp-rankology'),
            ],
            'link' => [
                'en'       => admin_url('admin.php?page=rankology-setup'),
                'title'    => esc_html__('Start the wizard', 'wp-rankology'),
                'external' => true,
            ],
            'deleteable' => true,
            'status' => $status ? $status : false,
        ];

        //AMP
        if (is_plugin_active('amp/amp.php')) {
            $status = false;
            if ('1' !== rankology_get_service('NoticeOption')->getNoticeAMPAnalytics()) {
                $alerts_medium++;
                $status = true;
            }
            $args[] = [
                'id'     => 'notice-amp-analytics',
                'title'  => esc_html__('Use Google Analytics with AMP plugin', 'wp-rankology'),
                'desc'   => esc_html__('Your site is using the AMP official plugin. To track users with Google Analytics on AMP pages, please go to this settings page.', 'wp-rankology'),
                'impact' => [
                    'info' => esc_html__('Medium impact', 'wp-rankology'),
                ],
                'link' => [
                    'en'       => admin_url('admin.php?page=amp-options#analytics-options'),
                    'title'    => esc_html__('Fix this!', 'wp-rankology'),
                    'external' => false,
                ],
                'deleteable' => true,
                'status' => $status ? $status : false,
            ];
        }

        //DIVI SEO options conflict
        $theme = wp_get_theme();
        if ('Divi' == $theme->template || 'Divi' == $theme->parent_theme) {
            $divi_options = get_option('et_divi');
            if (! empty($divi_options)) {
                if (
                    (array_key_exists('divi_seo_home_title', $divi_options) && 'on' == $divi_options['divi_seo_home_title']) ||
                    (array_key_exists('divi_seo_home_description', $divi_options) && 'on' == $divi_options['divi_seo_home_description']) ||
                    (array_key_exists('divi_seo_home_keywords', $divi_options) && 'on' == $divi_options['divi_seo_home_keywords']) ||
                    (array_key_exists('divi_seo_home_canonical', $divi_options) && 'on' == $divi_options['divi_seo_home_canonical']) ||
                    (array_key_exists('divi_seo_single_title', $divi_options) && 'on' == $divi_options['divi_seo_single_title']) ||
                    (array_key_exists('divi_seo_single_description', $divi_options) && 'on' == $divi_options['divi_seo_single_description']) ||
                    (array_key_exists('divi_seo_single_keywords', $divi_options) && 'on' == $divi_options['divi_seo_single_keywords']) ||
                    (array_key_exists('divi_seo_single_canonical', $divi_options) && 'on' == $divi_options['divi_seo_single_canonical']) ||
                    (array_key_exists('divi_seo_index_canonical', $divi_options) && 'on' == $divi_options['divi_seo_index_canonical']) ||
                    (array_key_exists('divi_seo_index_description', $divi_options) && 'on' == $divi_options['divi_seo_index_description'])
                ) {
                    $alerts_high++;

                    $args[] = [
                        'id'     => 'notice-divi-seo',
                        'title'  => esc_html__('We noticed that some SEO DIVI options are enabled!', 'wp-rankology'),
                        'desc'   => esc_html__('To avoid any SEO conflicts, please disable every SEO option from <strong>DIVI theme options page, SEO tab</strong>.', 'wp-rankology'),
                        'impact' => [
                            'high' => esc_html__('High impact', 'wp-rankology'),
                        ],
                        'link' => [
                            'en'       => admin_url('admin.php?page=et_divi_options#seo-1'),
                            'title'    => esc_html__('Fix this!', 'wp-rankology'),
                            'external' => false,
                        ],
                        'deleteable' => false,
                        'status' => true,
                    ];
                }
            }
        }

        if ('1' != get_theme_support('title-tag') && true !== wp_is_block_theme()) {
            if ('1' !== rankology_get_service('NoticeOption')->getNoticeTitleTag()) {
                $alerts_high++;
                $args[] = [
                    'id'     => 'notice-title-tag',
                    'title'  => esc_html__('Your theme doesn\'t use <strong>add_theme_support(\'title-tag\');</strong>', 'wp-rankology'),
                    'desc'   => esc_html__('This error indicates that your theme uses a deprecated function to generate the title tag of your pages. Rankology will not be able to generate your custom title tags if this error is not fixed.', 'wp-rankology'),
                    'impact' => [
                        'high' => esc_html__('High impact', 'wp-rankology'),
                    ],
                    'link' => [
                        'fr'       => '',
                        'en'       => '',
                        'title'    => esc_html__('Learn more', 'wp-rankology'),
                        'external' => true,
                    ],
                    'deleteable' => false,
                    'status' => true,
                ];
            }
        }

        if (is_plugin_active('swift-performance-lite/performance.php')) {
            if (rankology_get_service('NoticeOption')->getNoticeCacheSitemap() === "1") {
                if ('1' !== rankology_get_service('NoticeOption')->getNoticeSwift()) {
                    $alerts_high++;
                    $args[] = [
                        'id'     => 'notice-swift',
                        'title'  => esc_html__('Your XML sitemap is cached!', 'wp-rankology'),
                        'desc'   => esc_html__('Swift Performance is caching your XML sitemap. You must disable this option to prevent any compatibility issue (Swift Performance > Settings > Caching, General tab).', 'wp-rankology'),
                        'impact' => [
                            'high' => esc_html__('High impact', 'wp-rankology'),
                        ],
                        'link' => [
                            'en'       => admin_url('tools.php?page=swift-performance'),
                            'title'    => esc_html__('Fix this!', 'wp-rankology'),
                            'external' => false,
                        ],
                        'deleteable' => false,
                        'status' => true,
                    ];
                }
            }
        }
        $seo_plugins = [
            'wordpress-seo/wp-seo.php'                       => 'Yoast SEO',
            'wordpress-seo-premium/wp-seo-premium.php'       => 'Yoast SEO Premium',
            'all-in-one-seo-pack/all_in_one_seo_pack.php'    => 'All In One SEO',
            'autodescription/autodescription.php'            => 'The SEO Framework',
            'squirrly-seo/squirrly.php'                      => 'Squirrly SEO',
            'seo-by-rank-math/rank-math.php'                 => 'Rank Math',
            'seo-ultimate/seo-ultimate.php'                  => 'SEO Ultimate',
            'wp-meta-seo/wp-meta-seo.php'                    => 'WP Meta SEO',
            'premium-seo-pack/plugin.php'                    => 'Premium SEO Pack',
            'wpseo/wpseo.php'                                => 'wpSEO',
            'platinum-seo-pack/platinum-seo-pack.php'        => 'Platinum SEO Pack',
            'smartcrawl-seo/wpmu-dev-seo.php'                => 'SmartCrawl',
            'seo-pressor/seo-pressor.php'                    => 'Rankologyor',
            'slim-seo/slim-seo.php'                          => 'Slim SEO'
        ];

        foreach ($seo_plugins as $key => $value) {
            if (is_plugin_active($key)) {
                $alerts_high++;
                $args[] = [
                    'id' => 'notice-seo-plugins',
                    /* translators: %s name of a SEO plugin (e.g. Yoast SEO) */
                    'title'  => sprintf(wp_kses(__('We noticed that you use <strong>%s</strong> plugin.', 'wp-rankology'), array('strong' => array(), 'span' => array('class' => array()), 'a' => array('href' => array()))), $value),
                    'desc'   => esc_html__('Do you want to migrate all your metadata to Rankology? Do not use multiple SEO plugins at once to avoid conflicts!', 'wp-rankology'),
                    'impact' => [
                        'high' => esc_html__('High impact', 'wp-rankology'),
                    ],
                    'link' => [
                        'en'       => admin_url('admin.php?page=rankology-import-export'),
                        'title'    => esc_html__('Migrate!', 'wp-rankology'),
                        'external' => false,
                    ],
                    'deleteable' => false,
                    'status' => true,
                ];
            }
        }
        $indexing_plugins = [
            'indexnow/indexnow-url-submission.php'                       => 'IndexNow',
            'bing-webmaster-tools/bing-url-submission.php'               => 'Bing Webmaster Url Submission',
            'fast-indexing-api/instant-indexing.php'                     => 'Instant Indexing',
        ];

        foreach ($indexing_plugins as $key => $value) {
            if (is_plugin_active($key)) {
                $alerts_high++;
                $args[] = [
                    'id' => 'notice-indexing-plugins',
                    /* translators: %s name of a WP plugin (e.g. IndexNow) */
                    'title'  => sprintf(wp_kses(__('We noticed that you use <strong>%s</strong> plugin.', 'wp-rankology'), array('strong' => array(), 'span' => array('class' => array()), 'a' => array('href' => array()))), $value),
                    'desc'   => esc_html__('To prevent any conflicts with our Indexing feature, please disable it.', 'wp-rankology'),
                    'impact' => [
                        'high' => esc_html__('High impact', 'wp-rankology'),
                    ],
                    'link' => [
                        'en'       => admin_url('plugins.php'),
                        'title'    => esc_html__('Fix this!', 'wp-rankology'),
                        'external' => false,
                    ],
                    'deleteable' => false,
                    'status' => true,
                ];
            }
        }

        //Enfold theme
        $avia_options_enfold       = get_option('avia_options_enfold');
        $avia_options_enfold_child = get_option('avia_options_enfold_child');
        $theme                     = wp_get_theme();
        $status = false;
        if ('enfold' == $theme->template || 'enfold' == $theme->parent_theme) {
            if ('plugin' != $avia_options_enfold['avia']['seo_robots'] || 'plugin' != $avia_options_enfold_child['avia']['seo_robots']) {
                if ('1' !== rankology_get_service('NoticeOption')->getNoticeEnfold()) {
                    $alerts_high++;
                    $status = true;
                }
                $args[] = [
                    'id'     => 'notice-enfold',
                    'title'  => esc_html__('Enfold theme is not correctly setup for SEO!', 'wp-rankology'),
                    'desc'   => esc_html__('You must disable "Meta tag robots" option from Enfold settings (SEO Support tab) to avoid any SEO issues.', 'wp-rankology'),
                    'impact' => [
                        'low' => esc_html__('High impact', 'wp-rankology'),
                    ],
                    'link' => [
                        'en'       => admin_url('admin.php?avia_welcome=true&page=avia'),
                        'title'    => esc_html__('Fix this!', 'wp-rankology'),
                        'external' => false,
                    ],
                    'deleteable' => true,
                    'status' => $status ? $status : false,
                ];
            }
        }

        if (rankology_get_empty_templates('cpt', 'title')) {
            $alerts_high++;
            $args[] = [
                'id'     => 'notice-cpt-empty-title',
                'title'  => esc_html__('Global meta title missing for several custom post types!', 'wp-rankology'),
                'desc'   => rankology_get_empty_templates('cpt', 'title', false),
                'impact' => [
                    'high' => esc_html__('High impact', 'wp-rankology'),
                ],
                'link' => [
                    'en'       => admin_url('admin.php?page=rankology-titles#tab=tab_rankology_titles_single'),
                    'title'    => esc_html__('Fix this!', 'wp-rankology'),
                    'external' => false,
                ],
                'deleteable' => false,
                'wrap'       => false,
                'status' => true,
            ];
        }

        if (rankology_get_empty_templates('cpt', 'description')) {
            $alerts_high++;
            $args[] = [
                'id'     => 'notice-cpt-empty-desc',
                'title'  => esc_html__('Global meta description missing for several custom post types!', 'wp-rankology'),
                'desc'   => rankology_get_empty_templates('cpt', 'description', false),
                'impact' => [
                    'high' => esc_html__('High impact', 'wp-rankology'),
                ],
                'link' => [
                    'en'       => admin_url('admin.php?page=rankology-titles#tab=tab_rankology_titles_single'),
                    'title'    => esc_html__('Fix this!', 'wp-rankology'),
                    'external' => false,
                ],
                'deleteable' => false,
                'wrap'       => false,
                'status' => true,
            ];
        }

        if (rankology_get_empty_templates('tax', 'title')) {
            $alerts_high++;
            $args[] = [
                'id'     => 'notice-tax-empty-title',
                'title'  => esc_html__('Global meta title missing for several taxonomies!', 'wp-rankology'),
                'desc'   => rankology_get_empty_templates('tax', 'title', false),
                'impact' => [
                    'high' => esc_html__('High impact', 'wp-rankology'),
                ],
                'link' => [
                    'en'       => admin_url('admin.php?page=rankology-titles#tab=tab_rankology_titles_tax'),
                    'title'    => esc_html__('Fix this!', 'wp-rankology'),
                    'external' => false,
                ],
                'deleteable' => false,
                'wrap'       => false,
                'status' => true,
            ];
        }

        $status = false;
        if (rankology_get_empty_templates('tax', 'description')) {
            $alerts_high++;
            $args[] = [
                'id'     => 'notice-tax-empty-templates',
                'title'  => esc_html__('Global meta description missing for several taxonomies!', 'wp-rankology'),
                'desc'   => rankology_get_empty_templates('tax', 'description', false),
                'impact' => [
                    'high' => esc_html__('High impact', 'wp-rankology'),
                ],
                'link' => [
                    'en'       => admin_url('admin.php?page=rankology-titles#tab=tab_rankology_titles_tax'),
                    'title'    => esc_html__('Fix this!', 'wp-rankology'),
                    'external' => false,
                ],
                'deleteable' => false,
                'wrap'       => false,
                'status' => true,
            ];
        }

        if (! is_ssl()) {
            $status = false;
            if ('1' !== rankology_get_service('NoticeOption')->getNoticeSSL()) {
                $alerts_medium++;
                $status = true;
            }
            $args[] = [
                'id'     => 'notice-ssl',
                'title'  => esc_html__('Your site doesn\'t use an SSL certificate!', 'wp-rankology'),
                'desc'   => esc_html__('Https is considered by Google as a positive signal for the ranking of your site. It also reassures your visitors for data security, and improves trust.', 'wp-rankology') . '</a>',
                'impact' => [
                    'low' => esc_html__('Medium impact', 'wp-rankology'),
                ],
                'link' => [
                    'en'       => 'https://webmasters.googleblog.com/2014/08/https-as-ranking-signal.html',
                    'title'    => esc_html__('Learn more', 'wp-rankology'),
                    'external' => true,
                ],
                'deleteable' => true,
                'status' => $status ? $status : false,
            ];
        }

        if (function_exists('extension_loaded') && ! extension_loaded('dom')) {
            $alerts_high++;
            $args[] = [
                'id'     => 'notice-dom',
                'title'  => esc_html__('PHP module "DOM" is missing on your server.', 'wp-rankology'),
                'desc'   => esc_html__('This PHP module, installed by default with PHP, is required by many plugins including Rankology. Please contact your host as soon as possible to solve this.', 'wp-rankology'),
                'impact' => [
                    'high' => esc_html__('High impact', 'wp-rankology'),
                ],
                'link' => [
                    'fr'       => '',
                    'en'       => '',
                    'title'    => esc_html__('Learn more', 'wp-rankology'),
                    'external' => true,
                ],
                'deleteable' => false,
                'status' => true,
            ];
        }

        if (function_exists('extension_loaded') && ! extension_loaded('mbstring')) {
            $alerts_high++;
            $args[] = [
                'id'     => 'notice-mbstring',
                'title'  => esc_html__('PHP module "mbstring" is missing on your server.', 'wp-rankology'),
                'desc'   => esc_html__('This PHP module, installed by default with PHP, is required by many plugins including Rankology. Please contact your host as soon as possible to solve this.', 'wp-rankology'),
                'impact' => [
                    'high' => esc_html__('High impact', 'wp-rankology'),
                ],
                'link' => [
                    'fr'       => '',
                    'en'       => '',
                    'title'    => esc_html__('Learn more', 'wp-rankology'),
                    'external' => true,
                ],
                'deleteable' => false,
                'status' => true,
            ];
        }

        $status = false;
        if ('1' !== rankology_get_service('NoticeOption')->getNoticeNoIndex()) {
            if ('1' === rankology_get_service('TitleOption')->getTitleNoIndex() || '1' != get_option('blog_public')) {
                $alerts_high++;
                $status = true;

                $link = admin_url('options-reading.php');
                if (rankology_get_service('TitleOption')->getTitleNoIndex() ==='1') {
                    $link = admin_url('admin.php?page=rankology-titles#tab=tab_rankology_titles_advanced');
                }

                $args[] = [
                    'id'     => 'notice-noindex',
                    'title'  => esc_html__('Your site is not visible to Search Engines!', 'wp-rankology'),
                    'desc'   => esc_html__('You have activated the blocking of the indexing of your site. If your site is under development, this is probably normal. Otherwise, check your settings. Delete this notification using the cross on the right if you are not concerned.', 'wp-rankology'),
                    'impact' => [
                        'high' => esc_html__('High impact', 'wp-rankology'),
                    ],
                    'link' => [
                        'en'       => $link,
                        'title'    => esc_html__('Fix this!', 'wp-rankology'),
                        'external' => false,
                    ],
                    'deleteable' => false,
                    'status' => $status ? $status : false,
                ];
            }
        }

        if ('' == get_option('blogname')) {
            $alerts_high++;
            $args[] = [
                'id'     => 'notice-title-empty',
                'title'  => esc_html__('Your site title is empty!', 'wp-rankology'),
                'desc'   => esc_html__('Your Site Title is used by WordPress, your theme and your plugins including Rankology. It is an essential component in the generation of title tags, but not only. Enter one!', 'wp-rankology'),
                'impact' => [
                    'high' => esc_html__('High impact', 'wp-rankology'),
                ],
                'link' => [
                    'en'       => admin_url('options-general.php'),
                    'title'    => esc_html__('Fix this!', 'wp-rankology'),
                    'external' => false,
                ],
                'deleteable' => false,
                'status' => true,
            ];
        }

        if ('' == get_option('permalink_structure')) {
            $alerts_high++;

            $args[] = [
                'id'     => 'notice-permalinks',
                'title'  => esc_html__('Your permalinks are not SEO Friendly! Enable pretty permalinks to fix this.', 'wp-rankology'),
                'desc'   => esc_html__('Why is this important? Showing only the summary of each article significantly reduces the theft of your content by third party sites. Not to mention, the increase in your traffic, your advertising revenue, conversions...', 'wp-rankology'),
                'impact' => [
                    'high' => esc_html__('High impact', 'wp-rankology'),
                ],
                'link' => [
                    'en'       => admin_url('options-permalink.php'),
                    'title'    => esc_html__('Fix this!', 'wp-rankology'),
                    'external' => false,
                ],
                'deleteable' => false,
                'status' => true,
            ];
        }

        $status = false;
        if ('0' == get_option('rss_use_excerpt')) {
            if ('1' !== rankology_get_service('NoticeOption')->getNoticeRSSUseExcerpt()) {
                $alerts_medium++;
                $status = true;
            }
            $args[] = [
                'id'     => 'notice-rss-use-excerpt',
                'title'  => esc_html__('Your RSS feed shows full text!', 'wp-rankology'),
                'desc'   => esc_html__('Why is this important? Showing only the summary of each article significantly reduces the theft of your content by third party sites. Not to mention, the increase in your traffic, your advertising revenue, conversions...', 'wp-rankology'),
                'impact' => [
                    'medium' => esc_html__('Medium impact', 'wp-rankology'),
                ],
                'link' => [
                    'en'       => admin_url('options-reading.php'),
                    'title'    => esc_html__('Fix this!', 'wp-rankology'),
                    'external' => false,
                ],
                'deleteable' => true,
                'status' => $status ? $status : false,
            ];
        }

        $status = false;
        if ('' === rankology_get_service('GoogleAnalyticsOption')->getGA4() && '1' === rankology_get_service('GoogleAnalyticsOption')->getEnableOption()) {
            if ('1' !== rankology_get_service('NoticeOption')->getNoticeGAIds()) {
                $alerts_medium++;
                $status = true;
            }
            $args[] = [
                'id'     => 'notice-ga-ids',
                'title'  => esc_html__('You have activated Google Analytics tracking without adding identifiers!', 'wp-rankology'),
                'desc'   => esc_html__('Google Analytics will not track your visitors until you finish the configuration.', 'wp-rankology'),
                'impact' => [
                    'medium' => esc_html__('Medium impact', 'wp-rankology'),
                ],
                'link' => [
                    'en'       => admin_url('admin.php?page=rankology-google-analytics'),
                    'title'    => esc_html__('Fix this!', 'wp-rankology'),
                    'external' => false,
                ],
                'deleteable' => true,
                'status' => $status ? $status : false,
            ];
        }

        $status = false;
        if ('1' == get_option('page_comments')) {
            if ('1' !== rankology_get_service('NoticeOption')->getNoticeDivideComments()) {
                $alerts_high++;
                $status = true;
            }
            $args[] = [
                'id'     => 'notice-divide-comments',
                'title'  => esc_html__('Break comments into pages is ON!', 'wp-rankology'),
                'desc'   => esc_html__('Enabling this option will create duplicate content for each article beyond x comments. This can have a disastrous effect by creating a large number of poor quality pages, and slowing the Google bot unnecessarily, so your ranking in search results.', 'wp-rankology'),
                'impact' => [
                    'high' => esc_html__('High impact', 'wp-rankology'),
                ],
                'link' => [
                    'en'       => admin_url('options-discussion.php'),
                    'title'    => esc_html__('Disable this!', 'wp-rankology'),
                    'external' => false,
                ],
                'deleteable' => true,
                'status' => $status ? $status : false,
            ];
        }

        $status = false;
        if (get_option('posts_per_page') < '16') {
            if ('1' !== rankology_get_service('NoticeOption')->getNoticePostsNumber()) {
                $alerts_medium++;
                $status = true;
            }
            $args[] = [
                'id'     => 'notice-posts-number',
                'title'  => esc_html__('Display more posts per page on homepage and archives', 'wp-rankology'),
                'desc'   => esc_html__('To reduce the number pages search engines have to crawl to find all your articles, it is recommended displaying more posts per page. This should not be a problem for your users. Using mobile, we prefer to scroll down rather than clicking on next page links.', 'wp-rankology'),
                'impact' => [
                    'medium' => esc_html__('Medium impact', 'wp-rankology'),
                ],
                'link' => [
                    'en'       => admin_url('options-reading.php'),
                    'title'    => esc_html__('Fix this!', 'wp-rankology'),
                    'external' => false,
                ],
                'deleteable' => true,
                'status' => $status ? $status : false,
            ];
        }

        if ('1' !== rankology_get_service('SitemapOption')->isEnabled()) {
            $alerts_medium++;
            $args[] = [
                'id'     => 'notice-xml-sitemaps',
                'title'  => esc_html__('You don\'t have an XML Sitemap!', 'wp-rankology'),
                'desc'   => esc_html__('XML Sitemaps are useful to facilitate the crawling of your content by search engine robots. Indirectly, this can benefit your ranking by reducing the crawl bugdet.', 'wp-rankology'),
                'impact' => [
                    'medium' => esc_html__('Medium impact', 'wp-rankology'),
                ],
                'link' => [
                    'en'       => admin_url('admin.php?page=rankology-xml-sitemap'),
                    'title'    => esc_html__('Fix this!', 'wp-rankology'),
                    'external' => false,
                ],
                'deleteable' => false,
                'status' => true,
            ];
        }

        $status = false;
        if ('1' !== rankology_get_service('NoticeOption')->getNoticeGoogleBusiness()) {
            $alerts_high++;
            $status = true;
        }
        $args[] = [
            'id'     => 'notice-google-business',
            'title'  => esc_html__('Do you have a Google My Business page? It\'s free!', 'wp-rankology'),
            'desc'   => esc_html__('Local Business websites should have a My Business page to improve visibility in search results. Click on the cross on the right to delete this notification if you are not concerned.', 'wp-rankology'),
            'impact' => [
                'high' => esc_html__('High impact', 'wp-rankology'),
            ],
            'link' => [
                'en'       => 'https://www.google.com/business/go/',
                'title'    => esc_html__('Create your page now!', 'wp-rankology'),
                'external' => true,
            ],
            'deleteable' => true,
            'status' => $status ? $status : false,
        ];

        $status = false;
        if ('1' !== rankology_get_service('NoticeOption')->getNoticeSearchConsole()) {
            $alerts_high++;
            $status = true;
        }
        if (null === rankology_get_service('AdvancedOption')->getAdvancedGoogleVerification() || '' === rankology_get_service('AdvancedOption')->getAdvancedGoogleVerification()) {
            $args[] = [
                'id'     => 'notice-search-console',
                'title'  => esc_html__('Add your site to Google. It\'s free!', 'wp-rankology'),
                'desc'   => esc_html__('Is your brand new site online? So reference it as quickly as possible on Google to get your first visitors via Google Search Console. Already the case? Dismiss this alert.', 'wp-rankology'),
                'impact' => [
                    'high' => esc_html__('High impact', 'wp-rankology'),
                ],
                'link' => [
                    'en'       => 'https://www.google.com/webmasters/tools/home',
                    'title'    => esc_html__('Add your site to Search Console!', 'wp-rankology'),
                    'external' => true,
                ],
                'deleteable' => true,
                'status' => $status ? $status : false,
            ];
        }

        $args['impact']['high'] = $alerts_high;
        $args['impact']['medium'] = $alerts_medium;
        $args['impact']['low'] = $alerts_low;
        $args['impact']['info'] = $alerts_info;

        $args = apply_filters( 'rankology_notifications_center_item', $args, $alerts_info, $alerts_low, $alerts_medium, $alerts_high );

        return $args;
    }

    public function getSeverityNotification($impact = 'all')
    {
        $all = $this->generateAllNotifications();

        $sum = 0;
        $severityLevels = ['high', 'medium', 'low', 'info'];

        foreach ($severityLevels as $level) {
            if ($impact === 'all' || $impact === $level) {
                if (!empty($all['impact'][$level])) {
                    $sum += $all['impact'][$level];
                }
            }
        }

        if (isset($sum) && isset($all)) {
            return ['total' => $sum, 'severity' => $all['impact']];
        } else {
            return;
        }
    }

    /**
     * Generate notification (Notifications Center).
     *
     * 
     *
     * @param array $args
     *
     * @return string HTML notification
     */
    public function renderNotification($args) {
        if ( empty($args)) {
            return;
        }
        $id             = isset($args['id']) ? $args['id'] : null;
        $title          = isset($args['title']) ? $args['title'] : null;
        $desc           = isset($args['desc']) ? $args['desc'] : null;
        $impact         = isset($args['impact']) ? $args['impact'] : [];
        $link           = isset($args['link']) ? $args['link'] : null;
        $deleteable     = isset($args['deleteable']) ? $args['deleteable'] : null;
        $wrap           = isset($args['wrap']) ? $args['wrap'] : null;
        $status         = isset($args['status']) ? $args['status'] : false;

        $class = '';
        if ( ! empty($impact)) {
            $class .= ' impact';
            $class .= ' ' . key($impact);
        }

        if (true === $deleteable) {
            $class .= ' deleteable';
        }

        $html = '<div id="' . $id . '-alert" class="rankology-alert rankology-card">';

        if ( ! empty($impact)) {
            $html .= '<span class="rankology-impact rankology-impact-' . rankology_array_key_first($impact) . '"></span>';
            $html .= '<span class="screen-reader-text">' . reset($impact) . '</span>';
        }

        $html .= '<h3 class="rankology-impact-title">' . $title . '</h3>';

        if (false === $wrap) {
            $html .= $desc;
        } else {
            $html .= '<p>' . $desc . '</p>';
        }

        $href = '';
        if (function_exists('rankology_get_locale') && 'fr' == rankology_get_locale() && isset($link['fr'])) {
            $href = ' href="' . $link['fr'] . '"';
        } elseif (isset($link['en'])) {
            $href = ' href="' . $link['en'] . '"';
        }

        $target = '';
        if (isset($link['external']) && true === $link['external']) {
            $target = ' target="_blank"';
        }

        if ( ! empty($link) || true === $deleteable) {
            $html .= '<p class="rankology-alert-actions">';

            if ( ! empty($link)) {
                $html .= '<a class="btn btnSecondary"' . $href . $target . '>' . $link['title'] . '</a>';
            }
            if (true === $deleteable && $status === true) {
                $html .= '<button id="' . $id . '" name="notice-title-tag" type="button" class="btn btnLink" data-notice="' . $id . '">' . esc_html__('Dismiss', 'wp-rankology') . '</button>';
            }

            $html .= '</p>';
        }
        $html .= '</div>';

        return rankology_common_esc_str($html);
    }
}
