<?php

namespace Rankology\Models;

if ( ! defined('ABSPATH')) {
    exit;
}

/**
 * @abstract
 */
abstract class JsonSchemaValue implements GetJsonFromFile {
    abstract protected function getName();

    /**
     * 
     *
     * @param string $file
     * @param mixed  $name
     *
     * @return string
     */
    public function getJson() {
        $file = apply_filters('rankology_get_json_from_file', sprintf('%s/%s.json', RANKOLOGY_TEMPLATE_JSON_SCHEMAS, $this->getName(), '.json'));

        if ( ! file_exists($file)) {
            return '';
        }

        $json = file_get_contents($file);

        return $json;
    }

    /**
     * 
     *
     * @param string
     *
     * @return array
     */
    public function getArrayJson() {
        $json = $this->getJson();
        try {
            $data = json_decode($json, true);

            return apply_filters('rankology_schema_get_array_json', $data, $this->getName());
        } catch (\Exception $th) {
            return [];
        }
    }

    /**
     * 
     *
     * @param array $data
     *
     * @return array|string
     */
    public function renderJson($data) {
        return json_encode($data);
    }

    /**
     * 
     *
     * @param array $data
     *
     * @return array
     */
    public function cleanValues($data) {
        return apply_filters('rankology_schema_clean_values', $data, $this->getName());
    }
}
