<?php

namespace Rankology\Tags;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class ArchiveTitle implements GetTagValue {
    const NAME = 'archive_title';

    public static function getDescription() {
        return esc_html__('Archive Title', 'wp-rankology');
    }

    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;
        $value   = get_the_archive_title();

        return apply_filters('rankology_get_tag_archive_title_value', $value, $context);
    }
}
