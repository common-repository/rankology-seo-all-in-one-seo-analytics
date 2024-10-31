<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

function rankology_rkseo_print_section_info_advanced_advanced()
{
    ?>
<div class="rkseo-section-header">
    <h2>
        <?php esc_html_e('Advanced Meta Settings', 'wp-rankology'); ?>
    </h2>
</div>
<p>
    <?php esc_html_e('Advanced SEO meta options for advanced users.', 'wp-rankology'); ?>
</p>

<?php
}

function rankology_rkseo_print_section_info_advanced_appearance()
{
    ?>
<div class="rkseo-section-header">
    <h2>
        <?php esc_html_e('Appearance', 'wp-rankology'); ?>
    </h2>
</div>

<p>
    <?php esc_html_e('Customize the plugin to fit your needs.', 'wp-rankology'); ?>
</p>

<?php
}

function rankology_rkseo_print_section_info_advanced_appearance_col()
{ ?>
<hr>

<h3 id="rankology-advanced-columns">
    <?php esc_html_e('Columns', 'wp-rankology'); ?>
</h3>

<p><?php esc_html_e('Customize the SEO columns.','wp-rankology'); ?></p>

<?php
}

function rankology_rkseo_print_section_info_advanced_appearance_metabox()
{ ?>
<hr>

<h3 id="rankology-advanced-metaboxes">
    <?php esc_html_e('Metaboxes', 'wp-rankology'); ?>
</h3>

<?php
}
