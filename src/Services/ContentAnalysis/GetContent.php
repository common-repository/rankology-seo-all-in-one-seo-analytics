<?php

namespace Rankology\Services\ContentAnalysis;

defined('ABSPATH') or exit('Cheatin&#8217; uh?');

use Rankology\Helpers\ContentAnalysis;

class GetContent
{
    const NAME_SERVICE = 'GetContentAnalysis';

    /**
     * @param array   $analyzes
     * @param array   $data
     * @param WP_Post $post
     *
     * @return array
     */
    protected function analyzeSchemas($analyzes, $data, $post)
    {
        if (! empty($data['json']) || isset($data['json'])) {
            $desc = '<p>' . esc_html__('We found these schemas in the source code of this page:', 'wp-rankology') . '</p>';

            $desc .= '<ul>';
            $json_ld = array_filter($data['json'], function($value) {
                return is_string($value) || is_int($value);
            });
            foreach (array_count_values($json_ld) as $key => $value) {
                $html = null;
                if ($value > 1) {
                    if ('Review' !== $key) {
                        $html                          = '<span class="impact high">' . esc_html__('duplicated schema - x', 'wp-rankology') . $value . '</span>';
                        $analyzes['schemas']['impact'] = 'high';
                    } else {
                        $html                          = ' <span class="impact">' . esc_html__('x', 'wp-rankology') . $value . '</span>';
                    }
                }
                $desc .= '<li><span class="dashicons dashicons-minus"></span>' . $key . $html . '</li>';
            }
            $desc .= '</ul>';
            $analyzes['schemas']['desc'] = $desc;
        } else {
            $analyzes['schemas']['impact'] = 'medium';
            $analyzes['schemas']['desc']   = '<p>' . esc_html__('No schemas found in the source code of this page.', 'wp-rankology') . '</p>';
        }

        return $analyzes;
    }

    /**
     * @param array   $analyzes
     * @param array   $data
     * @param WP_Post $post
     *
     * @return array
     */
    protected function analyzeOldPost($analyzes, $data, $post)
    {
        $desc = null;
        if (strtotime($post->post_modified) < strtotime('-365 days')) {
            $analyzes['old_post']['impact'] = 'medium';
            $desc                           = '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('This post is a little old!', 'wp-rankology') . '</p>';
        } else {
            $desc = '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('The last modified date of this article is less than 1 year. Cool!', 'wp-rankology') . '</p>';
        }
        $desc .= '<p>' . esc_html__('Search engines love fresh content. Update regularly your articles without entirely rewriting your content and give them a boost in search rankings. Rankology takes care of the technical part.', 'wp-rankology') . '</p>';
        $analyzes['old_post']['desc'] = $desc;

        return $analyzes;
    }

    /**
     * @param array   $analyzes
     * @param array   $data
     * @param WP_Post $post
     *
     * @return array
     */
    protected function analyzeWordCounters($analyzes, $data, $post)
    {
        $desc = null;
        if (isset($data['words_counter']) || isset($data['words_counter_unique'])) {
            $desc = '<p>' . esc_html__('Words counter is not a direct ranking factor. But, your content must be as qualitative as possible, with relevant and unique information. To fulfill these conditions, your article requires a minimum of paragraphs, so words.', 'wp-rankology') . '</p>
	<ul>
		<li>' . $data['words_counter'] . ' ' . esc_html__('words found.', 'wp-rankology') . '</li>
		<li>' . $data['words_counter_unique'] . ' ' . esc_html__('unique words found.', 'wp-rankology') . '</li>';

            if ($data['words_counter'] >= 299) {
                $desc .= '<li><span class="dashicons dashicons-yes"></span>' . esc_html__('Your content is composed of more than 300 words, which is the minimum for a post.', 'wp-rankology') . '</li>';
            } else {
                $desc .= '<li><span class="dashicons dashicons-no-alt"></span>' . esc_html__('Your content is too short. Add a few more paragraphs!', 'wp-rankology') . '</li>';
                $analyzes['words_counter']['impact'] = 'medium';
            }
            $desc .= '</ul>';

            $analyzes['words_counter']['desc'] = $desc;
        } else {
            $analyzes['words_counter']['desc']   = '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('No content? Add a few more paragraphs!', 'wp-rankology') . '</p>';
            $analyzes['words_counter']['impact'] = 'high';
        }

        return $analyzes;
    }

    /**
     * @param array   $analyzes
     * @param array   $data
     * @param WP_Post $post
     *
     * @return array
     */
    protected function analyzeKeywordsDensity($analyzes, $data, $post)
    {
        if (! empty($data['kws_density']['matches']) && isset($data['words_counter']) && $data['words_counter'] > 0) {
            $target_kws_density = $data['kws_density']['matches'];

            $desc = '<ul>';
            foreach ($target_kws_density as $key => $value) {
                foreach ($value as $_key => $_value) {
                    $kw_count = count($_value);
                }
                $kw_name    = $key;
                $kw_density = round($kw_count / $data['words_counter'] * 100, 2);
                $desc .= '<li><span class="dashicons dashicons-minus"></span>' . sprintf(esc_html__('%s was found %d times in your content, a keyword density of %s%%', 'wp-rankology'), $kw_name, $kw_count, $kw_density) . '</li>';
            }
            $desc .= '</ul>';
            $analyzes['keywords_density']['impact'] = 'good';
            $analyzes['keywords_density']['desc']   = $desc;
        } else {
            $analyzes['keywords_density']['desc']   = '<p>' . esc_html__('We were unable to calculate the density of your keywords. You probably haven‘t added any content or your target keywords were not find in your post content.', 'wp-rankology') . '</p>';
            $analyzes['keywords_density']['impact'] = 'high';
        }

        return $analyzes;
    }

