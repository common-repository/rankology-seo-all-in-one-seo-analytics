<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

function rankology_instant_indexing_google_engine_callback()
{
    $options = get_option('rankology_instant_indexing_option_name');

    $search_engines = [
        'google' => 'Google',
        'bing'=> 'Bing / Yandex'
    ];

    if (!empty($search_engines)) {
        foreach ($search_engines as $key => $value) {
            $check = isset($options['engines'][$key]);
            ?>
            <div class="rankology_wrap_single_cpt">
                <label
                    for="rankology_instant_indexing_engines_<?php echo rankology_common_esc_str($key); ?>">
                    <input
                        id="rankology_instant_indexing_engines_<?php echo rankology_common_esc_str($key); ?>"
                        name="rankology_instant_indexing_option_name[engines][<?php echo rankology_common_esc_str($key); ?>]"
                        type="checkbox" <?php if ('1' == $check) { ?>
                    checked="yes"
                    <?php } ?>
                    value="1"/>
                    <?php echo esc_html($value); ?>
                </label>
            </div>
        <?php
            if (isset($options['engines'][$key])) {
                esc_attr($options['engines'][$key]);
            }
        }
    }
}

function rankology_instant_indexing_google_action_callback() {
    $options = get_option('rankology_instant_indexing_option_name');

    $actions = [
        'URL_UPDATED' => esc_html__('Update URLs', 'wp-rankology'),
        'URL_DELETED' => esc_attr__('Remove URLs (URL must return a 404 or 410 status code or the page contains <meta name="robots" content="noindex" /> meta tag)', 'wp-rankology'),
    ];

    foreach ($actions as $key => $value) { ?>
<div class="rankology_wrap_single_cpt">

    <?php if (isset($options['rankology_instant_indexing_google_action'])) {
        $check = $options['rankology_instant_indexing_google_action'];
    } else {
        $check = 'URL_UPDATED';
    } ?>

    <label
        for="rankology_instant_indexing_google_action_include_<?php echo rankology_common_esc_str($key); ?>">
        <input
            id="rankology_instant_indexing_google_action_include_<?php echo rankology_common_esc_str($key); ?>"
            name="rankology_instant_indexing_option_name[rankology_instant_indexing_google_action]" type="radio" <?php if ($key == $check) { ?>
        checked="yes"
        <?php } ?>
        value="<?php echo rankology_common_esc_str($key); ?>"/>

        <?php echo esc_html($value); ?>
    </label>

    <?php if (isset($options['rankology_instant_indexing_google_action'])) {
        esc_attr($options['rankology_instant_indexing_google_action']);
    } ?>
</div>
<?php }
}

