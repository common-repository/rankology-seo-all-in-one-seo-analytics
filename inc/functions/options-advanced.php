<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

//Attachments redirects
function rankology_advanced_advanced_attachments_option() {
	return rankology_get_service('AdvancedOption')->getAdvancedAttachments();
}

function rankology_redirections_attachments(){
	if (rankology_advanced_advanced_attachments_option() =='1') {
		global $post;
		if ( is_attachment() && isset($post->post_parent) && is_numeric($post->post_parent) && ($post->post_parent != 0) ) {
	    	wp_redirect( get_permalink( $post->post_parent ), 301 );
	    	exit();
		    wp_reset_postdata();
		} elseif (is_attachment() && isset($post->post_parent) && is_numeric($post->post_parent) && ($post->post_parent == 0)) {
			wp_redirect(get_home_url(), 302);
			exit();
		}
	}
}
add_action( 'template_redirect', 'rankology_redirections_attachments', 2 );

//Attachments redirects to file URL
function rankology_redirections_attachments_file(){
	if (rankology_get_service('AdvancedOption')->getAdvancedAttachmentsFile() ==='1') {
		if ( is_attachment() ) {
			wp_redirect( wp_get_attachment_url(), 301 );
			exit();
		}
	}
}
add_action( 'template_redirect', 'rankology_redirections_attachments_file', 1 );

//Remove reply to com link
if ('1' == rankology_get_service('AdvancedOption')->getAdvancedReplytocom()) {
    add_filter('comment_reply_link', 'rankology_remove_reply_to_com');
}
function rankology_remove_reply_to_com($link) {
    return preg_replace('/href=\'(.*(\?|&)replytocom=(\d+)#respond)/', 'href=\'#comment-$3', $link);
}

//Remove noreferrer on links
if ('1' == rankology_get_service('AdvancedOption')->getAdvancedNoReferrer()) {
    add_filter('the_content', 'rankology_remove_noreferrer', 999);
}
function rankology_remove_noreferrer($content) {
    if (empty($content)) {
        return $content;
    }

    $attrs = [
        "noreferrer " => "",
        " noreferrer" => ""
    ];

    $attrs = apply_filters( 'rankology_link_attrs', $attrs );

    return strtr($content, $attrs);
}

//Remove WP meta generator
if ('1' == rankology_get_service('AdvancedOption')->getAdvancedWPGenerator()) {
    remove_action('wp_head', 'wp_generator');
}

//Remove hentry post class
if ('1' == rankology_get_service('AdvancedOption')->getAdvancedHentry()) {
    function rankology_advanced_advanced_hentry_hook($classes) {

        $classes = array_diff($classes, ['hentry']);

        return $classes;
    }
    add_filter('post_class', 'rankology_advanced_advanced_hentry_hook');
}

//WordPress
if ('1' == rankology_get_service('AdvancedOption')->getAdvancedWPShortlink()) {
    remove_action('wp_head', 'wp_shortlink_wp_head');
}

//WordPress WLWManifest
if ('1' == rankology_get_service('AdvancedOption')->getAdvancedWPManifest()) {
    remove_action('wp_head', 'wlwmanifest_link');
}

//WordPress RSD
if ('1' == rankology_get_service('AdvancedOption')->getAdvancedWPRSD()) {
    remove_action('wp_head', 'rsd_link');
}

//Disable X-Pingback header
if ('1' === rankology_get_service('AdvancedOption')->getAdvancedOEmbed()) {
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
}

//Disable X-Pingback header
if ('1' === rankology_get_service('AdvancedOption')->getAdvancedXPingback()) {
    function rankology_advanced_advanced_x_pingback_hook() {
        header_remove('X-Pingback');
    }
    add_action('wp', 'rankology_advanced_advanced_x_pingback_hook');
}

//Disable X-Powered-By header
if ('1' === rankology_get_service('AdvancedOption')->getAdvancedXPoweredBy()) {
    function rankology_advanced_advanced_x_powered_by_hook() {
        header_remove('X-Powered-By');
    }
    add_action('wp', 'rankology_advanced_advanced_x_powered_by_hook');
}

