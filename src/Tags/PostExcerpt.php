<?php

namespace Rankology\Tags;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class PostExcerpt implements GetTagValue {
    const NAME = 'post_excerpt';

    const ALIAS = ['wc_single_short_desc'];

    public static function getDescription() {
        return esc_html__('Post Excerpt', 'wp-rankology');
    }

    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;
        $value   = '';

        if ( ! $context) {
            return $value;
        }

        if (isset($context['is_404']) && ! $context['is_404'] && ! empty($context['post'])) {
            if (has_excerpt($context['post']->ID)) {
                $value = get_the_excerpt();
            }
        }

        if (empty($value) && isset($context['post']->ID)) {
            $content = get_post_field('post_content', $context['post']->ID, true);
            if ( ! empty($content)) {
                $value = $content;
            }
        }

        $value = wp_trim_words(
            esc_attr(
                stripslashes_deep(
                    wp_filter_nohtml_kses(
                        wp_strip_all_tags(
                            strip_shortcodes($value),
                            true
                        )
                    )
                )
            ), rankology_get_service('TagsToString')->getExcerptLengthForTags()
        );

        return apply_filters('rankology_get_tag_post_excerpt_value', $value, $context);
    }
}
