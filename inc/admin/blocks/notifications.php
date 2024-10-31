<?php
// To prevent calling the plugin directly
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if (!function_exists('add_action')) {
    echo 'Please don&rsquo;t call the plugin directly. Thanks :)';
    exit;
}

if (defined('RANKOLOGY_WL_ADMIN_HEADER') && RANKOLOGY_WL_ADMIN_HEADER === false) {
    //do nothing
} else {

    $notifications = rankology_get_service('Notifications')->getSeverityNotification('all');

    $total = $alerts_high = $alerts_medium = $alerts_low = $alerts_info = 0;

    if (!empty($notifications['total'])) {
        $total = $notifications['total'];
        $alerts_high = !empty($notifications['severity']['high']) ? $notifications['severity']['high'] : 0;
        $alerts_medium = !empty($notifications['severity']['medium']) ? $notifications['severity']['medium'] : 0;
        $alerts_low = !empty($notifications['severity']['low']) ? $notifications['severity']['low'] : 0;
        $alerts_info = !empty($notifications['severity']['info']) ? $notifications['severity']['info'] : 0;
    }

    $class = '1' !== rankology_get_service('AdvancedOption')->getAppearanceNotification() ? 'is-active' : '';
?>

    
    <?php
}
