<?php
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// To prevent calling the plugin directly
if (! function_exists('add_action')) {
    echo 'Please don&rsquo;t call the plugin directly.';
    exit;
}

if (defined('RANKOLOGY_WL_ADMIN_HEADER') && RANKOLOGY_WL_ADMIN_HEADER === false) {
    //do nothing
} else {

}
