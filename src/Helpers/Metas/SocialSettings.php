<?php

namespace Rankology\Helpers\Metas;

if ( ! defined('ABSPATH')) {
    exit;
}

abstract class SocialSettings {
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
        $data = apply_filters('rankology_api_meta_social_settings', [
            [
                'key'         => '_rankology_social_fb_title',
                'type'        => 'input',
                'placeholder' => esc_html__('Enter your Facebook title', 'wp-rankology'),
                'use_default' => '',
                'default'     => '',
                'label'       => esc_html__('Facebook Title', 'wp-rankology'),
                'visible'     => true,
            ],
            [
                'key'         => '_rankology_social_fb_desc',
                'type'        => 'textarea',
                'placeholder' => esc_html__('Enter your Facebook description', 'wp-rankology'),
                'use_default' => '',
                'default'     => '',
                'label'       => esc_html__('Facebook description', 'wp-rankology'),
                'visible'     => true,
            ],
            [
                'key'                => '_rankology_social_fb_img',
                'type'               => 'upload',
                'placeholder'        => esc_html__('Select your default thumbnail', 'wp-rankology'),
                'use_default'        => '',
                'default'            => '',
                'label'              => esc_html__('Facebook thumbnail', 'wp-rankology'),
                'visible'            => true,
                'description'        => esc_html__('Minimum size: 200x200px, ideal ratio 1.91:1, 8Mb max. (e.g. 1640x856px or 3280x1712px for retina screens)', 'wp-rankology'),
            ],
            [
                'key'                => '_rankology_social_fb_img_attachment_id',
                'type'               => 'hidden',
            ],
            [
                'key'                => '_rankology_social_fb_img_width',
                'type'               => 'hidden',
            ],
            [
                'key'                => '_rankology_social_fb_img_height',
                'type'               => 'hidden',
            ],
            [
                'key'         => '_rankology_social_twitter_title',
                'type'        => 'input',
                'placeholder' => esc_html__('Enter your Twitter title', 'wp-rankology'),
                'use_default' => '',
                'default'     => '',
                'label'       => esc_html__('Twitter Title', 'wp-rankology'),
                'visible'     => true,
            ],
            [
                'key'         => '_rankology_social_twitter_desc',
                'type'        => 'textarea',
                'placeholder' => esc_html__('Enter your Twitter description', 'wp-rankology'),
                'use_default' => '',
                'default'     => '',
                'label'       => esc_html__('Twitter description', 'wp-rankology'),
                'visible'     => true,
            ],
            [
                'key'                => '_rankology_social_twitter_img',
                'type'               => 'upload',
                'placeholder'        => esc_html__('Select your default thumbnail', 'wp-rankology'),
                'use_default'        => '',
                'default'            => '',
                'label'              => esc_html__('Twitter Thumbnail', 'wp-rankology'),
                'visible'            => true,
                'description'        => esc_html__('Minimum size: 144x144px (300x157px with large card enabled), ideal ratio 1:1 (2:1 with large card), 5Mb max.', 'wp-rankology'),
            ],
            [
                'key'                => '_rankology_social_twitter_img_attachment_id',
                'type'               => 'hidden',
            ],
            [
                'key'                => '_rankology_social_twitter_img_width',
                'type'               => 'hidden',
            ],
            [
                'key'                => '_rankology_social_twitter_img_height',
                'type'               => 'hidden',
            ],
        ], $id);

        return $data;
    }
}
