<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

//Titles & metas
function rankology_titles_sep_callback()
{
    $options = get_option('rankology_titles_option_name');
    $check   = isset($options['rankology_titles_sep']) ? $options['rankology_titles_sep'] : null; ?>

<input type="text" id="rankology_titles_sep" name="rankology_titles_option_name[rankology_titles_sep]"
    placeholder="<?php esc_html_e('Enter your separator, e.g. "-"', 'wp-rankology'); ?>"
    aria-label="<?php esc_html_e('Separator', 'wp-rankology'); ?>"
    value="<?php esc_html($check); ?>" />

<p class="description">
    <?php esc_html_e('Use this separator with %%sep%% in your title and meta description.', 'wp-rankology'); ?>
</p>

<?php
}

function rankology_titles_home_site_title_callback()
{
    $options = get_option('rankology_titles_option_name');
    $check   = isset($options['rankology_titles_home_site_title']) ? $options['rankology_titles_home_site_title'] : null; ?>

<input type="text" id="rankology_titles_home_site_title"
    name="rankology_titles_option_name[rankology_titles_home_site_title]"
    placeholder="<?php esc_html_e('My awesome website', 'wp-rankology'); ?>"
    aria-label="<?php esc_html_e('Site title', 'wp-rankology'); ?>"
    value="<?php esc_html($check); ?>" />

<div class="wrap-tags">
    <button type="button" class="btn btnSecondary tag-title" id="rankology-tag-site-title" data-tag="%%sitetitle%%">
        <span class="dashicons dashicons-tag"></span>
        <?php esc_html_e('Site Title', 'wp-rankology'); ?>
    </button>

    <button type="button" class="btn btnSecondary tag-title" id="rankology-tag-site-sep" data-tag="%%sep%%">
        <span class="dashicons dashicons-tag"></span>
        <?php esc_html_e('Separator', 'wp-rankology'); ?>
    </button>

    <button type="button" class="btn btnSecondary tag-title" id="rankology-tag-site-desc" data-tag="%%tagline%%">
        <span class="dashicons dashicons-tag"></span>
        <?php esc_html_e('Tagline', 'wp-rankology'); ?>
    </button>

    <?php echo rankology_render_dyn_variables('tag-title');
}

function rankology_titles_home_site_title_alt_callback()
{
    $options = get_option('rankology_titles_option_name');
    $check   = isset($options['rankology_titles_home_site_title_alt']) ? $options['rankology_titles_home_site_title_alt'] : null;
    ?>

<input type="text" id="rankology_titles_home_site_title_alt"
    name="rankology_titles_option_name[rankology_titles_home_site_title_alt]"
    placeholder="<?php esc_html_e('My alternative site title', 'wp-rankology'); ?>"
    aria-label="<?php esc_html_e('Alternative site title', 'wp-rankology'); ?>"
    value="<?php esc_html($check); ?>" />
    <?php
}

function rankology_titles_home_site_desc_callback()
{
    $options = get_option('rankology_titles_option_name');
    $check   = isset($options['rankology_titles_home_site_desc']) ? $options['rankology_titles_home_site_desc'] : null; ?>

    <textarea id="rankology_titles_home_site_desc" name="rankology_titles_option_name[rankology_titles_home_site_desc]"
        placeholder="<?php esc_html_e('This is a cool website for fashion', 'wp-rankology'); ?>"
        aria-label="<?php esc_html_e('Meta description', 'wp-rankology'); ?>"><?php esc_html($check); ?></textarea>

    <div class="wrap-tags">
        <button type="button" class="btn btnSecondary tag-title" id="rankology-tag-meta-desc" data-tag="%%tagline%%">
            <span class="dashicons dashicons-tag"></span>
            <?php esc_html_e('Tagline', 'wp-rankology'); ?>
        </button>

        <?php echo rankology_render_dyn_variables('tag-description'); ?>
    </div>

    <?php if (get_option('page_for_posts')) { ?>
        <p>
            <a
                href="<?php echo rankology_set_admin_esx_url('post.php?post=' . get_option('page_for_posts') . '&action=edit'); ?>">
                <?php esc_html_e('Looking to edit your blog page?', 'wp-rankology'); ?>
            </a>
        </p>
    <?php }
}

