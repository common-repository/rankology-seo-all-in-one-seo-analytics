<?php

namespace Rankology\Tags\Date;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class CurrentYear implements GetTagValue {
    const NAME = 'currentyear';

    public static function getDescription() {
        return esc_html__('Current Year', 'wp-rankology');
    }

    public function getValue($args = null) {
        return date('Y');
    }
}
