<?php

namespace Rankology\Tags;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class PostContent implements GetTagValue {
    const NAME = 'post_content';

    public static function getDescription() {
        return esc_html__('Post Content', 'wp-rankology');
    }

    /**
     * 4.4.0.
     *
     * @param array $args
     *
     * @return string
     */
    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;
        $value   = '';

        if ( ! $context) {
            return $value;
        }

        if ( ! isset($context['post'])) {
            return $value;
        }

        if (isset($context['is_404']) && ! $context['is_404'] && ! empty($context['post'])) {
            if (has_excerpt($context['post']->ID)) {
                $value = get_post_field('post_content', $context['post']->ID);
            }
        }

        if ( ! empty($context['post'])) {
            $value = get_post_field('post_content', $context['post']->ID);
        }

        $value = wp_trim_words(
            esc_attr(
                stripslashes_deep(
                    wp_filter_nohtml_kses(
                        wp_strip_all_tags(
                            strip_shortcodes($value)
                        )
                    )
                )
            ), rankology_get_service('TagsToString')->getExcerptLengthForTags()
        );

        return apply_filters('rankology_get_tag_post_content_value', $value, $context);
    }
}
