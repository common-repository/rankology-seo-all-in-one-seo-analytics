<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

///////////////////////////////////////////////////////////////////////////////////////////////////
//Import / Exports settings page
///////////////////////////////////////////////////////////////////////////////////////////////////
//Export Rankology Settings to JSON
function rankology_export_settings()
{
    if (empty($_POST['rankology_action']) || 'export_settings' != $_POST['rankology_action']) {
        return;
    }
    if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['rankology_export_nonce'])), 'rankology_export_nonce')) {
        return;
    }
    if (!current_user_can(rankology_capability('manage_options', 'export_settings'))) {
        return;
    }

    $settings = rankology_get_service('ExportSettings')->handle();

    ignore_user_abort(true);
    nocache_headers();
    header('Content-Type: application/json; charset=utf-8');
    header('Content-Disposition: attachment; filename=rankology-settings-export-' . date('m-d-Y') . '.json');
    header('Expires: 0');
    echo wp_json_encode($settings);
    exit;
}
add_action('admin_init', 'rankology_export_settings');

//Import Rankology Settings from JSON
function rankology_import_settings()
{
    // Check if the action is set and matches the expected action
    if (empty($_POST['rankology_action']) || 'import_settings' !== $_POST['rankology_action']) {
        return;
    }

    // Verify the nonce to prevent CSRF attacks
    if (!isset($_POST['rankology_import_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['rankology_import_nonce'])), 'rankology_import_nonce')) {
        return;
    }

    // Check if the current user has the required capability
    if (!current_user_can(rankology_capability('manage_options', 'import_settings'))) {
        return;
    }

    // Validate and sanitize the file extension
    if (!isset($_FILES['import_file']) || pathinfo(sanitize_file_name($_FILES['import_file']['name']), PATHINFO_EXTENSION) !== 'json') {
        wp_die(__('Please upload a valid .json file', 'wp-rankology'));
    }

    // Check for upload errors
    if ($_FILES['import_file']['error'] !== UPLOAD_ERR_OK) {
        wp_die(__('An error occurred during file upload. Please try again.', 'wp-rankology'));
    }

    // Sanitize and validate the uploaded file
    $import_file = sanitize_file_name($_FILES['import_file']['tmp_name']);

    // Ensure the file is not empty
    if (empty($import_file) || !is_uploaded_file($import_file)) {
        wp_die(__('Please upload a file to import', 'wp-rankology'));
    }

    // Read and decode the JSON file
    $file_contents = file_get_contents($import_file);
    if ($file_contents === false) {
        wp_die(__('Failed to read the uploaded file.', 'wp-rankology'));
    }

    // Remove any UTF-8 BOM and decode the JSON content
    $settings = json_decode(rankology_remove_utf8_bom($file_contents), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        wp_die(__('The uploaded file contains invalid JSON.', 'wp-rankology'));
    }

    // Validate the settings array
    if (!is_array($settings)) {
        wp_die(__('Invalid settings format in the uploaded file.', 'wp-rankology'));
    }

    // Handle the import process
    rankology_get_service('ImportSettings')->handle($settings);

    // Redirect to the success page
    wp_safe_redirect(admin_url('admin.php?page=rankology-import-export&success=true'));
    exit;
}
add_action('admin_init', 'rankology_import_settings');


// Import Redirections from CSV
function rankology_import_redirections_settings() {
    // Check if the action is valid
    if (empty($_POST['rankology_action']) || 'import_redirections_settings' != $_POST['rankology_action']) {
        return;
    }

    // Verify nonce for security
    if (!isset($_POST['rankology_import_redirections_nonce']) || 
        !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['rankology_import_redirections_nonce'])), 'rankology_import_redirections_nonce')) {
        wp_die(__('Nonce verification failed', 'wp-rankology'));
    }

    // Check user capability
    if (!current_user_can(rankology_capability('manage_options', 'import_settings'))) {
        wp_die(__('You do not have sufficient permissions to perform this action', 'wp-rankology'));
    }

    // Validate file
    if (!isset($_FILES['import_file']) || $_FILES['import_file']['error'] !== UPLOAD_ERR_OK) {
        wp_die(__('File upload error or no file uploaded', 'wp-rankology'));
    }

    // Check file extension
    $extension = pathinfo(sanitize_file_name($_FILES['import_file']['name']), PATHINFO_EXTENSION);
    if ('csv' !== strtolower($extension)) {
        wp_die(__('Please upload a valid .csv file', 'wp-rankology'));
    }

    $import_file = $_FILES['import_file']['tmp_name'];

    // Check if file is empty
    if (empty($import_file)) {
        wp_die(__('Please upload a file to import', 'wp-rankology'));
    }

    // Validate separator
    if (empty($_POST['import_sep']) || !in_array($_POST['import_sep'], ['comma', 'semicolon'])) {
        wp_die(__('Please choose a valid separator', 'wp-rankology'));
    }

    $separator = $_POST['import_sep'] === 'comma' ? ',' : ';';

    // Read and process CSV
    $csv = array_map(function ($item) use ($separator) {
        return str_getcsv($item, $separator, '\"');
    }, file($import_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));

    // Remove duplicates
    $csv = array_unique($csv, SORT_REGULAR);

    foreach ($csv as $key => $value) {
        $csv_line = array_map('sanitize_text_field', $value);

        $csv_type_redirects = [
            2 => in_array($csv_line[2], ['301', '302', '307', '410', '451'], true) ? $csv_line[2] : '',
            3 => strtolower($csv_line[3]) === 'yes' ? 'yes' : '',
            4 => in_array($csv_line[4], ['exact_match', 'with_ignored_param', 'without_param'], true) ? $csv_line[4] : 'exact_match',
        ];

        $cats = !empty($csv_line[6]) ? array_map('intval', array_unique(explode(',', $csv_line[6]))) : [];

        $regex_enable = strtolower($csv_line[7]) === 'yes' ? 'yes' : '';

        $logged_status = in_array(strtolower($csv_line[8]), ['both', 'logged', 'not_logged'], true) ? strtolower($csv_line[8]) : 'both';

        if (!empty($csv_line[0])) {
            $count = !empty($csv_line[5]) ? intval($csv_line[5]) : null;
            $id = wp_insert_post([
                'post_title'  => rawurldecode($csv_line[0]),
                'post_type'   => 'rankology_404',
                'post_status' => 'publish',
                'meta_input'  => [
                    '_rankology_redirections_value'         => rawurldecode($csv_line[1]),
                    '_rankology_redirections_type'          => $csv_type_redirects[2],
                    '_rankology_redirections_enabled'       => $csv_type_redirects[3],
                    '_rankology_redirections_enabled_regex' => $regex_enable,
                    '_rankology_redirections_logged_status' => $logged_status,
                    '_rankology_redirections_param'         => $csv_type_redirects[4],
                    'rankology_404_count'                   => $count,
                ],
            ]);

            if (!is_wp_error($id) && !empty($cats)) {
                wp_set_object_terms($id, $cats, 'rankology_404_cat');
            }
        }
    }

    wp_safe_redirect(admin_url('edit.php?post_type=rankology_404'));
    exit;
}
add_action('admin_init', 'rankology_import_redirections_settings');


