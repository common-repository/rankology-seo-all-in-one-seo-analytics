// optimise database js

jQuery(document).ready(function () {
    jQuery("#rkns-run-optimize-database-form").submit(function (e) {
        var tbl = jQuery('#optimize-table').val();
        if (tbl == "0") {
            alert('Please select database table');
            e.preventDefault();
        }
    });
});


//internal linking js
document.addEventListener('DOMContentLoaded', function(){
    const $ = jQuery;
    $(".rankology-copy-clipboard").on("click", function(){
        const value = $(this).data("copy-value");
        const $temp = $("<input>");
        $("body").append($temp);
        $temp.val(value).select();
        document.execCommand("copy");
        $temp.remove();

        $("#rankology-link-copied").fadeIn(200).delay(2000).fadeOut(200);
    });
});

// 
jQuery(document).ready(function($) {
    $('input[data-id=<?php echo rankology_common_esc_str($rankology_cpt_key); ?>]')
        .on('click', function() {
            $(this).attr('data-toggle', $(this).attr('data-toggle') == '1' ? '0' : '1');
            if ($(this).attr('data-toggle') == '1') {
                $(this).next().next('.feature-state').html(
                    '<?php echo rankology_common_esc_str($toggle_txt_off); ?>'
                );
            } else {
                $(this).next().next('.feature-state').html(
                    '<?php echo rankology_common_esc_str($toggle_txt_on); ?>'
                );
            }
        });
});

// SEO Metaboxes columns js
document.addEventListener('DOMContentLoaded', function () {
    // Toggle checkbox functionality
    document.querySelectorAll('.toggle').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const postId = this.getAttribute('data-id');
            const isChecked = this.checked;
            const toggleState = isChecked ? 1 : 0;

            // Update the toggle state
            this.setAttribute('data-toggle', toggleState);

            // Update the toggle text
            const stateElements = document.querySelectorAll(`#titles-state, #titles-state-default`);
            stateElements.forEach(function (element) {
                element.classList.toggle('feature-state-off', !isChecked);
                element.classList.toggle('feature-state', isChecked);
            });

            // Log the event (for debugging purposes)
            console.log(`Toggled ${postId} to ${toggleState}`);
        });
    });

    // Tag button functionality
    document.querySelectorAll('.btn.tag-title').forEach(function (button) {
        button.addEventListener('click', function () {
            const tag = this.getAttribute('data-tag');
            const targetId = this.id.split('-').slice(-1)[0];
            const targetInput = document.querySelector(`#rankology_titles_single_titles_${targetId}, #rankology_titles_single_desc_${targetId}`);

            if (targetInput) {
                targetInput.value += tag;
            }

            // Log the event (for debugging purposes)
            console.log(`Inserted tag ${tag} into input ${targetId}`);
        });
    });
});

// Titles Archive js
jQuery(document).ready(function($) {
    function bindClickEvent(selector, inputSelector, dataTag) {
        $(selector).click(function() {
            var field = $(inputSelector);
            field.val(rankology_rkseo_get_field_length(field) + dataTag);
        });
    }

    $.each(rankologyData.postTypes, function(key, value) {
        bindClickEvent('#rankology-tag-archive-title-' + key, '#' + value.id_title, value.tags.title);
        bindClickEvent('#rankology-tag-archive-sep-' + key, '#' + value.id_title, value.tags.sep);
        bindClickEvent('#rankology-tag-archive-sitetitle-' + key, '#' + value.id_title, value.tags.sitetitle);
        
        bindClickEvent('#rankology-tag-archive-desc-' + key, '#' + value.id_title.replace('titles', 'desc'), value.tags.title);
        bindClickEvent('#rankology-tag-archive-desc-sep-' + key, '#' + value.id_title.replace('titles', 'desc'), value.tags.sep);
        bindClickEvent('#rankology-tag-archive-desc-sitetitle-' + key, '#' + value.id_title.replace('titles', 'desc'), value.tags.sitetitle);
    });
});


