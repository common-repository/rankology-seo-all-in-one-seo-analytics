<?php

namespace Rankology\Services\Metas;

if (! defined('ABSPATH')) {
    exit;
}

use Rankology\Helpers\Metas\RobotSettings;

class RobotMeta
{
    protected function getKeyValue($meta){
        switch($meta){
            case '_rankology_robots_index':
                return 'noindex';
            case '_rankology_robots_follow':
                return 'nofollow';
            case '_rankology_robots_archive':
                return 'noarchive';
            case '_rankology_robots_snippet':
                return 'nosnippet';
            case '_rankology_robots_imageindex':
                return 'noimageindex';
            case '_rankology_robots_canonical':
                return 'canonical';
            case '_rankology_robots_primary_cat':
                return 'primarycat';
            case '_rankology_robots_breadcrumbs':
                return 'breadcrumbs';
        }

        return null;
    }

    /**
     *
     * @param array $context
     * @return string|null
     */
    public function getValue($context)
    {
        $data = [];

        $id = null;

        $callback = 'get_post_meta';
        if(isset($context['post'])){
            $id = $context['post']->ID;
        }
        else if(isset($context['term_id'])){
            $id = $context['term_id'];
            $callback = 'get_term_meta';
        }

        if(!$id){
            return $data;
        }

        $metas = RobotSettings::getMetaKeys($id);

        $data = [];
        foreach ($metas as $key => $value) {
            $name = $this->getKeyValue($value['key']);
            if($name === null){
                continue;
            }
            if ($value['use_default']) {
                $data[$name] = $value['default'];
            } else {
                $result = $callback($id, $value['key'], true);
                $data[$name] = 'checkbox' === $value['type'] ? ($result === true || $result === 'yes' ? true : false) : $result;
            }
        }

        return $data;
    }
}



