<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

function rankology_xml_sitemap_general_enable_callback()
{

    $options = get_option('rankology_xml_sitemap_option_name');

    $check = isset($options['rankology_xml_sitemap_general_enable']); ?>


<label for="rankology_xml_sitemap_general_enable">
    <input id="rankology_xml_sitemap_general_enable"
        name="rankology_xml_sitemap_option_name[rankology_xml_sitemap_general_enable]" type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>
    <?php esc_html_e('Enable XML Sitemap', 'wp-rankology'); ?>
</label>


<?php if (isset($options['rankology_xml_sitemap_general_enable'])) {
        esc_attr($options['rankology_xml_sitemap_general_enable']);
    }
}

function rankology_xml_sitemap_img_enable_callback()
{

    $options = get_option('rankology_xml_sitemap_option_name');

    $check = isset($options['rankology_xml_sitemap_img_enable']); ?>


<label for="rankology_xml_sitemap_img_enable">
    <input id="rankology_xml_sitemap_img_enable" name="rankology_xml_sitemap_option_name[rankology_xml_sitemap_img_enable]"
        type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>
    <?php esc_html_e('Enable Image Sitemap (standard images, image galleries, featured image, WooCommerce product images)', 'wp-rankology'); ?>
</label>


<p class="description">
    <?php esc_html_e('Images in XML sitemaps are visible only from the source code.', 'wp-rankology'); ?>
</p>

<?php if (isset($options['rankology_xml_sitemap_img_enable'])) {
        esc_attr($options['rankology_xml_sitemap_img_enable']);
    }
}

function rankology_xml_sitemap_author_enable_callback()
{
    $options = get_option('rankology_xml_sitemap_option_name');

    $check = isset($options['rankology_xml_sitemap_author_enable']); ?>


<label for="rankology_xml_sitemap_author_enable">
    <input id="rankology_xml_sitemap_author_enable"
        name="rankology_xml_sitemap_option_name[rankology_xml_sitemap_author_enable]" type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>
    <?php esc_html_e('Enable Author Sitemap', 'wp-rankology'); ?>
</label>

<p class="description">
    <?php esc_html_e('Make sure to enable author archive from SEO, titles and metas, archives tab.</a>', 'wp-rankology'); ?>
</p>

<?php if (isset($options['rankology_xml_sitemap_author_enable'])) {
        esc_attr($options['rankology_xml_sitemap_author_enable']);
    }
}

function rankology_xml_sitemap_html_enable_callback()
{

    $options = get_option('rankology_xml_sitemap_option_name');

    $check = isset($options['rankology_xml_sitemap_html_enable']); ?>


<label for="rankology_xml_sitemap_html_enable">
    <input id="rankology_xml_sitemap_html_enable"
        name="rankology_xml_sitemap_option_name[rankology_xml_sitemap_html_enable]" type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>
    <?php esc_html_e('Enable HTML Sitemap', 'wp-rankology'); ?>
</label>


<?php if (isset($options['rankology_xml_sitemap_html_enable'])) {
        esc_attr($options['rankology_xml_sitemap_html_enable']);
    }
}