//Import Redirections from Yoast Premium (CSV)
function rankology_import_yoast_redirections() {
    if (empty($_POST['rankology_action']) || 'import_yoast_redirections' != $_POST['rankology_action']) {
        return;
    }
	if (!isset($_POST['rankology_import_yoast_redirections_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['rankology_import_yoast_redirections_nonce'])), 'rankology_import_yoast_redirections_nonce')) {
		return;
	}
    if (!current_user_can(rankology_capability('manage_options', 'import_settings'))) {
        return;
    }

    $extension = pathinfo(sanitize_file_name($_FILES['import_file']['name']), PATHINFO_EXTENSION);
    $extension = sanitize_text_field($extension); // Sanitize file extension

    if ('csv' != $extension) {
        wp_die(__('Please upload a valid .csv file', 'wp-rankology'));
    }

    $import_file = sanitize_file_name($_FILES['import_file']['tmp_name']);
    if (empty($import_file)) {
        wp_die(__('Please upload a file to import', 'wp-rankology'));
    }

    $csv = array_map('str_getcsv', file($import_file));

    foreach (array_slice($csv, 1) as $_key => $_value) {
        $csv_line = $_value;

        //Third column: redirections type
        $csv_type_redirects[2] = isset($csv_line[2]) ? sanitize_text_field($csv_line[2]) : '';

        //Fourth column: redirections enabled
        $csv_type_redirects[3] = 'yes';

        //Fifth column: redirections query param
        $csv_type_redirects[4] = 'exact_match';

        if (!empty($csv_line[0])) {
            $csv_line[0] = substr(wp_unslash($csv_line[0]), 1);
            if (!empty($csv_line[1])) {
                $csv_line[1] = ('//' === wp_unslash($csv_line[1])) ? '/' : home_url() . wp_unslash($csv_line[1]);
            }
            $id = wp_insert_post([
                'post_title'        => wp_unslash(urldecode($csv_line[0])),
                'post_type'         => 'rankology_404',
                'post_status'       => 'publish',
                'meta_input'        => [
                    '_rankology_redirections_value'          => wp_unslash(urldecode($csv_line[1])),
                    '_rankology_redirections_type'           => $csv_type_redirects[2],
                    '_rankology_redirections_enabled'        => $csv_type_redirects[3],
                    '_rankology_redirections_enabled_regex'  => '',
                    '_rankology_redirections_logged_status'  => 'both',
                    '_rankology_redirections_param'          => $csv_type_redirects[4],
                ],
            ]);
        }
    }
    wp_safe_redirect(admin_url('edit.php?post_type=rankology_404'));
    exit;
}

add_action('admin_init', 'rankology_import_yoast_redirections');

//Export Redirections to CSV file
function rankology_export_redirections_settings()
{
    if (empty($_POST['rankology_action']) || 'export_redirections' != $_POST['rankology_action']) {
        return;
    }
    if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['rankology_export_redirections_nonce'])), 'rankology_export_redirections_nonce')) {
        return;
    }
    if (!current_user_can(rankology_capability('manage_options', 'export_settings'))) {
        return;
    }

    //Init
    $redirects_html = '';

    $args = [
        'post_type'      => 'rankology_404',
        'posts_per_page' => '-1',
        'meta_query'     => [
            [
                'key'     => '_rankology_redirections_type',
                'value'   => ['301', '302', '307', '410', '451'],
                'compare' => 'IN',
            ],
        ],
    ];

    $args = apply_filters('rankology_export_redirections_query', $args);

    $rankology_redirects_query = new WP_Query($args);

    if ($rankology_redirects_query->have_posts()) {
        while ($rankology_redirects_query->have_posts()) {
            $rankology_redirects_query->the_post();
            $redirect_categories = get_the_terms(get_the_ID(), 'rankology_404_cat');

            if (!empty($redirect_categories)) {
                $redirect_categories = join(', ', wp_list_pluck($redirect_categories, 'term_id'));
            } else {
                $redirect_categories = "";
            }

            $redirects_html .= html_entity_decode(urldecode(urlencode(esc_attr(wp_filter_nohtml_kses(get_the_title())))));
            $redirects_html .= ';';
            $redirects_html .= html_entity_decode(urldecode(urlencode(esc_attr(wp_filter_nohtml_kses(get_post_meta(get_the_ID(), '_rankology_redirections_value', true))))));
            $redirects_html .= ';';
            $redirects_html .= get_post_meta(get_the_ID(), '_rankology_redirections_type', true);
            $redirects_html .= ';';
            $redirects_html .= get_post_meta(get_the_ID(), '_rankology_redirections_enabled', true);
            $redirects_html .= ';';
            $redirects_html .= get_post_meta(get_the_ID(), '_rankology_redirections_param', true);
            $redirects_html .= ';';
            $redirects_html .= get_post_meta(get_the_ID(), 'rankology_404_count', true);
            $redirects_html .= ';';
            $redirects_html .= $redirect_categories;
            $redirects_html .= ';';
            $redirects_html .= get_post_meta(get_the_ID(), '_rankology_redirections_enabled_regex', true);
            $redirects_html .= ';';
            $redirects_html .= get_post_meta(get_the_ID(), '_rankology_redirections_logged_status', true);
            $redirects_html .= "\n";
        }
        wp_reset_postdata();
    }

    ignore_user_abort(true);
    nocache_headers();
    header('Content-Type: application/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=rankology-redirections-export-' . date('m-d-Y') . '.csv');
    header('Expires: 0');
    echo rankology_common_esc_str($redirects_html);
    exit;
}
add_action('admin_init', 'rankology_export_redirections_settings');

