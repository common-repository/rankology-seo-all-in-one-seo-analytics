<?php

namespace Rankology\Actions\Api;

if (! defined('ABSPATH')) {
    exit;
}

use Rankology\Core\Hooks\ExecuteHooks;
use Rankology\ManualHooks\ApiHeader;

class PagePreview implements ExecuteHooks
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
        register_rest_route('rankology/v1', '/posts/(?P<id>\d+)/page-preview', [
            'methods'             => 'GET',
            'callback'            => [$this, 'preview'],
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
    public function preview(\WP_REST_Request $request)
    {
        $apiHeader = new ApiHeader();
        $apiHeader->hooks();

        $id   = (int) $request->get_param('id');
        $str  = rankology_get_service('RequestPreview')->getDomById($id);
        $data = rankology_get_service('DomFilterContent')->getData($str, $id);
        if (defined('WP_DEBUG') && WP_DEBUG) {
            $data['analyzed_content'] = rankology_get_service('DomAnalysis')->getPostContentAnalyze($id);
            $data['analyzed_content_id'] = $id;
        }

        $data['analysis_target_kw'] = [
            'value' => array_filter(explode(',', strtolower(get_post_meta($id, '_rankology_analysis_target_kw', true))))
        ];

        return new \WP_REST_Response($data);
    }
}
