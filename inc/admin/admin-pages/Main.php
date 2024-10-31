<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

// Set class property
$this->options = get_option('rankology_option_name');
$current_tab   ='';
if (function_exists('rankology_admin_header')) {
    echo rankology_admin_header();
}
?>

<div id="rankology-content" class="rankology-option">
    <!--Get started-->
    <?php
        include_once dirname(dirname(__FILE__)) . '/blocks/intro.php';
        include_once dirname(dirname(__FILE__)) . '/blocks/get-started.php';
        include_once dirname(dirname(__FILE__)) . '/blocks/features-list.php';
    ?>

    <div class="rankology-dashboard-columns">
        <div class="rankology-dashboard-column">
            <?php
                include_once dirname(dirname(__FILE__)) . '/blocks/tasks.php';
                include_once dirname(dirname(__FILE__)) . '/blocks/notifications.php';
            ?>
        </div>
        <div class="rankology-dashboard-column">
            <?php
                include_once dirname(dirname(__FILE__)) . '/blocks/insights.php';
                include_once dirname(dirname(__FILE__)) . '/blocks/upsell.php';
            ?>
        </div>
    </div>
    <?php
        include_once dirname(dirname(__FILE__)) . '/blocks/news.php';
        $this->rankology_feature_save();
    ?>
</div>
<?php echo rankology_common_esc_str($this->rankology_feature_save()); ?>
<?php