//Export Redirections to txt file for .htaccess
function rankology_export_redirections_htaccess_settings()
{
    $action = isset($_POST['rankology_action']) ? sanitize_text_field(wp_unslash($_POST['rankology_action'])) : '';

    // Validate action
    if (empty($action) || 'export_redirections_htaccess' !== $action) {
        return;
    }

    $nonce = isset($_POST['rankology_export_redirections_htaccess_nonce']) ? sanitize_text_field(wp_unslash($_POST['rankology_export_redirections_htaccess_nonce'])) : '';

    // Validate nonce
    if (!empty($nonce) && wp_verify_nonce($nonce, 'rankology_export_redirections_htaccess_nonce')) {
        // Nonce verification succeeded, continue with the rest of the code
    } else {
        // Nonce verification failed or nonce value is empty, handle the error or abort further execution
        return;
    }

    // Check user capability
    if (!current_user_can(rankology_capability('manage_options', 'export_settings'))) {
        return;
    }

    //Init
    $redirects_html = '';

    $args = [
        'post_type'      => 'rankology_404',
        'posts_per_page' => '-1',
        'meta_query'     => [
            [
                'key'     => '_rankology_redirections_type',
                'value'   => ['301', '302', '307', '410', '451'],
                'compare' => 'IN',
            ],
            [
                'key'     => '_rankology_redirections_enabled',
                'value'   => 'yes',
            ],
        ],
    ];
    $rankology_redirects_query = new WP_Query($args);

    if ($rankology_redirects_query->have_posts()) {
        while ($rankology_redirects_query->have_posts()) {
            $rankology_redirects_query->the_post();

            switch (get_post_meta(get_the_ID(), '_rankology_redirections_type', true)) {
                case '301':
                    $type = 'redirect 301 ';
                    break;
                case '302':
                    $type = 'redirect 302 ';
                    break;
                case '307':
                    $type = 'redirect 307 ';
                    break;
                case '410':
                    $type = 'redirect 410 ';
                    break;
                case '451':
                    $type = 'redirect 451 ';
                    break;
            }

            $redirects_html .= $type . ' /' . untrailingslashit(urldecode(urlencode(esc_attr(wp_filter_nohtml_kses(get_the_title()))))) . ' ';
            $redirects_html .= urldecode(urlencode(esc_attr(wp_filter_nohtml_kses(get_post_meta(get_the_ID(), '_rankology_redirections_value', true)))));
            $redirects_html .= "\n";
        }
        wp_reset_postdata();
    }

    ignore_user_abort(true);
    echo rankology_common_esc_str($redirects_html);
    nocache_headers();
    header('Content-Type: text/plain; charset=utf-8');
    header('Content-Disposition: attachment; filename=rankology-redirections-htaccess-export-' . date('m-d-Y') . '.txt');
    header('Expires: 0');
    exit;
}
add_action('admin_init', 'rankology_export_redirections_htaccess_settings');

