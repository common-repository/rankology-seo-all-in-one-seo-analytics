<?php

namespace Rankology\Services\Sitemap;

defined('ABSPATH') or exit('Cheatin&#8217; uh?');

class Headers {
    const NAME_SERVICE = 'SitemapHeaders';

    /**
     * 
     *
     * @return void
     */
    public function printHeaders() {
        $headers = ['Content-type' => 'text/xml', 'x-robots-tag' => 'noindex, follow'];
        $headers = apply_filters('rankology_sitemaps_headers', $headers);
        if (empty($headers)) {
            return;
        }

        foreach ($headers as $key => $header) {
            header($key . ':' . $header);
        }
    }
}