function rankology_xml_sitemap_post_types_list_callback()
{
    $options = get_option('rankology_xml_sitemap_option_name');

    $check = isset($options['rankology_xml_sitemap_post_types_list']);

    $postTypes = rankology_get_service('WordPressData')->getPostTypes();

    $postTypes = array_filter($postTypes, 'is_post_type_viewable');

    $postTypes[] = get_post_type_object('attachment');

    $postTypes = apply_filters( 'rankology_sitemaps_cpt', $postTypes );

    foreach ($postTypes as $rankology_cpt_key => $rankology_cpt_value) {
        ?>
<h3>
    <?php echo rankology_common_esc_str($rankology_cpt_value->labels->name); ?>
    <em><small>(<?php echo rankology_common_esc_str($rankology_cpt_value->name); ?>)</small></em>
</h3>

<!--List all post types-->
<div class="rankology_wrap_single_cpt">

    <?php
        $options = get_option('rankology_xml_sitemap_option_name');
        $check   = isset($options['rankology_xml_sitemap_post_types_list'][$rankology_cpt_key]['include']);
        ?>

    <label
        for="rankology_xml_sitemap_post_types_list_include[<?php echo rankology_common_esc_str($rankology_cpt_key); ?>]">
        <input
            id="rankology_xml_sitemap_post_types_list_include[<?php echo rankology_common_esc_str($rankology_cpt_key); ?>]"
            name="rankology_xml_sitemap_option_name[rankology_xml_sitemap_post_types_list][<?php echo rankology_common_esc_str($rankology_cpt_key); ?>][include]"
            type="checkbox" <?php if ('1' == $check) { ?>
        checked="yes"
        <?php } ?>
        value="1"/>
        <?php esc_html_e('Include', 'wp-rankology'); ?>
    </label>

    <?php if ('attachment' == $rankology_cpt_value->name) { ?>
    <div class="rankology-notice is-warning is-inline">
        <p>
            <?php esc_html_e('You should never include <strong>attachment</strong> post type in your sitemap. Be careful if you checked this.', 'wp-rankology'); ?>
        </p>
    </div>
    <?php } ?>

    <?php
        if (isset($options['rankology_xml_sitemap_post_types_list'][$rankology_cpt_key]['include'])) {
            esc_attr($options['rankology_xml_sitemap_post_types_list'][$rankology_cpt_key]['include']);
        }
        ?>
</div>
<?php
    }
}

function rankology_xml_sitemap_taxonomies_list_callback()
{
    $options = get_option('rankology_xml_sitemap_option_name');

    $check = isset($options['rankology_xml_sitemap_taxonomies_list']);

    $taxonomies = rankology_get_service('WordPressData')->getTaxonomies();

    $taxonomies = array_filter($taxonomies, 'is_taxonomy_viewable');

    $taxonomies = apply_filters( 'rankology_sitemaps_tax', $taxonomies );

    foreach ($taxonomies as $rankology_tax_key => $rankology_tax_value) { ?>
<h3>
    <?php echo rankology_common_esc_str($rankology_tax_value->labels->name); ?>
    <em><small>(<?php echo rankology_common_esc_str($rankology_tax_value->name); ?>)</small></em>
</h3>

<!--List all taxonomies-->
<div class="rankology_wrap_single_tax">

    <?php $options = get_option('rankology_xml_sitemap_option_name');

        $check = isset($options['rankology_xml_sitemap_taxonomies_list'][$rankology_tax_key]['include']); ?>

    <label
        for="rankology_xml_sitemap_taxonomies_list_include[<?php echo rankology_common_esc_str($rankology_tax_key); ?>]">
        <input
            id="rankology_xml_sitemap_taxonomies_list_include[<?php echo rankology_common_esc_str($rankology_tax_key); ?>]"
            name="rankology_xml_sitemap_option_name[rankology_xml_sitemap_taxonomies_list][<?php echo rankology_common_esc_str($rankology_tax_key); ?>][include]"
            type="checkbox" <?php if ('1' == $check) { ?>
        checked="yes"
        <?php } ?>
        value="1"/>
        <?php esc_html_e('Include', 'wp-rankology'); ?>
    </label>

    <?php if (isset($options['rankology_xml_sitemap_taxonomies_list'][$rankology_tax_key]['include'])) {
            esc_attr($options['rankology_xml_sitemap_taxonomies_list'][$rankology_tax_key]['include']);
        } ?>
</div>

<?php
    }
}

function rankology_xml_sitemap_html_mapping_callback()
{
    $options = get_option('rankology_xml_sitemap_option_name');
    $check   = isset($options['rankology_xml_sitemap_html_mapping']) ? $options['rankology_xml_sitemap_html_mapping'] : null;

    printf(
        '<input type="text" name="rankology_xml_sitemap_option_name[rankology_xml_sitemap_html_mapping]" placeholder="' . esc_html__('e.g. 2, 8, 18', 'wp-rankology') . '" aria-label="' . esc_html__('Enter a post, page or custom post type ID(s) to display the sitemap', 'wp-rankology') . '" value="%s"/>',
        esc_html($check)
    );
}

