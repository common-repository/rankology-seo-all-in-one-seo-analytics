<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

//Redirections
//=================================================================================================
//Enabled
function rankology_redirections_enabled() {
	if (is_home() && get_option( 'page_for_posts' ) !='' && get_post_meta(get_option( 'page_for_posts' ),'_rankology_redirections_enabled',true)) {
		$rankology_redirections_enabled = get_post_meta(get_option( 'page_for_posts' ),'_rankology_redirections_enabled',true);
		return $rankology_redirections_enabled;
	} else {
		global $post;
		if ($post) {
			if (get_post_meta($post->ID,'_rankology_redirections_enabled',true)) {
				$rankology_redirections_enabled = get_post_meta($post->ID,'_rankology_redirections_enabled',true);
				return $rankology_redirections_enabled;
			}
		}
	}
}

function rankology_redirections_term_enabled() {
	if (!get_queried_object_id()) {
        return;
	}

    $value = get_term_meta(get_queried_object_id(),'_rankology_redirections_enabled',true);
    if (empty($value)) {
        return;
    }

    return $value;
}

//Login status
function rankology_redirections_logged_status() {
	if (is_home() && get_option( 'page_for_posts' ) !='' && get_post_meta(get_option( 'page_for_posts' ),'_rankology_redirections_logged_status',true)) {
		$rankology_redirections_logged_status = get_post_meta(get_option( 'page_for_posts' ),'_rankology_redirections_logged_status',true);
		return $rankology_redirections_logged_status;
	} else {
		global $post;
		if ($post) {
			if (get_post_meta($post->ID,'_rankology_redirections_logged_status',true)) {
				$rankology_redirections_logged_status = get_post_meta($post->ID,'_rankology_redirections_logged_status',true);
				return $rankology_redirections_logged_status;
			}
		}
	}
}
function rankology_redirections_term_logged_status() {
	if (!get_queried_object_id()) {
        return;
	}

    $value = get_term_meta(get_queried_object_id(),'_rankology_redirections_logged_status',true);
    if (empty($value)) {
        return;
    }

    return $value;
}

//Type
function rankology_redirections_type() {
	if (is_home() && get_option( 'page_for_posts' ) !='' && get_post_meta(get_option( 'page_for_posts' ),'_rankology_redirections_type',true)) {
		$rankology_redirections_type = get_post_meta(get_option( 'page_for_posts' ),'_rankology_redirections_type',true);
		return $rankology_redirections_type;
	} else {
		global $post;
		if (get_post_meta($post->ID,'_rankology_redirections_type',true)) {
			$rankology_redirections_type = get_post_meta($post->ID,'_rankology_redirections_type',true);
			return $rankology_redirections_type;
		}
	}
}

function rankology_redirections_term_type() {
	if (!get_queried_object_id()) {
        return;
	}
    $value = get_term_meta(get_queried_object_id(),'_rankology_redirections_type',true);
    if (empty($value)) {
        return;
    }

    return $value;
}

//URL to redirect
function rankology_redirections_value() {
	global $post;

	$rankology_redirections_value = '';

	if (is_singular() && get_post_meta($post->ID, '_rankology_redirections_value', true)) {
		$rankology_redirections_value = esc_url(get_post_meta($post->ID, '_rankology_redirections_value', true));
	} elseif (is_home() && get_option('page_for_posts') != '' && get_post_meta(get_option('page_for_posts'), '_rankology_redirections_value', true)) {
		$rankology_redirections_value = esc_url(get_post_meta(get_option('page_for_posts'), '_rankology_redirections_value', true));
	} elseif ((is_tax() || is_category() || is_tag()) && get_term_meta(get_queried_object_id(), '_rankology_redirections_value', true) != '') {
		$rankology_redirections_value = esc_url(get_term_meta(get_queried_object_id(), '_rankology_redirections_value', true));
	} else {
		// Sanitize and validate the request URI
		$request_uri = sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI']));
		$rankology_redirections_value = esc_url(home_url($request_uri)); // Ensure it's a valid URL

		// Check if the value exists in rankology_404 custom post type titles
		$rankology_redirections_query = new WP_Query(array(
			'post_type'              => 'rankology_404',
			'posts_per_page'         => '-1',
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
		));

		$all_titles = array();
		if ($rankology_redirections_query->have_posts()) {
			while ($rankology_redirections_query->have_posts()) {
				$rankology_redirections_query->the_post();
				$all_titles[] = get_the_title();
			}
			if (in_array($rankology_redirections_value, $all_titles, true)) {
				// Perform redirection or return the value as needed
				return $rankology_redirections_value;
			}
			wp_reset_postdata();
		}
	}

	return $rankology_redirections_value;
}


function rankology_redirections_hook() {
	//If the current screen is: Elementor editor
	if ( class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
		return;
	}

	//If the current screen is: Elementor preview mode
	if ( class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
		return;
	}

    $metaValueByLoggedIn = \is_user_logged_in() ? 'only_logged_in' : 'only_not_logged_in';

    // Term
	if ((is_tax() || is_category() || is_tag()) && rankology_redirections_term_enabled() =='yes') {
        if (rankology_redirections_term_logged_status() === $metaValueByLoggedIn || rankology_redirections_term_logged_status() === 'both' || empty(rankology_redirections_term_logged_status())) {
            if (rankology_redirections_term_type() && rankology_redirections_value() !='') {
                wp_redirect( rankology_redirections_value(), rankology_redirections_term_type() );
                exit();
            }
        }
	}
    // Post
    elseif (rankology_redirections_enabled() =='yes') {
        if (rankology_redirections_logged_status() === $metaValueByLoggedIn || rankology_redirections_logged_status() === 'both' || empty(rankology_redirections_logged_status())) {
            if (rankology_redirections_type() && rankology_redirections_value() !='') {
                wp_redirect( rankology_redirections_value(), rankology_redirections_type() );
                exit();
            }
        }
	}
}
add_action('template_redirect', 'rankology_redirections_hook', 1);
