<?php
/**
 * Sitemap block display callback
 *
 * @param   array     $attributes  Block attributes
 * @param   string    $content     Inner block content
 * @param   WP_Block  $block       Actual block
 * @return  string    $html
 */
function rankology_sitemap_block( $attributes, $content, $block ){
    $attr = get_block_wrapper_attributes();
    $html = '';
    if ( '1' == rankology_get_toggle_option( 'xml-sitemap' ) && '1' == rankology_get_service('SitemapOption')->getHtmlEnable() ) {
        $atts = ! empty( $attributes['postTypes'] ) ? ['cpt' => join( ',', $attributes['postTypes'] ) ] : [];
        $html = sprintf( '<div %s>%s</div>', $attr, rankology_xml_sitemap_html_hook( $atts ) );
    }
    return rankology_common_esc_str($html);
}