// Import Redirections from Redirections plugin JSON file
function rankology_import_redirections_plugin_settings()
{
    if (empty($_POST['rankology_action']) || 'import_redirections_plugin_settings' !== sanitize_text_field($_POST['rankology_action'])) {
        return;
    }
    if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['rankology_import_redirections_plugin_nonce'])), 'rankology_import_redirections_plugin_nonce')) {
        wp_die(__('Nonce verification failed.', 'wp-rankology'));
    }
    if (!current_user_can(rankology_capability('manage_options', 'import_settings'))) {
        wp_die(__('You do not have sufficient permissions to import settings.', 'wp-rankology'));
    }

    if (!isset($_FILES['import_file']) || !is_array($_FILES['import_file'])) {
        wp_die(__('No file was uploaded.', 'wp-rankology'));
    }

    // Sanitize and validate file extension
    $file_name = sanitize_file_name($_FILES['import_file']['name']);
    $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if ('json' !== $extension) {
        wp_die(__('Please upload a valid .json file', 'wp-rankology'));
    }

    $import_file = $_FILES['import_file']['tmp_name'];
    if (empty($import_file) || !file_exists($import_file)) {
        wp_die(__('Please upload a valid file to import', 'wp-rankology'));
    }

    $file_contents = file_get_contents($import_file);
    if ($file_contents === false) {
        wp_die(__('Failed to read the file.', 'wp-rankology'));
    }

    $settings = json_decode($file_contents, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $error_message = sprintf(__('Failed to decode JSON. Error: %s', 'wp-rankology'), json_last_error_msg());
        wp_die($error_message);
    }
    
    if (empty($settings['redirects']) || !is_array($settings['redirects'])) {
        wp_die(__('No valid redirects found in the JSON file.', 'wp-rankology'));
    }

    foreach ($settings['redirects'] as $redirect_key => $redirect_value) {
        $type = !empty($redirect_value['action_code']) ? sanitize_text_field($redirect_value['action_code']) : '301';
        
        $param = '';
        if (!empty($redirect_value['match_data']['source']['flag_query'])) {
            $flag_query = sanitize_text_field($redirect_value['match_data']['source']['flag_query']);
            if ('pass' === $flag_query) {
                $param = 'with_ignored_param';
            } elseif ('ignore' === $flag_query) {
                $param = 'without_param';
            } else {
                $param = 'exact_match';
            }
        }

        $enabled = !empty($redirect_value['enabled']) ? 'yes' : '';
        $regex_enable = !empty($redirect_value['regex']) ? 'yes' : '';

        wp_insert_post([
            'post_title'  => sanitize_text_field(ltrim(urldecode($redirect_value['url']), '/')),
            'post_type'   => 'rankology_404',
            'post_status' => 'publish',
            'meta_input'  => [
                '_rankology_redirections_value'   => esc_url_raw(urldecode($redirect_value['action_data']['url'])),
                '_rankology_redirections_type'    => $type,
                '_rankology_redirections_enabled' => $enabled,
                '_rankology_redirections_enabled_regex' => $regex_enable,
                '_rankology_redirections_logged_status'  => 'both',
                '_rankology_redirections_param'   => $param,
            ],
        ]);
    }

    wp_safe_redirect(admin_url('edit.php?post_type=rankology_404'));
    exit;
}

