<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

function rankology_social_knowledge_type_callback()
{
    $options = get_option('rankology_social_option_name');

    $selected = isset($options['rankology_social_knowledge_type']) ? $options['rankology_social_knowledge_type'] : null; ?>

<select id="rankology_social_knowledge_type" name="rankology_social_option_name[rankology_social_knowledge_type]">
    <option <?php if ('none' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="none"><?php esc_html_e('None (will disable this feature)', 'wp-rankology'); ?>
    </option>
    <option <?php if ('Person' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="Person"><?php esc_html_e('Person', 'wp-rankology'); ?>
    </option>
    <option <?php if ('Organization' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="Organization"><?php esc_html_e('Organization', 'wp-rankology'); ?>
    </option>
</select>

<?php if (isset($options['rankology_social_knowledge_type'])) {
        esc_attr($options['rankology_social_knowledge_type']);
    }
}

function rankology_social_knowledge_name_callback()
{
    $options = get_option('rankology_social_option_name');
    $check   = isset($options['rankology_social_knowledge_name']) ? $options['rankology_social_knowledge_name'] : null;

    printf(
        '<input type="text" name="rankology_social_option_name[rankology_social_knowledge_name]" placeholder="' . esc_html__('e.g. My Local Business', 'wp-rankology') . '" aria-label="' . esc_html__('Person name/organization', 'wp-rankology') . '" value="%s"/>',
        esc_html($check)
    );
}

function rankology_social_knowledge_img_callback()
{
    $options = get_option('rankology_social_option_name');

    $options_set = isset($options['rankology_social_knowledge_img']) ? esc_attr($options['rankology_social_knowledge_img']) : null;

    $check = isset($options['rankology_social_knowledge_img']); ?>

<input id="rankology_social_knowledge_img_meta" type="text"
    value="<?php echo rankology_common_esc_str($options_set); ?>"
    name="rankology_social_option_name[rankology_social_knowledge_img]"
    aria-label="<?php esc_html_e('Your photo/organization logo', 'wp-rankology'); ?>"
    placeholder="<?php esc_html_e('Select your logo', 'wp-rankology'); ?>" />

<input id="rankology_social_knowledge_img_upload" class="btn btnSecondary" type="button" value="<?php esc_html_e('Upload an Image', 'wp-rankology'); ?>" />
<input id="rankology_social_knowledge_img_remove" class="btn btnLink is-deletable" type="button" value="<?php esc_html_e('Remove', 'wp-rankology'); ?>" />

<p class="description"><?php esc_html_e('JPG, PNG, WebP and GIF allowed. The image must be 150x150px, at minimum.', 'wp-rankology'); ?></p>

<div id="rankology_social_knowledge_img_placeholder_upload" class="rankology-img-placeholder" data_caption="<?php esc_html_e('Click to select an image', 'wp-rankology'); ?>">
    <img id="rankology_social_knowledge_img_placeholder_src" src="<?php echo esc_attr(rankology_get_service('SocialOption')->getSocialKnowledgeImage()); ?>" />
</div>

    <?php if (isset($options['rankology_social_knowledge_img'])) {
        esc_attr($options['rankology_social_knowledge_img']);
    }
}

function rankology_social_knowledge_phone_callback()
{
    $options = get_option('rankology_social_option_name');
    $check   = isset($options['rankology_social_knowledge_phone']) ? $options['rankology_social_knowledge_phone'] : null;

    printf(
        '<input type="text" name="rankology_social_option_name[rankology_social_knowledge_phone]" placeholder="' . esc_html__('e.g. +44123456789 (internationalized version required)', 'wp-rankology') . '" aria-label="' . esc_html__('Organization\'s phone number (only for Organizations)', 'wp-rankology') . '" value="%s"/>',
        esc_html($check)
    );
}

function rankology_social_knowledge_contact_type_callback()
{
    $options = get_option('rankology_social_option_name');

    $selected = isset($options['rankology_social_knowledge_contact_type']) ? $options['rankology_social_knowledge_contact_type'] : null; ?>

<select id="rankology_social_knowledge_contact_type"
    name="rankology_social_option_name[rankology_social_knowledge_contact_type]">
    <option <?php if ('customer support' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="customer support"><?php esc_html_e('Customer support', 'wp-rankology'); ?>
    </option>
    <option <?php if ('technical support' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="technical support"><?php esc_html_e('Technical support', 'wp-rankology'); ?>
    </option>
    <option <?php if ('billing support' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="billing support"><?php esc_html_e('Billing support', 'wp-rankology'); ?>
    </option>
    <option <?php if ('bill payment' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="bill payment"><?php esc_html_e('Bill payment', 'wp-rankology'); ?>
    </option>
    <option <?php if ('sales' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="sales"><?php esc_html_e('Sales', 'wp-rankology'); ?>
    </option>
    <option <?php if ('credit card support' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="credit card support"><?php esc_html_e('Credit card support', 'wp-rankology'); ?>
    </option>
    <option <?php if ('emergency' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="emergency"><?php esc_html_e('Emergency', 'wp-rankology'); ?>
    </option>
    <option <?php if ('baggage tracking' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="baggage tracking"><?php esc_html_e('Baggage tracking', 'wp-rankology'); ?>
    </option>
    <option <?php if ('roadside assistance' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="roadside assistance"><?php esc_html_e('Roadside assistance', 'wp-rankology'); ?>
    </option>
    <option <?php if ('package tracking' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="package tracking"><?php esc_html_e('Package tracking', 'wp-rankology'); ?>
    </option>
</select>

<?php if (isset($options['rankology_social_knowledge_contact_type'])) {
        esc_attr($options['rankology_social_knowledge_contact_type']);
    }
}

function rankology_social_knowledge_contact_option_callback()
{
    $options = get_option('rankology_social_option_name');

    $selected = isset($options['rankology_social_knowledge_contact_option']) ? $options['rankology_social_knowledge_contact_option'] : null; ?>

<select id="rankology_social_knowledge_contact_option"
    name="rankology_social_option_name[rankology_social_knowledge_contact_option]">
    <option <?php if ('None' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="None"><?php esc_html_e('None', 'wp-rankology'); ?>
    </option>
    <option <?php if ('TollFree' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="TollFree"><?php esc_html_e('Toll Free', 'wp-rankology'); ?>
    </option>
    <option <?php if ('HearingImpairedSupported' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="HearingImpairedSupported"><?php esc_html_e('Hearing impaired supported', 'wp-rankology'); ?>
    </option>
</select>

<?php if (isset($options['rankology_social_knowledge_contact_option'])) {
        esc_attr($options['rankology_social_knowledge_contact_option']);
    }
}

function rankology_social_accounts_facebook_callback()
{
    $options = get_option('rankology_social_option_name');
    $check   = isset($options['rankology_social_accounts_facebook']) ? $options['rankology_social_accounts_facebook'] : null;

    printf(
        '<input type="text" name="rankology_social_option_name[rankology_social_accounts_facebook]" placeholder="' . esc_html__('e.g. https://facebook.com/my-page-url', 'wp-rankology') . '" aria-label="' . esc_html__('Facebook Page URL', 'wp-rankology') . '" value="%s"/>',
        esc_html($check)
    );
}

function rankology_social_accounts_twitter_callback()
{
    $options = get_option('rankology_social_option_name');
    $check   = isset($options['rankology_social_accounts_twitter']) ? $options['rankology_social_accounts_twitter'] : null;

    printf(
        '<input type="text" name="rankology_social_option_name[rankology_social_accounts_twitter]" placeholder="' . esc_html__('e.g. @my_twitter_account', 'wp-rankology') . '" aria-label="' . esc_html__('Twitter Page URL', 'wp-rankology') . '" value="%s"/>',
        esc_html($check)
    );
}

function rankology_social_accounts_pinterest_callback()
{
    $options = get_option('rankology_social_option_name');
    $check   = isset($options['rankology_social_accounts_pinterest']) ? $options['rankology_social_accounts_pinterest'] : null;

    printf(
        '<input type="text" name="rankology_social_option_name[rankology_social_accounts_pinterest]" placeholder="' . esc_html__('e.g. https://pinterest.com/my-page-url/', 'wp-rankology') . '" aria-label="' . esc_html__('Pinterest URL', 'wp-rankology') . '" value="%s"/>',
        esc_html($check)
    );
}

function rankology_social_accounts_instagram_callback()
{
    $options = get_option('rankology_social_option_name');
    $check   = isset($options['rankology_social_accounts_instagram']) ? $options['rankology_social_accounts_instagram'] : null;

    printf(
        '<input type="text" name="rankology_social_option_name[rankology_social_accounts_instagram]" placeholder="' . esc_html__('e.g. https://www.instagram.com/my-page-url/', 'wp-rankology') . '" aria-label="' . esc_html__('Instagram URL', 'wp-rankology') . '" value="%s"/>',
        esc_html($check)
    );
}

function rankology_social_accounts_youtube_callback()
{
    $options = get_option('rankology_social_option_name');
    $check   = isset($options['rankology_social_accounts_youtube']) ? $options['rankology_social_accounts_youtube'] : null;

    printf(
        '<input type="text" name="rankology_social_option_name[rankology_social_accounts_youtube]" placeholder="' . esc_html__('e.g. https://www.youtube.com/my-channel-url', 'wp-rankology') . '" aria-label="' . esc_html__('YouTube URL', 'wp-rankology') . '" value="%s"/>',
        esc_html($check)
    );
}

function rankology_social_accounts_linkedin_callback()
{
    $options = get_option('rankology_social_option_name');
    $check   = isset($options['rankology_social_accounts_linkedin']) ? $options['rankology_social_accounts_linkedin'] : null;

    printf(
        '<input type="text" name="rankology_social_option_name[rankology_social_accounts_linkedin]" placeholder="' . esc_html__('e.g. http://linkedin.com/company/my-company-url/', 'wp-rankology') . '" aria-label="' . esc_html__('LinkedIn URL', 'wp-rankology') . '" value="%s"/>',
        esc_html($check)
    );
}

function rankology_social_accounts_extra_callback() {
    $options = get_option('rankology_social_option_name');
    $check   = isset($options['rankology_social_accounts_extra']) ? esc_attr($options['rankology_social_accounts_extra']) : null;

    printf(
'<textarea id="rankology_social_accounts_extra" name="rankology_social_option_name[rankology_social_accounts_extra]" rows="8" placeholder="' . esc_html__('Enter 1 URL per line (e.g. https://example.com/my-profile)', 'wp-rankology') . '" aria-label="' . esc_html__('Enter 1 URL per line (e.g. https://example.com/my-profile)', 'wp-rankology') . '">%s</textarea>',
esc_html($check)); ?>

<p class="rankology-help description"><?php esc_html_e('Enter 1 URL per line (e.g. https://example.com/my-profile)', 'wp-rankology'); ?></p>

<?php
}

function rankology_social_facebook_og_callback()
{
    $options = get_option('rankology_social_option_name');

    $check = isset($options['rankology_social_facebook_og']); ?>

<label for="rankology_social_facebook_og">
    <input id="rankology_social_facebook_og" name="rankology_social_option_name[rankology_social_facebook_og]"
        type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>

    <?php esc_html_e('Enable OG data', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_social_facebook_og'])) {
        esc_attr($options['rankology_social_facebook_og']);
    }
}

function rankology_social_facebook_img_callback()
{
    $options = get_option('rankology_social_option_name');

    $options_set = isset($options['rankology_social_facebook_img']) ? esc_attr($options['rankology_social_facebook_img']) : null;
    $options_set_attachment_id = isset($options['rankology_social_facebook_img_attachment_id']) ? esc_attr($options['rankology_social_facebook_img_attachment_id']) : null;
    $options_set_width = isset($options['rankology_social_facebook_img_width']) ? esc_attr($options['rankology_social_facebook_img_width']) : null;
    $options_set_height = isset($options['rankology_social_facebook_img_height']) ? esc_attr($options['rankology_social_facebook_img_height']) : null;



    ?>

<input id="rankology_social_fb_img_meta" type="text"
    value="<?php echo rankology_common_esc_str($options_set); ?>"
    name="rankology_social_option_name[rankology_social_facebook_img]"
    aria-label="<?php esc_html_e('Upload default image', 'wp-rankology'); ?>"
    placeholder="<?php esc_html_e('Select your default thumbnail', 'wp-rankology'); ?>" />


<input type="hidden" name="rankology_social_facebook_img_width" id="rankology_social_fb_img_width" value="<?php echo esc_html($options_set_width); ?>">
<input type="hidden" name="rankology_social_facebook_img_height" id="rankology_social_fb_img_height" value="<?php echo esc_html($options_set_height); ?>">
<input type="hidden" name="rankology_social_facebook_img_attachment_id" id="rankology_social_fb_img_attachment_id" value="<?php echo esc_html($options_set_attachment_id); ?>">

<input id="rankology_social_fb_img_upload" class="btn btnSecondary" type="button" value="<?php esc_html_e('Upload an Image', 'wp-rankology'); ?>" />
<input id="rankology_social_fb_img_remove" class="btn btnLink is-deletable" type="button" value="<?php esc_html_e('Remove', 'wp-rankology'); ?>" />


<p class="description"><?php esc_html_e('Minimum size: 200x200px, ideal ratio 1.91:1, 8Mb max. (e.g. 1640x856px or 3280x1712px for retina screens)', 'wp-rankology'); ?></p>
<p class="description"><?php esc_html_e('If no default image is set, we‘ll use your site icon defined from the Customizer.', 'wp-rankology'); ?></p>

<div id="rankology_social_fb_img_placeholder_upload" class="rankology-img-placeholder" data_caption="<?php esc_html_e('Click to select an image', 'wp-rankology'); ?>">
    <img id="rankology_social_fb_img_placeholder_src" style="width: 524px;height: 274px;" src="<?php echo rankology_common_esc_str($options_set); ?>" />
</div>

<?php if (isset($options['rankology_social_facebook_img'])) {
        esc_attr($options['rankology_social_facebook_img']);
    }
}

function rankology_social_facebook_img_default_callback()
{
    $options = get_option('rankology_social_option_name');

    $check = isset($options['rankology_social_facebook_img_default']); ?>

<label for="rankology_social_facebook_img_default">
    <input id="rankology_social_facebook_img_default"
        name="rankology_social_option_name[rankology_social_facebook_img_default]" type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>
    <?php esc_html_e('Override every <strong>og:image</strong> tag with this default image (except if a custom og:image has already been set from the SEO metabox).', 'wp-rankology'); ?>
</label>

<?php $def_og_img = isset($options['rankology_social_facebook_img']) ? $options['rankology_social_facebook_img'] : '';

    if ('' == $def_og_img) { ?>
<div class="rankology-notice is-warning is-inline">
    <p>
        <?php esc_html_e('Please define a <strong>default OG Image</strong> from the field above', 'wp-rankology'); ?>
    </p>
</div>
<?php }

    if (isset($options['rankology_social_facebook_img_default'])) {
        esc_attr($options['rankology_social_facebook_img_default']);
    }
}

function rankology_social_facebook_img_cpt_callback()
{
    $post_types = rankology_get_service('WordPressData')->getPostTypes();
    if (! empty($post_types)) {
        unset($post_types['post'], $post_types['page']);

		if (! empty($post_types)) {
			foreach ($post_types as $rankology_cpt_key => $rankology_cpt_value) { ?>
				<h3><?php echo esc_html($rankology_cpt_value->labels->name); ?>
					<em><small>(<?php echo esc_html($rankology_cpt_value->name); ?>)</small></em>
				</h3>

				<?php if ('product' === $rankology_cpt_value->name && is_plugin_active('woocommerce/woocommerce.php')) { ?>
				<p>
					<?php esc_html_e('WooCommerce Shop Page.', 'wp-rankology'); ?>
				</p>
				<?php }

					$options = get_option('rankology_social_option_name');
					$options_set = isset($options['rankology_social_facebook_img_cpt'][$rankology_cpt_key]['url']) ? esc_attr($options['rankology_social_facebook_img_cpt'][$rankology_cpt_key]['url']) : '';
				?>

				<p>
					<input
						id="rankology_social_facebook_img_cpt_meta_<?php echo esc_attr($rankology_cpt_key); ?>"
						class="rankology_social_facebook_img_cpt_meta" type="text"
						value="<?php echo esc_attr($options_set); ?>"
						name="rankology_social_option_name[rankology_social_facebook_img_cpt][<?php echo esc_attr($rankology_cpt_key); ?>][url]"
						aria-label="<?php esc_attr_e('Upload default image', 'wp-rankology'); ?>"
						placeholder="<?php esc_attr_e('Select your default thumbnail', 'wp-rankology'); ?>" />

					<input
						id="rankology_social_facebook_img_upload"
						class="rankology_social_facebook_img_cpt rankology-btn-upload-media btn btnSecondary"
						data-input-value="#rankology_social_facebook_img_cpt_meta_<?php echo esc_attr($rankology_cpt_key); ?>"
						type="button"
						value="<?php esc_attr_e('Upload an Image', 'wp-rankology'); ?>" />

				</p>

				<?php if (isset($options['rankology_social_facebook_img_cpt'][$rankology_cpt_key]['url'])) {
					echo esc_url($options['rankology_social_facebook_img_cpt'][$rankology_cpt_key]['url']);
				}
			}
		} else { ?>
				<p>
					<?php esc_html_e('No custom post type to configure.', 'wp-rankology'); ?>
				</p>
		<?php }
    }
}

function rankology_social_facebook_link_ownership_id_callback()
{
    $options = get_option('rankology_social_option_name');
    $check   = isset($options['rankology_social_facebook_link_ownership_id']) ? $options['rankology_social_facebook_link_ownership_id'] : null;

    printf(
        '<input type="text" placeholder="' . esc_html__('1234567890','wp-rankology') . '" name="rankology_social_option_name[rankology_social_facebook_link_ownership_id]" value="%s"/>',
        esc_html($check)
    ); ?>

<p class="description">
    <?php esc_html_e('One or more Facebook Page IDs that are associated with a URL in order to enable link editing and instant article publishing.', 'wp-rankology'); ?>
</p>

<pre>&lt;meta property="fb:pages" content="page ID"/&gt;</pre>

<p>
    <span class="rankology-help dashicons dashicons-redo"></span>
    <a class="rankology-help" href="https://www.facebook.com/help/1503421039731588" target="_blank">
        <?php esc_html_e('How do I find my Facebook Page ID?', 'wp-rankology'); ?>
    </a>
</p>
<?php
}

function rankology_social_facebook_admin_id_callback()
{
    $options = get_option('rankology_social_option_name');
    $check   = isset($options['rankology_social_facebook_admin_id']) ? $options['rankology_social_facebook_admin_id'] : null;

    printf(
        '<input type="text" placeholder="' . esc_html__('1234567890','wp-rankology') . '" name="rankology_social_option_name[rankology_social_facebook_admin_id]" value="%s"/>',
        esc_html($check)
    ); ?>

<p class="description">
    <?php esc_html_e('The ID (or comma-separated list for properties that can accept multiple IDs) of an app, person using the app, or Page Graph API object.', 'wp-rankology'); ?>
</p>

<pre>&lt;meta property="fb:admins" content="admins ID"/&gt;</pre>

<?php
}

function rankology_social_facebook_app_id_callback()
{
    $options = get_option('rankology_social_option_name');
    $check   = isset($options['rankology_social_facebook_app_id']) ? $options['rankology_social_facebook_app_id'] : null;

    printf(
        '<input type="text" placeholder="' . esc_html__('1234567890','wp-rankology') . '" name="rankology_social_option_name[rankology_social_facebook_app_id]" value="%s"/>',
        esc_html($check)
    ); ?>

<p class="description">
    <?php wp_kses(__('The Facebook app ID of the site\'s app. In order to use Facebook Insights you must add the app ID to your page. Insights lets you view analytics for traffic to your site from Facebook. Find the app ID in your App Dashboard. <a class="rankology-help" href="https://developers.facebook.com/apps/redirect/dashboard" target="_blank">More info here</a> <span class="rankology-help dashicons dashicons-redo"></span>', 'wp-rankology'), array('strong' => array(), 'span' => array('class' => array()), 'a' => array('href' => array()))); ?>
</p>

<pre>&lt;meta property="fb:app_id" content="app ID"/&gt;</pre>

<p>
    <span class="rankology-help dashicons dashicons-redo"></span>
    <a class="rankology-help" href="https://developers.facebook.com/docs/apps/register" target="_blank">
        <?php esc_html_e('How to create a Facebook App ID', 'wp-rankology'); ?>
    </a>
</p>
<?php
}

function rankology_social_twitter_card_callback()
{
    $options = get_option('rankology_social_option_name');

    $check = isset($options['rankology_social_twitter_card']); ?>

<label for="rankology_social_twitter_card">
    <input id="rankology_social_twitter_card" name="rankology_social_option_name[rankology_social_twitter_card]"
        type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>

    <?php esc_html_e('Enable Twitter card', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_social_twitter_card'])) {
        esc_attr($options['rankology_social_twitter_card']);
    }
}

function rankology_social_twitter_card_og_callback()
{
    $options = get_option('rankology_social_option_name');

    $check = isset($options['rankology_social_twitter_card_og']); ?>

<label for="rankology_social_twitter_card_og">
    <input id="rankology_social_twitter_card_og" name="rankology_social_option_name[rankology_social_twitter_card_og]"
        type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>

    <?php esc_html_e('Use OG if no Twitter Cards', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_social_twitter_card_og'])) {
        esc_attr($options['rankology_social_twitter_card_og']);
    }
}

function rankology_social_twitter_card_img_callback()
{
    $options = get_option('rankology_social_option_name');

    $options_set = isset($options['rankology_social_twitter_card_img']) ? esc_attr($options['rankology_social_twitter_card_img']) : null;

    $check = isset($options['rankology_social_twitter_card_img']); ?>

<input id="rankology_social_twitter_img_meta" type="text"
    value="<?php echo rankology_common_esc_str($options_set); ?>"
    name="rankology_social_option_name[rankology_social_twitter_card_img]"
    aria-label="<?php esc_html_e('Default Twitter Image', 'wp-rankology'); ?>"
    placeholder="<?php esc_html_e('Select your default thumbnail', 'wp-rankology'); ?>" />

<input id="rankology_social_twitter_img_upload" class="btn btnSecondary" type="button" value="<?php esc_html_e('Upload an Image', 'wp-rankology'); ?>" />
<input id="rankology_social_twitter_img_remove" class="btn btnLink is-deletable" type="button" value="<?php esc_html_e('Remove', 'wp-rankology'); ?>" />

<p class="description">
    <?php esc_html_e('Minimum size: 144x144px (300x157px with large card enabled), ideal ratio 1:1 (2:1 with large card), 5Mb max.', 'wp-rankology'); ?>
</p>

<div id="rankology_social_twitter_img_placeholder_upload" class="rankology-img-placeholder" data_caption="<?php esc_html_e('Click to select an image', 'wp-rankology'); ?>">
    <img id="rankology_social_twitter_img_placeholder_src" style="width: 600px;height: 314px;" src="<?php echo rankology_common_esc_str($options_set); ?>" />
</div>

<?php if (isset($options['rankology_social_twitter_card_img'])) {
        esc_attr($options['rankology_social_twitter_card_img']);
    }
}

function rankology_social_twitter_card_img_size_callback()
{
    $options = get_option('rankology_social_option_name');

    $selected = isset($options['rankology_social_twitter_card_img_size']) ? $options['rankology_social_twitter_card_img_size'] : null; ?>

<select id="rankology_social_twitter_card_img_size"
    name="rankology_social_option_name[rankology_social_twitter_card_img_size]">
    <option <?php if ('default' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="default"><?php esc_html_e('Default', 'wp-rankology'); ?>
    </option>
    <option <?php if ('large' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="large"><?php esc_html_e('Large', 'wp-rankology'); ?>
    </option>
</select>

<p class="description">
    <?php esc_html_e('The Summary Card with <strong>Large Image</strong> features a large, full-width prominent image alongside a tweet. It is designed to give the reader a rich photo experience, and clicking on the image brings the user to your website.', 'wp-rankology'); ?>
</p>

<?php if (isset($options['rankology_social_twitter_card_img_size'])) {
        esc_attr($options['rankology_social_twitter_card_img_size']);
    }
}
