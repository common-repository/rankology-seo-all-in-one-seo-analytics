<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

function rankology_advanced_advanced_attachments_callback() {
    $options = get_option('rankology_advanced_option_name');

    $check = isset($options['rankology_advanced_advanced_attachments']); ?>

<label for="rankology_advanced_advanced_attachments">
    <input id="rankology_advanced_advanced_attachments"
        name="rankology_advanced_option_name[rankology_advanced_advanced_attachments]" type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>
    <?php esc_html_e('Redirect attachment pages to post parent (or homepage if none)', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_advanced_advanced_attachments'])) {
        esc_attr($options['rankology_advanced_advanced_attachments']);
    }
}

function rankology_advanced_advanced_attachments_file_callback() {
    $options = get_option('rankology_advanced_option_name');

    $check = isset($options['rankology_advanced_advanced_attachments_file']); ?>

<label for="rankology_advanced_advanced_attachments_file">
    <input id="rankology_advanced_advanced_attachments_file"
        name="rankology_advanced_option_name[rankology_advanced_advanced_attachments_file]" type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>

    <?php esc_html_e('Redirect attachment pages to their file URL (https://www.example.com/my-image-file.jpg)', 'wp-rankology'); ?>
</label>

<p class="description">
    <?php esc_html_e('If this option is checked, it will take precedence over the redirection of attachments to the post\'s parent.', 'wp-rankology'); ?>
</p>

<?php if (isset($options['rankology_advanced_advanced_attachments_file'])) {
        esc_attr($options['rankology_advanced_advanced_attachments_file']);
    }
}

function rankology_advanced_advanced_clean_filename_callback() {
    $options = get_option('rankology_advanced_option_name');

    $check = isset($options['rankology_advanced_advanced_clean_filename']); ?>

<label for="rankology_advanced_advanced_clean_filename">
    <input id="rankology_advanced_advanced_clean_filename"
        name="rankology_advanced_option_name[rankology_advanced_advanced_clean_filename]" type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>

    <?php esc_html_e('When upload a media, remove accents, spaces, capital letters... and force UTF-8 encoding', 'wp-rankology'); ?>
</label>

<p class="description">
    <?php echo wp_kses(__('e.g. <code>ExãMple 1 cópy!.jpg</code> => <code>example-1-copy.jpg</code>', 'wp-rankology'), array('code' => array())); ?>
</p>

<?php if (isset($options['rankology_advanced_advanced_clean_filename'])) {
        esc_attr($options['rankology_advanced_advanced_clean_filename']);
    }
}

function rankology_advanced_advanced_image_auto_title_editor_callback() {
    $options = get_option('rankology_advanced_option_name');

    $check = isset($options['rankology_advanced_advanced_image_auto_title_editor']); ?>

<label for="rankology_advanced_advanced_image_auto_title_editor">
    <input id="rankology_advanced_advanced_image_auto_title_editor"
        name="rankology_advanced_option_name[rankology_advanced_advanced_image_auto_title_editor]" type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>

    <?php esc_html_e('When uploading an image file, automatically set the title based on the filename', 'wp-rankology'); ?>
</label>

<p class="description">
    <?php esc_html_e('We use the product title for WooCommerce products.', 'wp-rankology'); ?>
</p>

<?php if (isset($options['rankology_advanced_advanced_image_auto_title_editor'])) {
        esc_attr($options['rankology_advanced_advanced_image_auto_title_editor']);
    }
}

function rankology_advanced_advanced_image_auto_alt_editor_callback() {
    $options = get_option('rankology_advanced_option_name');

    $check = isset($options['rankology_advanced_advanced_image_auto_alt_editor']); ?>

<label for="rankology_advanced_advanced_image_auto_alt_editor">
    <input id="rankology_advanced_advanced_image_auto_alt_editor"
        name="rankology_advanced_option_name[rankology_advanced_advanced_image_auto_alt_editor]" type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>

    <?php esc_html_e('When uploading an image file, automatically set the alternative text based on the filename', 'wp-rankology'); ?>
</label>

<?php

    if (isset($options['rankology_advanced_advanced_image_auto_alt_editor'])) {
        esc_attr($options['rankology_advanced_advanced_image_auto_alt_editor']);
    }
}

function rankology_advanced_advanced_image_auto_alt_target_kw_callback() {
    $options = get_option('rankology_advanced_option_name');

    $check = isset($options['rankology_advanced_advanced_image_auto_alt_target_kw']); ?>

<label for="rankology_advanced_advanced_image_auto_alt_target_kw">
    <input id="rankology_advanced_advanced_image_auto_alt_target_kw"
        name="rankology_advanced_option_name[rankology_advanced_advanced_image_auto_alt_target_kw]" type="checkbox"
        <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>

    <?php esc_html_e('Use the target keywords if not alternative text set for the image', 'wp-rankology'); ?>
</label>

<p class="description">
    <?php esc_html_e('This setting will be applied to images without any alt text only on frontend.', 'wp-rankology'); ?>
</p>

<?php if (isset($options['rankology_advanced_advanced_image_auto_alt_target_kw'])) {
        esc_attr($options['rankology_advanced_advanced_image_auto_alt_target_kw']);
    }
}

function rankology_advanced_advanced_image_auto_caption_editor_callback() {
    $options = get_option('rankology_advanced_option_name');

    $check = isset($options['rankology_advanced_advanced_image_auto_caption_editor']); ?>

<label for="rankology_advanced_advanced_image_auto_caption_editor">
    <input id="rankology_advanced_advanced_image_auto_caption_editor"
        name="rankology_advanced_option_name[rankology_advanced_advanced_image_auto_caption_editor]" type="checkbox"
        <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>

    <?php esc_html_e('When uploading an image file, automatically set the caption based on the filename', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_advanced_advanced_image_auto_caption_editor'])) {
        esc_attr($options['rankology_advanced_advanced_image_auto_caption_editor']);
    }
}

function rankology_advanced_advanced_image_auto_desc_editor_callback() {
    $options = get_option('rankology_advanced_option_name');

    $check = isset($options['rankology_advanced_advanced_image_auto_desc_editor']); ?>
<label for="rankology_advanced_advanced_image_auto_desc_editor">
    <input id="rankology_advanced_advanced_image_auto_desc_editor"
        name="rankology_advanced_option_name[rankology_advanced_advanced_image_auto_desc_editor]" type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>

    <?php esc_html_e('When uploading an image file, automatically set the description based on the filename', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_advanced_advanced_image_auto_desc_editor'])) {
        esc_attr($options['rankology_advanced_advanced_image_auto_desc_editor']);
    }
}
