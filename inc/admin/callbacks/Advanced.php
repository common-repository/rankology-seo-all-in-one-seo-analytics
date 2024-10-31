<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

function rankology_advanced_advanced_replytocom_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_advanced_replytocom']); ?>

<label for="rankology_advanced_advanced_replytocom">
	<input id="rankology_advanced_advanced_replytocom"
		name="rankology_advanced_option_name[rankology_advanced_advanced_replytocom]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

    <?php esc_html_e('Remove ?replytocom link in source code and replace it with a simple anchor', 'wp-rankology'); ?>
</label>

<p class="description">
    <?php echo wp_kses(__( 'e.g. <code>https://www.example.com/my-blog-post/?replytocom=10#respond</code> => <code>#comment-10</code>', 'wp-rankology' ), array('code' => array())); ?>
</p>

<?php if (isset($options['rankology_advanced_advanced_replytocom'])) {
		esc_attr($options['rankology_advanced_advanced_replytocom']);
	}
}

function rankology_advanced_advanced_noreferrer_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_advanced_noreferrer']); ?>

<label for="rankology_advanced_advanced_noreferrer">
	<input id="rankology_advanced_advanced_noreferrer"
		name="rankology_advanced_option_name[rankology_advanced_advanced_noreferrer]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>
	<?php esc_html_e('Remove noreferrer link attribute in source code', 'wp-rankology'); ?>
</label>

<p class="description">
	<?php esc_html_e('Useful for affiliate links (e.g. Amazon).','wp-rankology'); ?>
</p>

<?php if (isset($options['rankology_advanced_advanced_noreferrer'])) {
		esc_attr($options['rankology_advanced_advanced_noreferrer']);
	}
}

function rankology_advanced_advanced_tax_desc_editor_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_advanced_tax_desc_editor']); ?>

<label for="rankology_advanced_advanced_tax_desc_editor">
	<input id="rankology_advanced_advanced_tax_desc_editor"
		name="rankology_advanced_option_name[rankology_advanced_advanced_tax_desc_editor]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>
	<?php esc_html_e('Add TINYMCE editor to term description', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_advanced_advanced_tax_desc_editor'])) {
		esc_attr($options['rankology_advanced_advanced_tax_desc_editor']);
	}
}

function rankology_advanced_advanced_category_url_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_advanced_category_url']); ?>

<label for="rankology_advanced_advanced_category_url">
	<input id="rankology_advanced_advanced_category_url"
		name="rankology_advanced_option_name[rankology_advanced_advanced_category_url]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>
	<?php
	$category_base = '/category/';
	if (get_option('category_base')) {
		$category_base = '/' . get_option('category_base');
	}

	printf(wp_kses(__('Remove <strong>%s</strong> in your permalinks', 'wp-rankology'), array('strong' => array())), $category_base); ?>
</label>

<p class="description">
	<?php echo wp_kses(__('e.g. <code>https://example.com/category/my-post-category/</code> => <code>https://example.com/my-post-category/</code>','wp-rankology'), array('code' => array())); ?>
</p>

<div class="rankology-notice">
	<p>
		<?php esc_html_e('You have to flush your permalinks each time you change this setting.', 'wp-rankology'); ?>
	</p>
</div>

<?php
	if (isset($options['rankology_advanced_advanced_category_url'])) {
		esc_attr($options['rankology_advanced_advanced_category_url']);
	}
}

