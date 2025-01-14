<?php

namespace Rankology\Models;

if ( ! defined('ABSPATH')) {
    exit;
}

abstract class AbstractCustomTagValue {
    protected function buildRegex($format) {
        return '/^' . $format . '(?<field>(?:.*))/';
    }
}
