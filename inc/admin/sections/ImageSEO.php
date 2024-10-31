<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

function rankology_rkseo_print_section_info_advanced_image()
{
    ?>
<div class="rkseo-section-header">
    <h2>
        <?php esc_html_e('Image Settings', 'wp-rankology'); ?>
    </h2>
</div>
<p><?php esc_html_e('Images optimization and proper SEO is most important for your site. Make sure to always add alternative texts, optimize their file size, filename etc.', 'wp-rankology'); ?>
</p>

<?php
}