function rankology_advanced_advanced_product_cat_url_callback() {
	if (is_plugin_active('woocommerce/woocommerce.php')) {
		$options = get_option('rankology_advanced_option_name');

		$check = isset($options['rankology_advanced_advanced_product_cat_url']);

		?>

	<label for="rankology_advanced_advanced_product_cat_url">
		<input id="rankology_advanced_advanced_product_cat_url"
			name="rankology_advanced_option_name[rankology_advanced_advanced_product_cat_url]" type="checkbox" <?php if ('1' == $check) { ?>
		checked="yes"
		<?php } ?>
		value="1"/>

		<?php
		$category_base = get_option('woocommerce_permalinks');
		$category_base = $category_base['category_base'];

		if ('' != $category_base) {
			$category_base = '/' . $category_base . '/';
		} else {
			$category_base = '/product-category/';
		}

		printf(wp_kses(__('Remove <strong>%s</strong> in your permalinks', 'wp-rankology'), array('strong' => array())), $category_base); ?>

	</label>

	<p class="description">
		<?php echo wp_kses(__('e.g. <code>https://example.com/product-category/my-product-category/</code> => <code>https://example.com/my-product-category/</code>','wp-rankology'), array('code' => array())); ?>
	</p>

	<div class="rankology-notice">
		<p>
			<?php esc_html_e('You have to flush your permalinks each time you change this setting.', 'wp-rankology'); ?>
		</p>
		<p>
			<?php esc_html_e('Make sure you don\'t have identical URLs after activating this option to prevent conflicts.', 'wp-rankology'); ?>
		</p>
	</div>

	<?php
		if (isset($options['rankology_advanced_advanced_product_cat_url'])) {
			esc_attr($options['rankology_advanced_advanced_product_cat_url']);
		}
	} else { ?>
		<div class="rankology-notice is-warning">
			<p>
				<?php esc_html_e('You need to enable WooCommerce to apply these settings.', 'wp-rankology'); ?>
			</p>
		</div>
		<?php
	}
}

function rankology_advanced_advanced_wp_generator_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_advanced_wp_generator']); ?>

<label for="rankology_advanced_advanced_wp_generator">
	<input id="rankology_advanced_advanced_wp_generator"
		name="rankology_advanced_option_name[rankology_advanced_advanced_wp_generator]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>
	<?php esc_html_e('Remove WordPress meta generator in source code', 'wp-rankology'); ?>
</label>

<pre><?php esc_attr_e('<meta name="generator" content="WordPress 6.2" />', 'wp-rankology'); ?></pre>

<?php if (isset($options['rankology_advanced_advanced_wp_generator'])) {
		esc_attr($options['rankology_advanced_advanced_wp_generator']);
	}
}

function rankology_advanced_advanced_hentry_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_advanced_hentry']); ?>

<label for="rankology_advanced_advanced_hentry">
	<input id="rankology_advanced_advanced_hentry"
		name="rankology_advanced_option_name[rankology_advanced_advanced_hentry]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Remove hentry post class to prevent Google from seeing this as structured data (schema)', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_advanced_advanced_hentry'])) {
		esc_attr($options['rankology_advanced_advanced_hentry']);
	}
}

function rankology_advanced_advanced_comments_author_url_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_advanced_comments_author_url']); ?>

<label for="rankology_advanced_advanced_comments_author_url">
	<input id="rankology_advanced_advanced_comments_author_url"
		name="rankology_advanced_option_name[rankology_advanced_advanced_comments_author_url]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Remove comment author URL in comments if the website is filled from profile page', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_advanced_advanced_comments_author_url'])) {
		esc_attr($options['rankology_advanced_advanced_comments_author_url']);
	}
}

function rankology_advanced_advanced_comments_website_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_advanced_comments_website']); ?>

<label for="rankology_advanced_advanced_comments_website">
	<input id="rankology_advanced_advanced_comments_website"
		name="rankology_advanced_option_name[rankology_advanced_advanced_comments_website]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Remove website field from comment form to reduce spam', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_advanced_advanced_comments_website'])) {
		esc_attr($options['rankology_advanced_advanced_comments_website']);
	}
}

function rankology_advanced_advanced_comments_form_link_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_advanced_comments_form_link']); ?>

<label for="rankology_advanced_advanced_comments_form_link">
	<input id="rankology_advanced_advanced_comments_form_link"
		name="rankology_advanced_option_name[rankology_advanced_advanced_comments_form_link]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

    <?php esc_html_e('Prevent search engines to follow / index the link to the comments form', 'wp-rankology'); ?>

</label>

<pre>https://www.example.com/my-blog-post/#respond</pre>

<?php if (isset($options['rankology_advanced_advanced_comments_form_link'])) {
		esc_attr($options['rankology_advanced_advanced_comments_form_link']);
	}
}

function rankology_advanced_advanced_wp_shortlink_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_advanced_wp_shortlink']); ?>

<label for="rankology_advanced_advanced_wp_shortlink">
	<input id="rankology_advanced_advanced_wp_shortlink"
		name="rankology_advanced_option_name[rankology_advanced_advanced_wp_shortlink]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Remove WordPress shortlink meta tag in source code', 'wp-rankology'); ?>
