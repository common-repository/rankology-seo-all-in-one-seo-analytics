<?php

namespace Rankology\Tags\Custom;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\AbstractCustomTagValue;
use Rankology\Models\GetTagValue;

class CustomUserMeta extends AbstractCustomTagValue implements GetTagValue {
    const CUSTOM_FORMAT = '_ucf_';
    const NAME          = '_ucf_your_user_meta';

    public static function getDescription() {
        return esc_html__('Custom User Meta', 'wp-rankology');
    }

    public function getValue($args = null) {

        $context = isset($args[0]) ? $args[0] : null;
        $tag     = isset($args[1]) ? $args[1] : null;
        $value   = '';
        if (null === $tag || ! $context) {
            return $value;
        }


        if ( ! $context['post'] && ! $context['is_author']) {
            return $value;
        }
        $regex = $this->buildRegex(self::CUSTOM_FORMAT);

        preg_match($regex, $tag, $matches);

        if (empty($matches) || ! array_key_exists('field', $matches)) {
            return $value;
        }

        $field = $matches['field'];

        $authorId = get_current_user_id();
        if($context['is_author'] && isset($context['author']->ID)){
            $authorId = $context['author']->ID;
        }
        if($context['post'] && isset($context['post']->post_author)){
            $authorId = $context['post']->post_author;
        }

        $value = esc_attr(get_user_meta($authorId, $field, true));

        return apply_filters('rankology_get_tag_' . $tag . '_value', $value, $context);
    }
}
