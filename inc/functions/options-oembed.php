<?php
defined('ABSPATH') or die('Please don&rsquo;t call the plugin directly. Thanks :)');

//oEmbed
//=================================================================================================
/**
 * Get Oembed Title (custom OG:title or Post title)
 * 
 * @param string $post
 * @return string rankology_oembed_title
 * @author Team Rankology
 */
function rankology_oembed_title_hook($post)
{
    //Init
    $rankology_oembed_title ='';

    $variables = null;
    $variables = apply_filters('rankology_dyn_variables_fn', $variables, $post, true);

    $rankology_titles_template_variables_array 	= $variables['rankology_titles_template_variables_array'];
    $rankology_titles_template_replace_array 	= $variables['rankology_titles_template_replace_array'];

    //If OG title set
    if (get_post_meta($post->ID, '_rankology_social_fb_title', true) !='') {
        $rankology_oembed_title = get_post_meta($post->ID, '_rankology_social_fb_title', true);
    } elseif (get_post_meta($post->ID, '_rankology_titles_title', true) !='') {
        $rankology_oembed_title = get_post_meta($post->ID, '_rankology_titles_title', true);
    } elseif (get_the_title($post) !='') {
        $rankology_oembed_title = the_title_attribute(['before'=>'','after'=>'','echo'=>false,'post'=>$post]);
    }

    //Apply dynamic variables
    preg_match_all('/%%_cf_(.*?)%%/', $rankology_oembed_title, $matches); //custom fields

    if ( ! empty($matches)) {
        $rankology_titles_cf_template_variables_array = [];
        $rankology_titles_cf_template_replace_array   = [];

        foreach ($matches['0'] as $key => $value) {
            $rankology_titles_cf_template_variables_array[] = $value;
        }

        foreach ($matches['1'] as $key => $value) {
            $rankology_titles_cf_template_replace_array[] = esc_attr(get_post_meta($post->ID, $value, true));
        }
    }

    preg_match_all('/%%_ct_(.*?)%%/', $rankology_oembed_title, $matches2); //custom terms taxonomy

    if ( ! empty($matches2)) {
        $rankology_titles_ct_template_variables_array = [];
        $rankology_titles_ct_template_replace_array   = [];

        foreach ($matches2['0'] as $key => $value) {
            $rankology_titles_ct_template_variables_array[] = $value;
        }

        foreach ($matches2['1'] as $key => $value) {
            $term = wp_get_post_terms($post->ID, $value);
            if ( ! is_wp_error($term)) {
                $terms                                       = esc_attr($term[0]->name);
                $rankology_titles_ct_template_replace_array[] = apply_filters('rankology_titles_custom_tax', $terms, $value);
            }
        }
    }

    //Default
    $rankology_oembed_title = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_oembed_title);

    //Custom fields
    if ( ! empty($matches) && ! empty($rankology_titles_cf_template_variables_array) && ! empty($rankology_titles_cf_template_replace_array)) {
        $rankology_oembed_title = str_replace($rankology_titles_cf_template_variables_array, $rankology_titles_cf_template_replace_array, $rankology_oembed_title);
    }

    //Custom terms taxonomy
    if ( ! empty($matches2) && ! empty($rankology_titles_ct_template_variables_array) && ! empty($rankology_titles_ct_template_replace_array)) {
        $rankology_oembed_title = str_replace($rankology_titles_ct_template_variables_array, $rankology_titles_ct_template_replace_array, $rankology_oembed_title);
    }

    $rankology_oembed_title = str_replace($rankology_titles_template_variables_array, $rankology_titles_template_replace_array, $rankology_oembed_title);

    //Hook on post oEmbed title - 'rankology_oembed_title'
    $rankology_oembed_title = apply_filters('rankology_oembed_title', $rankology_oembed_title);

    return $rankology_oembed_title;
}

/**
 * Get Oembed Thumbnail (custom OG:IMAGE or Post thumbnail)
 * 
 * @param string $post
 * @return array rankology_oembed_thumbnail
 * @author Team Rankology
 */
function rankology_oembed_thumbnail_hook($post)
{
    //Init
    $rankology_oembed_thumbnail = [];

    //If OG title set
    if (get_post_meta($post->ID, '_rankology_social_fb_img', true) !='') {
        $rankology_oembed_thumbnail['url'] = get_post_meta($post->ID, '_rankology_social_fb_img', true);
    } elseif (get_post_thumbnail_id($post) !='') {
        $post_thumbnail_id 	=  get_post_thumbnail_id($post);

        $img_size 			= 'full';

        $img_size 			= apply_filters('rankology_oembed_thumbnail_size', $img_size);

        $attachment 		= wp_get_attachment_image_src($post_thumbnail_id, $img_size);

        if (is_array($attachment)) {
            $rankology_oembed_thumbnail['url'] 		= $attachment[0];
            $rankology_oembed_thumbnail['width']		= $attachment[1];
            $rankology_oembed_thumbnail['height'] 	= $attachment[2];
        }
    }

    //Hook on post oEmbed thumbnail - 'rankology_oembed_thumbnail'
    $rankology_oembed_thumbnail = apply_filters('rankology_oembed_thumbnail', $rankology_oembed_thumbnail);

    return $rankology_oembed_thumbnail;
}

add_filter('oembed_response_data', 'rankology_oembed_response_data', 10, 4);
function rankology_oembed_response_data($data, $post, $width, $height)
{
    if (function_exists('rankology_oembed_title_hook') && rankology_oembed_title_hook($post) !='') {
        $data['title'] = rankology_oembed_title_hook($post);
    }
    if (function_exists('rankology_oembed_thumbnail_hook') && rankology_oembed_thumbnail_hook($post) !='') {
        $thumbnail = rankology_oembed_thumbnail_hook($post);

        if (!empty($thumbnail['url'])) {
            $data['thumbnail_url']		= $thumbnail['url'];
        }
        if (!empty($thumbnail['width'])) {
            $data['thumbnail_width']	= $thumbnail['width'];
        } else {
            $data['thumbnail_width']	= '';
        }
        if (!empty($thumbnail['height'])) {
            $data['thumbnail_height']	= $thumbnail['height'];
        } else {
            $data['thumbnail_height']	= '';
        }
    }
    return $data;
}
