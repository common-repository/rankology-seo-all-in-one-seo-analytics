<?php
/**
 * Uninstall Rankology
 *
 * @author Team Rankology, inspired by Polylang
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) { // If uninstall not called from WordPress exit
	exit;
}

class RANKOLOGY_Uninstall {

	/**
	 * Constructor: manages uninstall for multisite
	 */
	public function __construct() {
		global $wpdb;

		// Don't do anything except if the constant RANKOLOGY_UNINSTALL is explicitely defined and true.
		if ( ! defined( 'RANKOLOGY_UNINSTALL' ) || ! RANKOLOGY_UNINSTALL ) {
			return;
		}

		// Check if it is a multisite uninstall - if so, run the uninstall function for each blog id
		if ( is_multisite() ) {
			foreach ( $wpdb->get_col( $wpdb->prepare("SELECT blog_id FROM $wpdb->blogs WHERE '1'=%d", '1') ) as $blog_id ) {
				switch_to_blog( $blog_id );
				$this->uninstall();
			}
			restore_current_blog();
		}
		else {
			$this->uninstall();
		}
	}

	/**
	 * Delete all entries in the DB related to Rankology
	 * Transients, post meta, options, custom tables
	 */
	public function uninstall() {
		global $wpdb;

		do_action( 'rankology_uninstall' );

        // Delete post meta
        $wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key LIKE '_rankology_%'" );

        // Delete redirections / 404 errors
        $sql = 'DELETE `posts`, `pm`
		FROM `' . $wpdb->prefix . 'posts` AS `posts`
		LEFT JOIN `' . $wpdb->prefix . 'postmeta` AS `pm` ON `pm`.`post_id` = `posts`.`ID`
		WHERE `posts`.`post_type` = \'rankology_404\'';

        $wpdb->query($wpdb->prepare($sql));

        // Delete schemas
        $sql = 'DELETE `posts`, `pm`
		FROM `' . $wpdb->prefix . 'posts` AS `posts`
		LEFT JOIN `' . $wpdb->prefix . 'postmeta` AS `pm` ON `pm`.`post_id` = `posts`.`ID`
		WHERE `posts`.`post_type` = \'rankology_schemas\'';

        $wpdb->query($wpdb->prepare($sql));

        // Delete broken links
        $sql = 'DELETE `posts`, `pm`
		FROM `' . $wpdb->prefix . 'posts` AS `posts`
		LEFT JOIN `' . $wpdb->prefix . 'postmeta` AS `pm` ON `pm`.`post_id` = `posts`.`ID`
		WHERE `posts`.`post_type` = \'rankology_bot\'';

        $wpdb->query($wpdb->prepare($sql));

        // Delete global settings
        $options = $wpdb->get_col( $wpdb->prepare("SELECT option_name FROM $wpdb->options WHERE option_name LIKE %s", 'rankology_%') );
        array_map( 'delete_option', $options );

        // Delete widget options
        $options = $wpdb->get_col( $wpdb->prepare("SELECT option_name FROM $wpdb->options WHERE option_name LIKE %s", 'rankology_widget_%') );
        array_map( 'delete_option', $options );

		// Delete transients
		delete_transient( '_rankology_sitemap_ids_video' );
		delete_transient( 'rankology_results_page_speed' );
		delete_transient( 'rankology_results_page_speed_desktop' );
		delete_transient( 'rankology_results_google_analytics' );
		delete_transient( 'rankology_prevent_title_redirection_already_exist' );

        // Delete custom tables
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}rankology_significant_keywords");
	}
}

new RANKOLOGY_Uninstall();
