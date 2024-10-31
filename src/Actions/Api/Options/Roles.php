<?php

namespace Rankology\Actions\Api\Options;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Core\Hooks\ExecuteHooks;

class Roles implements ExecuteHooks {
    /**
	 * Current user ID
	 *
	 * @var int
	 */
    private $current_user = '';

    public function hooks() {
        $this->current_user = wp_get_current_user()->ID;
        add_action('rest_api_init', [$this, 'register']);
    }

    /**
     * 
     *
     * @return boolean
     */
    public function permissionCheck(\WP_REST_Request $request) {
        $nonce = $request->get_header('x-wp-nonce');
        if ( ! wp_verify_nonce(sanitize_text_field(wp_unslash($nonce)), 'wp_rest')) {
            return false;
        }

        if ( ! user_can( $this->current_user, 'manage_options' )) {
            return false;
        }

        return true;
    }

    /**
     * 
     *
     * @return void
     */
    public function register() {
        register_rest_route('rankology/v1', '/roles', [
            'methods'             => 'GET',
            'callback'            => [$this, 'processGet'],
            'permission_callback' => [$this, 'permissionCheck'],
        ]);
    }

    /**
     * 
     */
    public function processGet(\WP_REST_Request $request) {
        global $wp_roles;

        if ( ! isset( $wp_roles ) ) {
            $wp_roles = new WP_Roles();
        }

        if (empty($wp_roles)) {
            return;
        };

        $data = $wp_roles->get_names();

        return new \WP_REST_Response($data);
    }
}
