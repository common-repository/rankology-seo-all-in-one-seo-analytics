<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

function rankology_rkseo_print_section_info_xml_sitemap_general() {
    ?>
    <div class="rkseo-section-header">
        <h2>
            <?php esc_html_e('Other settings', 'wp-rankology'); ?>
        </h2>
    </div>

    <?php if ('' == get_option('permalink_structure')) { ?>
        <div class="rankology-notice is-error">
            <p>
                <?php esc_html_e('Your permalinks are not <strong>SEO Friendly</strong>! Enable <strong>pretty permalinks</strong> to fix this.', 'wp-rankology'); ?>
            </p>
            <p>
                <a href="<?php echo esc_url(rankology_set_admin_esx_url('options-permalink.php')); ?>" class="btn btnSecondary">
                    <?php esc_html_e('Change this settings', 'wp-rankology'); ?>
                </a>
            </p>
        </div>
    <?php } ?>

    <p><?php esc_html_e('This is the URL of your index sitemaps to submit to search engines.','wp-rankology'); ?></p>

    <p>
        <pre><span class="dashicons dashicons-redo"></span><a href="<?php echo esc_url(get_option('home') . '/sitemaps.xml'); ?>" target="_blank"><?php echo esc_url(get_option('home') . '/sitemaps.xml'); ?></a></pre>
    </p>

    <?php if (is_plugin_active('sg-cachepress/sg-cachepress.php')) { ?>
        <div class="rankology-notice">
            <h3><?php esc_html_e('SiteGround Optimizer user?', 'wp-rankology'); ?></h3>
            <p><?php esc_html_e('We automatically sent your XML sitemap URL for the preheat caching feature.', 'wp-rankology'); ?></p>
        </div>
    <?php } ?>

    <div class="rankology-notice">
        <p>
            <?php echo wp_kses(__('<strong>Noindex content will not be displayed in Sitemaps. Same for custom canonical URLs.</strong>', 'wp-rankology'), array('strong' => array())); ?>
        </p>
    </div>

    <?php if (isset($_SERVER['SERVER_SOFTWARE'])) {
        $server_software = explode('/', sanitize_text_field(wp_unslash($_SERVER['SERVER_SOFTWARE'])));
        reset($server_software);

        if ('nginx' == strtolower(current($server_software))) { // IF NGINX
            ?>
            <div class="rankology-notice">
                <p>
                    <?php esc_html_e('Your server uses NGINX. If XML Sitemaps doesn\'t work properly, you need to add this rule to your configuration:', 'wp-rankology'); ?>
                </p>
                <pre>location ~ (([^/]*)sitemap(.*)|news|author|video(.*))\.x(m|s)l$ {
					## Rankology
					rewrite ^.*/sitemaps\.xml$ /index.php?rankology_sitemap=1 last;
					rewrite ^.*/news.xml$ /index.php?rankology_news=$1 last;
					rewrite ^.*/video.xml$ /index.php?rankology_video=$1 last;
					rewrite ^.*/author.xml$ /index.php?rankology_author=$1 last;
					rewrite ^.*/sitemaps_xsl\.xsl$ /index.php?rankology_sitemap_xsl=1 last;
					rewrite ^.*/sitemaps_video_xsl\.xsl$ /index.php?rankology_sitemap_video_xsl=1 last;
					rewrite ^.*/([^/]+?)-sitemap([0-9]+)?.xml$ /index.php?rankology_cpt=$1&rankology_paged=$2 last;
				}
				</pre>
            </div>
            <?php
        }
    } ?>

    <?php
}

function rankology_rkseo_print_section_info_html_sitemap() {
    ?>
    <div class="rkseo-section-header">
        <h2>
            <?php esc_html_e('HTML Sitemap', 'wp-rankology'); ?>
        </h2>
    </div>

    <p>
        <?php esc_html_e('Limited to 1,000 posts per post type. You can change the order and sorting criteria below settings.', 'wp-rankology'); ?>
    </p>

    <div class="rankology-notice">
        <h3><?php esc_html_e('HTML Sitemap shortcode', 'wp-rankology'); ?></h3>
        <p><?php esc_html_e('You can also use this shortcode in your content:', 'wp-rankology'); ?></p>
        <pre>[rankology_html_sitemap]</pre>
        <p><?php esc_html_e('To include specific custom post types, use the CPT attribute:', 'wp-rankology'); ?></p>
        <pre>[rankology_html_sitemap cpt="post,product"]</pre>
    </div>
    <?php
}

function rankology_rkseo_print_section_info_xml_sitemap_post_types() {
    ?>
    <div class="rkseo-section-header">
        <h2>
            <?php esc_html_e('Post Types', 'wp-rankology'); ?>
        </h2>
    </div>
    <p>
        <?php esc_html_e('Include/Exclude Post Types.', 'wp-rankology'); ?>
    </p>
    <?php
}

function rankology_rkseo_print_section_info_xml_sitemap_taxonomies() {
    ?>
    <div class="rkseo-section-header">
        <h2>
            <?php esc_html_e('Taxonomies', 'wp-rankology'); ?>
        </h2>
    </div>
    <p>
        <?php esc_html_e('Include/Exclude Taxonomies.', 'wp-rankology'); ?>
    </p>
    <?php
}
