<?php

namespace Rankology\Actions\Api;

if (! defined('ABSPATH')) {
    exit;
}

use Rankology\Core\Hooks\ExecuteHooks;
use Rankology\ManualHooks\ApiHeader;

class SearchUrl implements ExecuteHooks
{
    public function hooks()
    {
        add_action('rest_api_init', [$this, 'register']);
    }

    /**
     *
     * @return void
     */
    public function register()
    {
        register_rest_route('rankology/v1', '/search-url', [
            'methods'             => 'GET',
            'callback'            => [$this, 'process'],
            'permission_callback' => '__return_true',
        ]);
    }

    public function process(\WP_REST_Request $request)
    {

        $url = $request->get_param('url');

        $data = rankology_get_service('SearchUrl')->searchByPostName($url);

        return new \WP_REST_Response($data);
    }
}
