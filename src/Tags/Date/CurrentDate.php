<?php

namespace Rankology\Tags\Date;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class CurrentDate implements GetTagValue {
    const NAME = 'currentdate';

    public static function getDescription() {
        return esc_html__('Current Date', 'wp-rankology');
    }

    public function getValue($args = null) {
        return date_i18n(get_option('date_format'));
    }
}
