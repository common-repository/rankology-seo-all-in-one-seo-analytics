<?php

namespace Rankology\Tags;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class CustomPostTypePlural implements GetTagValue {
    const NAME = 'cpt_plural';

    public static function getDescription() {
        return esc_html__('Plural Post Type Archive name', 'wp-rankology');
    }

    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;
        $value   = post_type_archive_title('', false);

        return apply_filters('rankology_get_tag_cpt_plural_value', $value, $context);
    }
}
