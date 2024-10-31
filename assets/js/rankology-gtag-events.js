// rankology-gtag-events.js
jQuery(document).ready(function($) {
    $('.actions .button').unbind().click(function() {
        gtag('event', 'remove_from_cart', {'items': rankology_cart_items});
    });
});

//another
jQuery(document).ready(function () {

	// Show and hide user license input base on license type option
	function handle_geoip_license_key_field() {
		console.log(jQuery("#geoip_license_type").val())
		if (jQuery("#geoip_license_type").val() == "user-license") {
			jQuery("#geoip_license_key_option").show();
		} else {
			jQuery("#geoip_license_key_option").hide();
		}
	}
	handle_geoip_license_key_field();
	jQuery("#geoip_license_type").on('change', handle_geoip_license_key_field);

	// Ajax function for updating database
	jQuery("input[name = 'update_geoip']").click(function (event) {
		event.preventDefault();
		var geoip_clicked_button = this;

		var geoip_action = jQuery(this).prev().val();
		jQuery(".geoip-update-loading").remove();
		jQuery(".update_geoip_result").remove();

		jQuery(this).after("<img class='geoip-update-loading' src='<?php echo esc_url(plugins_url('rankology-stats')); ?>/assets/images/loading.gif'/>");

		jQuery.ajax({
			url: ajaxurl,
			type: 'post',
			data: {
				'action': 'rankology_stats_update_geoip_database',
				'update_action': geoip_action,
				'rankology_rkns_nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
			},
			datatype: 'json',
		})
			.always(function (result) {
				jQuery(".geoip-update-loading").remove();
				jQuery(geoip_clicked_button).after("<span class='update_geoip_result'>" + result + "</span>")
			});
	});
});
