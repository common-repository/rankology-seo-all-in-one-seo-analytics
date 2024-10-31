<?php

namespace Rankology\Tags\Date;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class CurrentTime implements GetTagValue {
    const NAME = 'currenttime';

    public static function getDescription() {
        return esc_html__('Current Time', 'wp-rankology');
    }

    public function getValue($args = null) {
        return current_time(get_option('time_format'));
    }
}
