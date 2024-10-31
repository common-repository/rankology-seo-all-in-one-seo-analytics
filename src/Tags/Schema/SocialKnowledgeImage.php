<?php

namespace Rankology\Tags\Schema;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class SocialKnowledgeImage implements GetTagValue {
    const NAME = 'social_knowledge_image';

    /**
     * 
     *
     * @param array $args
     *
     * @return string
     */
    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;

        $value   = rankology_get_service('SocialOption')->getSocialKnowledgeImage();

        return apply_filters('rankology_get_tag_schema_social_knowledge_image', $value, $context);
    }
}
