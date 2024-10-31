<?php

namespace Rankology\Tags;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class TagTitle implements GetTagValue {
    const NAME = 'tag_title';

    public static function getDescription() {
        return esc_html__('Tag Title', 'wp-rankology');
    }

    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;

        $value   = '';

        if (null !== $context['term_id']) {
            $value = get_term_field('name', $context['term_id']);
            if (is_wp_error($value)) {
                $value = '';
            }
        } else {
            $value   = single_tag_title('', false);
        }

        return apply_filters('rankology_get_tag_tag_title_value', $value, $context);
    }
}
