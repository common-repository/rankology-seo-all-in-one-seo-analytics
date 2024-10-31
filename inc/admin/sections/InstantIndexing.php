<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

function rankology_rkseo_print_section_instant_indexing_general() {
?>
<div class="rkseo-section-header">
    <h2>
        <?php esc_html_e('Search Engines Indexing', 'wp-rankology'); ?>
    </h2>
</div>

<p><?php esc_html_e('You can use the Indexing API to tell Google & Bing to update or remove pages from the Search engine index.','wp-rankology'); ?></p>

<?php

$indexing_plugins = [
    'indexnow/indexnow-url-submission.php'                       => 'IndexNow',
    'bing-webmaster-tools/bing-url-submission.php'               => 'Bing Webmaster Url Submission',
    'fast-indexing-api/instant-indexing.php'                     => 'Instant Indexing',
];

foreach ($indexing_plugins as $key => $value) {
    if (is_plugin_active($key)) { ?>
        <div class="rankology-notice is-warning">
            <h3><?php printf(wp_kses(__('We noticed that you use <strong>%s</strong> plugin.', 'wp-rankology'), array('strong' => array(), 'a' => array('href' => array()))), $value); ?></h3>
            <p><?php printf(esc_html__('To prevent any conflicts with our Indexing feature, please disable it.', 'wp-rankology')); ?></p>
            <a class="btn btnPrimary" href="<?php echo rankology_set_admin_esx_url('plugins.php'); ?>"><?php esc_html_e('Fix this!', 'wp-rankology'); ?></a>
        </div>
        <?php
    }
}

}

function rankology_rkseo_print_section_instant_indexing_settings() { ?>
<div class="rkseo-section-header">
    <h2>
        <?php esc_html_e('Settings', 'wp-rankology'); ?>
    </h2>
</div>
<p>
    <?php esc_html_e('Edit your Instant Indexing settings for Google and Bing.', 'wp-rankology'); ?>
</p>

<?php
}
