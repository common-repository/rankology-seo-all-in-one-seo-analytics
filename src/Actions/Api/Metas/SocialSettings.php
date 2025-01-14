<?php

namespace Rankology\Actions\Api\Metas;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Core\Hooks\ExecuteHooks;
use Rankology\Helpers\Metas\SocialSettings as SocialSettingsHelper;

class SocialSettings implements ExecuteHooks {
    public function hooks() {
        add_action('rest_api_init', [$this, 'register']);
    }

    /**
     * 
     *
     * @return void
     */
    public function register() {
        register_rest_route('rankology/v1', '/posts/(?P<id>\d+)/social-settings', [
            'methods'             => 'GET',
            'callback'            => [$this, 'processGet'],
            'args'                => [
                'id' => [
                    'validate_callback' => function ($param, $request, $key) {
                        return is_numeric($param);
                    },
                ],
            ],
            'permission_callback' => '__return_true',
        ]);

        register_rest_route('rankology/v1', '/posts/(?P<id>\d+)/social-settings', [
            'methods'             => 'PUT',
            'callback'            => [$this, 'processPut'],
            'args'                => [
                'id' => [
                    'validate_callback' => function ($param, $request, $key) {
                        return is_numeric($param);
                    },
                ],
            ],
            'permission_callback' => function ($request) {
                $nonce = $request->get_header('x-wp-nonce');

                if ($nonce && wp_verify_nonce(sanitize_text_field(wp_unslash($nonce)), 'wp_rest')) {
                    if (current_user_can('edit_posts')) {
                        return true;
                    }
                }

                $authorization_header = $request->get_header('Authorization');

                if (!$authorization_header) {
                    return false;
                }

                $authorization_parts = explode(' ', $authorization_header);

                if (count($authorization_parts) !== 2 || $authorization_parts[0] !== 'Basic') {
                    return false;
                }

                $credentials = base64_decode($authorization_parts[1]);
                list($username, $password) = explode(':', $credentials);

                $wp_user = get_user_by('login', $username);

                $user = wp_authenticate_application_password($wp_user, $username, $password);

                if (is_wp_error($user)) {
                    return false;
                }

                if (!user_can($user, 'edit_posts')) {
                    return false;
                }

                return true;
            },
        ]);
    }

    /**
     * 
     */
    public function processPut(\WP_REST_Request $request) {
        $metas = SocialSettingsHelper::getMetaKeys($id);

        $id     = $request->get_param('id');
        $params = $request->get_params();

        try {

            //Elementor sync
            $elementor = get_post_meta($id, '_elementor_page_settings', true);

            foreach ($metas as $key => $value) {
                if ( ! isset($params[$value['key']])) {
                    continue;
                }

                $item = $params[$value['key']];
                if(in_array($value['type'], ['input', 'textarea'])){
                    $item = esc_html($item);
                }

                if(!empty($item)){
                    update_post_meta($id, $value['key'], $item);
                }
                else{
                    delete_post_meta($id, $value['key']);
                }

                if (! empty($elementor)) {
                    $elementor[$value['key']] = $item;
                }
            }

            if(!empty($elementor)){
                update_post_meta($id, '_elementor_page_settings', $elementor);
            }

            return new \WP_REST_Response([
                'code' => 'success',
            ]);
        } catch (\Exception $e) {
            return new \WP_REST_Response([
                'code'         => 'error',
                'code_message' => 'execution_failed',
            ], 403);
        }
    }

    /**
     * 
     */
    public function processGet(\WP_REST_Request $request) {
        $id    = $request->get_param('id');

        $metas = SocialSettingsHelper::getMetaKeys($id);

        $data = [];
        foreach ($metas as $key => $value) {
            if (isset($value['use_default']) && $value['use_default']) {
                $data[] = array_merge($value, [
                    'can_modify' => false,
                    'value'      => $value['default'],
                ]);
            } else {
                $result = get_post_meta($id, $value['key'], true);
                $data[] = array_merge($value, [
                    'can_modify' => true,
                    'value'      => 'checkbox' === $value['type'] ? ($result ? true : false) : $result,
                ]);
            }
        }

        return new \WP_REST_Response($data);
    }
}
