<?php

namespace Rankology\Services\ContentAnalysis;

defined('ABSPATH') or exit('Cheatin&#8217; uh?');

class RenderContentAnalysis {
    public function render($analyzes, $analysis_data) {
        ?>
        <div id="rankology-analysis-tabs">
            <div id="rankology-analysis-tabs-1">
                <div class="analysis-score">
                    <?php
                    $impact = array_unique(array_values(wp_list_pluck($analyzes, 'impact')));
                    $impact_all_vals = array_values(wp_list_pluck($analyzes, 'impact'));
                    if (!empty($impact_all_vals)) {
                        $total_impacts = count($impact_all_vals);
                        $high_counts = $medium_counts = $low_counts = $good_counts = 0;
                        foreach ($impact_all_vals as $impact_val) {
                            if ($impact_val == 'good') {
                                $good_counts++;
                            } else if ($impact_val == 'low') {
                                $low_counts++;
                            } else if ($impact_val == 'medium') {
                                $medium_counts++;
                            } else {
                                $high_counts++;
                            }
                        }

                        $avg_ovrall_score = 2;
                        if ($good_counts > 0 && $total_impacts > 0 && $total_impacts > $good_counts) {
                            $avg_ovrall_score = ceil(($good_counts/$total_impacts) * 100);
                        }

                        // Enqueue the script and pass data to it
                        add_action('admin_enqueue_scripts', function() use ($avg_ovrall_score) {
                            wp_register_script('rankology-content-analysis', plugins_url('/assets/js/rankology-content-analysis.js', __FILE__), [], '1.0.0', true);
                            wp_enqueue_script('rankology-content-analysis');

                            $score_color = '#e93f30';
                            $score_bgcolor = '#fdeae8';
                            $score_txt = absint($avg_ovrall_score) . ' / 100';

                            if ($avg_ovrall_score > 80) {
                                $score_color = '#58bb58';
                                $score_bgcolor = '#e9f6e9';
                            } else if ($avg_ovrall_score > 70 && $avg_ovrall_score <= 80) {
                                $score_color = '#bf890d';
                                $score_bgcolor = '#fdf0c4';
                            } else if ($avg_ovrall_score >= 50 && $avg_ovrall_score <= 70) {
                                $score_color = '#bc690a';
                                $score_bgcolor = '#ffddb6';
                            }

                            $score_data = [
                                'score_bgcolor' => $score_bgcolor,
                                'score_color' => $score_color,
                                'score_txt' => $score_txt,
                            ];

                            wp_add_inline_script(
                                'rankology-content-analysis',
                                sprintf(
                                    'var rankologyScoreData = %s;',
                                    wp_json_encode($score_data)
                                )
                            );
                        }, 90);
                    }
                    
                    $tooltip = rankology_tooltip(__('Content overview', 'wp-rankology'), esc_html__('<strong>Overall score is better, Could Be Enhanced:</strong> red or orange bars <br> <strong>Good:</strong> yellow or green bars', 'wp-rankology'), '');

                    if (!empty($impact)) {
                        if (in_array('medium', $impact) || in_array('high', $impact)) {
                            $score = false; ?><p class="avgscore"><span><?php echo esc_html__('Overall score is better, Could Be Enhanced', 'wp-rankology') . $tooltip; ?></span></p>
                        <?php
                        } else {
                            $score = true; ?><p class="goodscore"><span><?php echo esc_html__('Good', 'wp-rankology') . $tooltip; ?></span></p>
                        <?php
                        }
                    } else {
                        $score = false;
                    }

                    if (!empty($analysis_data) && is_array($analysis_data)) {
                        $analysis_data['score'] = $score;
                        update_post_meta(get_the_ID(), '_rankology_analysis_data', $analysis_data);
                        delete_post_meta(get_the_ID(), '_rankology_content_analysis_api');
                    } ?>
                </div><!-- .analysis-score -->
                <?php
                if (!empty($analyzes)) {
                    $order = [
                        '1' => 'high',
                        '2' => 'medium',
                        '3' => 'low',
                        '4' => 'good',
                    ];

                    usort($analyzes, function ($a, $b) use ($order) {
                        $pos_a = array_search($a['impact'], $order);
                        $pos_b = array_search($b['impact'], $order);

                        return $pos_a - $pos_b;
                    });

                    foreach ($analyzes as $key => $value) {
                        ?>
                        <div class="gr-analysis">
                            <?php if (isset($value['title'])) { ?>
                                <div class="gr-analysis-title">
                                    <h3>
                                        <button type="button" aria-expanded="false" class="btn-toggle rkns-togl-<?php echo rankology_common_esc_str($value['impact']); ?>">
                                            <span class="rankology-arrow" aria-hidden="true"></span>
                                            <?php echo rankology_common_esc_str($value['title']); ?>
                                            <?php if (isset($value['impact'])) { ?>
                                                <span class="screen-reader-text"><?php printf(esc_html__('Degree of severity: %s','wp-rankology'), $value['impact']); ?></span>
                                            <?php } ?>
                                        </button>
                                    </h3>
                                </div>
                            <?php } ?>
                            <?php if (isset($value['desc'])) { ?>
                                <div class="gr-analysis-content" aria-hidden="true"><?php echo rankology_common_esc_str($value['desc']); ?></div>
                            <?php } ?>
                        </div><!-- .gr-analysis -->
                    <?php
                    }
                } ?>
            </div><!-- #rankology-analysis-tabs-1 -->
        </div><!-- #rankology-analysis-tabs -->
        <?php
    }
}
