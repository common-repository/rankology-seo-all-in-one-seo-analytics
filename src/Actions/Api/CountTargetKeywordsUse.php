<?php

namespace Rankology\Actions\Api;

if (! defined('ABSPATH')) {
    exit;
}

use Rankology\Core\Hooks\ExecuteHooks;
use Rankology\ManualHooks\ApiHeader;

class CountTargetKeywordsUse implements ExecuteHooks
{
    public function hooks()
    {
        add_action('rest_api_init', [$this, 'register']);
    }

    /**
     * 
     *
     * @return void
     */
    public function register()
    {
        register_rest_route('rankology/v1', '/posts/(?P<id>\d+)/count-target-keywords-use', [
            'methods'             => 'GET',
            'callback'            => [$this, 'get'],
            'args'                => [
                'id' => [
                    'validate_callback' => function ($param, $request, $key) {
                        return is_numeric($param);
                    },
                ],
            ],
            'permission_callback' => '__return_true',
        ]);

    }

    /**
     * 
     */
    public function get(\WP_REST_Request $request)
    {
        $apiHeader = new ApiHeader();
        $apiHeader->hooks();

        $id   = (int) $request->get_param('id');
        $targetKeywords   =  $request->get_param('keywords');

        $data = rankology_get_service('CountTargetKeywordsUse')->getCountByKeywords($targetKeywords, $id);

        return new \WP_REST_Response($data);
    }



}
