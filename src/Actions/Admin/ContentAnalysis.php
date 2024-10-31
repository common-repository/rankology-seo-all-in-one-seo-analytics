<?php

namespace Rankology\Actions\Admin;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Core\Hooks\ExecuteHooksBackend;

class ContentAnalysis implements ExecuteHooksBackend {
    /**
     * 
     *
     * @return void
     */
    public function hooks() {
        add_filter('rankology_content_analysis_content', [$this, 'addContent'], 10, 2);
    }

    public function addContent($content, $id) {
        if ( ! apply_filters('rankology_content_analysis_acf_fields', true)) {
            return $content;
        }

        if ( ! function_exists('get_field_objects')) {
            return $content;
        }

        return $content . rankology_get_service('ContentAnalysisAcfFields')->addAcfContent($id);
    }
}
