<?php

namespace Rankology\Helpers;

if ( ! defined('ABSPATH')) {
    exit;
}

abstract class ContentAnalysis {
    public static function getData() {
        $data = [
            'all_canonical'=> [
                'title'  => esc_html__('Canonical URL', 'wp-rankology'),
                'impact' => 'good',
                'desc'   => null,
            ],
            'schemas'=> [
                'title'  => esc_html__('Structured data types', 'wp-rankology'),
                'impact' => 'good',
                'desc'   => null,
            ],
            'old_post'=> [
                'title'  => esc_html__('Last modified date', 'wp-rankology'),
                'impact' => 'good',
                'desc'   => null,
            ],
            'words_counter'=> [
                'title'  => esc_html__('Words counter', 'wp-rankology'),
                'impact' => 'good',
                'desc'   => null,
            ],
            'keywords_density'=> [
                'title'  => esc_html__('Keywords density', 'wp-rankology'),
                'impact' => null,
                'desc'   => null,
            ],
            'keywords_permalink'=> [
                'title'  => esc_html__('Keywords in permalink', 'wp-rankology'),
                'impact' => null,
                'desc'   => null,
            ],
            'headings'=> [
                'title'  => esc_html__('Headings', 'wp-rankology'),
                'impact' => 'good',
                'desc'   => null,
            ],
            'meta_title'=> [
                'title'  => esc_html__('Meta title', 'wp-rankology'),
                'impact' => null,
                'desc'   => null,
            ],
            'meta_desc'=> [
                'title'  => esc_html__('Meta description', 'wp-rankology'),
                'impact' => null,
                'desc'   => null,
            ],
            'social'=> [
                'title'  => esc_html__('Social meta tags', 'wp-rankology'),
                'impact' => 'good',
                'desc'   => null,
            ],
            'robots'=> [
                'title'  => esc_html__('Meta robots', 'wp-rankology'),
                'impact' => 'good',
                'desc'   => null,
            ],
            'img_alt'=> [
                'title'  => esc_html__('Alternative texts of images', 'wp-rankology'),
                'impact' => 'good',
                'desc'   => null,
            ],
            'nofollow_links'=> [
                'title'  => esc_html__('NoFollow Links', 'wp-rankology'),
                'impact' => 'good',
                'desc'   => null,
            ],
            'outbound_links'=> [
                'title'  => esc_html__('Outbound Links', 'wp-rankology'),
                'impact' => 'good',
                'desc'   => null,
            ],
            'internal_links'=> [
                'title'  => esc_html__('Internal Links', 'wp-rankology'),
                'impact' => 'good',
                'desc'   => null,
            ],
        ];

        return apply_filters('rankology_get_content_analysis_data', $data);
    }
}