</label>

<pre><?php esc_attr_e('<link rel="shortlink" href="https://www.example.com/"/>', 'wp-rankology'); ?></pre>

<?php if (isset($options['rankology_advanced_advanced_wp_shortlink'])) {
		esc_attr($options['rankology_advanced_advanced_wp_shortlink']);
	}
}

function rankology_advanced_advanced_wp_wlw_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_advanced_wp_wlw']); ?>

<label for="rankology_advanced_advanced_wp_wlw">
	<input id="rankology_advanced_advanced_wp_wlw"
		name="rankology_advanced_option_name[rankology_advanced_advanced_wp_wlw]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Remove Windows Live Writer meta tag in source code', 'wp-rankology'); ?>
</label>

<pre><?php esc_attr_e('<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="https://www.example.com/wp-includes/wlwmanifest.xml" />', 'wp-rankology'); ?></pre>

<?php if (isset($options['rankology_advanced_advanced_wp_wlw'])) {
		esc_attr($options['rankology_advanced_advanced_wp_wlw']);
	}
}

function rankology_advanced_advanced_wp_rsd_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_advanced_wp_rsd']); ?>

<label for="rankology_advanced_advanced_wp_rsd">
	<input id="rankology_advanced_advanced_wp_rsd"
		name="rankology_advanced_option_name[rankology_advanced_advanced_wp_rsd]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Remove Really Simple Discovery meta tag in source code', 'wp-rankology'); ?>
</label>

<p class="description">
	<?php esc_html_e('WordPress Site Health feature will return a HTTPS warning if you enable this option. This is a false positive of course.', 'wp-rankology'); ?>
</p>

<pre><?php esc_attr_e('<link rel="EditURI" type="application/rsd+xml" title="RSD" href="https://www.example.com/xmlrpc.php?rsd" />', 'wp-rankology'); ?></pre>

<?php if (isset($options['rankology_advanced_advanced_wp_rsd'])) {
		esc_attr($options['rankology_advanced_advanced_wp_rsd']);
	}
}

function rankology_advanced_advanced_wp_oembed_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_advanced_wp_oembed']); ?>

<label for="rankology_advanced_advanced_wp_oembed">
	<input id="rankology_advanced_advanced_wp_oembed"
		name="rankology_advanced_option_name[rankology_advanced_advanced_wp_oembed]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Remove oEmbed links in source code', 'wp-rankology'); ?>
</label>

<p class="description">
	<?php esc_html_e('This will prevent other blogs to embed one of your posts on their site.', 'wp-rankology'); ?>
</p>

<pre><?php echo esc_attr__('<link rel="alternate" type="application/json+oembed" href="https://www.example.com/wp-json/oembed/1.0/embed?url=https://www.example.com/my-blog-post/" />', 'wp-rankology'); ?></pre>

<pre><?php echo esc_attr__('<link rel="alternate" type="text/xml+oembed" href="https://www.example.com/wp-json/oembed/1.0/embed?url=https://www.example.com/my-blog-post/&format=xml" />', 'wp-rankology'); ?></pre>

<?php if (isset($options['rankology_advanced_advanced_wp_oembed'])) {
		esc_attr($options['rankology_advanced_advanced_wp_oembed']);
	}
}

function rankology_advanced_advanced_wp_x_pingback_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_advanced_wp_x_pingback']); ?>

<label for="rankology_advanced_advanced_wp_x_pingback">
	<input id="rankology_advanced_advanced_wp_x_pingback"
		name="rankology_advanced_option_name[rankology_advanced_advanced_wp_x_pingback]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Remove X-Pingback from HTTP headers', 'wp-rankology'); ?>
</label>

<p class="description">
	<?php esc_html_e('This will disable pingbacks/trackbacks and increase security (DDOS).', 'wp-rankology'); ?>
</p>

<pre><?php esc_attr_e('X-Pingback: https://www.example.com/xmlrpc.php', 'wp-rankology'); ?></pre>

<?php if (isset($options['rankology_advanced_advanced_wp_x_pingback'])) {
		esc_attr($options['rankology_advanced_advanced_wp_x_pingback']);
	}
}

