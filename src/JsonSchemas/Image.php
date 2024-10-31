<?php

namespace Rankology\JsonSchemas;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetJsonData;
use Rankology\Models\JsonSchemaValue;

class Image extends JsonSchemaValue implements GetJsonData {
    const NAME = 'image';

    protected function getName() {
        return self::NAME;
    }

    /**
     * 
     *
     * @param array $context
     *
     * @return string|array
     */
    public function getJsonData($context = null) {
        $data = $this->getArrayJson();

        return apply_filters('rankology_get_json_data_image', $data);
    }
}
