<?php

namespace Rankology\Services;

if ( ! defined('ABSPATH')) {
    exit;
}

class VariablesToString {
    const REGEX = "#\[\[(.*?)\]\]#";

    /**
     * 
     *
     * @param string $string
     *
     * @return array
     */
    public function getVariables($string) {
        if ( ! is_string($string)) {
            return [];
        }

        preg_match_all(self::REGEX, $string, $matches);

        return $matches;
    }

    /**
     * 
     *
     * @param function $variable
     * @param array    $context
     *
     * @return void
     */
    public function getValueFromContext($variable, $context= []) {
        if ( ! array_key_exists($variable, $context)) {
            return '';
        }

        return $context[$variable];
    }

    /**
     * 
     *
     * @param string $string
     * @param mixed  $context
     *
     * @return string
     */
    public function replace($string, $context = []) {
        $variables = $this->getVariables($string);

        if ( ! array_key_exists(1, $variables)) {
            return $string;
        }

        foreach ($variables[1] as $key => $variable) {
            $value  = $this->getValueFromContext($variable, $context);

            $string = str_replace($variables[0][$key], $value, $string);
        }

        return $string;
    }

    /**
     * 
     *
     * @param array $data
     *
     * @return array
     */
    protected function removeDataEmpty($data) {
        return array_filter($data);
    }

    /**
     * 
     *
     * @param array $data
     * @param array $context
     * @param mixed $options
     *
     * @return array
     */
    public function replaceDataToString($data, $context = [], $options = []) {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->replaceDataToString($value, $context, $options);
            } else {
                $data[$key] = $this->replace($value, $context);
            }
        }

        if (isset($options['remove_empty']) && $options['remove_empty']) {
            $data = $this->removeDataEmpty($data);
        }

        return $data;
    }
}
