<?php

namespace Rankology\Models;

if ( ! defined('ABSPATH')) {
    exit;
}

interface GetTagValue {
    public function getValue($context = null);
}
