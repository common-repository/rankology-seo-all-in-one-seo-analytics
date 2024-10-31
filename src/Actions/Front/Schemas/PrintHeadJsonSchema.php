<?php

namespace Rankology\Actions\Front\Schemas;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Core\Hooks\ExecuteHooksFrontend;

class PrintHeadJsonSchema implements ExecuteHooksFrontend {
    public function hooks() {
        add_action('wp_head', [$this, 'render'], 2);
    }

    public function render() {
        /**
         * Check if Social toggle is ON
         *
         * 
         * @author Team Rankology
         */
        if (rankology_get_toggle_option('social') !=='1') {
            return;
        }

        /**
         * Check if is homepage
         *
         * 
         * @author Team Rankology
         */
        if (!is_front_page()) {
            return;
        }

        if ('none' === rankology_get_service('SocialOption')->getSocialKnowledgeType()) {
            return;
        }

        $jsons = rankology_get_service('JsonSchemaGenerator')->getJsonsEncoded([
            'organization'
        ]);
        ?><script type="application/ld+json"><?php echo apply_filters('rankology_schemas_organization_html', $jsons[0]); ?></script>
<?php
    }
}
