<?php

namespace Rankology\Tags\Date;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class CurrentMonthNum implements GetTagValue {
    const NAME = 'currentmonth_num';

    public static function getDescription() {
        return esc_html__('Current Month Number', 'wp-rankology');
    }

    public function getValue($args = null) {
        return date_i18n('n');
    }
}
