<?php

namespace Rankology\Helpers\Metas;

if ( ! defined('ABSPATH')) {
    exit;
}

abstract class RobotSettings {
    protected static function getRobotPrimaryCats($id, $postType) {
        $cats = get_categories();

        if ('product' == $postType) {
            $cats = get_the_terms($id, 'product_cat');
        }

        $default = [
            'term_id' => 'none',
            'name'    => esc_html__('None (will disable this feature)', 'wp-rankology'),
        ];

        array_unshift($cats, $default);

        return $cats;
    }

    /**
     * 
     *
     * @param int|null $id
     *
     * @return array[]
     *
     *    key: string post meta
     *    use_default: default value need to use
     *    default: default value
     *    label: string label
     *    placeholder
     */
    public static function getMetaKeys($id = null) {
        $titleOptionService = rankology_get_service('TitleOption');

        $postType = get_post_type($id);

        $data = apply_filters('rankology_api_meta_robot_settings', [
            [
                'key'         => '_rankology_robots_index',
                'type'        => 'checkbox',
                'use_default' => $titleOptionService->getSingleCptNoIndex($id) || $titleOptionService->getTitleNoIndex() || true === post_password_required($id),
                'default'     => 'yes',
                'label'       => esc_html__('Do not display this page in search engine results / XML - HTML sitemaps (noindex)', 'wp-rankology'),
                'visible'     => true,
            ],
            [
                'key'         => '_rankology_robots_follow',
                'type'        => 'checkbox',
                'use_default' => $titleOptionService->getSingleCptNoFollow($id) || $titleOptionService->getTitleNoFollow(),
                'default'     => 'yes',
                'label'       => esc_html__('Do not follow links for this page (nofollow)', 'wp-rankology'),
                'visible'     => true,
            ],
            [
                'key'         => '_rankology_robots_archive',
                'type'        => 'checkbox',
                'use_default' => $titleOptionService->getTitleNoArchive(),
                'default'     => 'yes',
                'label'       => esc_html__('Do not display a "Cached" link in the Google search results (noarchive)', 'wp-rankology'),
                'visible'     => true,
            ],
            [
                'key'         => '_rankology_robots_snippet',
                'type'        => 'checkbox',
                'use_default' => $titleOptionService->getTitleNoSnippet(),
                'default'     => 'yes',
                'label'       => esc_html__('Do not display a description in search results for this page (nosnippet)', 'wp-rankology'),
                'visible'     => true,
            ],
            [
                'key'         => '_rankology_robots_imageindex',
                'type'        => 'checkbox',
                'use_default' => $titleOptionService->getTitleNoImageIndex(),
                'default'     => 'yes',
                'label'       => esc_html__('Do not index images for this page (noimageindex)', 'wp-rankology'),
                'visible'     => true,
            ],
            [
                'key'         => '_rankology_robots_canonical',
                'type'        => 'input',
                'use_default' => '',
                'placeholder' => sprintf('%s %s', esc_html__('Default value: ', 'wp-rankology'), urldecode(get_permalink($id))),
                'default'     => '',
                'label'       => esc_html__('Canonical URL', 'wp-rankology'),
                'visible'     => true,
            ],
            [
                'key'         => '_rankology_robots_primary_cat',
                'type'        => 'select',
                'use_default' => '',
                'placeholder' => '',
                'default'     => '',
                'label'       => esc_html__('Select a primary category', 'wp-rankology'),
                'description' => esc_html__('Set the category that gets used in the %category% permalink and in our breadcrumbs if you have multiple categories.', 'wp-rankology'),
                'options'     => self::getRobotPrimaryCats($id, $postType),
                'visible'     => ('post' === $postType || 'product' === $postType),
            ],
        ], $id);

        return $data;
    }
}
