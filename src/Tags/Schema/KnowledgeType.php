<?php

namespace Rankology\Tags\Schema;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class KnowledgeType implements GetTagValue {
    const NAME = 'knowledge_type';

    /**
     * 
     *
     * @param array $args
     *
     * @return string
     */
    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;

        $value   = rankology_get_service('SocialOption')->getSocialKnowledgeType();

        if (empty($value)) {
            $value = 'Organization';
        }

        return apply_filters('rankology_get_tag_schema_knowledge_type', $value, $context);
    }
}