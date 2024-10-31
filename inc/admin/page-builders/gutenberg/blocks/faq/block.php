<?php

if (! defined('ABSPATH')) {
    die();
}

function rankology_register_block_faq() {
    $path = RANKOLOGY_PLUGIN_DIR_PATH . 'public/editor/blocks/faq/index.asset.php';
    if(!file_exists($path)){
        return;
    }

    $asset_file = include_once $path;
    wp_register_script(
        'wp-rankology-faq-block',
        RANKOLOGY_URL_PUBLIC . '/editor/blocks/faq/index.js',
        $asset_file['dependencies'],
        $asset_file['version']
    );

    wp_register_style(
        'wp-rankology-faq-block',
        RANKOLOGY_URL_PUBLIC . '/editor/blocks/faq/index.css',
        '',
        $asset_file['version']
    );

    register_block_type('wprankology/faq-block', [
        'editor_script' => 'wp-rankology-faq-block',
        'editor_style'  => 'wp-rankology-faq-block',
        'attributes' => array(
            'faqs' => array(
                'type'    => 'array',
                'default' => array( '' ),
                'items'   => array(
                    'type' => 'object',
                ),
            ),
            'listStyle' => array(
                'type' => 'string',
                'default' => 'none'
            ),
            'titleWrapper' => array(
                'type' => 'string',
                'default' => 'p'
            ),
            'imageSize' => array(
                'type' => 'string',
                'default' => 'thumbnail'
            ),
            'showFAQScheme' => array(
                'type' => 'boolean',
                'default' => false
            ),
            'showAccordion' => array(
                'type' => 'boolean',
                'default' => false
            ),
            'isProActive' => array(
                'type'    => 'boolean',
                'default' => true
            )
        ),
        'render_callback' => 'rankology_block_faq_render_frontend',
    ]);
}

function rankology_block_faq_render_frontend($attributes)
{
    if (is_admin() || defined('REST_REQUEST')) {
        return;
    }

    if (!is_array($attributes)) {
        return '';
    }

    $titleWrapper = isset($attributes['titleWrapper']) ? $attributes['titleWrapper'] : 'default';

    switch ($titleWrapper) {
        case 'h2':
            $titleTag = '<h2 class="wprankology-faq-question">';
            $titleCloseTag = '</h2>';
            break;
        case 'h3':
            $titleTag = '<h3 class="wprankology-faq-question">';
            $titleCloseTag = '</h3>';
            break;
        case 'h4':
            $titleTag = '<h4 class="wprankology-faq-question">';
            $titleCloseTag = '</h4>';
            break;
        case 'h5':
            $titleTag = '<h5 class="wprankology-faq-question">';
            $titleCloseTag = '</h5>';
            break;
        case 'h6':
            $titleTag = '<h6 class="wprankology-faq-question">';
            $titleCloseTag = '</h6>';
            break;
        case 'p':
            $titleTag = '<p class="wprankology-faq-question">';
            $titleCloseTag = '</p>';
            break;
        default:
            $titleTag = '<div class="wprankology-faq-question">';
            $titleCloseTag = '</div>';
            break;
    }

    $listStyle = isset($attributes['listStyle']) ? $attributes['listStyle'] : 'default';

    switch ($listStyle) {
        case 'ul':
            $listStyleTag = '<ul class="wprankology-faqs">';
            $listStyleCloseTag = '</ul>';
            $listItemStyle = '<li class="wprankology-faq">';
            $listItemStyleClosingTag = '</li>';
            break;
        case 'ol':
            $listStyleTag = '<ol class="wprankology-faqs">';
            $listStyleCloseTag = '</ol>';
            $listItemStyle = '<li class="wprankology-faq">';
            $listItemStyleClosingTag = '</li>';
            break;
        default:
            $listStyleTag = '<div class="wprankology-faqs">';
            $listStyleCloseTag = '</div>';
            $listItemStyle = '<div class="wprankology-faq">';
            $listItemStyleClosingTag = '</div>';
            break;
    }

    $entities = [];

    ob_start(); ?>
    <?php echo rankology_common_esc_str($listStyleTag); ?>
    <?php
if (is_array($attributes['faqs'])) {
    foreach ($attributes['faqs'] as $faq) :
        if (!is_array($faq) || empty($faq['question'])) {
            continue;
        }

        $i = rand();

        $entity = [
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => !empty($faq['answer']) ? $faq['answer'] : ''
            ]
        ];
        $entities[] = $entity;

        $accordion = $attributes['showAccordion'];

        if ($accordion) {
            // Our simple accordion JS
            wp_enqueue_script('rankology-accordion', RANKOLOGY_URL_PUBLIC . '/editor/blocks/faq/accordion.js', '', RANKOLOGY_VERSION, true);
        }

        $image = '';
        $image_alt = '';
        if (isset($faq['image']) && is_int($faq['image'])) {
            $image = wp_get_attachment_image_src($faq['image'], $attributes['imageSize']);
            $image_alt = get_post_meta($faq['image'], '_wp_attachment_image_alt', true);
        }

        $image_url = '';
        if (isset($image) && !empty($image)) {
            $image_url = $image[0];
        } ?>
        <?php echo rankology_common_esc_str($listItemStyle); ?>
        <?php if ($accordion) { ?>
            <div id="wprankology-faq-title-<?php echo rankology_common_esc_str($i); ?>" class="wprankology-wrap-faq-question">
                <button class="wprankology-accordion-button" type="button" aria-expanded="false" aria-controls="wprankology-faq-answer-<?php echo rankology_common_esc_str($i); ?>">
        <?php } ?>
        <?php echo rankology_common_esc_str($titleTag . $faq['question'] . $titleCloseTag); ?>
        <?php if ($accordion) { ?>
                </button>
            </div>
        <?php } ?>

        <?php if ($accordion) { ?>
            <div id="wprankology-faq-answer-<?php echo rankology_common_esc_str($i); ?>" class="wprankology-faq-answer wprankology-hide" aria-labelledby="wprankology-faq-title-<?php echo rankology_common_esc_str($i); ?>">
        <?php } else { ?>
            <div class="wprankology-faq-answer">
        <?php } ?>
        <?php if (!empty($image_url)): ?>
            <div class="wprankology-faq-answer-image">
                <img src="<?php echo rankology_common_esc_str($image_url); ?>" alt="<?php echo rankology_common_esc_str($image_alt); ?>">
            </div>
        <?php endif; ?>
        <?php if (!empty($faq['answer'])): ?>
            <p class="wprankology-faq-answer-desc"><?php echo rankology_common_esc_str($faq['answer']); ?></p>
        <?php endif; ?>
        </div>
        <?php echo rankology_common_esc_str($listItemStyleClosingTag);
    endforeach;
}
?>

    <?php echo rankology_common_esc_str($listStyleCloseTag);

    // FAQ Schema
    if ((bool) $attributes['isProActive'] && (int) $attributes['showFAQScheme']) {
        wp_enqueue_script('rankology-faq-schema', plugin_dir_url(__FILE__) . 'js/rankology-faq-schema.js', array(), '1.0', true);
        $schema = array(
            "@context" => "https://schema.org",
            "@type" => "FAQPage",
            "mainEntity" => $entities
        );
        wp_add_inline_script('rankology-faq-schema', 'var rankologySchema = ' . wp_json_encode($schema) . ';', 'before');
    }

    $html = apply_filters('rankology_faq_block_html', ob_get_clean());
    return rankology_common_esc_str($html);
}

add_action('wp_enqueue_scripts', 'rankology_block_faq_render_frontend');