// Single CPT
function rankology_titles_single_titles_callback() {
    $postTypes = rankology_get_service('WordPressData')->getPostTypes();
    foreach ($postTypes as $rankology_cpt_key => $rankology_cpt_value) {
        ?>
        <h3>
            <?php echo rankology_common_esc_str($rankology_cpt_value->labels->name); ?>
            <em>
                <small>(<?php echo rankology_common_esc_str($rankology_cpt_value->name); ?>)</small>
            </em>
            
            <div class="rankology_wrap_single_cpt">

                <?php $options = get_option('rankology_titles_option_name');
                $check = isset($options['rankology_titles_single_titles'][$rankology_cpt_key]['enable']) ? $options['rankology_titles_single_titles'][$rankology_cpt_key]['enable'] : null; ?>

                <input
                    id="rankology_titles_single_cpt_enable[<?php echo rankology_common_esc_str($rankology_cpt_key); ?>]"
                    data-id="<?php echo rankology_common_esc_str($rankology_cpt_key); ?>"
                    name="rankology_titles_option_name[rankology_titles_single_titles][<?php echo rankology_common_esc_str($rankology_cpt_key); ?>][enable]"
                    class="toggle"
                    type="checkbox"
                    <?php if ('1' == $check) { ?>
                    checked="yes" data-toggle="0"
                    <?php } else { ?>
                    data-toggle="1"
                    <?php } ?>
                    value="1"/>

                <label for="rankology_titles_single_cpt_enable[<?php echo rankology_common_esc_str($rankology_cpt_key); ?>]">
                    <?php esc_html_e('Click to hide any SEO metaboxes / columns for this post type', 'wp-rankology'); ?>
                </label>

                <?php if ('1' == $check) { ?>
                <span id="titles-state-default" class="feature-state">
                    <span class="dashicons dashicons-visibility"></span>
                    <?php esc_html_e('Click to display any SEO metaboxes / columns for this post type', 'wp-rankology'); ?>
                </span>
                <span id="titles-state" class="feature-state feature-state-off">
                    <span class="dashicons dashicons-visibility"></span>
                    <?php esc_html_e('Click to hide any SEO metaboxes / columns for this post type', 'wp-rankology'); ?>
                </span>
                <?php } else { ?>
                <span id="titles-state-default" class="feature-state">
                    <span class="dashicons dashicons-visibility"></span>
                    <?php esc_html_e('Click to hide any SEO metaboxes / columns for this post type', 'wp-rankology'); ?>
                </span>
                <span id="titles-state" class="feature-state feature-state-off">
                    <span class="dashicons dashicons-visibility"></span>
                    <?php esc_html_e('Click to display any SEO metaboxes / columns for this post type', 'wp-rankology'); ?>
                </span>
                <?php } ?>
                
                <!-- Keep the PHP for retrieving the toggle text -->
                <?php 
                $toggle_txt_on = '<span class="dashicons dashicons-visibility"></span>' . esc_html__('Click to display any SEO metaboxes / columns for this post type', 'wp-rankology');
                $toggle_txt_off = '<span class="dashicons dashicons-visibility"></span>' . esc_html__('Click to hide any SEO metaboxes / columns for this post type', 'wp-rankology');
                ?>

            </div>
        </h3>

        <!-- Single Title CPT -->
        <div class="rankology_wrap_single_cpt">
            <p><?php esc_html_e('Title template', 'wp-rankology'); ?></p>

            <?php $check = isset($options['rankology_titles_single_titles'][$rankology_cpt_key]['title']) ? $options['rankology_titles_single_titles'][$rankology_cpt_key]['title'] : null; ?>
            
            <?php printf(
                '<input type="text" id="rankology_titles_single_titles_' . $rankology_cpt_key . '" name="rankology_titles_option_name[rankology_titles_single_titles][' . $rankology_cpt_key . '][title]" value="%s"/>',
                esc_html($check)
            ); ?>

            <div class="wrap-tags">
                <button type="button" class="btn btnSecondary tag-title" id="rankology-tag-single-title-<?php echo rankology_common_esc_str($rankology_cpt_key); ?>" data-tag="%%post_title%%">
                    <span class="dashicons dashicons-tag"></span>
                    <?php esc_html_e('Post Title', 'wp-rankology'); ?>
                </button>

                <button type="button" class="btn btnSecondary tag-title" id="rankology-tag-sep-<?php echo rankology_common_esc_str($rankology_cpt_key); ?>" data-tag="%%sep%%">
                    <span class="dashicons dashicons-tag"></span>
                    <?php esc_html_e('Separator', 'wp-rankology'); ?>
                </button>

                <button type="button" class="btn btnSecondary tag-title" id="rankology-tag-single-sitetitle-<?php echo rankology_common_esc_str($rankology_cpt_key); ?>" data-tag="%%sitetitle%%">
                    <span class="dashicons dashicons-tag"></span>
                    <?php esc_html_e('Site Title', 'wp-rankology'); ?>
                </button>

                <?php echo rankology_render_dyn_variables('tag-title'); ?>
            </div>
        </div>

        <!-- Single Meta Description CPT -->
        <div class="rankology_wrap_single_cpt">
            <p><?php esc_html_e('Meta description template', 'wp-rankology'); ?></p>

            <?php $check = isset($options['rankology_titles_single_titles'][$rankology_cpt_key]['description']) ? $options['rankology_titles_single_titles'][$rankology_cpt_key]['description'] : null; ?>

            <?php printf(
                '<textarea id="rankology_titles_single_desc_' . $rankology_cpt_key . '" name="rankology_titles_option_name[rankology_titles_single_titles][' . $rankology_cpt_key . '][description]">%s</textarea>',
                esc_html($check)
            ); ?>
            
            <div class="wrap-tags">
                <button type="button" class="btn btnSecondary tag-title" id="rankology-tag-single-desc-<?php echo rankology_common_esc_str($rankology_cpt_key); ?>" data-tag="%%post_excerpt%%">
                    <span class="dashicons dashicons-tag"></span>
                    <?php esc_html_e('Post excerpt', 'wp-rankology'); ?>
                </button>
                <?php echo rankology_render_dyn_variables('tag-description'); ?>
            </div>
        </div>

        <!-- Single No-Index CPT -->
        <div class="rankology_wrap_single_cpt">
            <?php $check = isset($options['rankology_titles_single_titles'][$rankology_cpt_key]['noindex']); ?>
            <label for="rankology_titles_single_cpt_noindex[<?php echo rankology_common_esc_str($rankology_cpt_key); ?>]">
                <input
                    id="rankology_titles_single_cpt_noindex[<?php echo rankology_common_esc_str($rankology_cpt_key); ?>]"
                    name="rankology_titles_option_name[rankology_titles_single_titles][<?php echo rankology_common_esc_str($rankology_cpt_key); ?>][noindex]"
                    type="checkbox"
                    <?php if ('1' == $check) { ?>
                    checked="yes"
                    <?php } ?>
                    value="1"/>
                <?php esc_html_e('Exclude this single post type from search engine results <strong>(noindex)</strong>', 'wp-rankology'); ?>
            </label>
            
            <?php $cpt_in_sitemap = rankology_get_service('SitemapOption')->getPostTypesList();
            if ('1' == $check && isset($cpt_in_sitemap[$rankology_cpt_key]) && '1' === $cpt_in_sitemap[$rankology_cpt_key]['include']) { ?>
            <div class="rankology-notice is-error is-inline">
                <p><?php printf(wp_kses(__('This custom post type is <strong>NOT</strong> excluded from your XML sitemaps despite the fact that it is set to <strong>NOINDEX</strong>. We recommend that you <a href="%s">check this out here</a>.', 'wp-rankology'), array('strong' => array(), 'a' => array('href' => array()))), admin_url('admin.php?page=rankology-xml-sitemap')); ?></p>
            </div>
            <?php } ?>
        </div>

        <!-- Single No-Follow CPT -->
        <div class="rankology_wrap_single_cpt">
            <?php $check = isset($options['rankology_titles_single_titles'][$rankology_cpt_key]['nofollow']); ?>
            <label for="rankology_titles_single_cpt_nofollow[<?php echo rankology_common_esc_str($rankology_cpt_key); ?>]">
                <input
                    id="rankology_titles_single_cpt_nofollow[<?php echo rankology_common_esc_str($rankology_cpt_key); ?>]"
                    name="rankology_titles_option_name[rankology_titles_single_titles][<?php echo rankology_common_esc_str($rankology_cpt_key); ?>][nofollow]"
                    type="checkbox"
                    <?php if ('1' == $check) { ?>
                    checked="yes"
                    <?php } ?>
                    value="1"/>
                <?php esc_html_e('Exclude any link in this single post type from search engines <strong>(nofollow)</strong>', 'wp-rankology'); ?>
            </label>
        </div>

        <!-- Single Robots No-Archive -->
        <div class="rankology_wrap_single_cpt">
            <?php $check = isset($options['rankology_titles_single_titles'][$rankology_cpt_key]['noarchive']); ?>
            <label for="rankology_titles_single_cpt_noarchive[<?php echo rankology_common_esc_str($rankology_cpt_key); ?>]">
                <input
                    id="rankology_titles_single_cpt_noarchive[<?php echo rankology_common_esc_str($rankology_cpt_key); ?>]"
                    name="rankology_titles_option_name[rankology_titles_single_titles][<?php echo rankology_common_esc_str($rankology_cpt_key); ?>][noarchive]"
                    type="checkbox"
                    <?php if ('1' == $check) { ?>
                    checked="yes"
                    <?php } ?>
                    value="1"/>
                <?php esc_html_e('Exclude any link in this single post type from search engines <strong>(noarchive)</strong>', 'wp-rankology'); ?>
            </label>
        </div>
    <?php }
}


//BuddyPress Groups
function rankology_titles_bp_groups_title_callback()
{
    if (is_plugin_active('buddypress/bp-loader.php') || is_plugin_active('buddyboss-platform/bp-loader.php')) {
        $options = get_option('rankology_titles_option_name'); ?>
            <h3>
                <?php esc_html_e('BuddyPress groups', 'wp-rankology'); ?>
            </h3>

            <p>
                <?php esc_html_e('Title template', 'wp-rankology'); ?>
            </p>

            <?php $check = isset($options['rankology_titles_bp_groups_title']) ? $options['rankology_titles_bp_groups_title'] : null; ?>

            <input id="rankology_titles_bp_groups_title" type="text"
                name="rankology_titles_option_name[rankology_titles_bp_groups_title]"
                value="<?php esc_html($check); ?>" />

            <div class="wrap-tags">
                <button type="button" class="btn btnSecondary tag-title" id="rankology-tag-post-title-bd-groups" data-tag="%%post_title%%">
                    <span class="dashicons dashicons-tag"></span>
                    <?php esc_html_e('Post Title', 'wp-rankology'); ?>
                </button>
                <button type="button" class="btn btnSecondary tag-title" id="rankology-tag-sep-bd-groups" data-tag="%%sep%%">
                    <span class="dashicons dashicons-tag"></span>
                    <?php esc_html_e('Separator', 'wp-rankology'); ?>
                </button>

                <button type="button" class="btn btnSecondary tag-title" id="rankology-tag-site-title-bd-groups" data-tag="%%sitetitle%%">
                    <span class="dashicons dashicons-tag"></span>
                    <?php esc_html_e('Site Title', 'wp-rankology'); ?>
                </button>

                <?php
        echo rankology_render_dyn_variables('tag-title');
    }
}