add_action('admin_init', 'rankology_import_redirections_plugin_settings');

/**
 * Import Redirections from Rank Math plugin JSON file
 *
 * 
 * @updated 6.3.0
 *
 */
function rankology_import_rk_redirections() {
    if (empty($_POST['rankology_action']) || 'import_rk_redirections' != sanitize_text_field(wp_unslash($_POST['rankology_action']))) {
        return;
    }

    // Verify nonce
    if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['rankology_import_rk_redirections_nonce'])), 'rankology_import_rk_redirections_nonce')) {
        return;
    }

    // Check user capability
    if (!current_user_can(rankology_capability('manage_options', 'import_settings'))) {
        return;
    }

    // Sanitize file name and get extension
    $file_name = sanitize_file_name($_FILES['import_file']['name']);
    $extension = pathinfo($file_name, PATHINFO_EXTENSION);

    // Validate that the uploaded file is a .json file
    if ('json' != $extension) {
        wp_die(__('Please upload a valid .json file', 'wp-rankology'));
    }

    // Get the temporary file path
    $import_file = sanitize_text_field($_FILES['import_file']['tmp_name']);
    if (empty($import_file)) {
        wp_die(__('Please upload a file to import', 'wp-rankology'));
    }

    // Read and decode the JSON file contents
    $settings = (array) json_decode(file_get_contents($import_file), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        wp_die(__('Invalid JSON format', 'wp-rankology'));
    }

    foreach ($settings['redirections'] as $redirect_key => $redirect_value) {
        // Sanitize and validate values
        $type = !empty($redirect_value['header_code']) ? sanitize_text_field($redirect_value['header_code']) : '';

        $source = '';
        if (!empty($redirect_value['sources'])) {
            if (is_serialized($redirect_value['sources'])) {
                $source = @unserialize(sanitize_text_field($redirect_value['sources']), ['allowed_classes' => false]);
                if (is_array($source)) {
                    $source = ltrim(urldecode($source[0]['pattern']), '/');
                    $source = sanitize_text_field($source); // Sanitize the source URL
                }
            }
        }

        $param = 'exact_match'; // Fixed value

        $enabled = !empty($redirect_value['status']) && 'active' === $redirect_value['status'] ? 'yes' : 'no';

        $redirect = !empty($redirect_value['url_to']) ? esc_url_raw(urldecode($redirect_value['url_to'])) : '';

        $count = !empty($redirect_value['hits']) ? (int) $redirect_value['hits'] : 0;

        $regex = '';
        if (!empty($redirect_value['sources']) && is_serialized($redirect_value['sources'])) {
            $sources = @unserialize(sanitize_text_field($redirect_value['sources']), ['allowed_classes' => false]);
            if (is_array($sources) && in_array("regex", array_column($sources, 'comparison'))) {
                $regex = 'yes';
            }
        }

        // Insert the redirection as a custom post
        wp_insert_post(
            [
                'post_title'  => sanitize_text_field($source),
                'post_type'   => 'rankology_404',
                'post_status' => 'publish',
                'meta_input'  => [
                    '_rankology_redirections_value'          => $redirect,
                    '_rankology_redirections_type'           => sanitize_text_field($type),
                    '_rankology_redirections_enabled'        => sanitize_text_field($enabled),
                    '_rankology_redirections_enabled_regex'  => sanitize_text_field($regex),
                    '_rankology_redirections_logged_status'  => 'both', // Assuming it's always 'both'
                    'rankology_404_count'                    => $count,
                    '_rankology_redirections_param'          => sanitize_text_field($param),
                ],
            ]
        );
    }

    // Redirect back to the list page after import
    wp_safe_redirect(admin_url('edit.php?post_type=rankology_404'));
    exit;
}
add_action('admin_init', 'rankology_import_rk_redirections');


