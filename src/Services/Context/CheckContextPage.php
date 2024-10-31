<?php

namespace Rankology\Services\Context;

if ( ! defined('ABSPATH')) {
    exit;
}

class CheckContextPage {
    /**
     * 
     *
     * @param array $context
     *
     * @return bool
     */
    public function hasSchemaManualValues($context) {
        if ( ! isset($context['schemas_manual']) || ! isset($context['key_get_json_schema'])) {
            return false;
        }

        if ( ! isset($context['schemas_manual'][$context['key_get_json_schema']])) {
            return false;
        }

        return true;
    }
}
