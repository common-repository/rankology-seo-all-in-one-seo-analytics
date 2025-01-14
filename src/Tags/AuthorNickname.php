<?php

namespace Rankology\Tags;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class AuthorNickname implements GetTagValue {
    const NAME = 'author_nickname';

    public static function getDescription() {
        return esc_html__('Author Nickname', 'wp-rankology');
    }

    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;
        $value   = '';

        if ( ! $context) {
            return $value;
        }

        if ($context['is_single'] && isset($context['post']->post_author)) {
            $value      = get_the_author_meta('nickname', $context['post']->post_author);
        }

        if ($context['is_author'] && is_int(get_queried_object_id())) {
            $user_info = get_userdata(get_queried_object_id());

            if (isset($user_info)) {
                $value = $user_info->nickname;
            }
        }

        $value = esc_attr($value);

        return apply_filters('rankology_get_tag_author_nickname_value', $value, $context);
    }
}