//Clean all 404
function rankology_clean_404_query_hook($args)
{
    unset($args['date_query']);

    return $args;
}

function rankology_clean_404()
{
    if (empty($_POST['rankology_action']) || 'clean_404' != $_POST['rankology_action']) {
        return;
    }
    if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['rankology_clean_404_nonce'])), 'rankology_clean_404_nonce')) {
        return;
    }
    if (!current_user_can(rankology_capability('manage_options', '404'))) {
        return;
    }

    add_filter('rankology_404_cleaning_query', 'rankology_clean_404_query_hook');
    do_action('rankology_404_cron_cleaning', true);
    wp_safe_redirect(admin_url('edit.php?post_type=rankology_404'));
    exit;
}
add_action('admin_init', 'rankology_clean_404');

//Reset Count column
function rankology_clean_counters()
{
    if (empty($_POST['rankology_action']) || 'clean_counters' != $_POST['rankology_action']) {
        return;
    }
    if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['rankology_clean_counters_nonce'])), 'rankology_clean_counters_nonce')) {
        return;
    }
    if (!current_user_can(rankology_capability('manage_options', '404'))) {
        return;
    }

    global $wpdb;

    //SQL query
    $sql = "DELETE  FROM `" . $wpdb->prefix . "postmeta` WHERE `meta_key` = 'rankology_404_count'";

    $wpdb->query($wpdb->prepare($sql));

    wp_safe_redirect(admin_url('edit.php?post_type=rankology_404'));
    exit;
}
add_action('admin_init', 'rankology_clean_counters');

