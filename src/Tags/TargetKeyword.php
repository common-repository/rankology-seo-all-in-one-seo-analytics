<?php

namespace Rankology\Tags;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class TargetKeyword implements GetTagValue {
    const NAME = 'target_keyword';

    public static function getDescription() {
        return esc_html__('Target Keywords', 'wp-rankology');
    }

    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;

        $value   = '';
        if (isset($context['post']->ID)) {
            $value = get_post_meta($context['post']->ID, '_rankology_analysis_target_kw', true);
        }

        return apply_filters('rankology_get_tag_target_keyword_value', $value, $context);
    }
}
