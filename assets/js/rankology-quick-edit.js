(function ($) {

    // we create a copy of the WP inline edit post function
    var $wp_inline_edit = inlineEditPost.edit;

    // and then we overwrite the function with our own code
    inlineEditPost.edit = function (id) {

        // "call" the original WP edit function
        // we don't want to leave WordPress hanging
        $wp_inline_edit.apply(this, arguments);

        // get the post ID
        var $post_id = 0;
        if (typeof (id) == 'object') {
            $post_id = parseInt(this.getId(id));
        }

        if ($post_id > 0) {
            // define the edit row
            var $edit_row = $('#edit-' + $post_id);
            var $post_row = $('#post-' + $post_id);

            // get the data
            var $rankology_title = $('.column-rankology_title .hidden', $post_row).text();
            var $rankology_desc = $('.column-rankology_desc .hidden', $post_row).text();
            var $rankology_tkw = $('.column-rankology_tkw', $post_row).text();
            var $rankology_canonical = $('.column-rankology_canonical', $post_row).text();
            var $rankology_noindex = $('.column-rankology_noindex', $post_row).html();
            var $rankology_nofollow = $('.column-rankology_nofollow', $post_row).html();
            var $rankology_redirect_enable = $('.column-rankology_redirect_enable', $post_row).html();
            var $rankology_redirect_url = $('.column-rankology_redirect_url', $post_row).text();

            var $rankology_redirections_enable = $('.column-rankology_404_redirect_enable', $post_row).html();

            var $rankology_redirections_regex_enable = $('.column-rankology_404_redirect_regex_enable', $post_row).html();
            var $rankology_redirections_type = $('.column-rankology_404_redirect_type', $post_row).text();
            var $rankology_redirections_value = $('.column-rankology_404_redirect_value', $post_row).text();

            // populate the data
            $(':input[name="rankology_title"]', $edit_row).val($rankology_title);
            $(':input[name="rankology_desc"]', $edit_row).val($rankology_desc);
            $(':input[name="rankology_tkw"]', $edit_row).val($rankology_tkw);
            $(':input[name="rankology_canonical"]', $edit_row).val($rankology_canonical);

            if ($rankology_noindex && $rankology_noindex.includes('<span class="dashicons dashicons-hidden"></span>')) {
                $(':input[name="rankology_noindex"]', $edit_row).attr('checked', 'checked');
            }

            if ($rankology_nofollow && $rankology_nofollow.includes('<span class="dashicons dashicons-yes"></span>')) {
                $(':input[name="rankology_nofollow"]', $edit_row).attr('checked', 'checked');
            }

            if ($rankology_redirect_enable && $rankology_redirect_enable == '<span class="dashicons dashicons-yes-alt"></span>') {
                $(':input[name="rankology_redirections_enabled"]', $edit_row).attr('checked', 'checked');
            }

            if ($rankology_redirect_url) {
                $(':input[name="rankology_redirections_value"]', $edit_row).val($rankology_redirect_url);
            }

            if ($rankology_redirections_enable && $rankology_redirections_enable == '<span class="dashicons dashicons-yes-alt"></span>') {
                $(':input[name="rankology_redirections_enabled"]', $edit_row).attr('checked', 'checked');
            }

            if ($rankology_redirections_regex_enable && $rankology_redirections_regex_enable == '<span class="dashicons dashicons-yes"></span>') {
                $(':input[name="rankology_redirections_enabled_regex"]', $edit_row).attr('checked', 'checked');
            }

            if ($rankology_redirections_type && $rankology_redirections_type != '404') {
                $('select[name="rankology_redirections_type"] option[value="' + $rankology_redirections_type + '"]', $edit_row).attr('selected', 'selected');
            }

            if ($rankology_redirections_value) {
                $(':input[name="rankology_redirections_value"]', $edit_row).val($rankology_redirections_value);
            }
        }
    };

})(jQuery);
