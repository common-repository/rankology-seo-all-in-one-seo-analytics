<?php
/**
 * Classic editor related functions
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
add_action( 'wp_enqueue_editor', 'rankology_wp_tiny_mce' );
/**
 * Load extension for wpLink
 *
 * @param  string  $hook  Page hook name
 */
function rankology_wp_tiny_mce( $hook ){
    $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
    wp_enqueue_style( 'rankology-classic', RANKOLOGY_ASSETS_DIR . '/css/rankology-classic-editor' . $suffix . '.css' , [], RANKOLOGY_VERSION );
    wp_enqueue_script( 'rankology-classic', RANKOLOGY_ASSETS_DIR . '/js/rankology-classic-editor' . $suffix . '.js' , ['wplink'], RANKOLOGY_VERSION, true );
    wp_localize_script( 'rankology-classic', 'rankologyI18n', array(
        'sponsored' => __( 'Add <code>rel="sponsored"</code> attribute', 'wp-rankology' ),
        'nofollow'  => __( 'Add <code>rel="nofollow"</code> attribute', 'wp-rankology' ),
        'ugc'       => __( 'Add <code>rel="UGC"</code> attribute', 'wp-rankology' ),
    ) );
}
