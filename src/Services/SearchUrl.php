<?php
namespace Rankology\Services;

if (!defined('ABSPATH')) {
    exit;
}

class SearchUrl
{
    public function searchByPostName($value)
    {
        global $wpdb;

        $limit = apply_filters('rankology_search_url_result_limit', 50);
        if ($limit > 200) {
            $limit = 200;
        }

        // Get post types and sanitize them
        $postTypes = rankology_get_service('WordPressData')->getPostTypes();
        $postTypes = array_keys($postTypes);

        // Create placeholders for each post type (e.g., %s for strings)
        $postTypePlaceholders = implode(',', array_fill(0, count($postTypes), '%s'));

        // Prepare the SQL query with placeholders
        $sql = "
            SELECT p.ID, p.post_title
            FROM $wpdb->posts p
            WHERE (
                p.post_name LIKE %s
                OR p.post_title LIKE %s
            )
            AND p.post_status = 'publish'
            AND p.post_type IN ($postTypePlaceholders)
            LIMIT %d";

        // Prepare the values for wpdb::prepare()
        $prepare_values = array_merge(
            ['%' . $wpdb->esc_like($value) . '%', '%' . $wpdb->esc_like($value) . '%'], // For post_name and post_title
            $postTypes, // For the post types
            [$limit] // For the limit
        );

        // Prepare and execute the query
        $sql = $wpdb->prepare($sql, ...$prepare_values);
        $data = $wpdb->get_results($sql, ARRAY_A);

        // Process results
        foreach ($data as $key => $value) {
            $data[$key]['guid'] = get_permalink($value['ID']);
        }

        return $data;
    }
}