//Clean all (redirects / 404 errors)
function rankology_clean_all()
{
    if (empty($_POST['rankology_action']) || 'clean_all' != $_POST['rankology_action']) {
        return;
    }
    if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['rankology_clean_all_nonce'])), 'rankology_clean_all_nonce')) {
        return;
    }
    if (!current_user_can(rankology_capability('manage_options', '404'))) {
        return;
    }

    global $wpdb;

    //SQL query
    $sql = 'DELETE `posts`, `pm`
		FROM `' . $wpdb->prefix . 'posts` AS `posts`
		LEFT JOIN `' . $wpdb->prefix . 'postmeta` AS `pm` ON `pm`.`post_id` = `posts`.`ID`
		WHERE `posts`.`post_type` = \'rankology_404\'';

    $wpdb->query($wpdb->prepare($sql));

    wp_safe_redirect(admin_url('edit.php?post_type=rankology_404'));
    exit;
}
add_action('admin_init', 'rankology_clean_all');

//Delete all content scans
function rankology_clean_content_scans()
{
    if (empty($_POST['rankology_action']) || 'clean_content_scans' != $_POST['rankology_action']) {
        return;
    }
    if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['rankology_clean_content_scans_nonce'])), 'rankology_clean_content_scans_nonce')) {
        return;
    }
    if (!current_user_can(rankology_capability('manage_options', 'cleaning'))) {
        return;
    }

    global $wpdb;

    //SQL query
    $sql = 'DELETE FROM `' . $wpdb->prefix . 'postmeta`	WHERE `meta_key` IN ( \'_rankology_analysis_data\', \'_rankology_content_analysis_api\', \'_rankology_analysis_data_oxygen\', \'_rankology_content_analysis_api_in_progress\')';

    $wpdb->query($wpdb->prepare($sql));

    wp_safe_redirect(admin_url('admin.php?page=rankology-import-export'));
    exit;
}
add_action('admin_init', 'rankology_clean_content_scans');

//Reset Rankology Notices Settings
function rankology_reset_notices_settings()
{
    if (empty($_POST['rankology_action']) || 'reset_notices_settings' != $_POST['rankology_action']) {
        return;
    }
    if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['rankology_reset_notices_nonce'])), 'rankology_reset_notices_nonce')) {
        return;
    }
    if (!current_user_can(rankology_capability('manage_options', 'reset_settings'))) {
        return;
    }

    global $wpdb;

    $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE 'rankology_notices' ");

    wp_safe_redirect(admin_url('admin.php?page=rankology-import-export'));
    exit;
}
add_action('admin_init', 'rankology_reset_notices_settings');

//Reset Rankology Settings
function rankology_reset_settings()
{
    if (empty($_POST['rankology_action']) || 'reset_settings' != $_POST['rankology_action']) {
        return;
    }
    if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['rankology_reset_nonce'])), 'rankology_reset_nonce')) {
        return;
    }
    if (!current_user_can(rankology_capability('manage_options', 'reset_settings'))) {
        return;
    }

    global $wpdb;

    $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE 'rankology_%' ");

    wp_safe_redirect(admin_url('admin.php?page=rankology-import-export'));
    exit;
}
add_action('admin_init', 'rankology_reset_settings');