function rankology_instant_indexing_manual_batch_callback() {
    require_once WP_PLUGIN_DIR . '/rankology/vendor/autoload.php';
    $options    = get_option('rankology_instant_indexing_option_name');
    $log        = get_option('rankology_instant_indexing_log_option_name');
    $check      = isset($options['rankology_instant_indexing_manual_batch']) ? esc_attr($options['rankology_instant_indexing_manual_batch']) : null;

    //URLs
    $urls       = isset($log['log']['urls']) ? $log['log']['urls'] : null;
    $date       = isset($log['log']['date']) ? $log['log']['date'] : null;

    //General errors
    $error       = isset($log['error']) ? $log['error'] : null;

    //Bing
    $bing_response       = isset($log['bing']['response']) ? $log['bing']['response'] : null;

    //Google
    $google_response     = isset($log['google']['response']) ? $log['google']['response'] : null;

    printf(
'<textarea id="rankology_instant_indexing_manual_batch" name="rankology_instant_indexing_option_name[rankology_instant_indexing_manual_batch]" rows="20" placeholder="' . esc_html__('Enter one URL per line to submit them to search engines (max 100 URLs)', 'wp-rankology') . '" aria-label="' . esc_html__('Enter one URL per line to submit them to search engines (max 100 URLs)', 'wp-rankology') . '">%s</textarea>',
esc_html($check));
?>

<p>
    <br>
    <button type="button" class="rankology-instant-indexing-batch btn btnPrimary">
        <?php esc_html_e('Submit URLs to Google & Bing', 'wp-rankology'); ?>
    </button>

    <span class="spinner"></span>
</p>

<h3><?php esc_html_e('Latest indexing request','wp-rankology'); ?></h3>
<p><em><?php echo rankology_common_esc_str($date); ?></em></p>

<?php
if (!empty($error)) { ?>
    <span class="indexing-log indexing-failed"></span><?php echo rankology_common_esc_str($error); ?>
<?php }
if (!empty($bing_response['response'])) {
    switch ($bing_response['response']['code']) {
        case 200:
            $msg = esc_html__('URLs submitted successfully', 'wp-rankology');
            break;
        case 202:
            $msg = esc_html__('URL received. IndexNow key validation pending.', 'wp-rankology');
            break;
        case 400:
            $msg = esc_html__('Bad request: Invalid format', 'wp-rankology');
            break;
        case 403:
            $msg = esc_html__('Forbidden: In case of key not valid (e.g. key not found, file found but key not in the file)', 'wp-rankology');
            break;
        case 422:
            $msg = esc_html__('Unprocessable Entity: In case of URLs don’t belong to the host or the key is not matching the schema in the protocol', 'wp-rankology');
            break;
        case 429:
            $msg = esc_html__('Too Many Requests: Too Many Requests (potential Spam)', 'wp-rankology');
            break;
        default:
            $msg = esc_html__('Something went wrong', 'wp-rankology');
    } ?>
    <div class="wrap-bing-response">
        <h4><?php esc_html_e('Bing Response','wp-rankology'); ?></h4>

        <?php if ($bing_response['response']['code'] == 200 || $bing_response['response']['code'] == 202) { ?>
            <span class="indexing-log indexing-done"></span>
        <?php } else { ?>
            <span class="indexing-log indexing-failed"></span>
        <?php } ?>
        <code><?php echo esc_html($msg); ?></code>
    </div>
<?php }

    if (is_array($google_response) && !empty($google_response)) { ?>
        <div class="wrap-google-response">
            <h4><?php esc_html_e('Google Response','wp-rankology'); ?></h4>

            <?php
            $google_exception = $google_response[rankology_array_key_first($google_response)];
            if ( is_a( $google_exception, 'Google\Service\Exception' ) ) {
                $error = json_decode($google_exception->getMessage(), true);
                echo '<span class="indexing-log indexing-failed"></span><code>' . esc_html($error['error']['code']) . ' - ' . esc_html($error['error']['message']) . '</code>';
            } elseif (!empty($google_response['error'])) {
                echo '<span class="indexing-log indexing-failed"></span><code>' . esc_html($google_response['error']['code']) . ' - ' . esc_html($google_response['error']['message']) . '</code>';
            } else { ?>
                <p><span class="indexing-log indexing-done"></span><code><?php esc_html_e('URLs submitted successfully', 'wp-rankology'); ?></code></p>
                <ul>
                    <?php foreach($google_response as $result) {
                        if ($result) {
                            if (!empty($result->urlNotificationMetadata->latestUpdate["url"]) || !empty($result->urlNotificationMetadata->latestUpdate["type"])) {
                                echo '<li>';
                            }
                            if (!empty($result->urlNotificationMetadata->latestUpdate["url"])) {
                                echo rankology_common_esc_str($result->urlNotificationMetadata->latestUpdate["url"]);
                            }
                            if (!empty($result->urlNotificationMetadata->latestUpdate["type"])) {
                                echo ' - ';
                                echo '<code>' . $result->urlNotificationMetadata->latestUpdate["type"] . '</code>';
                            }
                            if (!empty($result->urlNotificationMetadata->latestUpdate["url"]) || !empty($result->urlNotificationMetadata->latestUpdate["type"])) {
                                echo '</li>';
                            }
                            if (!empty($result->urlNotificationMetadata->latestRemove["url"]) || !empty($result->urlNotificationMetadata->latestRemove["type"])) {
                                echo '<li>';
                            }
                            if (!empty($result->urlNotificationMetadata->latestRemove["url"])) {
                                echo rankology_common_esc_str($result->urlNotificationMetadata->latestRemove["url"]);
                            }
                            if (!empty($result->urlNotificationMetadata->latestRemove["type"])) {
                                echo ' - ';
                                echo '<code>' . $result->urlNotificationMetadata->latestRemove["type"] . '</code>';
                            }
                            if (!empty($result->urlNotificationMetadata->latestRemove["url"]) || !empty($result->urlNotificationMetadata->latestRemove["type"])) {
                                echo '</li>';
                            }
                        }
                    } ?>
                </ul>
            <?php } ?>
        </div>
    <?php }
    ?>

    <h4><?php esc_html_e('Latest URLs submitted','wp-rankology'); ?></h4>
    <?php if (!empty($urls[0])) { ?>
        <ul>
        <?php foreach($urls as $url) { ?>
            <li>
                <?php echo esc_url($url); ?>
            </li>
        <?php } ?>
        </ul>
    <?php } else {
        esc_html_e('None', 'wp-rankology');
    }
}

