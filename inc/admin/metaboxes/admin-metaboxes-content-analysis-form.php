<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

$data_attr = rankology_metaboxes_init();
?>

<div id="rankology-ca-tabs" class="wrap-rankology-analysis rankology-tabs-preview"
    data-home-id="<?php echo rankology_common_esc_str($data_attr['isHomeId']); ?>"
    data-term-id="<?php echo rankology_common_esc_str($data_attr['termId']); ?>"
    data_id="<?php echo rankology_common_esc_str($data_attr['current_id']); ?>"
    data_origin="<?php echo rankology_common_esc_str($data_attr['origin']); ?>"
    data_tax="<?php echo rankology_common_esc_str($data_attr['data_tax']); ?>">

    <?php do_action('rankology_ca_tab_before'); ?>

    <div id="rankology-ca-tabs-2">
        <p>
            <?php esc_html_e('Enter keywords for analysis and you can also use google suggestions to write optimized content.', 'wp-rankology'); ?>
        </p>
        <div class="col-left">
            <p>
                <label for="rankology_analysis_target_kw_meta"><?php esc_html_e('Target keywords', 'wp-rankology'); ?>
                    <?php echo rankology_tooltip(esc_html__('Target keywords', 'wp-rankology'), esc_html__('Separate target keywords with commas. Do not use spaces after the commas, unless you want to include them', 'wp-rankology'), esc_html('my super keyword,another keyword,keyword')); ?>
                </label>
                <input id="rankology_analysis_target_kw_meta" type="text" name="rankology_analysis_target_kw"
                    placeholder="<?php esc_html_e('Enter your target keywords', 'wp-rankology'); ?>"
                    aria-label="<?php esc_html_e('Target keywords', 'wp-rankology'); ?>"
                    value="<?php echo esc_attr($rankology_analysis_target_kw); ?>" />
            </p>

            <button id="rankology_launch_analysis" type="button" class="<?php echo rankology_btn_secondary_classes(); ?>" data_id="<?php echo get_the_ID(); ?>" data_post_type="<?php echo get_current_screen()->post_type; ?>"><?php esc_html_e('Refresh analysis', 'wp-rankology'); ?></button>

            <?php do_action('rankology_ca_after_resfresh_analysis'); ?>

            <p><span class="description"><?php esc_html_e('To get the most accurate analysis, save your post first. We analyze all of your source code as a search engine would.', 'wp-rankology'); ?></span></p>
        </div>
            <?php do_action('rankology_ca_before'); ?>

            <div id="rankology-wrap-notice-target-kw" style="clear:both">
                <?php
                    $html = '';
                    $i = 0;
                    if (!empty($rankology_analysis_data['target_kws_count'])) {
                        foreach($rankology_analysis_data['target_kws_count'] as $kw => $item) {
                            if(!is_array($item)){
                                continue;
                            }

                            if(count($item['rows']) === 0){
                                continue;
                            }
                            $html .= '<li>
                                    <span class="dashicons dashicons-minus"></span>
                                    <strong>' . $item['key'] . '</strong>
                                    ' . sprintf(_n('is already used %d time', 'is already used %d times', count($item['rows']), 'wp-rankology'), count($item['rows'])). '
                                </li>';
                            $i++;
                        }
                    }
                ?>

                <?php if (!empty($html)) { ?>
                    <div id="rankology-notice-target-kw" class="rankology-notice is-warning">
                        <p><?php printf(_n('The keyword:','These keywords:', $i, 'wp-rankology'), number_format_i18n($i)); ?></p>
                        <ul>
                            <?php echo rankology_common_esc_str($html); ?>
                        </ul>
                        <p><?php esc_html_e('You should avoid using multiple times the same keyword for different pages. Try to consolidate your content into one single page.','wp-rankology'); ?></p>
                    </div>
                <?php } ?>
            </div>
        <?php
        if (function_exists('rankology_get_service')) {
            $analyzes = rankology_get_service('GetContentAnalysis')->getAnalyzes($post);
            rankology_get_service('RenderContentAnalysis')->render($analyzes, $rankology_analysis_data);
        } ?>
    </div>
    <?php do_action('rankology_ca_tab_after', $data_attr['current_id']); ?>
</div>