//purging js
jQuery(document).ready(function () {
    jQuery("#purge-data-submit").click(function () {
        var action = jQuery('#purge-data').val();
        if (action == 0) return false;

        var agree = confirm(rankologyL10n.confirmMessage);
        if (!agree) return false;

        jQuery("#purge-data-submit").attr("disabled", "disabled");
        jQuery("#purge-data-status").html("<img src='" + rankologyL10n.loadingImage + "'/>");
        jQuery.ajax({
            url: rankologyL10n.ajaxUrl,
            type: 'post',
            data: {
                'action': 'rankology_stats_purge_data',
                'purge-days': action,
                'rankology_rkns_nonce': rankologyL10n.nonce
            },
            datatype: 'json',
        }).always(function (result) {
            jQuery("#purge-data-status").html("");
            jQuery("#purge-data-result").html(result);
            jQuery("#purge-data-submit").removeAttr("disabled");
            jQuery("#rankology_rkns_historical_purge").show();
        });
    });

    jQuery("#purge-visitor-hits-submit").click(function () {
        var action = jQuery('#purge-visitor-hits').val();
        if (action == 0) return false;

        var agree = confirm(rankologyL10n.confirmMessage);
        if (!agree) return false;

        jQuery("#purge-visitor-hits-submit").attr("disabled", "disabled");
        jQuery("#purge-visitor-hits-status").html("<img src='" + rankologyL10n.loadingImage + "'/>");
        jQuery.ajax({
            url: rankologyL10n.ajaxUrl,
            type: 'post',
            data: {
                'action': 'rankology_stats_purge_visitor_hits',
                'purge-hits': action,
                'rankology_rkns_nonce': rankologyL10n.nonce
            },
            datatype: 'json',
        }).always(function (result) {
            jQuery("#purge-visitor-hits-status").html("");
            jQuery("#purge-visitor-hits-result").html(result);
            jQuery("#purge-visitor-hits-submit").removeAttr("disabled");
        });
    });

    jQuery("#empty-table-submit").click(function () {
        var action = jQuery('#empty-table').val();
        if (action == 0) return false;

        var agree = confirm(rankologyL10n.confirmMessage);
        if (!agree) return false;

        jQuery("#empty-table-submit").attr("disabled", "disabled");
        jQuery("#empty-status").html("<img src='" + rankologyL10n.loadingImage + "'/>");
        jQuery.ajax({
            url: rankologyL10n.ajaxUrl,
            type: 'post',
            data: {
                'action': 'rankology_stats_empty_table',
                'table-name': action,
                'rankology_rkns_nonce': rankologyL10n.nonce
            },
            datatype: 'json',
        }).always(function (result) {
            jQuery("#empty-status").html("");
            jQuery("#empty-result").html(result);
            jQuery("#empty-table-submit").removeAttr("disabled");
        });
    });

    jQuery("#delete-agents-submit").click(function () {
        var action = jQuery('#delete-agent').val();
        if (action == 0) return false;

        var agree = confirm(rankologyL10n.confirmMessage);
        if (!agree) return false;

        jQuery("#delete-agents-submit").attr("disabled", "disabled");
        jQuery("#delete-agents-status").html("<img src='" + rankologyL10n.loadingImage + "'/>");
        jQuery.ajax({
            url: rankologyL10n.ajaxUrl,
            type: 'post',
            data: {
                'action': 'rankology_stats_delete_agents',
                'agent-name': action,
                'rankology_rkns_nonce': rankologyL10n.nonce
            },
            datatype: 'json',
        }).always(function (result) {
            jQuery("#delete-agents-status").html("");
            jQuery("#delete-agents-result").html(result);
            jQuery("#delete-agents-submit").removeAttr("disabled");
            aid = action.replace(/[^a-zA-Z]/g, "");
            jQuery("#agent-" + aid + "-id").remove();
        });
    });

    jQuery("#delete-platforms-submit").click(function () {
        var action = jQuery('#delete-platform').val();
        if (action == 0) return false;

        var agree = confirm(rankologyL10n.confirmMessage);
        if (!agree) return false;

        jQuery("#delete-platforms-submit").attr("disabled", "disabled");
        jQuery("#delete-platforms-status").html("<img src='" + rankologyL10n.loadingImage + "'/>");
        jQuery.ajax({
            url: rankologyL10n.ajaxUrl,
            type: 'post',
            data: {
                'action': 'rankology_stats_delete_platforms',
                'platform-name': action,
                'rankology_rkns_nonce': rankologyL10n.nonce
            },
            datatype: 'json',
        }).always(function (result) {
            jQuery("#delete-platforms-status").html("");
            jQuery("#delete-platforms-result").html(result);
            jQuery("#delete-platforms-submit").removeAttr("disabled");
            pid = action.replace(/[^a-zA-Z]/g, "");
            jQuery("#platform-" + pid + "-id").remove();
        });
    });

    jQuery("#delete-ip-submit").click(function () {
        var value = jQuery('#delete-ip').val();
        if (value == 0) return false;

        var agree = confirm(rankologyL10n.confirmMessage);
        if (!agree) return false;

        jQuery("#delete-ip-submit").attr("disabled", "disabled");
        jQuery("#delete-ip-status").html("<img src='" + rankologyL10n.loadingImage + "'/>");
        jQuery.ajax({
            url: rankologyL10n.ajaxUrl,
            type: 'post',
            data: {
                'action': 'rankology_stats_delete_ip',
                'ip-address': value,
                'rankology_rkns_nonce': rankologyL10n.nonce
            },
            datatype: 'json',
        }).always(function (result) {
            jQuery("#delete-ip-status").html("");
            jQuery("#delete-ip-result").html(result);
            jQuery("#delete-ip-submit").removeAttr("disabled");
            jQuery("#delete-ip").val('');
        });
    });
});


// Titles JS
jQuery(document).ready(function($) {
    $('#rankology-tag-tax-desc-<?php echo esc_attr(rankology_common_esc_str($rankology_tax_key)); ?>')
        .click(function() {
            $('#rankology_titles_tax_desc_<?php echo esc_attr(rankology_common_esc_str($rankology_tax_key)); ?>')
                .val(
                    rankology_rkseo_get_field_length($(
                        '#rankology_titles_tax_desc_<?php echo esc_attr(rankology_common_esc_str($rankology_tax_key)); ?>'
                    )) + $(
                        '#rankology-tag-tax-desc-<?php echo esc_attr(rankology_common_esc_str($rankology_tax_key)); ?>'
                    )
                    .attr('data-tag'));
        });
});

// admin metabox form JS
document.addEventListener('DOMContentLoaded', function(){

    var cache = {};
    jQuery( ".js-rankology_redirections_value_meta" ).autocomplete({
        source: async function( request, response ) {
            var term = request.term;
            if ( term in cache ) {
                response( cache[ term ] );
                return;
            }

            const dataResponse = await fetch("<?php echo rest_url(); ?>rankology/v1/search-url?url=" + term)
            const data = await dataResponse.json();

            cache[ term ] = data.map(item => {
                return {
                    label: item.post_title + " (" + item.guid + ")",
                    value: item.guid
                }
            });
            response( cache[term] );
        },

        minLength: 3,
    });


});

// Disable PostBox
jQuery(document).ready(function () {

    // close postboxes that should be closed
    jQuery('.if-js-closed').removeClass('if-js-closed').addClass('closed');

    // postboxes setup
    postboxes.add_postbox_toggles('<?php echo esc_attr($overview_page_slug); ?>');
});
