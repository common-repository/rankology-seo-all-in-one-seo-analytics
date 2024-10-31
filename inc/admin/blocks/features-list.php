<?php
	// To prevent calling the plugin directly
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	if (! function_exists('add_action')) {
		echo 'Please don&rsquo;t call the plugin directly. Thanks :)';
		exit;
	}
?>
<div id="rankology-page-list" class="rankology-page-list rankology-card">
	<div class="rankology-card-title">
		<h2><?php esc_html_e('SEO settings', 'wp-rankology'); ?></h2>
	</div>

	<?php
		$features = [
			'titles' => [
				'title'         => esc_html__('Header Metas', 'wp-rankology'),
				'desc'          => esc_html__('Manage your post titles & metas for post types, taxonomies and archives.', 'wp-rankology'),
				'btn_primary'   => admin_url('admin.php?page=rankology-titles'),
				'filter'        => 'rankology_remove_feature_titles',
			],
			'social' => [
				'title'         => esc_html__('Social Platforms', 'wp-rankology'),
				'desc'          => esc_html__('Facebook, Twitter Card, Google Knowledge Graph and more.', 'wp-rankology'),
				'btn_primary'   => admin_url('admin.php?page=rankology-social'),
				'filter'        => 'rankology_remove_feature_social',
			],
			'xml-sitemap' => [
				'title'         => esc_html__('XML Sitemaps', 'wp-rankology'),
				'desc'          => esc_html__('Manage your XML - Image - Video - HTML Sitemap.', 'wp-rankology'),
				'btn_primary'   => admin_url('admin.php?page=rankology-xml-sitemap'),
				'filter'        => 'rankology_remove_feature_xml_sitemap',
			],
			'google-analytics' => [
				'title'         => esc_html__('Analytics', 'wp-rankology'),
				'desc'          => esc_html__('Track everything about website visitors with Google Analytics.', 'wp-rankology'),
				'btn_primary'   => admin_url('admin.php?page=rankology-google-analytics'),
				'filter'        => 'rankology_remove_feature_google_analytics',
			],
		];

		$features = apply_filters('rankology_features_list_before_tools', $features);

		$features['tools'] = [
			'title'         => esc_html__('Tools', 'wp-rankology'),
			'desc'          => esc_html__('Import/Export plugin settings from one site to other site.', 'wp-rankology'),
			'btn_primary'   => admin_url('admin.php?page=rankology-import-export'),
			'filter'        => 'rankology_remove_feature_tools',
			'toggle'        => false,
		];

		$features = apply_filters('rankology_features_list_after_tools', $features);

		if (! empty($features)) { ?>
			<div class="rankology-card-content">

				<?php foreach ($features as $key => $value) {
					if (isset($value['filter'])) {
						$rankology_feature = apply_filters($value['filter'], true);
					}
					?>

					<div class="rankology-cart-list">

						<?php
						if (true === $rankology_feature) {
							$svg              = isset($value['svg']) ? $value['svg'] : null;
							$title            = isset($value['title']) ? $value['title'] : null;
							$desc             = isset($value['desc']) ? $value['desc'] : null;
							$btn_primary      = isset($value['btn_primary']) ? $value['btn_primary'] : '';
							$help             = isset($value['help']) ? $value['help'] : null;
							$toggle           = isset($value['toggle']) ? $value['toggle'] : true;

							if (true === $toggle) {
								$class = "";
								if ('1' == rankology_get_toggle_option($key)) {
									$rankology_get_toggle_option = '1';
									$class = ' is-rankology-feature-active';
								} else {
									$rankology_get_toggle_option = '0';
								}
							}
							?>

							<div class="rankology-card-item">
								<div class="setin-itm-hdercon">
									<h3><?php echo rankology_common_esc_str($title); ?></h3>
									<?php if (true === $toggle) { ?>
										<div class="setin-itm-toglbtn">
											<span class="screen-reader-text"><?php printf(esc_html__('Toggle %s','wp-rankology'), $title); ?></span>
											<input type="checkbox" name="toggle-<?php echo rankology_common_esc_str($key); ?>" id="toggle-<?php echo rankology_common_esc_str($key); ?>" class="toggle" data-toggle="<?php echo rankology_common_esc_str($rankology_get_toggle_option); ?>">
											<label for="toggle-<?php echo rankology_common_esc_str($key); ?>"></label>
										</div>
									<?php } ?>
								</div>
								<p><?php echo rankology_common_esc_str($desc); ?></p>
								<div class="setin-itm-mngebtn">
									<a href="<?php echo rankology_common_esc_str($btn_primary); ?>" class="button button-secondary">
										<?php esc_html_e('Settings', 'wp-rankology'); ?>
									</a>
								</div>
							</div>

						<?php
						}
					?>
					</div>
				<?php
				} ?>
			</div>
	<?php }
	?>
</div>