function rankology_advanced_advanced_wp_x_powered_by_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_advanced_wp_x_powered_by']); ?>

<label for="rankology_advanced_advanced_wp_x_powered_by">
	<input id="rankology_advanced_advanced_wp_x_powered_by"
		name="rankology_advanced_option_name[rankology_advanced_advanced_wp_x_powered_by]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Remove X-Powered-By from HTTP headers', 'wp-rankology'); ?>
</label>

<p class="description">
	<?php esc_html_e('By default, WordPress uses this to display your PHP version.', 'wp-rankology'); ?>
</p>

<pre><?php esc_attr_e('X-Powered-By: PHP/8.1.9', 'wp-rankology'); ?></pre>

<?php if (isset($options['rankology_advanced_advanced_wp_x_powered_by'])) {
		esc_attr($options['rankology_advanced_advanced_wp_x_powered_by']);
	}
}

function rankology_advanced_advanced_google_callback() {
	$options = get_option('rankology_advanced_option_name');
	$check   = isset($options['rankology_advanced_advanced_google']) ? $options['rankology_advanced_advanced_google'] : null;

	printf(
'<input type="text" name="rankology_advanced_option_name[rankology_advanced_advanced_google]" placeholder="' . esc_html__('Enter Google meta value site verification', 'wp-rankology') . '" aria-label="' . esc_html__('Google site verification', 'wp-rankology') . '" value="%s"/>',
esc_html($check)
); ?>
<p class="description">
	<?php esc_html_e('If your site is already verified in <strong>Google Search Console</strong>, you can leave this field empty.', 'wp-rankology'); ?>
</p>

<?php
}

function rankology_advanced_advanced_bing_callback() {
	$options = get_option('rankology_advanced_option_name');
	$check   = isset($options['rankology_advanced_advanced_bing']) ? $options['rankology_advanced_advanced_bing'] : null;

	printf(
'<input type="text" name="rankology_advanced_option_name[rankology_advanced_advanced_bing]" placeholder="' . esc_html__('Enter Bing meta value site verification', 'wp-rankology') . '" aria-label="' . esc_html__('Bing site verification', 'wp-rankology') . '" value="%s"/>',
esc_html($check)
); ?>
<p class="description">
	<?php esc_html_e('If your site is already verified in <strong>Bing Webmaster tools</strong>, you can leave this field empty.', 'wp-rankology'); ?>
</p>

<?php
}

function rankology_advanced_advanced_pinterest_callback() {
	$options = get_option('rankology_advanced_option_name');
	$check   = isset($options['rankology_advanced_advanced_pinterest']) ? $options['rankology_advanced_advanced_pinterest'] : null;

	printf(
'<input type="text" name="rankology_advanced_option_name[rankology_advanced_advanced_pinterest]" placeholder="' . esc_html__('Enter Pinterest meta value site verification', 'wp-rankology') . '" aria-label="' . esc_html__('Pinterest site verification', 'wp-rankology') . '" value="%s"/>',
esc_html($check)
);
}

function rankology_advanced_advanced_yandex_callback() {
	$options = get_option('rankology_advanced_option_name');
	$check   = isset($options['rankology_advanced_advanced_yandex']) ? $options['rankology_advanced_advanced_yandex'] : null;

	printf(
'<input type="text" name="rankology_advanced_option_name[rankology_advanced_advanced_yandex]" aria-label="' . esc_html__('Yandex site verification', 'wp-rankology') . '" placeholder="' . esc_html__('Enter Yandex meta value site verification', 'wp-rankology') . '" value="%s"/>',
esc_html($check)
);
}

function rankology_advanced_appearance_adminbar_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_appearance_adminbar']); ?>

<label for="rankology_advanced_appearance_adminbar">
	<input id="rankology_advanced_appearance_adminbar"
		name="rankology_advanced_option_name[rankology_advanced_appearance_adminbar]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Remove SEO from Admin Bar in backend and frontend', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_advanced_appearance_adminbar'])) {
		esc_attr($options['rankology_advanced_appearance_adminbar']);
	}
}

