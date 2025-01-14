<?php

namespace Rankology\Tags;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class Separator implements GetTagValue {
    const NAME = 'sep';

    const DEFAULT_SEPARATOR = '-';

    public static function getDescription() {
        return esc_html__('Separator', 'wp-rankology');
    }

    public function getValue($args = null) {
        $context   = isset($args[0]) ? $args[0] : null;

        $separator = rankology_get_service('TitleOption')->getSeparator();
        if (empty($separator)) {
            $separator = self::DEFAULT_SEPARATOR;
        }

        return apply_filters('rankology_get_tag_separator_value', $separator, $context);
    }
}
