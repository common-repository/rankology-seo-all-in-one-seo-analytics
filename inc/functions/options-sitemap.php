<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

//XML/HTML Sitemap
//=================================================================================================
if ('1' === rankology_get_service('SitemapOption')->getHtmlEnable()) {
    function rankology_xml_sitemap_html_display()
    {
        if ('' !== rankology_get_service('SitemapOption')->getHtmlMapping()) {
            if (is_page(explode(',', rankology_get_service('SitemapOption')->getHtmlMapping()))) {
                add_filter('the_content', 'rankology_xml_sitemap_html_hook');
            }
        }
    }
    add_action('wp', 'rankology_xml_sitemap_html_display');

    function rankology_xml_sitemap_html_hook($html)
    {
        // Attributes
        $atts = shortcode_atts(
            [
                'cpt' => '',
            ],
            $html,
            '[rankology_html_sitemap]'
        );

        //Exclude IDs
        if ('' !== rankology_get_service('SitemapOption')->getHtmlExclude()) {
            $rankology_xml_sitemap_html_exclude_option = rankology_get_service('SitemapOption')->getHtmlExclude();
        } else {
            $rankology_xml_sitemap_html_exclude_option = '';
        }

        //Order
        if ('' !== rankology_get_service('SitemapOption')->getHtmlOrder()) {
            $rankology_xml_sitemap_html_order_option = rankology_get_service('SitemapOption')->getHtmlOrder();
        } else {
            $rankology_xml_sitemap_html_order_option = '';
        }

        //Orderby
        if ('' !== rankology_get_service('SitemapOption')->getHtmlOrderBy()) {
            $rankology_xml_sitemap_html_orderby_option = rankology_get_service('SitemapOption')->getHtmlOrderBy();
        } else {
            $rankology_xml_sitemap_html_orderby_option = '';
        }

        $html = '';

        //CPT
        if (!empty(rankology_get_service('SitemapOption')->getPostTypesList())) {
            $html .= '<div class="wrap-html-sitemap rkseo-html-sitemap">';

            $rankology_xml_sitemap_post_types_list_option = rankology_get_service('SitemapOption')->getPostTypesList();

            if (isset($rankology_xml_sitemap_post_types_list_option['page'])) {
                $rankology_xml_sitemap_post_types_list_option = ['page' => $rankology_xml_sitemap_post_types_list_option['page']] + $rankology_xml_sitemap_post_types_list_option; //Display page first
            }

            if (!empty($atts['cpt'])) {
                unset($rankology_xml_sitemap_post_types_list_option);

                $cpt = explode(',', $atts['cpt']);

                foreach ($cpt as $key => $value) {
                    $rankology_xml_sitemap_post_types_list_option[$value] = ['include' => '1'];
                }
            }

            $rankology_xml_sitemap_post_types_list_option = apply_filters('rankology_sitemaps_html_cpt', $rankology_xml_sitemap_post_types_list_option);

            $display_archive = '';
            foreach ($rankology_xml_sitemap_post_types_list_option as $cpt_key => $cpt_value) {
                if ('1' !== rankology_get_service('SitemapOption')->getHtmlArchiveLinks()) {
                    $display_archive = false;
                }
                $display_archive = apply_filters('rankology_sitemaps_html_remove_archive', $display_archive, $cpt_key);

                if (!empty($cpt_value)) {
                    $html .= '<div class="rkseo-wrap-cpt">';
                }
                $obj = get_post_type_object($cpt_key);

                if ($obj) {
                    $cpt_name = $obj->labels->name;
                    $cpt_name = apply_filters('rankology_sitemaps_html_cpt_name', $cpt_name, $obj->name);

                    $html .= '<h2 class="rkseo-cpt-name">' . $cpt_name . '</h2>';
                }
                foreach ($cpt_value as $_cpt_key => $_cpt_value) {
                    if ('1' == $_cpt_value) {
                        $args = [
                            'posts_per_page'   => 1000,
                            'order'            => $rankology_xml_sitemap_html_order_option,
                            'orderby'          => $rankology_xml_sitemap_html_orderby_option,
                            'post_type'        => $cpt_key,
                            'post_status'      => 'publish',
                            'meta_query'       => [['key' => '_rankology_robots_index', 'value' => 'yes', 'compare' => 'NOT EXISTS']],
                            'fields'           => 'ids',
                            'exclude'          => $rankology_xml_sitemap_html_exclude_option,
                            'suppress_filters' => false,
                            'no_found_rows'    => true,
                            'nopaging'         => true,
                        ];
                        if ('post' === $cpt_key || 'product' === $cpt_key) {
                            if (get_post_type_archive_link($cpt_key) && 0 != get_option('page_for_posts')) {
                                if (false === $display_archive) {
                                    $html .= '<ul>';
                                    $html .= '<li><a href="' . get_post_type_archive_link($cpt_key) . '">' . $obj->labels->name . '</a></li>';
                                    $html .= '</ul>';
                                }
                            }

                            $args_cat_query = [
                                'orderby'             => 'name',
                                'order'                  => 'ASC',
                                'meta_query'       => [['key' => '_rankology_robots_index', 'value' => 'yes', 'compare' => 'NOT EXISTS']],
                                'exclude'          => $rankology_xml_sitemap_html_exclude_option,
                                'suppress_filters' => false,
                            ];
                            if ('post' === $cpt_key) {
                                $args_cat_query = apply_filters('rankology_sitemaps_html_cat_query', $args_cat_query);

                                $cats = get_categories($args_cat_query);
                            } elseif ('product' === $cpt_key) {
                                $args_cat_query = apply_filters('rankology_sitemaps_html_product_cat_query', $args_cat_query);

                                $args_cat_query = array(
                                    'taxonomy'   => 'product_cat',
                                    'hide_empty' => false,
                                );

                                $cats = get_terms($args_cat_query);
                            }

                            if (!empty($cats)) {
                                $html .= '<div class="rkseo-wrap-cats">';

                                foreach ($cats as $cat) {
                                    if (!is_wp_error($cat) && is_object($cat)) {
                                        $html .= '<div class="rkseo-wrap-cat">';
                                        $html .= '<h3 class="rkseo-cat-name"><a href="' . get_term_link($cat->term_id) . '">' . $cat->name . '</a></h3>';

                                        if ('post' === $cpt_key) {
                                            unset($args['cat']);
                                            $args['cat'][] = $cat->term_id;
                                        } elseif ('product' === $cpt_key) {
                                            unset($args['tax_query']);
                                            $args['tax_query'] = [[
                                                'taxonomy' => 'product_cat',
                                                'field'    => 'term_id',
                                                'terms'    => $cat->term_id,
                                            ]];
                                        }

                                        require dirname(__FILE__) . '/sitemap/template-html-sitemap.php';

                                        $html .= '</div>';
                                    }
                                }

                                $html .= '</div>';
                            }
                        } else {
                            require dirname(__FILE__) . '/sitemap/template-html-sitemap.php';
                        }
                    }
                }
                if (!empty($cpt_value)) {
                    $html .= '</div>';
                }
            }
            $html .= '</div>';
        }

        return rankology_common_esc_str($html);
    }
    add_shortcode('rankology_html_sitemap', 'rankology_xml_sitemap_html_hook');
}