function rankology_advanced_appearance_universal_metabox_callback() {
	$options = get_option('rankology_advanced_option_name');

	if(!$options){
		$check = "1";
	} else {
		$check = isset($options['rankology_advanced_appearance_universal_metabox']) && $options['rankology_advanced_appearance_universal_metabox'] === '1' ? true : false;
	}
?>

<label for="rankology_advanced_appearance_universal_metabox">
	<input id="rankology_advanced_appearance_universal_metabox"
		name="rankology_advanced_option_name[rankology_advanced_appearance_universal_metabox]"
		type="checkbox"
		<?php checked($check, "1"); ?>
		value="1"/>

	<?php esc_html_e('Enable the universal SEO metabox for the Block Editor (Gutenberg)', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_advanced_appearance_adminbar'])) {
		esc_attr($options['rankology_advanced_appearance_adminbar']);
	}
}

function rankology_advanced_appearance_universal_metabox_disable_callback() {
	$options = get_option('rankology_advanced_option_name');

	if(!$options){
		$check = "1";
	} else {
		$check = isset($options['rankology_advanced_appearance_universal_metabox_disable']) && $options['rankology_advanced_appearance_universal_metabox_disable'] === '1' ? true : false;
	}
?>

<label for="rankology_advanced_appearance_universal_metabox_disable">
	<input id="rankology_advanced_appearance_universal_metabox_disable"
		name="rankology_advanced_option_name[rankology_advanced_appearance_universal_metabox_disable]"
		type="checkbox"
		<?php checked($check, "1"); ?>
		value="1"/>

	<?php esc_html_e('Disable the universal SEO metabox', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_advanced_appearance_adminbar'])) {
		esc_attr($options['rankology_advanced_appearance_adminbar']);
	}
}

function rankology_advanced_appearance_adminbar_noindex_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_appearance_adminbar_noindex']); ?>

<label for="rankology_advanced_appearance_adminbar_noindex">
	<input id="rankology_advanced_appearance_adminbar_noindex"
		name="rankology_advanced_option_name[rankology_advanced_appearance_adminbar_noindex]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Remove noindex item from Admin Bar in backend and frontend', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_advanced_appearance_adminbar_noindex'])) {
		esc_attr($options['rankology_advanced_appearance_adminbar_noindex']);
	}
}

function rankology_advanced_appearance_metaboxe_position_callback() {
	$options = get_option('rankology_advanced_option_name');

	$selected = isset($options['rankology_advanced_appearance_metaboxe_position']) ? $options['rankology_advanced_appearance_metaboxe_position'] : null; ?>

<select id="rankology_advanced_appearance_metaboxe_position"
	name="rankology_advanced_option_name[rankology_advanced_appearance_metaboxe_position]">
	<option <?php if ('high' == $selected) { ?>
		selected="selected"
		<?php } ?>
		value="high"><?php esc_html_e('High priority (top)', 'wp-rankology'); ?>
	</option>
	<option <?php if ('default' == $selected) { ?>
		selected="selected"
		<?php } ?>
		value="default"><?php esc_html_e('Normal priority (default)', 'wp-rankology'); ?>
	</option>
	<option <?php if ('low' == $selected) { ?>
		selected="selected"
		<?php } ?>
		value="low"><?php esc_html_e('Low priority', 'wp-rankology'); ?>
	</option>
</select>

<?php if (isset($options['rankology_advanced_appearance_metaboxe_position'])) {
		esc_attr($options['rankology_advanced_appearance_metaboxe_position']);
	}
}

function rankology_advanced_appearance_title_col_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_appearance_title_col']); ?>

<label for="rankology_advanced_appearance_title_col">
	<input id="rankology_advanced_appearance_title_col"
		name="rankology_advanced_option_name[rankology_advanced_appearance_title_col]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Add title column', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_advanced_appearance_title_col'])) {
		esc_attr($options['rankology_advanced_appearance_title_col']);
	}
}

function rankology_advanced_appearance_meta_desc_col_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_appearance_meta_desc_col']); ?>

<label for="rankology_advanced_appearance_meta_desc_col">
	<input id="rankology_advanced_appearance_meta_desc_col"
		name="rankology_advanced_option_name[rankology_advanced_appearance_meta_desc_col]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Add meta description column', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_advanced_appearance_meta_desc_col'])) {
		esc_attr($options['rankology_advanced_appearance_meta_desc_col']);
	}
}

