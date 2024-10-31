<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/** --------------------------------------------------------------------------------------------- */
/** MIGRATE / UPGRADE =========================================================================== */
/** --------------------------------------------------------------------------------------------- */

add_action( 'admin_init', 'rankology_upgrader' );
/**
 * Tell WP what to do when admin is loaded aka upgrader
 *
 * 
 */
function rankology_upgrader() {
	$versions = get_option( 'rankology_versions' );
	$actual_version = isset( $versions['free'] ) ? $versions['free'] : 0;

	// You can hook the upgrader to trigger any action when rankology is upgraded.
	// First install.
	if ( ! $actual_version ) {
		/**
		 * Allow to prevent plugin first install hooks to fire.
		 *
		 * 
		 *
		 * @param (bool) $prevent True to prevent triggering first install hooks. False otherwise.
		 */
		if ( ! apply_filters( 'rankology_prevent_first_install', false ) ) {
			/**
			 * Fires on the plugin first install.
			 *
			 * 
			 *
			 */
			do_action( 'rankology_first_install' );
		}

	}

	if ( RANKOLOGY_VERSION !== $actual_version ) {
			/**
			 * @param (string) $new_pro_version    The version being upgraded to.
			 * @param (string) $actual_pro_version The previous version.
			 */
			do_action( 'rankology_upgrade', RANKOLOGY_VERSION, $actual_version );
	}

	// If any upgrade has been done, we flush and update version.
	if ( did_action( 'rankology_first_install' ) || did_action( 'rankology_upgrade' ) ) {

		// Do not use rankology_get_option() here.
		$options = get_option( 'rankology_versions' );
		$options = is_array( $options ) ? $options : [];

		$options['free'] = RANKOLOGY_VERSION;

		update_option( 'rankology_versions', $options, false );
	}
}


add_action( 'rankology_upgrade', 'rankology_new_upgrade', 10, 2 );
/**
 * What to do when rankology is updated, depending on versions.
 *
 * 
 *
 * @param (string) $rankology_version The version being upgraded to.
 * @param (string) $actual_version    The previous version.
 */
function rankology_new_upgrade( $rankology_version, $actual_version ) {
	global $wpdb;

	// < 3.8.2
	if ( version_compare( $actual_version, '3.8.2', '<' ) ) {
	}

}

/**
 * Try to delete an old plugin file removed in a particular version, if not, will empty the file, if not, will rename it, if still not well… ¯\_(ツ)_/¯.
 *
 * 
 * @param (string) $file
 * 
 **/
function rankology_remove_old_plugin_file( $file ) {
	// Is it a sym link ?
	if ( is_link( $file ) ) {
		$file = @readlink( $file );
	}
	// Try to delete.
	if ( file_exists( $file ) && ! @unlink( $file ) ) {
		// Or try to empty it.
		$fh = @fopen( $file, 'w' );
		$fw = @fwrite( $fh, '<?php // File removed by rankology' );
		@fclose( $fh );
		if ( ! $fw ) {
			// Or try to rename it.
			return @rename( $file, $file . '.old' );
		}
	}
	return true;
}
