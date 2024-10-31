<?php

namespace Rankology\Services;

if ( ! defined('ABSPATH')) {
    exit;
}

class I18nUniversalMetabox
{
    public function getTranslations() {

        return [
            'generic' => [
                'pixels' => esc_html__('pixels', 'wp-rankology'),
                'save' => esc_html__('Save', 'wp-rankology'),
                'save_settings' => __("Your settings have been saved.", "wp-rankology"),
                'yes' => __("Yes", "wp-rankology"),
                'good' => __("Good", "wp-rankology"),
                'expand' => __("Expand", "wp-rankology"),
                'close' => __("Close", "wp-rankology"),
                'title' => __("Title", "wp-rankology"),
                'twitter' => __("Twitter", "wp-rankology"),
                'maximum_limit' => __("maximum limit", "wp-rankology"),
                'choose_image' => __("Choose an image", "wp-rankology"),
                'opening_hours_morning' => __("Open in the morning?", "wp-rankology"),
                'opening_hours_afternoon' => __("Open in the afternoon?", "wp-rankology"),
                'thumbnail' => __("Thumbnail", "wp-rankology"),
                'x' => __("x", "wp-rankology"),
                'search_tag' => __("Search a tag", "wp-rankology"),
                'loading_data' => __("Loading your data", "wp-rankology")
            ],
            'services' => [
                'social_meta_tags_title' => __("Social meta tags", "wp-rankology"),
                'twitter' => [
                    'title' => __("Twitter Title", "wp-rankology"),
                    'description' => __("Twitter Description", "wp-rankology"),
                    'image' => __("Twitter Image", "wp-rankology"),
                    'missing' => __(
                        'Your %s is missing!',
                        "wp-rankology"
                    ),
                    'we_founded' => __("We found", "wp-rankology"),
                    'we_founded_2' => __("in your content.", "wp-rankology"),
                    'help_twitter_title' =>  __(
                        "You should not use more than one twitter:title in your post content to avoid conflicts when sharing on social networks. Twitter will take the last twitter:title tag from your source code. Below, the list:",
                        "wp-rankology"
                    ),
                    'help_twitter_description' => __(
                        "You should not use more than one twitter:description in your post content to avoid conflicts when sharing on social networks. Twitter will take the last twitter:description tag from your source code. Below, the list:",
                        "wp-rankology"
                    ),
                    'we_founded_tag' => __("We found a", "wp-rankology"),
                    'we_founded_tag_2' => __("tag in your source code.", "wp-rankology"),
                    'tag_empty' => __(
                        'Your %s tag is empty!',
                        "wp-rankology"
                    ),

                ],
                'open_graph' => [
                    'title' => __("Open Graph","wp-rankology"),
                    'description' => __("Description", "wp-rankology"),
                    'image' => __("Image", "wp-rankology"),
                    'url' => __("URL", "wp-rankology"),
                    'site_name' => __("Site Name", "wp-rankology"),
                    'missing' => __(
                        'Your Open Graph %s is missing!',
                        "wp-rankology"
                    ),
                    'we_founded' => __("We found", "wp-rankology"),
                    'we_founded_2' => __("in your content.", "wp-rankology"),
                    'help_og_title' => __(
                        "You should not use more than one og:title in your post content to avoid conflicts when sharing on social networks. Facebook will take the last og:title tag from your source code. Below, the list:",
                        "wp-rankology"
                    ),
                    'help_og_description' => __(
                        "You should not use more than one og:description in your post content to avoid conflicts when sharing on social networks. Facebook will take the last og:description tag from your source code. Below, the list:",
                        "wp-rankology"
                    ),
                    'help_og_url' => __(
                        "You should not use more than one og:url in your post content to avoid conflicts when sharing on social networks. Facebook will take the last og:url tag from your source code. Below, the list:",
                        "wp-rankology"
                    ),
                    'help_og_site_name' => __(
                        "You should not use more than one og:site_name in your post content to avoid conflicts when sharing on social networks. Facebook will take the last og:site_name tag from your source code. Below, the list:",
                        "wp-rankology"
                    ),
                    'we_founded_tag' => __("We found an Open Graph", "wp-rankology"),
                    'we_founded_tag_2' => __("tag in your source code.", "wp-rankology"),
                    'tag_empty' => __(
                        'Your Open Graph %s tag is empty!',
                        "wp-rankology"
                    )
                ],
                'content_analysis' => [
                    'meta_title' => [
                        'title' => __("Meta title", "wp-rankology"),
                        'no_meta_title' => __(
                            "No custom title is set for this post. If the global meta title suits you, you can ignore this recommendation.",
                            "wp-rankology"
                        ),
                        'meta_title_found' => __(
                            "Target keywords were found in the Meta Title.",
                            "wp-rankology"
                        ),
                        'meta_title_found_in' => __(
                            '%s was found %s times.',
                            "wp-rankology"
                        ),
                        'empty_matches' => __(
                            "None of your target keywords were found in the Meta Title.",
                            "wp-rankology"
                        ),
                        'too_long' => __("Your custom title is too long.", "wp-rankology"),
                        'length' => __("The length of your title is correct.", "wp-rankology")

                    ],
                    'meta_description' => [
                        'title' => __("Meta description", "wp-rankology"),
                        'no_meta_description' => __(
                            "No custom meta description is set for this post. If the global meta description suits you, you can ignore this recommendation.",
                            "wp-rankology"
                        ),
                        'meta_description_found' => __(
                            "Target keywords were found in the Meta description.",
                            "wp-rankology"
                        ),
                        'meta_description_found_in' => __(
                            '%s was found %s times.',
                            "wp-rankology"
                        ),
                        'no_meta_description_found' => __(
                            "None of your target keywords were found in the Meta description.",
                            "wp-rankology"
                        ),
                        'too_long' => __(
                            "You custom meta description is too long.",
                            "wp-rankology"
                        ),
                        'length' => __(
                            "The length of your meta description is correct",
                            "wp-rankology"
                        ),
                    ],
                    'meta_robots' => [
                        'title' => __("Meta robots", "wp-rankology"),
                        'empty_meta_google' => __(
                            "is off. Google will probably display a sitelinks searchbox in search results.",
                            "wp-rankology"
                        ),
                        'empty_metas' => __(
                            "We found no meta robots on this page. It means, your page is index,follow. Search engines will index it, and follow links. ",
                            "wp-rankology"
                        ),
                        'founded_multiple_metas' => __(
                            'We found %s meta robots in your page. There is probably something wrong with your theme!',
                            "wp-rankology"
                        ),
                        'noindex_on' => __(
                            "is on! Search engines can't index this page.",
                            "wp-rankology"
                        ),
                        'noindex_off' => __(
                            "is off. Search engines will index this page.",
                            "wp-rankology"
                        ),
                        'nofollow_on' => __(
                            "is on! Search engines can't follow your links on this page.",
                            "wp-rankology"
                        ),
                        'nofollow_off' => __(
                            "is off. Search engines will follow links on this page.",
                            "wp-rankology"
                        ),
                        'noimageindex_on' => __(
                            "is on! Google will not index your images on this page (but if someone makes a direct link to one of your image in this page, it will be indexed).",
                            "wp-rankology"
                        ),
                        'noimageindex_off' => __(
                            "is off. Google will index the images on this page.",
                            "wp-rankology"
                        ),
                        'noarchive_on' => __(
                            "is on! Search engines will not cache your page.",
                            "wp-rankology"
                        ),
                        'noarchive_off' => __(
                            "is off. Search engines will probably cache your page.",
                            "wp-rankology"
                        ),
                        'nosnippet_on' => __(
                            "is on! Search engines will not display a snippet of this page in search results.",
                            "wp-rankology"
                        ),
                        'nosnippet_off' => __(
                            "is off. Search engines will display a snippet of this page in search results.",
                            "wp-rankology"
                        ),
                        'nositelinkssearchbox_on' => __(
                            "is on! Google will not display a sitelinks searchbox in search results.",
                            "wp-rankology"
                        ),
                        'nositelinkssearchbox_off' => __(
                            "is off. Google will probably display a sitelinks searchbox in search results.",
                            "wp-rankology"
                        )
                    ],
                    'outbound_links' => [
                        'title' => __("Outbound Links", "wp-rankology"),
                        'description' => __(
                            'Internet is built on the principle of hyperlink. It is therefore perfectly normal to make links between different websites. However, avoid making links to low quality sites, SPAM... If you are not sure about the quality of a site, add the attribute "nofollow" to your link.', "wp-rankology"
                        ),
                        'no_outbound_links' => __(
                            "This page doesn't have any outbound links.",
                            "wp-rankology"
                        ),
                        'outbound_links_count' => __(
                            'We found %s outbound links in your page. Below, the list:',
                            "wp-rankology"
                        ),
                    ],
                    'words_counter' => [
                        'title' => __("Words counter", "wp-rankology"),
                        'no_content' => __("No content? Add a few more paragraphs!", "wp-rankology"),
                        'description' => __(
                            "Words counter is not a direct ranking factor. But, your content must be as qualitative as possible, with relevant and unique information. To fulfill these conditions, your article requires a minimum of paragraphs, so words.",
                            "wp-rankology"
                        ),
                        'unique_words' => __("unique words found.", "wp-rankology"),
                        'good' => __(
                            "Your content is composed of more than 300 words, which is the minimum for a post.",
                            "wp-rankology"
                        ),
                        'bad' => __(
                            "Your content is too short. Add a few more paragraphs!",
                            "wp-rankology"
                        ),
                        'counter_words' => __("words found.", "wp-rankology"),
                    ],
                    'old_post' => [
                        'bad' => __("This post is a little old!", "wp-rankology"),
                        'good' => __(
                            "The last modified date of this article is less than 1 year. Cool!",
                            "wp-rankology"
                        ),
                        'description' => __(
                            "Search engines love fresh content. Update regularly your articles without entirely rewriting your content and give them a boost in search rankings. Rankology takes care of the technical part.",
                            "wp-rankology"
                        ),
                        'title' => __("Last modified date", "wp-rankology"),
                    ],
                    'headings' => [
                        'head' => __(
                            'Target keywords were found in Heading %s (H%s).',
                            "wp-rankology"
                        ),
                        'heading_hn' => __("Heading H%s", "wp-rankology"),
                        'heading' => __("Heading", "wp-rankology"),
                        'no_heading' => __(
                            'No custom title is set for this post. If the global meta title suits you, you can ignore this recommendation.',
                            "wp-rankology"
                        ),
                        'no_heading_detail' =>__(
                            'No Heading %s (H%s) found in your content. This is required for both SEO and Accessibility!',
                            "wp-rankology"
                        ),
                        'no_target_keywords_detail' => __(
                            'None of your target keywords were found in Heading %s (H%s).',
                            "wp-rankology"
                        ),
                        'match' => __(
                            '%s was found %s times.',
                            "wp-rankology"
                        ),
                        'count_h1' => __(
                            'We found %s Heading 1 (H1) in your content.',
                            "wp-rankology"
                        ),
                        'count_h1_detail' => __(
                            "You should not use more than one H1 heading in your post content. The rule is simple: only one H1 for each web page. It is better for both SEO and accessibility. Below, the list:",
                            "wp-rankology"
                        ),
                        'below_h1' => __("Below the list:", "wp-rankology"),
                        'title' => __("Headings", "wp-rankology"),
                    ],
                    'images' => [
                        'bad' => __(
                            "We could not find any image in your content. Content with media is a plus for your SEO.",
                            "wp-rankology"
                        ),
                        'good' => __(
                            "All alternative tags are filled in. Good work!",
                            "wp-rankology"
                        ),
                        'no_alternative_text' => __(
                            "No alternative text found for these images. Alt tags are important for both SEO and accessibility. Edit your images using the media library or your favorite page builder and fill in alternative text fields.",
                            "wp-rankology"
                        ),
                        'description_no_alternative_text' => __(
                            "Note that we scan all your source code, it means, some missing alternative texts of images might be located in your header, sidebar or footer.",
                            "wp-rankology"
                        ),
                        'title' => __("Alternative texts of images", "wp-rankology"),
                    ],
                    'internal_links' => [
                        'description' => __(
                            "Internal links are important for SEO and user experience. Always try to link your content together, with quality link anchors.", "wp-rankology"
                        ),
                        'no_internal_links' => __(
                            "This page doesn't have any internal links from other content. Links from archive pages are not considered internal links due to lack of context.",
                            "wp-rankology"
                        ),
                        'internal_links_count' => __(
                            'We found %s internal links in your page. Below, the list:',
                            "wp-rankology"
                        ),
                        'title' => __("Internal Links", "wp-rankology")
                    ],
                    'kws_density' => [
                        'no_match' => __(
                            "We were unable to calculate the density of your keywords. You probably haven‘t added any content or your target keywords were not find in your post content.",
                            "wp-rankology"
                        ),
                        'match' => __(
                            '%s was found %s times in your content, a keyword density of %s',
                            "wp-rankology"
                        ),
                        'description' => '',
                        'title' => __("Keywords density", "wp-rankology")
                    ],
                    'kws_permalink' => [
                        'no_apply' => __(
                            "This is your homepage. This check doesn't apply here because there is no slug.",
                            "wp-rankology"
                        ),
                        'bad' => __(
                            "You should add one of your target keyword in your permalink.",
                            "wp-rankology"
                        ),
                        'good' => __(
                            "Cool, one of your target keyword is used in your permalink.",
                            "wp-rankology"
                        ),
                        'description' => '',
                        'title' =>__("Keywords in permalink", "wp-rankology")
                    ],
                    'no_follow_links' => [
                        'founded' => __(
                            'We found %s links with nofollow attribute in your page. Do not overuse nofollow attribute in links. Below, the list:',
                            "wp-rankology"
                        ),
                        'no_founded' => __(
                            "This page doesn't have any nofollow links.",
                            "wp-rankology"
                        ),
                        'title' =>__("NoFollow Links", "wp-rankology")
                    ]

                ],
                'canonical_url' => [
                    'title' => __("Canonical URL", "wp-rankology"),
                    'head' => __(
                        "A canonical URL is required by search engines to handle duplicate content."
                    ,'wp-rankology'),
                    'no_canonical' => __(
                        "This page doesn't have any canonical URL because your post is set to <strong>noindex</strong>. This is normal.",
                        "wp-rankology"
                    ),
                    'no_canonical_no_index' => __(
                        "This page doesn't have any canonical URL.",
                        "wp-rankology"
                    ),
                    'canonicals_found' => esc_html__('We found %d canonical URL in your source code. Below, the list:', 'wp-rankology'),
                    'canonicals_found_plural' => esc_html__('We found %d canonicals URLs in your source code. Below, the list:', 'wp-rankology'),
                    'multiple_canonicals' => __("You must fix this. Canonical URL duplication is bad for SEO.", "wp-rankology"),
                    'duplicated' => __("duplicated schema - x", "wp-rankology"),
                ],
                'schemas' => [
                    'title' => __("Structured Data Types (schemas)", "wp-rankology"),
                    'no_schema' => __("No schemas found in the source code of this page.", "wp-rankology"),
                    'head' => __("We found these schemas in the source code of this page:", "wp-rankology"),
                    'duplicated' => __("duplicated schema - x", "wp-rankology"),

                ]
            ],
            'constants' => [
                'tabs' => [
                    'title_description_meta' => __("Header Metas", "wp-rankology"),
                    'content_analysis' => __("Content Analysis", "wp-rankology"),
                    'schemas' => __("Schemas", "wp-rankology")
                ],
                'sub_tabs' => [
                    'title_settings' => __("Title settings", "wp-rankology"),
                    'social' => __("Social", "wp-rankology"),
                    'advanced' => __("Advanced", "wp-rankology"),
                    'redirection' => __("Redirection", "wp-rankology"),
                    'google_news' => __("Google News", "wp-rankology"),
                    'video_sitemap' => __("Video Sitemap", "wp-rankology"),
                    'overview' => __("Overview", "wp-rankology"),
                    'inspect_url' => __("Inspect with Google", "wp-rankology"),
                    'internal_linking' => __("Internal Linking", "wp-rankology"),
                    'schema_manual' => __("Manual", "wp-rankology"),
                ]
            ],
            'seo_bar' => [
                'title' => __("SEO","wp-rankology"),
            ],
            'forms' => [
                'maximum_limit' => esc_html__('maximum limit', 'wp-rankology'),
                'maximum_recommended_limit' => esc_html__('maximum recommended limit', 'wp-rankology'),
                'meta_title_description' => [
                    'title' => esc_html__('Title', 'wp-rankology'),
                    'tooltip_title' => esc_html__('Meta Title', 'wp-rankology'),
                    'tooltip_description' => __("Titles are critical to give users a quick insight into the content of a result and why it’s relevant to their query. It's often the primary piece of information used to decide which result to click on, so it's important to use high-quality titles on your web pages.", 'wp-rankology'),
                    'placeholder_title' => esc_html__('Enter your title', 'wp-rankology'),
                    'meta_description' => esc_html__('Meta description', 'wp-rankology'),
                    'tooltip_description_1' => __( "A meta description tag should generally inform and interest users with a short, relevant summary of what a particular page is about.", 'wp-rankology'),
                    'tooltip_description_2' => __("They are like a pitch that convince the user that the page is exactly what they're looking for.", 'wp-rankology'),
                    'tooltip_description_3' => __("There's no limit on how long a meta description can be, but the search result snippets are truncated as needed, typically to fit the device width.", 'wp-rankology'),
                    'placeholder_description' => esc_html__('Enter your description', 'wp-rankology'),
                    'generate_ai' => esc_html__('Generate meta with AI', 'wp-rankology')
                ],
                'repeater_how_to' => [
                    'title_step' => __(
                        "The title of the step (required)",
                        "wp-rankology"
                    ),
                    'description_step' => __(
                        "The text of your step (required)",
                        "wp-rankology"
                    ),
                    'remove_step' => __("Remove step", "wp-rankology"),
                    'add_step' => __("Add step", "wp-rankology")
                ],
                'repeater_negative_notes_review' => [
                    'title' => __(
                        "Your negative statement (required)",
                        "wp-rankology"
                    ),
                    'remove' => __("Remove note", "wp-rankology"),
                    'add' => __("Add a statement", "wp-rankology"),
                ],
                'repeater_positive_notes_review' => [
                    'title' => __(
                        "Your positive statement (required)",
                        "wp-rankology"
                    ),
                    'remove' => __("Remove note", "wp-rankology"),
                    'add' => __("Add a statement", "wp-rankology"),
                ],
            ],
            'google_preview' => [
                'title'  => esc_html__('Google Preview', 'wp-rankology'),
                'tooltip_title' => esc_html__('Snippet Preview', 'wp-rankology'),
                'tooltip_description_1' => esc_html__('The Google preview is a simulation.', 'wp-rankology'),
                'tooltip_description_2' => esc_html__('There is no reliable preview because it depends on the screen resolution, the device used, the expression sought, and Google.', 'wp-rankology'),
                'tooltip_description_3' => esc_html__('There is not one snippet for one URL but several.', 'wp-rankology'),
                'tooltip_description_4' => esc_html__('All the data in this overview comes directly from your source code.', 'wp-rankology'),
                'tooltip_description_5' => esc_html__('This is what the crawlers will see.', 'wp-rankology'),
                'description' => __(
                    "This is a preview of how your page will appear in Google search results. To see the Google Preview, you must publish your post. Please keep in mind that Google may choose to include an image from your article if available.",
                    "wp-rankology"
                ),
                'mobile_title' => __("Mobile Preview", "wp-rankology")
            ],
            'components' => [
                'repeated_faq' => [
                    'empty_question' => __(
                        "Empty Question",
                        "wp-rankology"
                    ),
                    'empty_answer' => __(
                        "Empty Answer",
                        "wp-rankology"
                    ),
                    'question' => __(
                        "Question (required)",
                        "wp-rankology"
                    ),
                    'answer' => __(
                        "Answer (required)",
                        "wp-rankology"
                    ),
                    'remove' => __("Remove question", "wp-rankology"),
                    'add' => __("Add question", "wp-rankology")
                ],
            ],
            'layouts' => [
                'meta_robot' => [
                    'title' => __(
                        "You cannot uncheck a parameter? This is normal, and it's most likely defined in the <a href='%s'>global settings of the plugin.</a>",
                        "wp-rankology"
                    ),
                    'robots_index_description' => __(
                        "Do not display this page in search engine results / XML - HTML sitemaps",
                        "wp-rankology"
                    ),
                    'robots_index_tooltip_title' => esc_html__('"noindex" robots meta tag', 'wp-rankology'),
                    'robots_index_tooltip_description_1' => __(
                        'By checking this option, you will add a meta robots tag with the value "noindex".',
                        'wp-rankology'
                    ),
                    'robots_index_tooltip_description_2' => __(
                        'Search engines will not index this URL in the search results.',
                        'wp-rankology'
                    ),
                    'robots_follow_description' => __("Do not follow links for this page", "wp-rankology"),
                    'robots_follow_tooltip_title' => esc_html__('"nofollow" robots meta tag', 'wp-rankology'),
                    'robots_follow_tooltip_description_1' => __(
                        'By checking this option, you will add a meta robots tag with the value "nofollow".',
                        'wp-rankology'
                    ),
                    'robots_follow_tooltip_description_2' => __(
                        'Search engines will not follow links from this URL.',
                        'wp-rankology'
                    ),
                    'robots_archive_description' => __(
                        "Do not display a 'Cached' link in the Google search results",
                        "wp-rankology"
                    ),
                    'robots_archive_tooltip_title' => esc_html__('"noarchive" robots meta tag', 'wp-rankology'),
                    'robots_archive_tooltip_description_1' => __(
                        'By checking this option, you will add a meta robots tag with the value "noarchive".',
                        'wp-rankology'
                    ),
                    'robots_snippet_description' =>__(
                        "Do not display a description in search results for this page",
                        "wp-rankology"
                    ),
                    'robots_snippet_tooltip_title' => esc_html__('"nosnippet" robots meta tag', 'wp-rankology'),
                    'robots_snippet_tooltip_description_1' => __(
                        'By checking this option, you will add a meta robots tag with the value "nosnippet".',
                        'wp-rankology'
                    ),
                    'robots_imageindex_description' => __("Do not index images for this page", "wp-rankology"),
                    'robots_imageindex_tooltip_title' => esc_html__('"noimageindex" robots meta tag', 'wp-rankology'),
                    'robots_imageindex_tooltip_description_1' => __(
                        'By checking this option, you will add a meta robots tag with the value "noimageindex".',
                        'wp-rankology'
                    ),
                    'robots_imageindex_tooltip_description_2' => __(
                        'Note that your images can always be indexed if they are linked from other pages.',
                        'wp-rankology'
                    )
                ],
                'inspect_url' => [
                    'description' => __(
                        "Inspect the current post URL with Google Search Console and get informations about your indexing, crawling, rich snippets and more.",
                        "wp-rankology"
                    ),
                    'verdict_unspecified' => [
                        'title' => __("Unknown verdict", "wp-rankology"),
                        'description' =>__(
                            "The URL has been indexed, can appear in Google Search results, and no problems were found with any enhancements found in the page (structured data, linked AMP pages, and so on).",
                            "wp-rankology"
                        )
                    ],
                    'pass' => [
                        'title' => __("URL is on Google", "wp-rankology"),
                        'description' => __(
                            "The URL has been indexed, can appear in Google Search results, and no problems were found with any enhancements found in the page (structured data, linked AMP pages, and so on).",
                            "wp-rankology"
                        )
                    ],
                    'partial' => [
                        'title' => __("URL is on Google, but has issues", "wp-rankology"),
                        'description' => __(
                            "The URL has been indexed and can appear in Google Search results, but there are some problems that might prevent it from appearing with the enhancements that you applied to the page. This might mean a problem with an associated AMP page, or malformed structured data for a rich result (such as a recipe or job posting) on the page.",
                            "wp-rankology"
                        )
                    ],
                    'fail' => [
                        'title' => __(
                            "URL is not on Google: Indexing errors",
                            "wp-rankology"
                        ),
                        'description' => __(
                            "There was at least one critical error that prevented the URL from being indexed, and it cannot appear in Google Search until those issues are fixed.",
                            "wp-rankology"
                        )
                    ],
                    'neutral' => [
                        'title' => __("URL is not on Google", "wp-rankology"),
                        'description' => __(
                            "This URL won‘t appear in Google Search results, but we think that was your intention. Common reasons include that the page is password-protected or robots.txt protected, or blocked by a noindex directive.",
                            "wp-rankology"
                        )
                    ],
                    'indexing_state_unspecified' => __("Unknown indexing status.", "wp-rankology"),
                    'indexing_allowed' => __("Indexing allowed.", "wp-rankology"),
                    'blocked_by_meta_tag' => __(
                        "Indexing not allowed, 'noindex' detected in 'robots' meta tag.",
                        "wp-rankology"
                    ),
                    'blocked_by_http_header' => __(
                        "Indexing not allowed, 'noindex' detected in 'X-Robots-Tag' http header.",
                        "wp-rankology"
                    ),
                    'blocked_by_robots_txt' => __(
                        "Indexing not allowed, blocked to Googlebot with a robots.txt file.",
                        "wp-rankology"
                    ),
                    'page_fetch_state_unspecified' => __("Unknown fetch state.", "wp-rankology"),
                    'successful' => __("Successful fetch.", "wp-rankology"),
                    'soft_404' => __("Soft 404.", "wp-rankology"),
                    'blocked_robots_txt' => __("Blocked by robots.txt.", "wp-rankology"),
                    'not_found' => __("Not found (404).", "wp-rankology"),
                    'access_denied' => __(
                        "Blocked due to unauthorized request (401).",
                        "wp-rankology"
                    ),
                    'server_error' => __("Server error (5xx).", "wp-rankology"),
                    'redirect_error' => __("Redirection error.", "wp-rankology"),
                    'access_forbidden' => __("Blocked due to access forbidden (403).", "wp-rankology"),
                    'blocked_4xx' => __(
                        "Blocked due to other 4xx issue (not 403, 404).",
                        "wp-rankology"
                    ),
                    'internal_crawl_error' => __("Internal error.", "wp-rankology"),
                    'invalid_url' => __("Invalid URL.", "wp-rankology"),
                    'crawling_user_agent_unspecified' => __("Unknown user agent.", "wp-rankology"),
                    'desktop' => __("Googlebot desktop", "wp-rankology"),
                    'mobile' => __("Googlebot smartphone", "wp-rankology"),
                    'robots_txt_state_unspecified' => __(
                        "Unknown robots.txt state, typically because the page wasn‘t fetched or found, or because robots.txt itself couldn‘t be reached.",
                        "wp-rankology"
                    ),
                    'disallowed' => __("Crawl blocked by robots.txt.", "wp-rankology"),
                    'mobile_verdict_unspecified_title' => __("No data available", "wp-rankology"),
                    'mobile_verdict_unspecified_description' => __(
                        "For some reason we couldn't retrieve the page or test its mobile-friendliness. Please wait a bit and try again.",
                        "wp-rankology"
                    ),
                    'mobile_pass_title' => __("Page is mobile friendly", "wp-rankology"),
                    'mobile_pass_description' => __(
                        "The page should probably work well on a mobile device.",
                        "wp-rankology"
                    ),
                    'mobile_fail_title' => __("Page is not mobile friendly", "wp-rankology"),
                    'mobile_fail_description' => __(
                        "The page won‘t work well on a mobile device because of a few issues.",
                        "wp-rankology"
                    ),
                    'rich_snippets_verdict_unspecified'=> __("No data available", "wp-rankology"),
                    'rich_snippets_pass' => __("Your Rich Snippets are valid", "wp-rankology"),
                    'rich_snippets_fail' => __("Your Rich Snippets are not valid", "wp-rankology"),
                    'discovery' => __("Discovery", "wp-rankology"),
                    'discovery_sitemap' => __("Sitemaps", "wp-rankology"),
                    'discovery_referring_urls' => __("Referring page", "wp-rankology"),
                    'crawl' => __("Crawl", "wp-rankology"),
                    'crawl_last_crawl_time' => __("Last crawl", "wp-rankology"),
                    'crawl_crawled_as' => __("Crawled as", "wp-rankology"),
                    'crawl_allowed' => __("Crawl allowed?", "wp-rankology"),
                    'crawl_page_fetch' => __("Page fetch", "wp-rankology"),
                    'crawl_indexing' => __("Indexing allowed?", "wp-rankology"),
                    'indexing_title' => __("Indexing", "wp-rankology"),
                    'indexing_user_canonical' => __("User-declared canonical", "wp-rankology"),
                    'indexing_google_canonical' => __("Google-selected canonical", "wp-rankology"),
                    'enhancements_title' => __("Enhancements", "wp-rankology"),
                    'enhancements_mobile' => __("Mobile Usability", "wp-rankology"),
                    'enhancements_rich_snippets' => __("Rich Snippets detected", "wp-rankology"),
                    'btn_inspect_url' => __("Inspect URL with Google", "wp-rankology"),
                    'notice_empty_api_key' => __(
                        "No data found, click Inspect URL button above.",
                        "wp-rankology"
                    ),
                    'btn_full_report' => __("View Full Report", "wp-rankology")
                ],
                'video_sitemap' => [
                    'btn_remove_video' => __(
                        "Remove video",
                        "wp-rankology"
                    ),
                    'btn_add_video' => __("Add video", "wp-rankology")
                ],
                'internal_linking' => [
                    'description_1' => __(
                        "Internal links are important for SEO and user experience. Always try to link your content together, with quality link anchors.",
                        "wp-rankology"
                    ),
                    'description_2' => __(
                        "Here is a list of articles related to your content, sorted by relevance, that you should link to.",
                        "wp-rankology"
                    ),
                    'no_suggestions' =>  __("No suggestion of internal links.", "wp-rankology"),
                    'copied' => __(
                        "Link copied in the clipboard",
                        "wp-rankology"
                    ),
                    'copy_link' => __("Copy %s link", "wp-rankology"),
                    'open_link' => __(
                        "Open this link in a new window",
                        "wp-rankology"
                    ),
                    'edit_link' => __(
                        "Edit this link in a new window",
                        "wp-rankology"
                    ),
                    'edit_link_aria' => __("Edit %s link", "wp-rankology")
                ],
                'content_analysis' => [
                    'description' => __(
                        "Enter keywords for analysis and you can also use google suggestions to write optimized content.",
                        "wp-rankology"
                    ),
                    'description_2' => '',
                    'title_severity' => esc_html__('Degree of severity: %s', 'wp-rankology'),
                    'target_keywords' => __("Target keywords", "wp-rankology"),
                    'target_keywords_tooltip_description' => __(
                        "Separate target keywords with commas. Do not use spaces after the commas, unless you want to include them",
                        "wp-rankology"
                    ),
                    'target_keywords_multiple_usage' => __(
                        'You should avoid using multiple times the same keyword for different pages. Try to consolidate your content into one single page.',
                        "wp-rankology"
                    ),
                    'target_keywords_placeholder' => __(
                        "Enter your target keywords",
                        "wp-rankology"
                    ),
                    'btn_refresh_analysis' => __("Refresh analysis", "wp-rankology"),
                    'help_target_keywords' => __(
                        "To get the most accurate analysis, save your post first. We analyze all of your source code as a search engine would.",
                        "wp-rankology"
                    ),
                    'google_suggestions' => __("Google suggestions", "wp-rankology"),
                    'google_suggestions_tooltip_description' => __(
                        "Enter a keyword, or a phrase, to find the top 10 Google suggestions instantly. This is useful if you want to work with the long tail technique.",
                        "wp-rankology"
                    ),
                    'google_suggestions_placeholder' => __(
                        "Get suggestions from Google",
                        "wp-rankology"
                    ),
                    'get_suggestions' => __("Get suggestions!", "wp-rankology"),
                    'should_be_improved' =>  __("Overall score is better, Could Be Enhanced", "wp-rankology"),
                    'keyword_singular' => __("The keyword:", "wp-rankology"),
                    'keyword_plural' => __("These keywords:", "wp-rankology"),
                    'already_used_singular' => __("is already used %d time", "wp-rankology"),
                    'already_used_plural' => __("is already used %d times", "wp-rankology"),
                ],
                'schemas_manual' => [
                    'description' => esc_html__('To increase the likelihood of obtaining a rich snippet in Google search results, it is advisable to provide as many properties as you can.', 'wp-rankology'),
                    'remove' => __("Delete schema", "wp-rankology"),
                    'add' => __("Add a schema", "wp-rankology"),
                ],
                'social' => [
                    'title' => __(
                        "LinkedIn, Instagram, WhatsApp and Pinterest use the same social metadata as Facebook. Twitter does the same if no Twitter cards tags are defined below.",
                        "wp-rankology"
                    ),
                    'facebook_title' => __(
                        "Ask Facebook to update its cache",
                        "wp-rankology"
                    ),
                    'twitter_title' => __(
                        "Preview your Twitter card using the official validator",
                        "wp-rankology"
                    ),
                ],
                'social_preview' => [
                    "facebook" => [
                        "title" => __("Facebook Preview", "wp-rankology"),
                        "description" => __(
                            "This is what your post will look like in Facebook. You have to publish your post to get the Facebook Preview.",
                            "wp-rankology"
                        ),
                        "ratio" => __("Your image ratio is:", "wp-rankology"),
                        "ratio_info" => __("The closer to 1.91 the better.", "wp-rankology"),
                        'img_filesize' => esc_html__('Your filesize is: ', 'wp-rankology'),
                        'filesize_is_too_large' => esc_html__('This is superior to 300KB. WhatsApp will not use your image.', 'wp-rankology'),
                        "min_size" => __(
                            "Minimun size for Facebook is <strong>200x200px</strong>. Please choose another image.",
                            "wp-rankology"
                        ),
                        "file_support" =>__(
                            "File type not supported by Facebook. Please choose another image.",
                            "wp-rankology"
                        ),
                        "error_image" => __(
                            "File error. Please choose another image.",
                            "wp-rankology"
                        ),
                        "choose_image" =>__("Please choose an image", "wp-rankology"),
                    ],
                    "twitter" => [
                        "title" => __("Twitter Preview", "wp-rankology"),
                        "description" => __(
                            "This is what your post will look like in Twitter. You have to publish your post to get the Twitter Preview.",
                            "wp-rankology"
                        ),
                        "ratio" => __("Your image ratio is:", "wp-rankology"),
                        "ratio_info" =>__(
                            "The closer to 1 the better (with large card, 2 is better).",
                            "wp-rankology"
                        ),
                        "min_size" => __(
                            "Minimun size for Twitter is <strong>144x144px</strong>. Please choose another image.",
                            "wp-rankology"
                        ),
                        "file_support" => __(
                            "File type not supported by Twitter. Please choose another image.",
                            "wp-rankology"
                        ),
                        "error_image" => __(
                            "File error. Please choose another image.",
                            "wp-rankology"
                        ),
                        "choose_image" =>__("Please choose an image", "wp-rankology")

                    ]
                ],
                "advanced" => [
                    'title' => __("Meta robots settings", "wp-rankology"),
                    'tooltip_canonical' => __(
                        "Canonical URL",
                        "wp-rankology"
                    ),
                    'tooltip_canonical_description' => __(
                        "A canonical URL is the URL of the page that Google thinks is most representative from a set of duplicate pages on your site.",
                        "wp-rankology"
                    ),
                    'tooltip_canonical_description_2' => __(
                        "For example, if you have URLs for the same page (for example: example.com?dress=1234 and example.com/dresses/1234), Google chooses one as canonical.",
                        "wp-rankology"
                    ),
                    'tooltip_canonical_description_3' => __(
                        "Note that the pages do not need to be absolutely identical; minor changes in sorting or filtering of list pages do not make the page unique (for example, sorting by price or filtering by item color). The canonical can be in a different domain than a duplicate.",
                        "wp-rankology"
                    )
                ]
            ]
        ];

    }
}