//Google site verification
function rankology_advanced_advanced_google_hook() {
    if (is_home() || is_front_page()) {
        $optionGoogle = rankology_get_service('AdvancedOption')->getAdvancedGoogleVerification();
        if (!empty($optionGoogle)) {
            $google = '<meta name="google-site-verification" content="' . $optionGoogle . '">';
            $google .= "\n";
            echo rankology_common_esc_str($google);
        }
    }
}
add_action('wp_head', 'rankology_advanced_advanced_google_hook', 2);

//Bing site verification
function rankology_advanced_advanced_bing_hook() {
    if (is_home() || is_front_page()) {
        $optionBing = rankology_get_service('AdvancedOption')->getAdvancedBingVerification();
        if (!empty($optionBing)) {
            $bing = '<meta name="msvalidate.01" content="' . $optionBing . '">';
            $bing .= "\n";
            echo rankology_common_esc_str($bing);
        }
    }
}
add_action('wp_head', 'rankology_advanced_advanced_bing_hook', 2);

//Pinterest site verification
function rankology_advanced_advanced_pinterest_hook() {
    if (is_home() || is_front_page()) {
        $optionPinterest =rankology_get_service('AdvancedOption')->getAdvancedPinterestVerification();
        if (!empty($optionPinterest)) {
            $pinterest = '<meta name="p:domain_verify" content="' . $optionPinterest . '">';
            $pinterest .= "\n";
            echo rankology_common_esc_str($pinterest);
        }
    }
}
add_action('wp_head', 'rankology_advanced_advanced_pinterest_hook', 2);

//Yandex site verification
function rankology_advanced_advanced_yandex_hook() {
    if (is_home() || is_front_page()) {
        $contentYandex = rankology_get_service('AdvancedOption')->getAdvancedYandexVerification();

        if(empty($contentYandex)){
            return;
        }

        $yandex = '<meta name="yandex-verification" content="' . $contentYandex . '">';
        $yandex .= "\n";
        echo rankology_common_esc_str($yandex);
    }
}
add_action('wp_head', 'rankology_advanced_advanced_yandex_hook', 2);

//Automatic alt text based on target kw
if (!empty(rankology_get_service('AdvancedOption')->getAdvancedImageAutoAltTargetKw())) {
    function rankology_auto_img_alt_thumb_target_kw($atts, $attachment) {
        if ( ! is_admin()) {
            if (empty($atts['alt'])) {
                if ('' != get_post_meta(get_the_ID(), '_rankology_analysis_target_kw', true)) {
                    $atts['alt'] = esc_html(get_post_meta(get_the_ID(), '_rankology_analysis_target_kw', true));

                    $atts['alt'] = apply_filters('rankology_auto_image_alt_target_kw', $atts['alt']);
                }
            }
        }

        return $atts;
    }
    add_filter('wp_get_attachment_image_attributes', 'rankology_auto_img_alt_thumb_target_kw', 10, 2);

    /**
     * Replace alt for content no use gutenberg.
     *
     * 
     *
     * @param string $content
     *
     * @return void
     */
    function rankology_auto_img_alt_target_kw($content) {
        if (empty($content)) {
            return $content;
        }

        $target_keyword = get_post_meta(get_the_ID(), '_rankology_analysis_target_kw', true);

        $target_keyword = apply_filters('rankology_auto_image_alt_target_kw', $target_keyword);

        if (empty($target_keyword)) {
            return $content;
        }

        $regex = '#<img[^>]* alt=(?:\"|\')(?<alt>([^"]*))(?:\"|\')[^>]*>#mU';

        preg_match_all($regex, $content, $matches);

        $matchesTag = $matches[0];
        $matchesAlt = $matches['alt'];

        if (empty($matchesAlt)) {
            return $content;
        }

        $regexSrc = '#<img[^>]* src=(?:\"|\')(?<src>([^"]*))(?:\"|\')[^>]*>#mU';

        foreach ($matchesAlt as $key => $alt) {
            if ( ! empty($alt)) {
                continue;
            }
            $contentMatch = $matchesTag[$key];
            preg_match($regexSrc, $contentMatch, $matchSrc);

            $contentToReplace  = str_replace('alt=""', 'alt="' . htmlspecialchars(esc_html($target_keyword)) . '"', $contentMatch);

            if ($contentMatch !== $contentToReplace) {
                $content = str_replace($contentMatch, $contentToReplace, $content);
            }
        }

        return $content;
    }
    add_filter('the_content', 'rankology_auto_img_alt_target_kw', 20);
}