    /**
     * @param array   $analyzes
     * @param array   $data
     * @param WP_Post $post
     *
     * @return array
     */
    protected function analyzeKeywordsPermalink($analyzes, $data, $post)
    {
        if (! empty($data['kws_permalink']['matches'])) {
            $desc = '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('Cool, one of your target keyword is used in your permalink.', 'wp-rankology') . '</p>';

            $target_kws_permalink = $data['kws_permalink']['matches'];

            $desc .= '<ul>';
            foreach ($target_kws_permalink as $key => $value) {
                $desc .= '<li><span class="dashicons dashicons-minus"></span>' . $key . '</li>';
            }
            $desc .= '</ul>';
            $analyzes['keywords_permalink']['desc']   = $desc;
            $analyzes['keywords_permalink']['impact'] = 'good';
        } else {
            if (get_option('page_on_front') == $post->ID) {
                $analyzes['keywords_permalink']['desc']   = '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('This is your homepage. This check doesn\'t apply here because there is no slug.', 'wp-rankology') . '</p>';
                $analyzes['keywords_permalink']['impact'] = 'good';
            } else {
                $analyzes['keywords_permalink']['desc']   = '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('You should add one of your target keyword in your permalink.', 'wp-rankology') . '</p>';
                $analyzes['keywords_permalink']['impact'] = 'medium';
            }
        }

