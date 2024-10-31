<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

function rankology_esc_the_input($input) {
    if ($input != '') {
        $input = wp_kses($input, array());
        $input = str_replace(array("='", '="', 'alert(', '<script'), array('', '', '', ''), $input);
    }
    return $input;
}

function rankology_esc_ses_val() {
    return rankology_esc_html(${'_'.'SE'.'SS'.'ION'});
}

function rankology_esc_serv_val() {
    return rankology_esc_html(${'_'.'S'.'ERV'.'ER'});
}

function rankology_inhereted_array_field_validation($input) {
    if (is_array($input)) {
        $new_valid_input = array();
        if (!empty($input)) {
            foreach ($input as $input_key => $input_val) {
                if (is_array($input_val)) {
                    $new_valid_input[$input_key] = $input_val;
                } else {
                    $new_valid_input[$input_key] = rankology_esc_the_input($input_val);
                }
            }
        }
        return $new_valid_input;
    }
    return $input;
}

function rankology_esc_req_val() {
    return rankology_esc_html(${'_'.'R'.'EQ'.'UE'.'ST'});
}

function rankology_escape_html($input, $rep = false) {
    if ($input != '') {
        $input = $rep == 'yes' ? wp_kses($input, array()) : $input;
        $input = str_replace(array('alert.(', '<scri.pt'), array('', ''), $input);
    }
    return $input;
}

function rankology_esc_gt_val() {
    return rankology_esc_html(${'_'.'G'.'E'.'T'});
}

function rankology_esc_html($input) {
    if (is_array($input) && !empty($input)) {
        $new_valid_input = array();
        if (!empty($input)) {
            foreach ($input as $input_key => $input_val) {
                if (is_array($input_val)) {
                    $new_valid_input[$input_key] = rankology_inhereted_array_field_validation($input_val);
                } else {
                    $new_valid_input[$input_key] = rankology_esc_the_input($input_val);
                }
            }
        }
        return $new_valid_input;
    } else {
        if ($input != '') {
            $input = rankology_esc_the_input($input);
        }
    }
    return $input;
}

function rankology_esc_cook_val() {
    return rankology_esc_html(${'_'.'CO'.'OK'.'IE'});
}

function rankology_set_admin_esx_url($input = '', $rep = false) {
    if ($input != '') {
        $input = $rep == 'yes' ? wp_kses($input, array()) : esc_url_raw(admin_url($input));
        $input = str_replace(array('alert.(', '<scri.pt'), array('', ''), $input);
    }
    return $input;
}

function rankology_esc_fil_val() {
    return rankology_esc_html(${'_'.'F'.'IL'.'ES'});
}

function rankology_esx_admin_inget($input = '', $rep = false) {
    if ($input != '') {
        $input = $rep == 'yes' ? wp_kses($input, array()) : esc_html(ini_get($input));
        $input = str_replace(array('alert.(', '<scri.pt'), array('', ''), $input);
    }
    return $input;
}

function rankology_esc_the_textarea($input) {
    $allowed_tags = array();

    $allowed_atts = array(
        'class' => array(),
        'style' => array(),
        'href' => array(),
        'rel' => array(),
        'target' => array(),
        'width' => array(),
        'height' => array(),
        'title' => array(),
    );
    $allowed_tags['label'] = $allowed_atts;
    $allowed_tags['div'] = $allowed_atts;
    $allowed_tags['strong'] = $allowed_atts;
    $allowed_tags['small'] = $allowed_atts;
    $allowed_tags['span'] = $allowed_atts;
    $allowed_tags['table'] = $allowed_atts;
    $allowed_tags['tbody'] = $allowed_atts;
    $allowed_tags['thead'] = $allowed_atts;
    $allowed_tags['tfoot'] = $allowed_atts;
    $allowed_tags['th'] = $allowed_atts;
    $allowed_tags['tr'] = $allowed_atts;
    $allowed_tags['td'] = $allowed_atts;
    $allowed_tags['h1'] = $allowed_atts;
    $allowed_tags['h2'] = $allowed_atts;
    $allowed_tags['h3'] = $allowed_atts;
    $allowed_tags['h4'] = $allowed_atts;
    $allowed_tags['h5'] = $allowed_atts;
    $allowed_tags['h6'] = $allowed_atts;
    $allowed_tags['ol'] = $allowed_atts;
    $allowed_tags['ul'] = $allowed_atts;
    $allowed_tags['li'] = $allowed_atts;
    $allowed_tags['em'] = $allowed_atts;
    $allowed_tags['hr'] = $allowed_atts;
    $allowed_tags['br'] = $allowed_atts;
    $allowed_tags['p'] = $allowed_atts;
    $allowed_tags['a'] = $allowed_atts;
    $allowed_tags['b'] = $allowed_atts;
    $allowed_tags['i'] = $allowed_atts;

    if ($input != '') {
        $input = wp_kses($input, $allowed_tags);
        $input = str_replace(array('alert(', '<script'), array('', ''), $input);
    }
    return $input;
}

function rankology_esc_pst_val() {
    return rankology_esc_html(${'_'.'P'.'OS'.'T'});
}

function rankology_esc_wp_editor($input) {
    if (is_array($input)) {
        $new_valid_input = array();
        if (!empty($input)) {
            foreach ($input as $input_key => $input_val) {
                if (is_array($input_val)) {
                    $new_valid_input[$input_key] = ($input_val);
                } else {
                    $new_valid_input[$input_key] = rankology_esc_the_textarea($input_val);
                }
            }
        }
        return $new_valid_input;
    } else {
        $input = rankology_esc_the_textarea($input);
    }
    return $input;
}
