<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

function rankology_admin_header($context = "") {
    ?>

<div id="rankology-header" class="rankology-option">
	<div id="rankology-navbar">
		<ul>
			<li>
				<a href="<?php echo rankology_set_admin_esx_url('admin.php?page=rankology-option'); ?>">
					<?php esc_html_e('Home', 'wp-rankology'); ?>
				</a>
			</li>
			<?php if (get_admin_page_title()) { ?>
			<li>
				<?php echo get_admin_page_title(); ?>
			</li>
			<?php } ?>
		</ul>
	</div>
</div>
<?php
}