function rankology_titles_bp_groups_desc_callback()
{
    if (is_plugin_active('buddypress/bp-loader.php') || is_plugin_active('buddyboss-platform/bp-loader.php')) {
        $options = get_option('rankology_titles_option_name'); ?>
                <p>
                    <?php esc_html_e('Meta description template', 'wp-rankology'); ?>
                </p>

                <?php $check = isset($options['rankology_titles_bp_groups_desc']) ? $options['rankology_titles_bp_groups_desc'] : null; ?>

                <textarea
                    name="rankology_titles_option_name[rankology_titles_bp_groups_desc]"><?php esc_html($check); ?></textarea>

                <?php
    }
}

function rankology_titles_bp_groups_noindex_callback()
{
    if (is_plugin_active('buddypress/bp-loader.php') || is_plugin_active('buddyboss-platform/bp-loader.php')) {
        $options = get_option('rankology_titles_option_name');

        $check = isset($options['rankology_titles_bp_groups_noindex']); ?>

                <label for="rankology_titles_bp_groups_noindex">
                    <input id="rankology_titles_bp_groups_noindex"
                        name="rankology_titles_option_name[rankology_titles_bp_groups_noindex]" type="checkbox" <?php if ('1' == $check) { ?>
                    checked="yes"
                    <?php } ?>
                    value="1"/>

                    <?php esc_html_e('Exclude BuddyPress groups from search engine results <strong>(noindex)</strong>', 'wp-rankology'); ?>
                </label>

                <?php if (isset($options['rankology_titles_bp_groups_noindex'])) {
            esc_attr($options['rankology_titles_bp_groups_noindex']);
        }
    }
}

