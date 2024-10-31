<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

function rankology_rkseo_print_section_info_google_analytics_enable()
{
    ?>
<div class="rkseo-section-header">
    <h2>
        <?php esc_html_e('Google Analytics', 'wp-rankology'); ?>
    </h2>
</div>

<p>
    <?php esc_html_e('Link your Google Analytics and your tracking code will be automatically added to your site.', 'wp-rankology'); ?>
</p>
<hr>

<?php
}

function rankology_rkseo_print_section_info_google_analytics_gdpr()
{
    ?>
<div class="rkseo-section-header">
    <h2>
        <?php esc_html_e('Cookie bar in GDPR', 'wp-rankology'); ?>
    </h2>
</div>
<p>
    <?php esc_html_e('Manage customize your cookie bar and user consent for GDPR.', 'wp-rankology'); ?>
</p>


<?php
}

function rankology_rkseo_print_section_info_google_analytics_features()
{ ?>

<hr>
<h3 id="rankology-analytics-tracking">
    <?php esc_html_e('Tracking', 'wp-rankology'); ?>
</h3>

<p>
    <?php esc_html_e('Configure your Google Analytics tracking code.', 'wp-rankology'); ?>
</p>

<?php
}

function rankology_rkseo_print_section_info_google_analytics_custom_tracking()
{
    ?>
<div class="rkseo-section-header">
    <h2>
        <?php esc_html_e('Custom Code', 'wp-rankology'); ?>
    </h2>
</div>
<p>
    <?php esc_html_e('Add your tracking code like Facebook Pixel by copy and paste the provided code to the header, body or footer.', 'wp-rankology'); ?>
</p>
<?php
}

function rankology_rkseo_print_section_info_google_analytics_events()
{
?>
<hr>
<h3 id="rankology-analytics-events">
    <?php esc_html_e('Track Events', 'wp-rankology'); ?>
</h3>
<p>
    <?php esc_html_e('Track events in Google Analytics.', 'wp-rankology'); ?>
</p>

<?php
}

function rankology_rkseo_print_section_info_google_analytics_advanced()
{
?>
<br>
<hr>
<h3 id="rankology-analytics-misc"><?php esc_html_e('Misc','wp-rankology'); ?></h3>

<?php
}