function rankology_xml_sitemap_html_exclude_callback()
{
    $options = get_option('rankology_xml_sitemap_option_name');
    $check   = isset($options['rankology_xml_sitemap_html_exclude']) ? $options['rankology_xml_sitemap_html_exclude'] : null;

    printf(
        '<input type="text" name="rankology_xml_sitemap_option_name[rankology_xml_sitemap_html_exclude]" placeholder="' . esc_html__('e.g. 3, 6, 10', 'wp-rankology') . '" aria-label="' . esc_html__('Exclude some Posts, Pages, Custom Post Types or Terms IDs', 'wp-rankology') . '" value="%s"/>',
        esc_html($check)
    );
}

function rankology_xml_sitemap_html_order_callback()
{
    $options = get_option('rankology_xml_sitemap_option_name');

    $selected = isset($options['rankology_xml_sitemap_html_order']) ? $options['rankology_xml_sitemap_html_order'] : null; ?>

<select id="rankology_xml_sitemap_html_order" name="rankology_xml_sitemap_option_name[rankology_xml_sitemap_html_order]">
    <option <?php if ('DESC' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="DESC"><?php esc_html_e('DESC (descending order from highest to lowest values)', 'wp-rankology'); ?>
    </option>
    <option <?php if ('ASC' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="ASC"><?php esc_html_e('ASC (ascending order from lowest to highest values)', 'wp-rankology'); ?>
    </option>
</select>

<?php if (isset($options['rankology_xml_sitemap_html_order'])) {
        esc_attr($options['rankology_xml_sitemap_html_order']);
    }
}

function rankology_xml_sitemap_html_orderby_callback()
{
    $options = get_option('rankology_xml_sitemap_option_name');

    $selected = isset($options['rankology_xml_sitemap_html_orderby']) ? $options['rankology_xml_sitemap_html_orderby'] : null; ?>

<select id="rankology_xml_sitemap_html_orderby"
    name="rankology_xml_sitemap_option_name[rankology_xml_sitemap_html_orderby]">
    <option <?php if ('date' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="date"><?php esc_html_e('Default (date)', 'wp-rankology'); ?>
    </option>
    <option <?php if ('title' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="title"><?php esc_html_e('Post Title', 'wp-rankology'); ?>
    </option>
    <option <?php if ('modified' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="modified"><?php esc_html_e('Modified date', 'wp-rankology'); ?>
    </option>
    <option <?php if ('ID' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="ID"><?php esc_html_e('Post ID', 'wp-rankology'); ?>
    </option>
    <option <?php if ('menu_order' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="menu_order"><?php esc_html_e('Menu order', 'wp-rankology'); ?>
    </option>
</select>

<?php if (isset($options['rankology_xml_sitemap_html_orderby'])) {
        esc_attr($options['rankology_xml_sitemap_html_orderby']);
    }
}

function rankology_xml_sitemap_html_date_callback()
{
    $options = get_option('rankology_xml_sitemap_option_name');

    $check = isset($options['rankology_xml_sitemap_html_date']); ?>


<label for="rankology_xml_sitemap_html_date">
    <input id="rankology_xml_sitemap_html_date" name="rankology_xml_sitemap_option_name[rankology_xml_sitemap_html_date]"
        type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>
    <?php esc_html_e('Disable date after each post, page, post type?', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_xml_sitemap_html_date'])) {
        esc_attr($options['rankology_xml_sitemap_html_date']);
    }
}

function rankology_xml_sitemap_html_archive_links_callback()
{
    $options = get_option('rankology_xml_sitemap_option_name');

    $check = isset($options['rankology_xml_sitemap_html_archive_links']); ?>


<label for="rankology_xml_sitemap_html_archive_links">
    <input id="rankology_xml_sitemap_html_archive_links"
        name="rankology_xml_sitemap_option_name[rankology_xml_sitemap_html_archive_links]" type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>
    <?php esc_html_e('Remove links from archive pages (e.g. Products)', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_xml_sitemap_html_archive_links'])) {
        esc_attr($options['rankology_xml_sitemap_html_archive_links']);
    }
}
