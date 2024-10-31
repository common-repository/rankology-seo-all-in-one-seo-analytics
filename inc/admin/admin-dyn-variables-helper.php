<?php

function rankology_get_dyn_variables()
{
    return apply_filters('rankology_get_dynamic_variables', [
        '%%sep%%'                           => 'Separator',
        '%%sitetitle%%'                     => esc_html__('Site Title', 'wp-rankology'),
        '%%tagline%%'                       => esc_html__('Tagline', 'wp-rankology'),
        '%%post_title%%'                    => esc_html__('Post Title', 'wp-rankology'),
        '%%post_excerpt%%'                  => esc_html__('Post excerpt', 'wp-rankology'),
        '%%post_content%%'                  => esc_html__('Post content / product description', 'wp-rankology'),
        '%%post_thumbnail_url%%'            => esc_html__('Post thumbnail URL', 'wp-rankology'),
        '%%post_url%%'                      => esc_html__('Post URL', 'wp-rankology'),
        '%%post_date%%'                     => esc_html__('Post date', 'wp-rankology'),
        '%%post_modified_date%%'            => esc_html__('Post modified date', 'wp-rankology'),
        '%%post_author%%'                   => esc_html__('Post author', 'wp-rankology'),
        '%%post_category%%'                 => esc_html__('Post category', 'wp-rankology'),
        '%%post_tag%%'                      => esc_html__('Post tag', 'wp-rankology'),
        '%%_category_title%%'               => esc_html__('Category title', 'wp-rankology'),
        '%%_category_description%%'         => esc_html__('Category description', 'wp-rankology'),
        '%%tag_title%%'                     => esc_html__('Tag title', 'wp-rankology'),
        '%%tag_description%%'               => esc_html__('Tag description', 'wp-rankology'),
        '%%term_title%%'                    => esc_html__('Term title', 'wp-rankology'),
        '%%term_description%%'              => esc_html__('Term description', 'wp-rankology'),
        '%%search_keywords%%'               => esc_html__('Search keywords', 'wp-rankology'),
        '%%current_pagination%%'            => esc_html__('Current number page', 'wp-rankology'),
        '%%page%%'                          => esc_html__('Page number with context', 'wp-rankology'),
        '%%cpt_plural%%'                    => esc_html__('Plural Post Type Archive name', 'wp-rankology'),
        '%%archive_title%%'                 => esc_html__('Archive title', 'wp-rankology'),
        '%%archive_date%%'                  => esc_html__('Archive date', 'wp-rankology'),
        '%%archive_date_day%%'              => esc_html__('Day Archive date', 'wp-rankology'),
        '%%archive_date_month%%'            => esc_html__('Month Archive title', 'wp-rankology'),
        '%%archive_date_month_name%%'       => esc_html__('Month name Archive title', 'wp-rankology'),
        '%%archive_date_year%%'             => esc_html__('Year Archive title', 'wp-rankology'),
        '%%_cf_your_custom_field_name%%'    => esc_html__('Custom fields from post, page, post type and term taxonomy', 'wp-rankology'),
        '%%_ct_your_custom_taxonomy_slug%%' => esc_html__('Custom term taxonomy from post, page or post type', 'wp-rankology'),
        '%%wc_single_cat%%'                 => esc_html__('Single product category', 'wp-rankology'),
        '%%wc_single_tag%%'                 => esc_html__('Single product tag', 'wp-rankology'),
        '%%wc_single_short_desc%%'          => esc_html__('Single product short description', 'wp-rankology'),
        '%%wc_single_price%%'               => esc_html__('Single product price', 'wp-rankology'),
        '%%wc_single_price_exc_tax%%'       => esc_html__('Single product price taxes excluded', 'wp-rankology'),
        '%%wc_sku%%'                        => esc_html__('Single SKU product', 'wp-rankology'),
        '%%currentday%%'                    => esc_html__('Current day', 'wp-rankology'),
        '%%currentmonth%%'                  => esc_html__('Current month', 'wp-rankology'),
        '%%currentmonth_short%%'            => esc_html__('Current month in 3 letters', 'wp-rankology'),
        '%%currentyear%%'                   => esc_html__('Current year', 'wp-rankology'),
        '%%currentdate%%'                   => esc_html__('Current date', 'wp-rankology'),
        '%%currenttime%%'                   => esc_html__('Current time', 'wp-rankology'),
        '%%author_first_name%%'             => esc_html__('Author first name', 'wp-rankology'),
        '%%author_last_name%%'              => esc_html__('Author last name', 'wp-rankology'),
        '%%author_website%%'                => esc_html__('Author website', 'wp-rankology'),
        '%%author_nickname%%'               => esc_html__('Author nickname', 'wp-rankology'),
        '%%author_bio%%'                    => esc_html__('Author biography', 'wp-rankology'),
        '%%_ucf_your_user_meta%%'           => esc_html__('Custom User Meta', 'wp-rankology'),
        '%%currentmonth_num%%'              => esc_html__('Current month in digital format', 'wp-rankology'),
        '%%target_keyword%%'                => esc_html__('Target keyword', 'wp-rankology'),
    ]);
}

/**
 * @param string $classes
 *
 * @return string
 */
function rankology_render_dyn_variables($classes)
{
    $html = sprintf('<button type="button" class="'.rankology_btn_secondary_classes().' rankology-tag-single-all rankology-tag-dropdown %s"><span class="dashicons dashicons-arrow-down-alt2"></span></button>', $classes);
    if (! empty(rankology_get_dyn_variables())) {
        $html .= '<div class="rkseo-wrap-tag-variables-list"><ul class="rkseo-tag-variables-list">';
        foreach (rankology_get_dyn_variables() as $key => $value) {
            $html .= '<li data-value=' . $key . ' tabindex="0"><span>' . $value . '</span></li>';
        }
        $html .= '</ul></div>';
    }

    return rankology_common_esc_str($html);
}