function rankology_advanced_appearance_redirect_enable_col_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_appearance_redirect_enable_col']); ?>

<label for="rankology_advanced_appearance_redirect_enable_col">
	<input id="rankology_advanced_appearance_redirect_enable_col"
		name="rankology_advanced_option_name[rankology_advanced_appearance_redirect_enable_col]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Add redirection enable column', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_advanced_appearance_redirect_enable_col'])) {
		esc_attr($options['rankology_advanced_appearance_redirect_enable_col']);
	}
}

function rankology_advanced_appearance_redirect_url_col_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_appearance_redirect_url_col']); ?>

<label for="rankology_advanced_appearance_redirect_url_col">
	<input id="rankology_advanced_appearance_redirect_url_col"
		name="rankology_advanced_option_name[rankology_advanced_appearance_redirect_url_col]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Add redirection URL column', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_advanced_appearance_redirect_url_col'])) {
		esc_attr($options['rankology_advanced_appearance_redirect_url_col']);
	}
}

function rankology_advanced_appearance_canonical_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_appearance_canonical']); ?>

<label for="rankology_advanced_appearance_canonical">
	<input id="rankology_advanced_appearance_canonical"
		name="rankology_advanced_option_name[rankology_advanced_appearance_canonical]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Add canonical URL column', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_advanced_appearance_canonical'])) {
		esc_attr($options['rankology_advanced_appearance_canonical']);
	}
}

function rankology_advanced_appearance_target_kw_col_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_appearance_target_kw_col']); ?>

<label for="rankology_advanced_appearance_target_kw_col">
	<input id="rankology_advanced_appearance_target_kw_col"
		name="rankology_advanced_option_name[rankology_advanced_appearance_target_kw_col]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Add target keyword column', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_advanced_appearance_target_kw_col'])) {
		esc_attr($options['rankology_advanced_appearance_target_kw_col']);
	}
}

function rankology_advanced_appearance_noindex_col_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_appearance_noindex_col']); ?>

<label for="rankology_advanced_appearance_noindex_col">
	<input id="rankology_advanced_appearance_noindex_col"
		name="rankology_advanced_option_name[rankology_advanced_appearance_noindex_col]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Display noindex status', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_advanced_appearance_noindex_col'])) {
		esc_attr($options['rankology_advanced_appearance_noindex_col']);
	}
}

function rankology_advanced_appearance_nofollow_col_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_appearance_nofollow_col']); ?>

<label for="rankology_advanced_appearance_nofollow_col">
	<input id="rankology_advanced_appearance_nofollow_col"
		name="rankology_advanced_option_name[rankology_advanced_appearance_nofollow_col]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Display nofollow status', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_advanced_appearance_nofollow_col'])) {
		esc_attr($options['rankology_advanced_appearance_nofollow_col']);
	}
}

function rankology_advanced_appearance_words_col_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_appearance_words_col']); ?>

<label for="rankology_advanced_appearance_words_col">
	<input id="rankology_advanced_appearance_words_col"
		name="rankology_advanced_option_name[rankology_advanced_appearance_words_col]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Display total number of words in content', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_advanced_appearance_words_col'])) {
		esc_attr($options['rankology_advanced_appearance_words_col']);
	}
}

function rankology_advanced_appearance_score_col_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_appearance_score_col']); ?>

<label for="rankology_advanced_appearance_score_col">
	<input id="rankology_advanced_appearance_score_col"
		name="rankology_advanced_option_name[rankology_advanced_appearance_score_col]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Display Content Analysis results column ("Good" or "Overall score is better, Could Be Enhanced")', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_advanced_appearance_score_col'])) {
		esc_attr($options['rankology_advanced_appearance_score_col']);
	}
}

function rankology_advanced_appearance_ca_metaboxe_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_appearance_ca_metaboxe']); ?>

<label for="rankology_advanced_appearance_ca_metaboxe">
	<input id="rankology_advanced_appearance_ca_metaboxe"
		name="rankology_advanced_option_name[rankology_advanced_appearance_ca_metaboxe]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Remove Content Analysis Metabox', 'wp-rankology'); ?>
</label>


<p class="description">
	<?php esc_html_e('By checking this option, we will no longer track the significant keywords.','wp-rankology'); ?>
</p>