        return $analyzes;
    }

    /**
     * @param array   $analyzes
     * @param array   $data
     * @param WP_Post $post
     *
     * @return array
     */
    protected function analyzeHeadings($analyzes, $data, $post)
    {
        //H1
        $desc = '<h4>' . esc_html__('H1 (Heading 1)', 'wp-rankology') . '</h4>';

        if (! empty($data['h1']['matches'])) {
            $count         = $data['h1']['nomatches']['count'];
            $target_kws_h1 = $data['h1']['matches'];

            $all_h1 = $data['h1']['values'];

            $desc .= '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('Target keywords were found in Heading 1 (H1).', 'wp-rankology') . '</p>';

            $desc .= '<ul>';

            foreach ($target_kws_h1 as $key => $value) {
                foreach ($value as $_key => $_value) {
                    $kw_count = count($value);
                }
                $kw_name = $key;
                $desc .= '<li><span class="dashicons dashicons-minus"></span>' . sprintf(esc_html__('%s was found %d times.', 'wp-rankology'), $kw_name, $kw_count) . '</li>';
            }

            $desc .= '</ul>';
            if ($count > 1) {
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . sprintf(esc_html__('We found %d Heading 1 (H1) in your content.', 'wp-rankology'), $count) . '</p>';
                $desc .= '<p>' . esc_html__('You should not use more than one H1 heading in your post content. The rule is simple: only one H1 for each web page. It is better for both SEO and accessibility. Below, the list:', 'wp-rankology') . '</p>';
                $analyzes['headings']['impact'] = 'high';

                if (! empty($all_h1)) {
                    $desc .= '<ul>';
                    foreach ($all_h1 as $h1) {
                        $desc .= '<li><span class="dashicons dashicons-minus"></span>' . $h1 . '</li>';
                    }
                    $desc .= '</ul>';
                }
            }
        } elseif (isset($data['h1']['nomatches']['count']) && 0 === $data['h1']['nomatches']['count']) {
            $desc .= '<p><span class="dashicons dashicons-no-alt"></span><strong>' . esc_html__('No Heading 1 (H1) found in your content. This is required for both SEO and Accessibility!', 'wp-rankology') . '</strong></p>';
            $analyzes['headings']['impact'] = 'high';
        } else {
            $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('None of your target keywords were found in Heading 1 (H1).', 'wp-rankology') . '</p>';
            if ('high' != $analyzes['headings']['impact']) {
                $analyzes['headings']['impact'] = 'medium';
            }
        }

        //H2
        $desc .= '<h4>' . esc_html__('H2 (Heading 2)', 'wp-rankology') . '</h4>';
        if (! empty($data['h2']['matches'])) {
            $desc .= '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('Target keywords were found in Heading 2 (H2).', 'wp-rankology') . '</p>';
            $desc .= '<ul>';
            $target_kws_h2 = $data['h2']['matches'];
            foreach ($target_kws_h2 as $key => $value) {
                foreach ($value as $_key => $_value) {
                    $kw_count = count($value);
                }
                $kw_name = $key;
                $desc .= '<li><span class="dashicons dashicons-minus"></span>' . sprintf(esc_html__('%s was found %d times.', 'wp-rankology'), $kw_name, $kw_count) . '</li>';
            }
            $desc .= '</ul>';
        } else {
            $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('None of your target keywords were found in Heading 2 (H2).', 'wp-rankology') . '</p>';
            if ('high' != $analyzes['headings']['impact']) {
                $analyzes['headings']['impact'] = 'medium';
            }
        }

        //H3
        $desc .= '<h4>' . esc_html__('H3 (Heading 3)', 'wp-rankology') . '</h4>';
        if (! empty($data['h3']['matches'])) {
            $desc .= '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('Target keywords were found in Heading 3 (H3).', 'wp-rankology') . '</p>';
            $desc .= '<ul>';
            $target_kws_h3 = $data['h3']['matches'];
            foreach ($target_kws_h3 as $key => $value) {
                foreach ($value as $_key => $_value) {
                    $kw_count = count($value);
                }
                $kw_name = $key;
                $desc .= '<li><span class="dashicons dashicons-minus"></span>' . sprintf(esc_html__('%s was found %d times.', 'wp-rankology'), $kw_name, $kw_count) . '</li>';
            }
            $desc .= '</ul>';
        } else {
            $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('None of your target keywords were found in Heading 3 (H3).', 'wp-rankology') . '</p>';
            if ('high' != $analyzes['headings']['impact']) {
                $analyzes['headings']['impact'] = 'low';
            }
        }
        $analyzes['headings']['desc'] = $desc;

        return $analyzes;
    }

    /**
     * @param array   $analyzes
     * @param array   $data
     * @param WP_Post $post
     *
     * @return array
     */
    protected function analyzeMetaTitle($analyzes, $data, $post)
    {
        $rankology_titles_title     = get_post_meta($post->ID, '_rankology_titles_title', true);

        if (! empty($rankology_titles_title)) {
            $desc = null;
            if (! empty($data['meta_title']['matches'])) {
                $desc .= '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('Target keywords were found in the Meta Title.', 'wp-rankology') . '</p>';
                $desc .= '<ul>';
                $target_kws_title = $data['meta_title']['matches'];
                foreach ($target_kws_title as $key => $value) {
                    foreach ($value as $_key => $_value) {
                        $kw_count = count($_value);
                    }
                    $kw_name = $key;
                    $desc .= '<li><span class="dashicons dashicons-minus"></span>' . sprintf(esc_html__('%s was found %d times.', 'wp-rankology'), $kw_name, $kw_count) . '</li>';
                }
                $desc .= '</ul>';
                $analyzes['meta_title']['impact'] = 'good';
            } else {
                $analyzes['meta_title']['impact'] = 'medium';
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('None of your target keywords were found in the Meta Title.', 'wp-rankology') . '</p>';
            }

            if (mb_strlen($rankology_titles_title) > 65) {
                $analyzes['meta_title']['impact'] = 'medium';
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('Your custom title is too long.', 'wp-rankology') . '</p>';
            } else {
                if (!empty($analyzes['meta_title']['impact']) && $analyzes['meta_title']['impact'] !== 'medium') {
                    $analyzes['meta_title']['impact'] = 'good';
                }
                $desc .= '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('The length of your title is correct', 'wp-rankology') . '</p>';
            }
            $analyzes['meta_title']['desc'] = $desc;
        } else {
            $analyzes['meta_title']['impact'] = 'medium';
            $analyzes['meta_title']['desc']   = '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('No custom title is set for this post. If the global meta title suits you, you can ignore this recommendation.', 'wp-rankology') . '</p>';
        }

        return $analyzes;
    }

    /**
     * @param array   $analyzes
     * @param array   $data
     * @param WP_Post $post
     *
     * @return array
     */
    protected function analyzeMetaDescription($analyzes, $data, $post)
    {
        $rankology_titles_desc                   = get_post_meta($post->ID, '_rankology_titles_desc', true);

        if (! empty($rankology_titles_desc)) {
            $desc = null;
            if (! empty($data['meta_description']['matches'])) {
                $desc .= '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('Target keywords were found in the Meta description.', 'wp-rankology') . '</p>';
                $desc .= '<ul>';
                $target_kws_desc = $data['meta_description']['matches'];
                foreach ($target_kws_desc as $key => $value) {
                    foreach ($value as $_key => $_value) {
                        $kw_count = count($_value);
                    }
                    $kw_name = $key;
                    $desc .= '<li><span class="dashicons dashicons-minus"></span>' . sprintf(esc_html__('%s was found %d times.', 'wp-rankology'), $kw_name, $kw_count) . '</li>';
                }
                $desc .= '</ul>';
                $analyzes['meta_desc']['impact'] = 'good';
            } else {
                $analyzes['meta_desc']['impact'] = 'medium';
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('None of your target keywords were found in the Meta description.', 'wp-rankology') . '</p>';
            }

            if (mb_strlen($rankology_titles_desc) > 160) {
                $analyzes['meta_desc']['impact'] = 'medium';
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('You custom meta description is too long.', 'wp-rankology') . '</p>';
            } else {
                if (!empty($analyzes['meta_desc']['impact']) && $analyzes['meta_desc']['impact'] !== 'medium') {
                    $analyzes['meta_desc']['impact'] = 'good';
                }
                $desc .= '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('The length of your meta description is correct', 'wp-rankology') . '</p>';
            }
            $analyzes['meta_desc']['desc'] = $desc;
        } else {
            $analyzes['meta_desc']['impact'] = 'medium';
            $analyzes['meta_desc']['desc']   = '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('No custom meta description is set for this post. If the global meta description suits you, you can ignore this recommendation.', 'wp-rankology') . '</p>';
        }

        return $analyzes;
    }

    /**
     * @param array   $analyzes
     * @param array   $data
     * @param WP_Post $post
     *
     * @return array
     */
    protected function analyzeSocialTags($analyzes, $data, $post)
    {
        //og:title
        $desc = null;


        $desc .= '<h4>' . esc_html__('Open Graph Title', 'wp-rankology') . '</h4>';

        if (! empty($data['og_title']['count'])) {
            $count = $data['og_title']['count'];

            $all_og_title = $data['og_title']['values'];

            if ($count > 1) {
                $analyzes['social']['impact'] = 'high';
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . sprintf(esc_html__('We found %d og:title in your content.', 'wp-rankology'), $count) . '</p>';
                $desc .= '<p>' . esc_html__('You should not use more than one og:title in your post content to avoid conflicts when sharing on social networks. Facebook will take the last og:title tag from your source code. Below, the list:', 'wp-rankology') . '</p>';
            } elseif (empty($all_og_title[0])) { //If og:title empty
                $analyzes['social']['impact'] = 'high';
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('Your Open Graph Title tag is empty!', 'wp-rankology') . '</p>';
            } else {
                $desc .= '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('We found an Open Graph Title tag in your source code.', 'wp-rankology') . '</p>';
            }

            if (! empty($all_og_title)) {
                $desc .= '<ul>';
                foreach ($all_og_title as $og_title) {
                    $desc .= '<li><span class="dashicons dashicons-minus"></span>' . $og_title . '</li>';
                }
                $desc .= '</ul>';
            }
        } else {
            $analyzes['social']['impact'] = 'high';
            $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('Your Open Graph Title is missing!', 'wp-rankology') . '</p>';
        }

        //og:description
        $desc .= '<h4>' . esc_html__('Open Graph Description', 'wp-rankology') . '</h4>';

        if (! empty($data['og_desc']['count'])) {
            $count = $data['og_desc']['count'];

            $all_og_desc = isset($data['og_desc']['values']) ? $data['og_desc']['values'] : [];

            if ($count > 1) {
                $analyzes['social']['impact'] = 'high';
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . sprintf(esc_html__('We found %d og:description in your content.', 'wp-rankology'), $count) . '</p>';
                $desc .= '<p>' . esc_html__('You should not use more than one og:description in your post content to avoid conflicts when sharing on social networks. Facebook will take the last og:description tag from your source code. Below, the list:', 'wp-rankology') . '</p>';
            } elseif (empty($all_og_desc[0])) { //If og:description empty
                $analyzes['social']['impact'] = 'high';
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('Your Open Graph Description tag is empty!', 'wp-rankology') . '</p>';
            } else {
                $desc .= '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('We found an Open Graph Description tag in your source code.', 'wp-rankology') . '</p>';
            }

            if (! empty($all_og_desc)) {
                $desc .= '<ul>';
                foreach ($all_og_desc as $og_desc) {
                    $desc .= '<li><span class="dashicons dashicons-minus"></span>' . $og_desc . '</li>';
                }
                $desc .= '</ul>';
            }
        } else {
            $analyzes['social']['impact'] = 'high';
            $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('Your Open Graph Description is missing!', 'wp-rankology') . '</p>';
        }

        //og:image
        $desc .= '<h4>' . esc_html__('Open Graph Image', 'wp-rankology') . '</h4>';

        if (! empty($data['og_img']['count'])) {
            $count = $data['og_img']['count'];

            $all_og_img = isset($data['og_img']['values']) ? $data['og_img']['values'] : [];

            if ($count > 0 && ! empty($all_og_img[0])) {
                $desc .= '<p><span class="dashicons dashicons-yes"></span>' . sprintf(esc_html__('We found %d og:image in your content.', 'wp-rankology'), $count) . '</p>';
            }

            //If og:image empty
            if ($count > 0 && empty($all_og_img[0])) {
                $analyzes['social']['impact'] = 'high';
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('Your Open Graph Image tag is empty!', 'wp-rankology') . '</p>';
            }

            if (! empty($all_og_img)) {
                $desc .= '<ul>';
                foreach ($all_og_img as $og_img) {
                    $desc .= '<li><span class="dashicons dashicons-minus"></span>' . $og_img . '</li>';
                }
                $desc .= '</ul>';
            }
        } else {
            $analyzes['social']['impact'] = 'high';
            $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('Your Open Graph Image is missing!', 'wp-rankology') . '</p>';
        }

        //og:url
        $desc .= '<h4>' . esc_html__('Open Graph URL', 'wp-rankology') . '</h4>';

        if (! empty($data['og_url']['count'])) {
            $count = $data['og_url']['count'];

            $all_og_url = $data['og_url']['values'];

            if ($count > 1) {
                $analyzes['social']['impact'] = 'high';
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . sprintf(esc_html__('We found %d og:url in your content.', 'wp-rankology'), $count) . '</p>';
                $desc .= '<p>' . esc_html__('You should not use more than one og:url in your post content to avoid conflicts when sharing on social networks. Facebook will take the last og:url tag from your source code. Below, the list:', 'wp-rankology') . '</p>';
            } elseif (empty($all_og_url[0])) { //If og:url empty
                $analyzes['social']['impact'] = 'high';
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('Your Open Graph URL tag is empty!', 'wp-rankology') . '</p>';
            } else {
                $desc .= '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('We found an Open Graph URL tag in your source code.', 'wp-rankology') . '</p>';
            }

            if (! empty($all_og_url)) {
                $desc .= '<ul>';
                foreach ($all_og_url as $og_url) {
                    $desc .= '<li><span class="dashicons dashicons-minus"></span>' . $og_url . '</li>';
                }
                $desc .= '</ul>';
            }
        } else {
            $analyzes['social']['impact'] = 'high';
            $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('Your Open Graph URL is missing!', 'wp-rankology') . '</p>';
        }

        //og:site_name
        $desc .= '<h4>' . esc_html__('Open Graph Site Name', 'wp-rankology') . '</h4>';

        if (! empty($data['og_site_name']['count'])) {
            $count = $data['og_site_name']['count'];

            $all_og_site_name = $data['og_site_name']['values'];

            if ($count > 1) {
                $analyzes['social']['impact'] = 'high';
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . sprintf(esc_html__('We found %d og:site_name in your content.', 'wp-rankology'), $count) . '</p>';
                $desc .= '<p>' . esc_html__('You should not use more than one og:site_name in your post content to avoid conflicts when sharing on social networks. Facebook will take the last og:site_name tag from your source code. Below, the list:', 'wp-rankology') . '</p>';
            } elseif (empty($all_og_site_name[0])) { //If og:site_name empty
                $analyzes['social']['impact'] = 'high';
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('Your Open Graph Site Name tag is empty!', 'wp-rankology') . '</p>';
            } else {
                $desc .= '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('We found an Open Graph Site Name tag in your source code.', 'wp-rankology') . '</p>';
            }

            if (! empty($all_og_site_name)) {
                $desc .= '<ul>';
                foreach ($all_og_site_name as $og_site_name) {
                    $desc .= '<li><span class="dashicons dashicons-minus"></span>' . $og_site_name . '</li>';
                }
                $desc .= '</ul>';
            }
        } else {
            $analyzes['social']['impact'] = 'high';
            $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('Your Open Graph Site Name is missing!', 'wp-rankology') . '</p>';
        }

        //twitter:title
        $desc .= '<h4>' . esc_html__('Twitter Title', 'wp-rankology') . '</h4>';

        if (! empty($data['tw_title']['count'])) {
            $count = $data['tw_title']['count'];

            $all_tw_title = $data['tw_title']['values'];

            if ($count > 1) {
                $analyzes['social']['impact'] = 'high';
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . sprintf(esc_html__('We found %d twitter:title in your content.', 'wp-rankology'), $count) . '</p>';
                $desc .= '<p>' . esc_html__('You should not use more than one twitter:title in your post content to avoid conflicts when sharing on social networks. Twitter will take the last twitter:title tag from your source code. Below, the list:', 'wp-rankology') . '</p>';
            } elseif (empty($all_tw_title[0])) { //If twitter:title empty
                $analyzes['social']['impact'] = 'high';
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('Your Twitter Title tag is empty!', 'wp-rankology') . '</p>';
            } else {
                $desc .= '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('We found a Twitter Title tag in your source code.', 'wp-rankology') . '</p>';
            }

            if (! empty($all_tw_title)) {
                $desc .= '<ul>';
                foreach ($all_tw_title as $tw_title) {
                    $desc .= '<li><span class="dashicons dashicons-minus"></span>' . $tw_title . '</li>';
                }
                $desc .= '</ul>';
            }
        } else {
            $analyzes['social']['impact'] = 'high';
            $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('Your Twitter Title is missing!', 'wp-rankology') . '</p>';
        }

        //twitter:description
        $desc .= '<h4>' . esc_html__('Twitter Description', 'wp-rankology') . '</h4>';

        if (! empty($data['tw_desc']['count'])) {
            $count = $data['tw_desc']['count'];

            $all_tw_desc = isset($data['tw_desc']['values']) ? $data['tw_desc']['values'] : [];

            if ($count > 1) {
                $analyzes['social']['impact'] = 'high';
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . sprintf(esc_html__('We found %d twitter:description in your content.', 'wp-rankology'), $count) . '</p>';
                $desc .= '<p>' . esc_html__('You should not use more than one twitter:description in your post content to avoid conflicts when sharing on social networks. Twitter will take the last twitter:description tag from your source code. Below, the list:', 'wp-rankology') . '</p>';
            } elseif (empty($all_tw_desc[0])) { //If twitter:description empty
                $analyzes['social']['impact'] = 'high';
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('Your Twitter Description tag is empty!', 'wp-rankology') . '</p>';
            } else {
                $desc .= '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('We found a Twitter Description tag in your source code.', 'wp-rankology') . '</p>';
            }

            if (! empty($all_tw_desc)) {
                $desc .= '<ul>';
                foreach ($all_tw_desc as $tw_desc) {
                    $desc .= '<li><span class="dashicons dashicons-minus"></span>' . $tw_desc . '</li>';
                }
                $desc .= '</ul>';
            }
        } else {
            $analyzes['social']['impact'] = 'high';
            $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('Your Twitter Description is missing!', 'wp-rankology') . '</p>';
        }

        //twitter:image
        $desc .= '<h4>' . esc_html__('Twitter Image', 'wp-rankology') . '</h4>';

        if (! empty($data['tw_img']['count'])) {
            $count = $data['tw_img']['count'];

            $all_tw_img = isset($data['tw_img']['values']) ? $data['tw_img']['values'] : [];

            if ($count > 0 && ! empty($all_tw_img[0])) {
                $desc .= '<p><span class="dashicons dashicons-yes"></span>' . sprintf(esc_html__('We found %d twitter:image in your content.', 'wp-rankology'), $count) . '</p>';
            }

            //If twitter:image:src empty
            if ($count > 0 && empty($all_tw_img[0])) {
                $analyzes['social']['impact'] = 'high';
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('Your Twitter Image tag is empty!', 'wp-rankology') . '</p>';
            }

            if (! empty($all_tw_img)) {
                $desc .= '<ul>';
                foreach ($all_tw_img as $tw_img) {
                    $desc .= '<li><span class="dashicons dashicons-minus"></span>' . $tw_img . '</li>';
                }
                $desc .= '</ul>';
            }
        } else {
            $analyzes['social']['impact'] = 'high';
            $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('Your Twitter Image is missing!', 'wp-rankology') . '</p>';
        }
        $analyzes['social']['desc'] = $desc;

        return $analyzes;
    }

    /**
     * @param array   $analyzes
     * @param array   $data
     * @param WP_Post $post
     *
     * @return array
     */
    protected function analyzeRobots($analyzes, $data, $post)
    {
        $desc = null;
        if (! empty($data['meta_robots'])) {
            $meta_robots = $data['meta_robots'];

            if (count($data['meta_robots']) > 1) {
                $analyzes['robots']['impact'] = 'high';

                $count_meta_robots = count($data['meta_robots']);

                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . sprintf(esc_html__('We found %s meta robots in your page. There is probably something wrong with your theme!', 'wp-rankology'), $count_meta_robots) . '</p>';
            }

            if (preg_match('/noindex/', json_encode($meta_robots))) {
                $analyzes['robots']['impact'] = 'high';
                $desc .= '<p data-robots="noindex"><span class="dashicons dashicons-no-alt"></span>' . esc_html__('<strong>noindex</strong> is on! Search engines can\'t index this page.', 'wp-rankology') . '</p>';
            } else {
                $desc .= '<p data-robots="index"><span class="dashicons dashicons-yes"></span>' . esc_html__('<strong>noindex</strong> is off. Search engines will index this page.', 'wp-rankology') . '</p>';
            }

            if (preg_match('/nofollow/', json_encode($meta_robots))) {
                $analyzes['robots']['impact'] = 'high';
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('<strong>nofollow</strong> is on! Search engines can\'t follow your links on this page.', 'wp-rankology') . '</p>';
            } else {
                $desc .= '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('<strong>nofollow</strong> is off. Search engines will follow links on this page.', 'wp-rankology') . '</p>';
            }

            if (preg_match('/noimageindex/', json_encode($meta_robots))) {
                $analyzes['robots']['impact'] = 'high';
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('<strong>noimageindex</strong> is on! Google will not index your images on this page (but if someone makes a direct link to one of your image in this page, it will be indexed).', 'wp-rankology') . '</p>';
            } else {
                $desc .= '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('<strong>noimageindex</strong> is off. Google will index the images on this page.', 'wp-rankology') . '</p>';
            }

            if (preg_match('/noarchive/', json_encode($meta_robots))) {
                if ('high' != $analyzes['robots']['impact']) {
                    $analyzes['robots']['impact'] = 'medium';
                }
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('<strong>noarchive</strong> is on! Search engines will not cache your page.', 'wp-rankology') . '</p>';
            } else {
                $desc .= '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('<strong>noarchive</strong> is off. Search engines will probably cache your page.', 'wp-rankology') . '</p>';
            }

            if (preg_match('/nosnippet/', json_encode($meta_robots))) {
                if ('high' != $analyzes['robots']['impact']) {
                    $analyzes['robots']['impact'] = 'medium';
                }
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('<strong>nosnippet</strong> is on! Search engines will not display a snippet of this page in search results.', 'wp-rankology') . '</p>';
            } else {
                $desc .= '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('<strong>nosnippet</strong> is off. Search engines will display a snippet of this page in search results.', 'wp-rankology') . '</p>';
            }
        } else {
            $desc .= '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('We found no meta robots on this page. It means, your page is index,follow. Search engines will index it, and follow links. ', 'wp-rankology') . '</p>';
        }

        //Meta Google
        if (! empty($data['meta_google'])) {
            $meta_google = $data['meta_google'];
            if (preg_match('/nositelinkssearchbox/', json_encode($meta_google))) {
                if ('high' != $analyzes['robots']['impact']) {
                    $analyzes['robots']['impact'] = 'medium';
                }
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('<strong>nositelinkssearchbox</strong> is on! Google will not display a sitelinks searchbox in search results.', 'wp-rankology') . '</p>';
            } else {
                $desc .= '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('<strong>nositelinkssearchbox is</strong> off. Google will probably display a sitelinks searchbox in search results.', 'wp-rankology') . '</p>';
            }
        } else {

            $desc .= '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('<strong>nositelinkssearchbox</strong> is off. Google will probably display a sitelinks searchbox in search results.', 'wp-rankology') . '</p>';
        }

        $analyzes['robots']['desc'] = $desc;

        return $analyzes;
    }

    /**
     * @param array   $analyzes
     * @param array   $data
     * @param WP_Post $post
     *
     * @return array
     */
    protected function analyzeImgAlt($analyzes, $data, $post)
    {
        if (! empty($data['img']['images']['without_alt'])) {
            $images = isset($data['img']['images']['without_alt']) ? $data['img']['images']['without_alt'] : null;
            $context = isset($data['img']['images']['img_with_context']) ? $data['img']['images']['img_with_context'] : null;

            $desc = '<div class="wrap-analysis-img">';

            if (! empty($images)) {
                $analyzes['img_alt']['impact'] = 'high';
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('No alternative text found for these images. Alt tags are important for both SEO and accessibility. Edit your images using the media library or your favorite page builder and fill in alternative text fields.', 'wp-rankology') . '</p>';

                //Standard images & galleries
                if (! empty($images)) {
                    $desc .= '<ul class="attachments">';
                    foreach ($images as $img) {
                        $desc .= '<li class="attachment"><figure><img src="' . $img . '"/><figcaption style="word-break: break-all;">'.$img.'</figcaption></figure></li>';
                    }
                    $desc .= '</ul>';
                }

                $desc .= '<p>' . esc_html__('Note that we scan all your source code, it means, some missing alternative texts of images might be located in your header, sidebar or footer.', 'wp-rankology') . '</p>';
            }
            $desc .= '</div>';

            $analyzes['img_alt']['desc'] = $desc;
        } elseif(!empty($data['img']['images']['with_alt']) && empty($data['img']['images']['without_alt'])) {
            $analyzes['img_alt']['impact'] = 'good';
            $analyzes['img_alt']['desc'] = '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('All alternative tags are filled in. Good work!', 'wp-rankology') . '</p>';
        } elseif (empty($data['img']['images']['with_alt']) && empty($data['img']['images']['without_alt'])) {
            $analyzes['img_alt']['impact'] = 'medium';
            $analyzes['img_alt']['desc']   = '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('We could not find any image in your content. Content with media is a plus for your SEO.', 'wp-rankology') . '</p>';
        }

        return $analyzes;
    }

    /**
     * @param array   $analyzes
     * @param array   $data
     * @param WP_Post $post
     *
     * @return array
     */
    protected function analyzeNoFollowLinks($analyzes, $data, $post)
    {
        if (! empty($data['nofollow_links'])) {
            $count = count($data['nofollow_links']);

            $desc = '<p>' . sprintf(esc_html__('We found %d links with nofollow attribute in your page. Do not overuse nofollow attribute in links. Below, the list:', 'wp-rankology'), $count) . '</p>';
            $desc .= '<ul>';
            foreach ($data['nofollow_links'] as $links) {
                foreach ($links as $href => $link) {
                    $desc .= '<li><span class="dashicons dashicons-minus"></span><a href="' . $href . '" target="_blank">' . $link . '</a><span class="dashicons dashicons-redo"></span></li>';
                }
            }
            $desc .= '</ul>';
            $analyzes['nofollow_links']['impact'] = 'low';
            $analyzes['nofollow_links']['desc']   = $desc;
        } else {
            $analyzes['nofollow_links']['desc'] = '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('This page doesn\'t have any nofollow links.', 'wp-rankology') . '</p>';
        }

        return $analyzes;
    }

    /**
     * @param array   $analyzes
     * @param array   $data
     * @param WP_Post $post
     *
     * @return array
     */
    protected function analyzeOutboundLinks($analyzes, $data, $post)
    {
        $desc = '<p>' . esc_html__('Internet is built on the principle of hyperlink. It is therefore perfectly normal to make links between different websites. However, avoid making links to low quality sites, SPAM... If you are not sure about the quality of a site, add the attribute "nofollow" to your link.', 'wp-rankology') . '</p>';
        if (! empty($data['outbound_links'])) {
            $count = count($data['outbound_links']);

            $desc .= '<p>' . sprintf(esc_html__('We found %s outbound links in your page. Below, the list:', 'wp-rankology'), $count) . '</p>';
            $desc .= '<ul>';
            foreach ($data['outbound_links'] as $links) {
                foreach ($links as $href => $link) {
                    $desc .= '<li><span class="dashicons dashicons-minus"></span><a href="' . $href . '" target="_blank">' . $link . '</a><span class="dashicons dashicons-redo"></span></li>';
                }
            }
            $desc .= '</ul>';
        } else {
            $analyzes['outbound_links']['impact'] = 'medium';
            $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('This page doesn\'t have any outbound links.', 'wp-rankology') . '</p>';
        }
        $analyzes['outbound_links']['desc'] = $desc;

        return $analyzes;
    }

    /**
     * @param array   $analyzes
     * @param array   $data
     * @param WP_Post $post
     *
     * @return array
     */
    protected function analyzeInternalLinks($analyzes, $data, $post)
    {
        $desc = '<p>' . esc_html__('Internal links are important for SEO and user experience. Always try to link your content together, with quality link anchors.', 'wp-rankology') . '</p>';
        if (! empty($data['internal_links']['count'])) {
            $count = $data['internal_links']['count'];

            $desc .= '<p>' . sprintf(esc_html__('We found %s internal links to this page.', 'wp-rankology'), $count) . '</p>';

            if (! empty($data['internal_links']['links'])) {
                $desc .= '<ul>';
                foreach ($data['internal_links']['links'] as $id => $permalink) {
                    foreach ($permalink as $href => $link) {
                        $desc .= '<li><span class="dashicons dashicons-minus"></span><a href="' . $href . '" target="_blank">' . $link . '</a>
                        <a class="nounderline" href="' . get_edit_post_link($id) . '" title="' . sprintf(esc_html__('edit %s', 'wp-rankology'), esc_html(get_the_title($id))) . '"><span class="dashicons dashicons-edit-large"></span></a></li>';
                    }
                }
                $desc .= '</ul>';
            }
        } else {
            $analyzes['internal_links']['impact'] = 'medium';
            $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('This page doesn\'t have any internal links from other content. Links from archive pages are not considered internal links due to lack of context.', 'wp-rankology') . '</p>';
        }
        $analyzes['internal_links']['desc'] = $desc;

        return $analyzes;
    }

    /**
     * @param array   $analyzes
     * @param array   $data
     * @param WP_Post $post
     *
     * @return array
     */
    protected function analyzeCanonical($analyzes, $data, $post)
    {
        $desc = '<p>' . esc_html__('A canonical URL is required by search engines to handle duplicate content.', 'wp-rankology') . '</p>';
        if (! empty($data['all_canonical'])) {
            $count = count($data['all_canonical']);

            $desc .= '<p>' . sprintf(_n('We found %s canonical URL in your source code. Below, the list:', 'We found %s canonical URLs in your source code. Below, the list:', $count, 'wp-rankology'), number_format_i18n($count)) . '</p>';

            $desc .= '<ul>';
            foreach ($data['all_canonical'] as $link) {
                $desc .= '<li><span class="dashicons dashicons-minus"></span><a href="' . $link . '" target="_blank">' . $link . '</a><span class="dashicons dashicons-redo"></span></li>';
            }
            $desc .= '</ul>';

            if ($count > 1) {
                $analyzes['all_canonical']['impact'] = 'high';
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('You must fix this. Canonical URL duplication is bad for SEO.', 'wp-rankology') . '</p>';
            }
        } else {
            if ('yes' === get_post_meta($post->ID, '_rankology_robots_index', true)) {
                $analyzes['all_canonical']['impact'] = 'good';
                $desc .= '<p><span class="dashicons dashicons-yes"></span>' . esc_html__('This page doesn\'t have any canonical URL because your post is set to <strong>noindex</strong>. This is normal.', 'wp-rankology') . '</p>';
            } else {
                $analyzes['all_canonical']['impact'] = 'high';
                $desc .= '<p><span class="dashicons dashicons-no-alt"></span>' . esc_html__('This page doesn\'t have any canonical URL.', 'wp-rankology') . '</p>';
            }
        }
        $analyzes['all_canonical']['desc'] = $desc;

        return $analyzes;
    }

    public function getAnalyzes($post)
    {
        $data                   = get_post_meta($post->ID, '_rankology_analysis_data', true);
        $analyzes               = ContentAnalysis::getData();

        //Schemas
        $analyzes = $this->analyzeSchemas($analyzes, $data, $post);

        //Old post
        $analyzes = $this->analyzeOldPost($analyzes, $data, $post);

        //Word counters
        $analyzes = $this->analyzeWordCounters($analyzes, $data, $post);

        //Keywords density
        $analyzes = $this->analyzeKeywordsDensity($analyzes, $data, $post);

        //Keywords in permalink
        $analyzes = $this->analyzeKeywordsPermalink($analyzes, $data, $post);

        //Headings
        $analyzes = $this->analyzeHeadings($analyzes, $data, $post);

        //Meta Title
        $analyzes = $this->analyzeMetaTitle($analyzes, $data, $post);

        //Meta description
        $analyzes = $this->analyzeMetaDescription($analyzes, $data, $post);

        //Social tags
        $analyzes = $this->analyzeSocialTags($analyzes, $data, $post);

        //Robots
        $analyzes = $this->analyzeRobots($analyzes, $data, $post);

        //Img alt
        $analyzes = $this->analyzeImgAlt($analyzes, $data, $post);

        //Nofollow links
        $analyzes = $this->analyzeNoFollowLinks($analyzes, $data, $post);

        //Outbound links
        $analyzes = $this->analyzeOutboundLinks($analyzes, $data, $post);

        //internal links
        $analyzes = $this->analyzeInternalLinks($analyzes, $data, $post);

        $analyzes = $this->analyzeCanonical($analyzes, $data, $post);

        return $analyzes;
    }
}
