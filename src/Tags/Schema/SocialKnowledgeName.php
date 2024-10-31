<?php

namespace Rankology\Tags\Schema;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class SocialKnowledgeName implements GetTagValue {
    const NAME = 'social_knowledge_name';

    /**
     * 
     *
     * @param array $args
     *
     * @return string
     */
    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;

        $value  = rankology_get_service('SocialOption')->getSocialKnowledgeName();
        $type   = rankology_get_service('SocialOption')->getSocialKnowledgeType();

        if (empty($value) && 'none' !== $type) {
            $value = get_bloginfo('name');
        }

        return apply_filters('rankology_get_tag_schema_social_knowledge_name', $value, $context);
    }
}