<?php if (isset($options['rankology_advanced_appearance_ca_metaboxe'])) {
		esc_attr($options['rankology_advanced_appearance_ca_metaboxe']);
	}
}

function rankology_advanced_appearance_genesis_seo_metaboxe_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_appearance_genesis_seo_metaboxe']); ?>

<label for="rankology_advanced_appearance_genesis_seo_metaboxe">
	<input id="rankology_advanced_appearance_genesis_seo_metaboxe"
		name="rankology_advanced_option_name[rankology_advanced_appearance_genesis_seo_metaboxe]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Remove Genesis SEO Metabox', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_advanced_appearance_genesis_seo_metaboxe'])) {
		esc_attr($options['rankology_advanced_appearance_genesis_seo_metaboxe']);
	}
}

function rankology_advanced_appearance_genesis_seo_menu_callback() {
	$options = get_option('rankology_advanced_option_name');

	$check = isset($options['rankology_advanced_appearance_genesis_seo_menu']); ?>

<label for="rankology_advanced_appearance_genesis_seo_menu">
	<input id="rankology_advanced_appearance_genesis_seo_menu"
		name="rankology_advanced_option_name[rankology_advanced_appearance_genesis_seo_menu]" type="checkbox" <?php if ('1' == $check) { ?>
	checked="yes"
	<?php } ?>
	value="1"/>

	<?php esc_html_e('Remove Genesis SEO link in WP Admin Menu', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_advanced_appearance_genesis_seo_menu'])) {
		esc_attr($options['rankology_advanced_appearance_genesis_seo_menu']);
	}
}

function rankology_advanced_security_metaboxe_role_callback() {
    $options = get_option('rankology_advanced_option_name');
    global $wp_roles;

    if (!isset($wp_roles)) {
        $wp_roles = new WP_Roles();
    }
    ?>

    <?php foreach ($wp_roles->get_names() as $key => $value) {
        $check = isset($options['rankology_advanced_security_metaboxe_role'][$key]);
        ?>

        <p>
            <label for="rankology_advanced_security_metaboxe_role_<?php echo esc_attr(rankology_common_esc_str($key)); ?>">
                <input id="rankology_advanced_security_metaboxe_role_<?php echo esc_attr(rankology_common_esc_str($key)); ?>"
                       name="rankology_advanced_option_name[rankology_advanced_security_metaboxe_role][<?php echo esc_attr(rankology_common_esc_str($key)); ?>]"
                       type="checkbox" <?php if ('1' == $check) { ?> checked="checked" <?php } ?> value="1"/>
                <strong><?php echo esc_html($value); ?></strong> (<em><?php echo esc_html(translate_user_role($value, 'default')); ?></em>)
            </label>
        </p>

        <?php
        if (isset($options['rankology_advanced_security_metaboxe_role'][$key])) {
            echo esc_attr($options['rankology_advanced_security_metaboxe_role'][$key]);
        }
    }
}


function rankology_advanced_security_metaboxe_ca_role_callback() {
	
	$options = get_option('rankology_advanced_option_name');

	global $wp_roles;

	if ( ! isset($wp_roles)) {
		$wp_roles = new WP_Roles();
	} ?>

	<?php foreach ($wp_roles->get_names() as $key => $value) {
		$check = isset($options['rankology_advanced_security_metaboxe_ca_role'][$key]); ?>

	<p>
		<label
			for="rankology_advanced_security_metaboxe_ca_role_<?php echo rankology_common_esc_str($key); ?>">
			<input
				id="rankology_advanced_security_metaboxe_ca_role_<?php echo rankology_common_esc_str($key); ?>"
				name="rankology_advanced_option_name[rankology_advanced_security_metaboxe_ca_role][<?php echo rankology_common_esc_str($key); ?>]"
				type="checkbox" <?php if ('1' == $check) { ?>
			checked="yes"
			<?php } ?>
			value="1"/>

			<strong><?php echo esc_html($value); ?></strong> (<em><?php echo esc_html(translate_user_role($value,  'default')); ?>)</em>
		</label>
	</p>

	<?php if (isset($options['rankology_advanced_security_metaboxe_ca_role'][$key])) {
			esc_attr($options['rankology_advanced_security_metaboxe_ca_role'][$key]);
		}
	}
}
