<?php

namespace Rankology\Tags\Date;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class ArchiveDateYear implements GetTagValue {
    const NAME = 'archive_date_year';

    public static function getDescription() {
        return esc_html__('Year Archive Date', 'wp-rankology');
    }

    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;
        $value   = get_query_var('year');

        return apply_filters('rankology_get_tag_archive_date_year_value', $value, $context);
    }
}