//Export Rankology BOT Links to CSV
function rankology_bot_links_export_settings()
{
    if (empty($_POST['rankology_action']) || 'export_csv_links_settings' != $_POST['rankology_action']) {
        return;
    }
    if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['rankology_export_csv_links_nonce'])), 'rankology_export_csv_links_nonce')) {
        return;
    }
    if (!current_user_can(rankology_capability('manage_options', 'export_settings'))) {
        return;
    }
    $args = [
        'post_type'      => 'rankology_bot',
        'posts_per_page' => 1000,
        'post_status'    => 'publish',
        'order'          => 'DESC',
        'orderby'        => 'date',
    ];
    $the_query = new WP_Query($args);

    $settings['URL']        = [];
    $settings['Source']     = [];
    $settings['Source_Url'] = [];
    $settings['Status']     = [];
    $settings['Type']       = [];

    $csv_fields   = [];
    $csv_fields[] = 'URL';
    $csv_fields[] = 'Source';
    $csv_fields[] = 'Source URL';
    $csv_fields[] = 'Status';
    $csv_fields[] = 'Type';

    $output_handle = @fopen('php://output', 'w');

    //Header
    ignore_user_abort(true);
    nocache_headers();
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=rankology-links-export-' . date('m-d-Y') . '.csv');
    header('Expires: 0');
    header('Pragma: public');

    //Insert header row
    fputcsv($output_handle, $csv_fields);

    // The Loop
    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {
            $the_query->the_post();

            array_push($settings['URL'], get_the_title());

            array_push($settings['Source'], get_post_meta(get_the_ID(), 'rankology_bot_source_title', true));

            array_push($settings['Source_Url'], get_post_meta(get_the_ID(), 'rankology_bot_source_url', true));

            array_push($settings['Status'], get_post_meta(get_the_ID(), 'rankology_bot_status', true));

            array_push($settings['Type'], get_post_meta(get_the_ID(), 'rankology_bot_type', true));

            fputcsv($output_handle, array_merge($settings['URL'], $settings['Source'], $settings['Source_Url'], $settings['Status'], $settings['Type']));

            //Clean arrays
            $settings['URL']        = [];
            $settings['Source']     = [];
            $settings['Source_Url'] = [];
            $settings['Status']     = [];
            $settings['Type']       = [];
        }
        wp_reset_postdata();
    }

    // Close output file stream
    fclose($output_handle);

    exit;
}
add_action('admin_init', 'rankology_bot_links_export_settings');

//Export metadata
function rankology_download_batch_export()
{
    if (empty($_GET['rankology_action']) || 'rankology_download_batch_export' != $_GET['rankology_action']) {
        return;
    }
    if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['nonce'])), 'rankology_csv_batch_export_nonce')) {
        return;
    }
    if (!current_user_can(rankology_capability('manage_options', 'export_settings'))) {
        return;
    }
    if ('' != get_option('rankology_metadata_csv')) {
        $csv = get_option('rankology_metadata_csv');

        $csv_fields   = [];
        $csv_fields[] = 'id';
        $csv_fields[] = 'post_title';
        $csv_fields[] = 'url';
        $csv_fields[] = 'slug';
        $csv_fields[] = 'meta_title';
        $csv_fields[] = 'meta_desc';
        $csv_fields[] = 'fb_title';
        $csv_fields[] = 'fb_desc';
        $csv_fields[] = 'fb_img';
        $csv_fields[] = 'tw_title';
        $csv_fields[] = 'tw_desc';
        $csv_fields[] = 'tw_img';
        $csv_fields[] = 'noindex';
        $csv_fields[] = 'nofollow';
        $csv_fields[] = 'noimageindex';
        $csv_fields[] = 'noarchive';
        $csv_fields[] = 'nosnippet';
        $csv_fields[] = 'canonical_url';
        $csv_fields[] = 'primary_cat';
        $csv_fields[] = 'redirect_active';
        $csv_fields[] = 'redirect_status';
        $csv_fields[] = 'redirect_type';
        $csv_fields[] = 'redirect_url';
        $csv_fields[] = 'target_kw';
        ob_start();
        $output_handle = @fopen('php://output', 'w');

        //Insert header row
        fputcsv($output_handle, $csv_fields, ';');

        //Header
        ignore_user_abort(true);
        nocache_headers();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=rankology-metadata-export-' . date('m-d-Y') . '.csv');
        header('Expires: 0');
        header('Pragma: public');

        if (!empty($csv)) {
            foreach ($csv as $value) {
                fputcsv($output_handle, $value, ';');
            }
        }

        // Close output file stream
        fclose($output_handle);

        //Clean database
        delete_option('rankology_metadata_csv');
        exit;
    }
}
add_action('admin_init', 'rankology_download_batch_export');
