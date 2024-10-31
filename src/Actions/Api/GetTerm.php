<?php

namespace Rankology\Actions\Api;

if (! defined('ABSPATH')) {
    exit;
}

use Rankology\Core\Hooks\ExecuteHooks;

class GetTerm implements ExecuteHooks
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
        register_rest_route('rankology/v1', '/terms/(?P<id>\d+)', [
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

    }

    /**
     * 
     * @param int $id
     * @return array
     */
    protected function getData($id, $taxonomy = 'category'){
        $context = rankology_get_service('ContextPage')->buildContextWithCurrentId($id, ['type' => 'term','taxonomy' => $taxonomy])->getContext();

        $title = rankology_get_service('TitleMeta')->getValue($context);
        $description = rankology_get_service('DescriptionMeta')->getValue($context);

        $social = rankology_get_service('SocialMeta')->getValue($context);
        $robots = rankology_get_service('RobotMeta')->getValue($context);
        $redirections = rankology_get_service('RedirectionMeta')->getValue($context);

        $canonical =  '';
        if(isset($robots['canonical'])){
            $canonical = $robots['canonical'];
            unset($robots['canonical']);
        }

        if(isset($robots['primarycat'])){
            unset($robots['primarycat']);
        }

        $breadcrumbs =  '';
        if(isset($robots['breadcrumbs'])){
            $breadcrumbs = $robots['breadcrumbs'];
            unset($robots['breadcrumbs']);
        }

        $data = [
            "title" => $title,
            "description" => $description,
            "canonical" => $canonical,
            "og" => $social['og'],
            "twitter" => $social['twitter'],
            "robots" => $robots,
            "breadcrumbs" => $breadcrumbs,
            "redirections" => $redirections
        ];

        return apply_filters('rankology_headless_get_post', $data, $id, $context);

    }

    /**
     * 
     *
     * @param \WP_REST_Request $request
     */
    public function processGet(\WP_REST_Request $request)
    {
        $id     = $request->get_param('id');
        $taxonomy = $request->get_param('taxonomy');
        if($taxonomy === null){
            $taxonomy = 'category';
        }

        $data = $this->getData($id, $taxonomy);

        return new \WP_REST_Response($data);
    }

}
