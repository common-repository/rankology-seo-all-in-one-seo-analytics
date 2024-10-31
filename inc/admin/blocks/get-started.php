<?php
// To prevent calling the plugin directly
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! function_exists('add_action')) {
    echo 'Please don&rsquo;t call the plugin directly.';
    exit;
}
$class = '1' !== rankology_get_service('NoticeOption')->getNoticeGetStarted() ? 'is-active' : '';

if (defined('RANKOLOGY_WL_ADMIN_HEADER') && RANKOLOGY_WL_ADMIN_HEADER === false) {
    //do nothing
}