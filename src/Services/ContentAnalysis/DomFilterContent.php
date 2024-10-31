<?php

namespace Rankology\Services\ContentAnalysis;

defined('ABSPATH') or exit('Cheatin&#8217; uh?');

class DomFilterContent
{
    /**
     * @param string $str
     * @param mixed  $id
     *
     * @return array
     */
    public function getData($str, $id)
    {
        if (empty($str)) {
            return [
                'code' => 'no_data',
            ];
        }

        $dom                     = new \DOMDocument();
        $internalErrors          = libxml_use_internal_errors(true);
        $dom->preserveWhiteSpace = false;

        $dom->loadHTML($str);

        //Disable wptexturize
        add_filter('run_wptexturize', '__return_false');

        $xpath = new \DOMXPath($dom);

        $data = [
            'title' => [
                'class' => '\Rankology\Services\ContentAnalysis\GetContent\Title',
                'value' => '',
            ],
            'description' => [
                'class' => '\Rankology\Services\ContentAnalysis\GetContent\Description',
                'value' => '',
            ],
            'og:title' => [
                'class' => '\Rankology\Services\ContentAnalysis\GetContent\OG\Title',
                'value' => '',
            ],
            'og:description' => [
                'class' => '\Rankology\Services\ContentAnalysis\GetContent\OG\Description',
                'value' => '',
            ],
            'og:image' => [
                'class' => '\Rankology\Services\ContentAnalysis\GetContent\OG\Image',
                'value' => '',
            ],
            'og:url' => [
                'class' => '\Rankology\Services\ContentAnalysis\GetContent\OG\Url',
                'value' => '',
            ],
            'og:site_name' => [
                'class' => '\Rankology\Services\ContentAnalysis\GetContent\OG\Sitename',
                'value' => '',
            ],
            'twitter:title' => [
                'class' => '\Rankology\Services\ContentAnalysis\GetContent\Twitter\Title',
                'value' => '',
            ],
            'twitter:description' => [
                'class' => '\Rankology\Services\ContentAnalysis\GetContent\Twitter\Description',
                'value' => '',
            ],
            'twitter:image' => [
                'class' => '\Rankology\Services\ContentAnalysis\GetContent\Twitter\Image',
                'value' => '',
            ],
            'twitter:image:src' => [
                'class' => '\Rankology\Services\ContentAnalysis\GetContent\Twitter\ImageSrc',
                'value' => '',
            ],
            'canonical' => [
                'class' => '\Rankology\Services\ContentAnalysis\GetContent\Canonical',
                'value' => '',
            ],
            'h1' => [
                'class'   => '\Rankology\Services\ContentAnalysis\GetContent\Hn',
                'value'   => '',
                'options' => [
                    'hn' => 'h1',
                ],
            ],
            'h2' => [
                'class'   => '\Rankology\Services\ContentAnalysis\GetContent\Hn',
                'value'   => '',
                'options' => [
                    'hn' => 'h2',
                ],
            ],
            'h3' => [
                'class'   => '\Rankology\Services\ContentAnalysis\GetContent\Hn',
                'value'   => '',
                'options' => [
                    'hn' => 'h3',
                ],
            ],
            'images' => [
                'class'   => '\Rankology\Services\ContentAnalysis\GetContent\Image',
                'value'   => '',
            ],
            'meta_robots' => [
                'class'   => '\Rankology\Services\ContentAnalysis\GetContent\Metas\Robot',
                'value'   => '',
            ],
            'meta_google' => [
                'class'   => '\Rankology\Services\ContentAnalysis\GetContent\Metas\Google',
                'value'   => '',
            ],
            'links_no_follow' => [
                'class'   => '\Rankology\Services\ContentAnalysis\GetContent\LinkNoFollow',
                'value'   => '',
            ],
            'outbound_links' => [
                'class'   => '\Rankology\Services\ContentAnalysis\GetContent\OutboundLinks',
                'value'   => '',
            ],
            'internal_links' => [
                'class'   => '\Rankology\Services\ContentAnalysis\GetContent\InternalLinks',
                'value'   => '',
                'options' => [
                    'id' => $id,
                ],
            ],
            'schemas' => [
                'class'   => '\Rankology\Services\ContentAnalysis\GetContent\Schema',
                'value'   => '',
            ],
        ];

        $data = apply_filters('rankology_get_data_dom_filter_content', $data);

        foreach ($data as $key => $item) {
            $class = new $item['class']();

            $options = isset($item['options']) ? $item['options'] : [];

            if (method_exists($class, 'getDataByXPath')) {
                $data[$key]['value'] = $class->getDataByXPath($xpath, $options);
            } elseif (method_exists($class, 'getDataByDom')) {
                $data[$key]['value'] = $class->getDataByDom($dom, $options);
            }
        }

        $data["permalink"] = [
            "value" => get_permalink($id)
        ];

        $data['id_homepage'] = [
            "value" => get_option('page_on_front')
        ];

        return $data;
    }
}
