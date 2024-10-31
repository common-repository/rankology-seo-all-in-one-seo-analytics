<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

function rankology_rkseo_print_section_info_social_knowledge()
{
    ?>
<div class="rkseo-section-header">
    <h2>
        <?php esc_html_e('Google Knowledge Graph', 'wp-rankology'); ?>
    </h2>
</div>

<p>
    <?php esc_html_e('Configure Google Knowledge Graph. This will print a schema for search engines on your homepage.', 'wp-rankology'); ?>
</p>

<p class="rankology-help">
    <span class="dashicons dashicons-redo"></span>
    <a href="https://developers.google.com/search/docs/guides/enhance-site" target="_blank">
        <?php esc_html_e('Learn more on Google official website.', 'wp-rankology'); ?>
    </a>
</p>

<?php
}

function rankology_rkseo_print_section_info_social_accounts()
{
    ?>

<div class="rkseo-section-header">
    <h2>
        <?php esc_html_e('Social account Links', 'wp-rankology'); ?>
    </h2>
</div>

<?php
}

function rankology_rkseo_print_section_info_social_facebook()
{
?>
<div class="rkseo-section-header">
    <h2>
        <?php esc_html_e('Facebook (Open Graph)', 'wp-rankology'); ?>
    </h2>
</div>

<p>
    <?php esc_html_e('Manage Open Graph data. These metatags will be used by Facebook, Pinterest, LinkedIn', 'wp-rankology'); ?>
</p>

<?php
}

function rankology_rkseo_print_section_info_social_twitter()
{
?>
<div class="rkseo-section-header">
    <h2>
        <?php esc_html_e('Twitter (Twitter card)', 'wp-rankology'); ?>
    </h2>
</div>
<p>
    <?php esc_html_e('Manage your Twitter card.', 'wp-rankology'); ?>
</p>

<?php
}