function rankology_instant_indexing_google_api_key_callback() {
    $options = get_option('rankology_instant_indexing_option_name');
    $check   = isset($options['rankology_instant_indexing_google_api_key']) ? esc_attr($options['rankology_instant_indexing_google_api_key']) : null;

    printf(
    '<textarea id="rankology_instant_indexing_google_api_key" name="rankology_instant_indexing_option_name[rankology_instant_indexing_google_api_key]" rows="12" placeholder="' . esc_html__('Paste your Google JSON key file here', 'wp-rankology') . '" aria-label="' . esc_html__('Paste your Google JSON key file here', 'wp-rankology') . '">%s</textarea>',
    esc_html($check));
}

function rankology_instant_indexing_bing_api_key_callback() {
    $options = get_option('rankology_instant_indexing_option_name');
    $check   = isset($options['rankology_instant_indexing_bing_api_key']) ? esc_attr($options['rankology_instant_indexing_bing_api_key']) : null; ?>

    <input type="text" id="rankology_instant_indexing_bing_api_key" name="rankology_instant_indexing_option_name[rankology_instant_indexing_bing_api_key]"
    placeholder="<?php esc_html_e('Enter your Bing Instant Indexing API', 'wp-rankology'); ?>"
    aria-label="<?php esc_html_e('Enter your Bing Instant Indexing API', 'wp-rankology'); ?>"
    value="<?php echo rankology_common_esc_str($check); ?>" />

    <button type="button" class="rankology-instant-indexing-refresh-api-key btn btnSecondary"><?php esc_html_e('Generate key','wp-rankology'); ?></button>

    <p class="description"><?php esc_html_e('The Bing Indexing API key is automatically generated. Click Generate key if you want to recreate it, or if it\'s missing.', 'wp-rankology') ?></p>
    <p class="description"><?php esc_html_e('A key should look like this: ', 'wp-rankology'); ?><code>XjA2NWI3ZWM3MmNhDFRBHYliYmY0YjljMzg5YTk2NGE=</code></p>
<?php
}

function rankology_instant_indexing_automate_submission_callback() {
    $options = get_option('rankology_instant_indexing_option_name');

    $check = isset($options['rankology_instant_indexing_automate_submission']); ?>

    <label for="rankology_instant_indexing_automate_submission">
        <input id="rankology_instant_indexing_automate_submission" name="rankology_instant_indexing_option_name[rankology_instant_indexing_automate_submission]" type="checkbox"
        <?php if ('1' == $check) {
            echo 'checked="yes"';
        } ?>
        value="1"/>
        <?php esc_html_e('Enable automatic URL submission for IndexNow API', 'wp-rankology'); ?>
    </label>

    <?php if (isset($options['rankology_instant_indexing_automate_submission'])) {
        esc_attr($options['rankology_instant_indexing_automate_submission']);
    }
}