//Taxonomies
function rankology_titles_tax_titles_callback()
{

    $taxonomies = rankology_get_service('WordPressData')->getTaxonomies();
    foreach ($taxonomies as $rankology_tax_key => $rankology_tax_value) { ?>
                <h3>
                    <?php echo rankology_common_esc_str($rankology_tax_value->labels->name); ?>
                    <em>
                        <small>(<?php echo rankology_common_esc_str($rankology_tax_value->name); ?>)</small>
                    </em>


                <!--Single on/off Tax-->
                <div class="rankology_wrap_tax">
                    <?php
        $options = get_option('rankology_titles_option_name');

        $check = isset($options['rankology_titles_tax_titles'][$rankology_tax_key]['enable']) ? $options['rankology_titles_tax_titles'][$rankology_tax_key]['enable'] : null;
        ?>
                    <input
                        id="rankology_titles_tax_titles_enable[<?php echo rankology_common_esc_str($rankology_tax_key); ?>]"
                        data-id=<?php echo rankology_common_esc_str($rankology_tax_key); ?>
                    name="rankology_titles_option_name[rankology_titles_tax_titles][<?php echo rankology_common_esc_str($rankology_tax_key); ?>][enable]"
                    class="toggle" type="checkbox"
                    <?php if ('1' == $check) { ?>
                    checked="yes" data-toggle="0"
                    <?php } else { ?>
                    data-toggle="1"
                    <?php } ?>
                    value="1"/>

                    <label
                        for="rankology_titles_tax_titles_enable[<?php echo rankology_common_esc_str($rankology_tax_key); ?>]">
                        <?php esc_html_e('Click to hide any SEO metaboxes for this taxonomy', 'wp-rankology'); ?>
                    </label>
					<?php
					// Assuming $rankology_tax_key and $options are defined earlier in the code
					$check = isset($options['rankology_titles_tax_titles'][$rankology_tax_key]['title']) ? $options['rankology_titles_tax_titles'][$rankology_tax_key]['title'] : null;
					$toggle_txt_on  = '<span class="dashicons dashicons-visibility"></span>' . esc_html__('Click to display any SEO metaboxes for this taxonomy', 'wp-rankology');
					$toggle_txt_off = '<span class="dashicons dashicons-visibility"></span>' . esc_html__('Click to hide any SEO metaboxes for this taxonomy', 'wp-rankology');
					?>

					<div class="rankology_wrap_tax">
						<h3>
							<?php if ('1' == $check) { ?>
								<span id="titles-state-default" class="feature-state">
									<span class="dashicons dashicons-visibility"></span>
									<?php esc_html_e('Click to display any SEO metaboxes for this taxonomy', 'wp-rankology'); ?>
								</span>
								<span id="titles-state" class="feature-state feature-state-off">
									<span class="dashicons dashicons-visibility"></span>
									<?php esc_html_e('Click to hide any SEO metaboxes for this taxonomy', 'wp-rankology'); ?>
								</span>
							<?php } else { ?>
								<span id="titles-state-default" class="feature-state">
									<span class="dashicons dashicons-visibility"></span>
									<?php esc_html_e('Click to hide any SEO metaboxes for this taxonomy', 'wp-rankology'); ?>
								</span>
								<span id="titles-state" class="feature-state feature-state-off">
									<span class="dashicons dashicons-visibility"></span>
									<?php esc_html_e('Click to display any SEO metaboxes for this taxonomy', 'wp-rankology'); ?>
								</span>
							<?php } ?>
						</h3>

						<p>
							<?php esc_html_e('Title template', 'wp-rankology'); ?>
						</p>
					</div>

					<?php
					// Localize script for use in JavaScript
					wp_register_script('rankology-toggle-script', false); // Register a dummy handle
					wp_enqueue_script('rankology-toggle-script');
					wp_add_inline_script('rankology-toggle-script', "
						jQuery(document).ready(function($) {
							var toggleTxtOn = '" . wp_kses_post($toggle_txt_on) . "';
							var toggleTxtOff = '" . wp_kses_post($toggle_txt_off) . "';

							$('input[data-id=" . esc_js($rankology_tax_key) . "]').on('click', function() {
								var \$this = $(this);
								\$this.attr('data-toggle', \$this.attr('data-toggle') == '1' ? '0' : '1');
								var newText = \$this.attr('data-toggle') == '1' ? toggleTxtOff : toggleTxtOn;
								\$this.next().next('.feature-state').html(newText);
							});
						});
					");
					
			add_action('admin_enqueue_scripts', function() {
                wp_enqueue_script('jquery');
				
				// Register a dummy script handle
				wp_register_script('rankology-inline-scripts', false);
				wp_enqueue_script('rankology-inline-scripts');

				// Prepare the inline script
				$rankology_tax_key = rankology_common_esc_str($rankology_tax_key); // Ensure escaping is done before using the variable
				$inline_script = "
					jQuery(document).ready(function($) {
						$('#rankology-tag-tax-title-{$rankology_tax_key}')
							.click(function() {
								$('#rankology_titles_tax_titles_{$rankology_tax_key}')
									.val(rankology_rkseo_get_field_length($('#rankology_titles_tax_titles_{$rankology_tax_key}')) + 
									$('#rankology-tag-tax-title-{$rankology_tax_key}').attr('data-tag'));
							});
						$('#rankology-tag-sep-{$rankology_tax_key}')
							.click(function() {
								$('#rankology_titles_tax_titles_{$rankology_tax_key}')
									.val(rankology_rkseo_get_field_length($('#rankology_titles_tax_titles_{$rankology_tax_key}')) + 
									$('#rankology-tag-sep-{$rankology_tax_key}').attr('data-tag'));
							});
						$('#rankology-tag-tax-sitetitle-{$rankology_tax_key}')
							.click(function() {
								$('#rankology_titles_tax_titles_{$rankology_tax_key}')
									.val(rankology_rkseo_get_field_length($('#rankology_titles_tax_titles_{$rankology_tax_key}')) + 
									$('#rankology-tag-tax-sitetitle-{$rankology_tax_key}').attr('data-tag'));
							});
					});
				";
				wp_add_inline_script('rankology-inline-scripts', $inline_script);
            });

					printf(
				'<input type="text" id="rankology_titles_tax_titles_%1$s" name="rankology_titles_option_name[rankology_titles_tax_titles][%1$s][title]" value="%2$s"/>',
				esc_attr($rankology_tax_key),
				esc_attr($check)
			);

        if ('category' == $rankology_tax_key) { ?>
                    <div class=" wrap-tags">
                        <button type="button"
                            id="rankology-tag-tax-title-<?php echo rankology_common_esc_str($rankology_tax_key); ?>"
                            data-tag="%%_category_title%%" class="btn btnSecondary tag-title">
                            <span class="dashicons dashicons-tag"></span>
                            <?php esc_html_e('Category Title', 'wp-rankology'); ?>
                        </button>
        <?php } 
		elseif ('post_tag' == $rankology_tax_key) { ?>
                        <div class="wrap-tags">
                            <button type="button" class="btn btnSecondary tag-title"
                                id="rankology-tag-tax-title-<?php echo rankology_common_esc_str($rankology_tax_key); ?>"
                                data-tag="%%tag_title%%">
                                <span class="dashicons dashicons-tag"></span>
                                <?php esc_html_e('Tag Title', 'wp-rankology'); ?>
                            </button>
                            <?php } else { ?>
                            <div class="wrap-tags">
                                <button type="button" class="btn btnSecondary tag-title"
                                    id="rankology-tag-tax-title-<?php echo rankology_common_esc_str($rankology_tax_key); ?>"
                                    data-tag="%%term_title%%">
                                    <span class="dashicons dashicons-tag"></span>
                                    <?php esc_html_e('Term Title', 'wp-rankology'); ?>
                                </button>
                                <?php } ?>

                                <button type="button" class="btn btnSecondary tag-title"
                                    id="rankology-tag-sep-<?php echo rankology_common_esc_str($rankology_tax_key); ?>"
                                    data-tag="%%sep%%">
                                    <span class="dashicons dashicons-tag"></span>
                                    <?php esc_html_e('Separator', 'wp-rankology'); ?>
                                </button>

                                <button type="button" class="btn btnSecondary tag-title"
                                    id="rankology-tag-tax-sitetitle-<?php echo rankology_common_esc_str($rankology_tax_key); ?>"
                                    data-tag="%%sitetitle%%">
                                    <span class="dashicons dashicons-tag"></span>
                                    <?php esc_html_e('Site Title', 'wp-rankology'); ?>
                                </button>

                                <?php echo rankology_render_dyn_variables('tag-title'); ?>
                            </div>

                            <!--Tax Meta Description-->
                            <div class="rankology_wrap_tax">
                                <?php $check2 = isset($options['rankology_titles_tax_titles'][$rankology_tax_key]['description']) ? $options['rankology_titles_tax_titles'][$rankology_tax_key]['description'] : null; ?>

                                <p>
                                    <?php esc_html_e('Meta description template', 'wp-rankology'); ?>
                                </p>

                                <?php
        printf(
            '<textarea id="rankology_titles_tax_desc_' . $rankology_tax_key . '" name="rankology_titles_option_name[rankology_titles_tax_titles][' . $rankology_tax_key . '][description]">%s</textarea>',
            esc_html($check2)
        );
?>
                                <?php if ('category' == $rankology_tax_key) { ?>
                                <div class="wrap-tags">
                                    <button type="button" class="btn btnSecondary tag-title"
                                        id="rankology-tag-tax-desc-<?php echo rankology_common_esc_str($rankology_tax_key); ?>"
                                        data-tag="%%_category_description%%">
                                        <span class="dashicons dashicons-tag"></span>
                                        <?php esc_html_e('Category Description', 'wp-rankology'); ?>
                                    </button>
                                    <?php } elseif ('post_tag' == $rankology_tax_key) { ?>
                                    <div class="wrap-tags">
                                        <button type="button" class="btn btnSecondary tag-title"
                                            id="rankology-tag-tax-desc-<?php echo rankology_common_esc_str($rankology_tax_key); ?>"
                                            data-tag="%%tag_description%%">
                                            <span class="dashicons dashicons-tag"></span>
                                            <?php esc_html_e('Tag Description', 'wp-rankology'); ?>
                                        </button>
                                        <?php } else { ?>
                                        <div class="wrap-tags">
                                            <button type="button" class="btn btnSecondary tag-title"
                                                id="rankology-tag-tax-desc-<?php echo rankology_common_esc_str($rankology_tax_key); ?>"
                                                data-tag="%%term_description%%">
                                                <span class="dashicons dashicons-tag"></span>
                                                <?php esc_html_e('Term Description', 'wp-rankology'); ?>
                                            </button>
                                            <?php } echo esc_html(rankology_render_dyn_variables('tag-description')); ?>

                                        </div>

                                        <!--Tax No-Index-->
                                        <div class="rankology_wrap_tax">

                                            <?php $options = get_option('rankology_titles_option_name');

        $check = isset($options['rankology_titles_tax_titles'][$rankology_tax_key]['noindex']); ?>


                                            <label
                                                for="rankology_titles_tax_noindex[<?php echo rankology_common_esc_str($rankology_tax_key); ?>]">
                                                <input
                                                    id="rankology_titles_tax_noindex[<?php echo rankology_common_esc_str($rankology_tax_key); ?>]"
                                                    name="rankology_titles_option_name[rankology_titles_tax_titles][<?php echo rankology_common_esc_str($rankology_tax_key); ?>][noindex]"
                                                    type="checkbox" <?php if ('1' == $check) { ?>
                                                checked="yes"
                                                <?php } ?>
                                                value="1"/>
                                                <?php esc_html_e('Exclude this taxonomy archive from search engine results <strong>(noindex)</strong>', 'wp-rankology'); ?>
                                                
                                            </label>

                                            <?php $tax_in_sitemap = rankology_get_service('SitemapOption')->getTaxonomiesList();

        if ('1' == $check && isset($tax_in_sitemap[$rankology_tax_key]) && '1' === $tax_in_sitemap[$rankology_tax_key]['include']) { ?>
                                            <div class="rankology-notice is-error">
                                                <p>
                                                    <?php esc_html_e('This custom taxonomy is <strong>NOT</strong> excluded from your XML sitemaps despite the fact that it is set to <strong>NOINDEX</strong>. We recommend that you check this out.', 'wp-rankology'); ?>
                                                </p>
                                            </div>
                                            <?php }

        if (isset($options['rankology_titles_tax_titles'][$rankology_tax_key]['noindex'])) {
            esc_attr($options['rankology_titles_tax_titles'][$rankology_tax_key]['noindex']);
        } ?>

                                        </div>

                                        <!--Tax No-Follow-->
                                        <div class="rankology_wrap_tax">

                                            <?php
        $options = get_option('rankology_titles_option_name');

        $check = isset($options['rankology_titles_tax_titles'][$rankology_tax_key]['nofollow']);
        ?>


                                            <label
                                                for="rankology_titles_tax_nofollow[<?php echo rankology_common_esc_str($rankology_tax_key); ?>]">
                                                <input
                                                    id="rankology_titles_tax_nofollow[<?php echo rankology_common_esc_str($rankology_tax_key); ?>]"
                                                    name="rankology_titles_option_name[rankology_titles_tax_titles][<?php echo rankology_common_esc_str($rankology_tax_key); ?>][nofollow]"
                                                    type="checkbox" <?php if ('1' == $check) { ?>
                                                checked="yes"
                                                <?php } ?>
                                                value="1"/>
                                                <?php esc_html_e('Do not follow links for this taxonomy archive <strong>(nofollow)</strong>', 'wp-rankology'); ?>
                                            </label>

                                            <?php if (isset($options['rankology_titles_tax_titles'][$rankology_tax_key]['nofollow'])) {
            esc_attr($options['rankology_titles_tax_titles'][$rankology_tax_key]['nofollow']);
        } ?>

                                        </div>
                                        <?php
    }
}

function rankology_titles_archives_titles_callback() {
    $options = get_option('rankology_titles_option_name');
    $postTypes = rankology_get_service('WordPressData')->getPostTypes();

    foreach ($postTypes as $rankology_cpt_key => $rankology_cpt_value) {
        if (!in_array($rankology_cpt_key, ['post', 'page'])) {
            $check = isset($options['rankology_titles_archive_titles'][$rankology_cpt_key]['title']) ? $options['rankology_titles_archive_titles'][$rankology_cpt_key]['title'] : null;
            ?>
            <h3><?php echo rankology_common_esc_str($rankology_cpt_value->labels->name); ?>
                <em><small>(<?php echo rankology_common_esc_str($rankology_cpt_value->name); ?>)</small></em>

                <?php if (get_post_type_archive_link($rankology_cpt_value->name)) { ?>
                <span class="link-archive">
                    <span class="dashicons dashicons-redo"></span>
                    <a href="<?php echo get_post_type_archive_link($rankology_cpt_value->name); ?>" target="_blank">
                        <?php esc_html_e('See archive', 'wp-rankology'); ?>
                    </a>
                </span>
                <?php } ?>
            </h3>

            <!-- Archive Title CPT -->
            <div class="rankology_wrap_archive_cpt">
                <p><?php esc_html_e('Title template', 'wp-rankology'); ?></p>
                <?php printf(
                    '<input type="text" id="rankology_titles_archive_titles_%s"
                    name="rankology_titles_option_name[rankology_titles_archive_titles][%s][title]"
                    value="%s" />',
                    esc_attr($rankology_cpt_key),
                    esc_attr($rankology_cpt_key),
                    esc_attr($check)
                ); ?>
                <div class="wrap-tags">
                    <button type="button" class="btn btnSecondary tag-title"
                            id="rankology-tag-archive-title-<?php echo esc_attr($rankology_cpt_key); ?>"
                            data-tag="%%cpt_plural%%">
                        <span class="dashicons dashicons-tag"></span><?php esc_html_e('Post Type Archive Name', 'wp-rankology'); ?>
                    </button>
                    <button type="button" class="btn btnSecondary tag-title"
                            id="rankology-tag-archive-sep-<?php echo esc_attr($rankology_cpt_key); ?>"
                            data-tag="%%sep%%">
                        <span class="dashicons dashicons-tag"></span><?php esc_html_e('Separator', 'wp-rankology'); ?>
                    </button>
                    <button type="button" class="btn btnSecondary tag-title"
                            id="rankology-tag-archive-sitetitle-<?php echo esc_attr($rankology_cpt_key); ?>"
                            data-tag="%%sitetitle%%">
                        <span class="dashicons dashicons-tag"></span><?php esc_html_e('Site Title', 'wp-rankology'); ?>
                    </button>
                    <?php echo rankology_render_dyn_variables('tag-title'); ?>
                </div>
            </div>

            <!-- Archive Meta Description CPT -->
            <div class="rankology_wrap_archive_cpt">
                <p><?php esc_html_e('Meta description template', 'wp-rankology'); ?></p>
                <?php $check = isset($options['rankology_titles_archive_titles'][$rankology_cpt_key]['description']) ? $options['rankology_titles_archive_titles'][$rankology_cpt_key]['description'] : null; ?>
                <?php printf(
                    '<textarea name="rankology_titles_option_name[rankology_titles_archive_titles][%s][description]">%s</textarea>',
                    esc_attr($rankology_cpt_key),
                    esc_textarea($check)
                ); ?>
                <div class="wrap-tags">
                    <?php echo rankology_render_dyn_variables('tag-description'); ?>
                </div>
            </div>

            <!-- Archive No-Index CPT -->
            <div class="rankology_wrap_archive_cpt">
                <?php
                $check = isset($options['rankology_titles_archive_titles'][$rankology_cpt_key]['noindex']); ?>
                <label for="rankology_titles_archive_cpt_noindex_<?php echo esc_attr($rankology_cpt_key); ?>">
                    <input id="rankology_titles_archive_cpt_noindex_<?php echo esc_attr($rankology_cpt_key); ?>"
                           name="rankology_titles_option_name[rankology_titles_archive_titles][<?php echo esc_attr($rankology_cpt_key); ?>][noindex]"
                           type="checkbox" <?php checked($check, '1'); ?> value="1"/>
                    <?php esc_html_e('Exclude this post type archive from search engine results <strong>(noindex)</strong>', 'wp-rankology'); ?>
                </label>
            </div>

            <!-- Archive No-Follow CPT -->
            <div class="rankology_wrap_archive_cpt">
                <?php
                $check = isset($options['rankology_titles_archive_titles'][$rankology_cpt_key]['nofollow']); ?>
                <label for="rankology_titles_archive_cpt_nofollow_<?php echo esc_attr($rankology_cpt_key); ?>">
                    <input id="rankology_titles_archive_cpt_nofollow_<?php echo esc_attr($rankology_cpt_key); ?>"
                           name="rankology_titles_option_name[rankology_titles_archive_titles][<?php echo esc_attr($rankology_cpt_key); ?>][nofollow]"
                           type="checkbox" <?php checked($check, '1'); ?> value="1"/>
                    <?php esc_html_e('Do not follow links for this post type archive <strong>(nofollow)</strong>', 'wp-rankology'); ?>
                </label>
            </div>
            <?php
        }
    }
}

function rankology_enqueue_admin_scripts() {
    wp_enqueue_script('rankology-admin-js', plugin_dir_url(__FILE__) . 'assets/js/rankology-common-admin.js', array('jquery'), '1.0.0', true);

    // Pass dynamic data to JavaScript
    $postTypes = rankology_get_service('WordPressData')->getPostTypes();
    $data = array();
    foreach ($postTypes as $rankology_cpt_key => $rankology_cpt_value) {
        if (!in_array($rankology_cpt_key, ['post', 'page'])) {
            $data[$rankology_cpt_key] = array(
                'id_title' => 'rankology_titles_archive_titles_' . esc_attr($rankology_cpt_key),
                'tags' => array(
                    'title' => '%%cpt_plural%%',
                    'sep' => '%%sep%%',
                    'sitetitle' => '%%sitetitle%%'
                )
            );
        }
    }
    wp_localize_script('rankology-admin-js', 'rankologyData', array('postTypes' => $data));
}
add_action('admin_enqueue_scripts', 'rankology_enqueue_admin_scripts');



function rankology_titles_archives_author_title_callback()
{
    $options = get_option('rankology_titles_option_name'); ?>
                                                <h3>
                                                    <?php esc_html_e('Author archives', 'wp-rankology'); ?>
                                                </h3>

                                                <p>
                                                    <?php esc_html_e('Title template', 'wp-rankology'); ?>
                                                </p>

                                                <?php $check = isset($options['rankology_titles_archives_author_title']) ? $options['rankology_titles_archives_author_title'] : null; ?>

                                                <input id="rankology_titles_archive_post_author" type="text"
                                                    name="rankology_titles_option_name[rankology_titles_archives_author_title]"
                                                    value="<?php esc_html($check); ?>" />

                                                <div class="wrap-tags">
                                                    <button type="button" class="btn btnSecondary tag-title" id="rankology-tag-post-author" data-tag="%%post_author%%">
                                                        <span class="dashicons dashicons-tag"></span>
                                                        <?php esc_html_e('Post author', 'wp-rankology'); ?>
                                                    </button>
                                                    <button type="button" class="btn btnSecondary tag-title" id="rankology-tag-sep-author" data-tag="%%sep%%">
                                                        <span class="dashicons dashicons-tag"></span>
                                                        <?php esc_html_e('Separator', 'wp-rankology'); ?>
                                                    </button>

                                                    <button type="button" class="btn btnSecondary tag-title" id="rankology-tag-site-title-author" data-tag="%%sitetitle%%">
                                                        <span class="dashicons dashicons-tag"></span>
                                                        <?php esc_html_e('Site Title', 'wp-rankology'); ?>
                                                    </button>

                                                    <?php
        echo rankology_render_dyn_variables('tag-title');
}

function rankology_titles_archives_author_desc_callback()
{
    $options = get_option('rankology_titles_option_name'); ?>
                                                    <p>
                                                        <?php esc_html_e('Meta description template', 'wp-rankology'); ?>
                                                    </p>

                                                    <?php $check = isset($options['rankology_titles_archives_author_desc']) ? $options['rankology_titles_archives_author_desc'] : null; ?>

                                                    <textarea
                                                        name="rankology_titles_option_name[rankology_titles_archives_author_desc]"><?php esc_html($check); ?></textarea>

                                                    <?php
}

function rankology_titles_archives_author_noindex_callback()
{
    $options = get_option('rankology_titles_option_name');

    $check = isset($options['rankology_titles_archives_author_noindex']); ?>


                                                    <label for="rankology_titles_archives_author_noindex">
                                                        <input id="rankology_titles_archives_author_noindex"
                                                            name="rankology_titles_option_name[rankology_titles_archives_author_noindex]"
                                                            type="checkbox" <?php if ('1' == $check) { ?>
                                                        checked="yes"
                                                        <?php } ?>
                                                        value="1"/>
                                                        <?php esc_html_e('Exclude author archives from search engine results <strong>(noindex)</strong>', 'wp-rankology'); ?>
                                                    </label>

                                                    <?php if (isset($options['rankology_titles_archives_author_noindex'])) {
        esc_attr($options['rankology_titles_archives_author_noindex']);
    }
}

function rankology_titles_archives_author_disable_callback()
{
    $options = get_option('rankology_titles_option_name');

    $check = isset($options['rankology_titles_archives_author_disable']); ?>

                                                    <label for="rankology_titles_archives_author_disable">
                                                        <input id="rankology_titles_archives_author_disable"
                                                            name="rankology_titles_option_name[rankology_titles_archives_author_disable]"
                                                            type="checkbox" <?php if ('1' == $check) { ?>
                                                        checked="yes"
                                                        <?php } ?>
                                                        value="1"/>
                                                        <?php esc_html_e('Disable author archives', 'wp-rankology'); ?>
                                                    </label>

                                                    <?php if (isset($options['rankology_titles_archives_author_disable'])) {
        esc_attr($options['rankology_titles_archives_author_disable']);
    }
}

function rankology_titles_archives_date_title_callback()
{
    $options = get_option('rankology_titles_option_name'); ?>
                                                    <h3>
                                                        <?php esc_html_e('Date archives', 'wp-rankology'); ?>
                                                    </h3>

                                                    <p>
                                                        <?php esc_html_e('Title template', 'wp-rankology'); ?>
                                                    </p>

                                                    <?php $check = isset($options['rankology_titles_archives_date_title']) ? $options['rankology_titles_archives_date_title'] : null; ?>

                                                    <input id="rankology_titles_archives_date_title" type="text"
                                                        name="rankology_titles_option_name[rankology_titles_archives_date_title]"
                                                        value="<?php esc_html($check); ?>" />

                                                    <div class="wrap-tags">
                                                        <button type="button" class="btn btnSecondary tag-title" id="rankology-tag-archive-date" data-tag="%%archive_date%%">
                                                            <span class="dashicons dashicons-tag"></span>
                                                            <?php esc_html_e('Date archives', 'wp-rankology'); ?>
                                                        </button>
                                                        <button type="button" class="btn btnSecondary tag-title" id="rankology-tag-sep-date" data-tag="%%sep%%">
                                                            <span class="dashicons dashicons-tag"></span>
                                                            <?php esc_html_e('Separator', 'wp-rankology'); ?>
                                                        </button>
                                                        <button type="button" class="btn btnSecondary tag-title" id="rankology-tag-site-title-date" data-tag="%%sitetitle%%">
                                                            <span class="dashicons dashicons-tag"></span>
                                                            <?php esc_html_e('Site Title', 'wp-rankology'); ?>
                                                        </button>
                                                        <?php
    echo rankology_render_dyn_variables('tag-title');
}

function rankology_titles_archives_date_desc_callback()
{
    $options = get_option('rankology_titles_option_name'); ?>

                                                        <p>
                                                            <?php esc_html_e('Meta description template', 'wp-rankology'); ?>
                                                        </p>

                                                        <?php $check = isset($options['rankology_titles_archives_date_desc']) ? $options['rankology_titles_archives_date_desc'] : null; ?>

                                                        <textarea
                                                            name="rankology_titles_option_name[rankology_titles_archives_date_desc]"><?php esc_html($check); ?></textarea>

                                                        <?php
}

function rankology_titles_archives_date_noindex_callback()
{
    $options = get_option('rankology_titles_option_name');

    $check = isset($options['rankology_titles_archives_date_noindex']); ?>

                                                        <label for="rankology_titles_archives_date_noindex">
                                                            <input id="rankology_titles_archives_date_noindex"
                                                                name="rankology_titles_option_name[rankology_titles_archives_date_noindex]"
                                                                type="checkbox" <?php if ('1' == $check) { ?>
                                                            checked="yes"
                                                            <?php } ?>
                                                            value="1"/>
                                                            <?php esc_html_e('Exclude date archives from search engine results <strong>(noindex)</strong>', 'wp-rankology'); ?>
                                                        </label>

                                                        <?php if (isset($options['rankology_titles_archives_date_noindex'])) {
        esc_attr($options['rankology_titles_archives_date_noindex']);
    }
}

function rankology_titles_archives_date_disable_callback()
{
    $options = get_option('rankology_titles_option_name');

    $check = isset($options['rankology_titles_archives_date_disable']); ?>


                                                        <label for="rankology_titles_archives_date_disable">
                                                            <input id="rankology_titles_archives_date_disable"
                                                                name="rankology_titles_option_name[rankology_titles_archives_date_disable]"
                                                                type="checkbox" <?php if ('1' == $check) { ?>
                                                            checked="yes"
                                                            <?php } ?>
                                                            value="1"/>
                                                            <?php esc_html_e('Disable date archives', 'wp-rankology'); ?>
                                                        </label>

                                                        <?php if (isset($options['rankology_titles_archives_date_disable'])) {
        esc_attr($options['rankology_titles_archives_date_disable']);
    }
}

function rankology_titles_archives_search_title_callback()
{
    $options = get_option('rankology_titles_option_name'); ?>
                                                        <h3>
                                                            <?php esc_html_e('Search archives', 'wp-rankology'); ?>
                                                        </h3>

                                                        <p>
                                                            <?php esc_html_e('Title template', 'wp-rankology'); ?>
                                                        </p>

                                                        <?php $check = isset($options['rankology_titles_archives_search_title']) ? $options['rankology_titles_archives_search_title'] : null; ?>

                                                        <input id="rankology_titles_archives_search_title" type="text"
                                                            name="rankology_titles_option_name[rankology_titles_archives_search_title]"
                                                            value="<?php esc_html($check); ?>" />

                                                        <div class="wrap-tags">
                                                            <button type="button" class="btn btnSecondary tag-title" id="rankology-tag-search-keywords" data-tag="%%search_keywords%%">
                                                                <span class="dashicons dashicons-tag"></span>
                                                                <?php esc_html_e('Search Keywords', 'wp-rankology'); ?>
                                                            </button>

                                                            <button type="button" class="btn btnSecondary tag-title" id="rankology-tag-sep-search" data-tag="%%sep%%">
                                                                <span class="dashicons dashicons-tag"></span>
                                                                <?php esc_html_e('Separator', 'wp-rankology'); ?>
                                                            </button>

                                                            <button type="button" class="btn btnSecondary tag-title" id="rankology-tag-site-title-search" data-tag="%%sitetitle%%">
                                                                <span class="dashicons dashicons-tag"></span>
                                                                <?php esc_html_e('Site Title', 'wp-rankology'); ?>
                                                            </button>
                                                            <?php
    echo rankology_render_dyn_variables('tag-title');
}

function rankology_titles_archives_search_desc_callback()
{
    $options = get_option('rankology_titles_option_name'); ?>
                                                            <p>
                                                                <?php esc_html_e('Meta description template', 'wp-rankology'); ?>
                                                            </p>

                                                            <?php $check = isset($options['rankology_titles_archives_search_desc']) ? $options['rankology_titles_archives_search_desc'] : null; ?>

                                                            <textarea
                                                                name="rankology_titles_option_name[rankology_titles_archives_search_desc]"><?php esc_html($check); ?></textarea>

                                                            <?php
}

function rankology_titles_archives_search_title_noindex_callback()
{
    $options = get_option('rankology_titles_option_name');

    $check = isset($options['rankology_titles_archives_search_title_noindex']); ?>


                                                            <label for="rankology_titles_archives_search_title_noindex">
                                                                <input
                                                                    id="rankology_titles_archives_search_title_noindex"
                                                                    name="rankology_titles_option_name[rankology_titles_archives_search_title_noindex]"
                                                                    type="checkbox" <?php if ('1' == $check) { ?>
                                                                checked="yes"
                                                                <?php } ?>
                                                                value="1"/>
                                                                <?php esc_html_e('Exclude search archives from search engine results <strong>(noindex)</strong>', 'wp-rankology'); ?>
                                                            </label>

                                                            <?php if (isset($options['rankology_titles_archives_search_title_noindex'])) {
        esc_attr($options['rankology_titles_archives_search_title_noindex']);
    }
}

function rankology_titles_archives_404_title_callback()
{
    $options = get_option('rankology_titles_option_name'); ?>
                                                            <h3>
                                                                <?php esc_html_e('404 archives', 'wp-rankology'); ?>
                                                            </h3>

                                                            <p>
                                                                <?php esc_html_e('Title template', 'wp-rankology'); ?>
                                                            </p>

                                                            <?php $check = isset($options['rankology_titles_archives_404_title']) ? $options['rankology_titles_archives_404_title'] : null; ?>

                                                            <input id="rankology_titles_archives_404_title" type="text"
                                                                name="rankology_titles_option_name[rankology_titles_archives_404_title]"
                                                                value="<?php esc_html($check); ?>" />

                                                            <div class="wrap-tags">
                                                                <button type="button" class="btn btnSecondary tag-title" id="rankology-tag-site-title-404" data-tag="%%sitetitle%%">
                                                                    <span class="dashicons dashicons-tag"></span>
                                                                    <?php esc_html_e('Site Title', 'wp-rankology'); ?>
                                                                </button>
                                                                <button type="button" class="btn btnSecondary tag-title" id="rankology-tag-sep-404" data-tag="%%sep%%">
                                                                    <span class="dashicons dashicons-tag"></span>
                                                                    <?php esc_html_e('Separator', 'wp-rankology'); ?>
                                                                </button>
                                                                <?php
    echo rankology_render_dyn_variables('tag-title');
}

function rankology_titles_archives_404_desc_callback()
{
    $options = get_option('rankology_titles_option_name'); ?>

                                                                <p>
                                                                    <label for="rankology_titles_archives_404_desc">
                                                                        <?php esc_html_e('Meta description template', 'wp-rankology'); ?>
                                                                    </label>
                                                                </p>

                                                                <?php $check = isset($options['rankology_titles_archives_404_desc']) ? $options['rankology_titles_archives_404_desc'] : null; ?>

                                                                <textarea id="rankology_titles_archives_404_desc"
                                                                    name="rankology_titles_option_name[rankology_titles_archives_404_desc]"><?php esc_html($check); ?></textarea>

                                                                <?php
}

//Advanced
function rankology_titles_noindex_callback()
{
    $options = get_option('rankology_titles_option_name');

    $check = isset($options['rankology_titles_noindex']); ?>


                                                                <label for="rankology_titles_noindex">
                                                                    <input id="rankology_titles_noindex"
                                                                        name="rankology_titles_option_name[rankology_titles_noindex]"
                                                                        type="checkbox" <?php if ('1' == $check) { ?>
                                                                    checked="yes"
                                                                    <?php } ?>
                                                                    value="1"/>
                                                                    <?php esc_html_e('noindex', 'wp-rankology'); ?>
                                                                </label>

                                                                <p class="description">
                                                                    <?php esc_html_e('Exclude all pages from the site in Google search results and do not display "Cached" links in search results.', 'wp-rankology'); ?>
                                                                </p>

                                                                <p class="description">
                                                                    <?php printf(wp_kses(__('Check also the "Search engine visibility" setting from the <a href="%s">Admin Reading page</a>.', 'wp-rankology'), array('strong' => array(), 'a' => array('href' => array()))), admin_url('options-reading.php')); ?>
                                                                </p>

                                                                <?php if (isset($options['rankology_titles_noindex'])) {
        esc_attr($options['rankology_titles_noindex']);
    }
}

function rankology_titles_nofollow_callback()
{
    $options = get_option('rankology_titles_option_name');

    $check = isset($options['rankology_titles_nofollow']); ?>


                                                                <label for="rankology_titles_nofollow">
                                                                    <input id="rankology_titles_nofollow"
                                                                        name="rankology_titles_option_name[rankology_titles_nofollow]"
                                                                        type="checkbox" <?php if ('1' == $check) { ?>
                                                                    checked="yes"
                                                                    <?php } ?>
                                                                    value="1"/>
                                                                    <?php esc_html_e('nofollow', 'wp-rankology'); ?>
                                                                </label>

                                                                <p class="description">
                                                                    <?php esc_html_e('Do not follow links for all pages.', 'wp-rankology'); ?>
                                                                </p>

                                                                <?php if (isset($options['rankology_titles_nofollow'])) {
        esc_attr($options['rankology_titles_nofollow']);
    }
}

function rankology_titles_noimageindex_callback()
{
    $options = get_option('rankology_titles_option_name');

    $check = isset($options['rankology_titles_noimageindex']); ?>


                                                                <label for="rankology_titles_noimageindex">
                                                                    <input id="rankology_titles_noimageindex"
                                                                        name="rankology_titles_option_name[rankology_titles_noimageindex]"
                                                                        type="checkbox" <?php if ('1' == $check) { ?>
                                                                    checked="yes"
                                                                    <?php } ?>
                                                                    value="1"/>
                                                                    <?php esc_html_e('noimageindex', 'wp-rankology'); ?>
                                                                </label>

                                                                <p class="description">
                                                                    <?php esc_html_e('Do not index images from the entire site.', 'wp-rankology'); ?>
                                                                </p>

                                                                <?php if (isset($options['rankology_titles_noimageindex'])) {
        esc_attr($options['rankology_titles_noimageindex']);
    }
}

function rankology_titles_noarchive_callback()
{
    $options = get_option('rankology_titles_option_name');

    $check = isset($options['rankology_titles_noarchive']); ?>

                                                                <label for="rankology_titles_noarchive">
                                                                    <input id="rankology_titles_noarchive"
                                                                        name="rankology_titles_option_name[rankology_titles_noarchive]"
                                                                        type="checkbox" <?php if ('1' == $check) { ?>
                                                                    checked="yes"
                                                                    <?php } ?>
                                                                    value="1"/>
                                                                    <?php esc_html_e('noarchive', 'wp-rankology'); ?>
                                                                </label>

                                                                <p class="description">
                                                                    <?php esc_html_e('Exclude a "Cached" link in the Google search results.', 'wp-rankology'); ?>
                                                                </p>

                                                                <?php if (isset($options['rankology_titles_noarchive'])) {
        esc_attr($options['rankology_titles_noarchive']);
    }
}

function rankology_titles_nosnippet_callback()
{
    $options = get_option('rankology_titles_option_name');

    $check = isset($options['rankology_titles_nosnippet']); ?>


                                                                <label for="rankology_titles_nosnippet">
                                                                    <input id="rankology_titles_nosnippet"
                                                                        name="rankology_titles_option_name[rankology_titles_nosnippet]"
                                                                        type="checkbox" <?php if ('1' == $check) { ?>
                                                                    checked="yes"
                                                                    <?php } ?>
                                                                    value="1"/>
                                                                    <?php esc_html_e('nosnippet', 'wp-rankology'); ?>
                                                                </label>

                                                                <p class="description">
                                                                    <?php esc_html_e('Exclude a description in the Google search results for all pages.', 'wp-rankology'); ?>
                                                                </p>

                                                                <?php if (isset($options['rankology_titles_nosnippet'])) {
        esc_attr($options['rankology_titles_nosnippet']);
    }
}

function rankology_titles_nositelinkssearchbox_callback()
{
    $options = get_option('rankology_titles_option_name');

    $check = isset($options['rankology_titles_nositelinkssearchbox']); ?>


                                                                <label for="rankology_titles_nositelinkssearchbox">
                                                                    <input id="rankology_titles_nositelinkssearchbox"
                                                                        name="rankology_titles_option_name[rankology_titles_nositelinkssearchbox]"
                                                                        type="checkbox" <?php if ('1' == $check) { ?>
                                                                    checked="yes"
                                                                    <?php } ?>
                                                                    value="1"/>
                                                                    <?php esc_html_e('nositelinkssearchbox', 'wp-rankology'); ?>
                                                                </label>

                                                                <p class="description">
                                                                    <?php esc_html_e('Prevents Google to display a sitelinks searchbox in search results. Enable this option will remove the "Website" schema from your source code.', 'wp-rankology'); ?>
                                                                </p>

                                                                <?php if (isset($options['rankology_titles_nositelinkssearchbox'])) {
        esc_attr($options['rankology_titles_nositelinkssearchbox']);
    }
}

function rankology_titles_paged_rel_callback()
{
    $options = get_option('rankology_titles_option_name');

    $check = isset($options['rankology_titles_paged_rel']); ?>


                                                                <label for="rankology_titles_paged_rel">
                                                                    <input id="rankology_titles_paged_rel"
                                                                        name="rankology_titles_option_name[rankology_titles_paged_rel]"
                                                                        type="checkbox" <?php if ('1' == $check) { ?>
                                                                    checked="yes"
                                                                    <?php } ?>
                                                                    value="1"/>
                                                                    <?php esc_html_e('Add rel next/prev link in head of paginated archive pages', 'wp-rankology'); ?>
                                                                </label>

                                                                <?php if (isset($options['rankology_titles_paged_rel'])) {
        esc_attr($options['rankology_titles_paged_rel']);
    }
}

function rankology_titles_paged_noindex_callback()
{
    $options = get_option('rankology_titles_option_name');

    $check = isset($options['rankology_titles_paged_noindex']); ?>

                                                                <label for="rankology_titles_paged_noindex">

                                                                    <input id="rankology_titles_paged_noindex"
                                                                        name="rankology_titles_option_name[rankology_titles_paged_noindex]"
                                                                        type="checkbox" <?php if ('1' == $check) { ?>
                                                                    checked="yes"
                                                                    <?php } ?>
                                                                    value="1"/>
                                                                    <?php esc_html_e('Add a "noindex" meta robots for all paginated archive pages', 'wp-rankology'); ?>
                                                                </label>

                                                                <p class="description">
                                                                    <?php esc_html_e('e.g. https://example.com/category/my-category/page/2/', 'wp-rankology'); ?>
                                                                </p>

                                                                <?php if (isset($options['rankology_titles_paged_noindex'])) {
        esc_attr($options['rankology_titles_paged_noindex']);
    }
}

function rankology_titles_attachments_noindex_callback()
{
    $options = get_option('rankology_titles_option_name');

    $check = isset($options['rankology_titles_attachments_noindex']); ?>


                                                                <label for="rankology_titles_attachments_noindex">
                                                                    <input id="rankology_titles_attachments_noindex"
                                                                        name="rankology_titles_option_name[rankology_titles_attachments_noindex]"
                                                                        type="checkbox" <?php if ('1' == $check) { ?>
                                                                    checked="yes"
                                                                    <?php } ?>
                                                                    value="1"/>
                                                                    <?php esc_html_e('Add a "noindex" meta robots for all attachment pages', 'wp-rankology'); ?>
                                                                </label>

                                                                <p class="description">
                                                                    <?php esc_html_e('e.g. https://example.com/my-media-attachment-page', 'wp-rankology'); ?>
                                                                </p>

                                                                <?php if (isset($options['rankology_titles_attachments_noindex'])) {
        esc_attr($options['rankology_titles_attachments_noindex']);
    }
}
