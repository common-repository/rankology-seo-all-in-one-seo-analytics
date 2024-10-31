<?php

namespace Rankology\Tags\Date;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class CurrentDay implements GetTagValue {
    const NAME = 'currentday';

    public static function getDescription() {
        return esc_html__('Current Day', 'wp-rankology');
    }

    public function getValue($args = null) {
        return date_i18n('j');
    }
}
