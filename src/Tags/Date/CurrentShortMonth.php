<?php

namespace Rankology\Tags\Date;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class CurrentShortMonth implements GetTagValue {
    const NAME = 'currentmonth_short';

    public static function getDescription() {
        return esc_html__('Current Month in 3 letters', 'wp-rankology');
    }

    public function getValue($args = null) {
        return date_i18n('M');
    }
}
