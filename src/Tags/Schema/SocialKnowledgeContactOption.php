<?php

namespace Rankology\Tags\Schema;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class SocialKnowledgeContactOption implements GetTagValue
{
    const NAME = 'social_knowledge_contact_option';

    /**
     * 
     *
     * @param array $args
     *
     * @return string
     */
    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;

        $value   = rankology_get_service('SocialOption')->getSocialKnowledgeContactOption();
        if ('None' === $value) {
            $value = '';
        }

        return apply_filters('rankology_get_tag_schema_social_knowledge_contact_option', $value, $context);
    }
}
