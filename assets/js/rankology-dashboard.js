jQuery(document).ready(function ($) {
    //If no notices
    if (!$.trim($("#rankology-notifications-center").html())) {
        $('#rankology-notifications-center').remove();
    }
    const notices = [
        "notice-get-started",
        "notice-usm",
        "notice-wizard",
        "notice-insights-wizard",
        "notice-amp-analytics",
        "notice-divide-comments",
        "notice-review",
        "notice-trailingslash",
        "notice-posts-number",
        "notice-rss-use-excerpt",
        "notice-ga-ids",
        "notice-search-console",
        "notice-google-business",
        "notice-ssl",
        "notice-title-tag",
        "notice-enfold",
        "notice-themes",
        "notice-page-builders",
        "notice-go-insights",
        "notice-noindex",
        "notice-tasks",
        "notice-insights",
        "notice-robots-txt",
        "notice-robots-txt-valid",
    ]
    notices.forEach(function (item) {
        $('#' + item).on('click', function () {
            $('#' + item).attr('data-notice', $('#' + item).attr('data-notice') == '1' ? '0' : '1');

            $.ajax({
                method: 'POST',
                url: rankologyAjaxHideNotices.rankology_hide_notices,
                data: {
                    action: 'rankology_hide_notices',
                    notice: item,
                    notice_value: $('#' + item).attr('data-notice'),
                    _ajax_nonce: rankologyAjaxHideNotices.rankology_nonce,
                },
                success: function (data) {
                    $('#rankology-notice-save').css('display', 'block');
                    $('#rankology-notice-save .html').html('Notice successfully removed');
                    $('#' + item + '-alert').fadeOut();
                    $('#rankology-notice-save').delay(3500).fadeOut();
                },
            });
        });
    });

    const features = [
        "titles",
        "xml-sitemap",
        "social",
        "google-analytics",
        "instant-indexing",
        "advanced",
        "local-business",
        "woocommerce",
        "edd",
        "dublin-core",
        "rich-snippets",
        "breadcrumbs",
        "inspect-url",
        "robots",
        "news",
        "404",
        "bot",
        "rewrite",
        "white-label",
        "ai"
    ]
    features.forEach(function (item) {
        $('#toggle-' + item).on('click', function () {
            $('#toggle-' + item).attr('data-toggle', $('#toggle-' + item).attr('data-toggle') == '1' ? '0' : '1');

            $(this).siblings('#titles-state-default').toggleClass('feature-state-off');
            $(this).siblings('#titles-state').toggleClass('feature-state-off');

            $.ajax({
                method: 'POST',
                url: rankologyAjaxToggleFeatures.rankology_toggle_features,
                data: {
                    action: 'rankology_toggle_features',
                    feature: 'toggle-' + item,
                    feature_value: $('#toggle-' + item).attr('data-toggle'),
                    _ajax_nonce: rankologyAjaxToggleFeatures.rankology_nonce,
                },
                success: function () {
                    window.history.pushState("", "", window.location.href + "&settings-updated=true");
                    $('#rankology-notice-save').show();
                    $('#rankology-notice-save').delay(3500).fadeOut();
                    window.history.pushState("", "", window.location.href)
                },
            });
        });
    });
    $('#rankology-activity-panel button, #rankology-notifications button').on('click', function () {
        $(this).toggleClass('is-active');
        $('#rankology-activity-panel-' + $(this).data('panel')).toggleClass('is-open');
    });
    $('#wpbody-content > form, #rankology-content').on('click', function (e) {
        if (e.target.id !== 'rankology-see-notifications') {
            $('#rankology-activity-panel').find('.is-open').toggleClass('is-open');
            $('#rankology-activity-panel').find('.is-active').toggleClass('is-active');
        }
    });
    $('.rankology-item-toggle-options').on('click', function () {
        $(this).next('.rankology-card-popover').toggleClass('is-open');
    });

    $('#rankology_news').on('click', function () {
        $('#rankology-news-panel').toggleClass('is-active');
        $('#rankology_news').attr('data-toggle', $('#rankology_news').attr('data-toggle') == '1' ? '0' : '1');
        $.ajax({
            method: 'POST',
            url: rankologyAjaxDisplay.rankology_display,
            data: {
                action: 'rankology_display',
                news_center: $('#rankology_news').attr('data-toggle'),
                _ajax_nonce: rankologyAjaxDisplay.rankology_nonce,
            },
        });
    });
    $('#rankology_tools').on('click', function () {
        $('#notice-insights-alert').toggleClass('is-active');
        $('#rankology_tools').attr('data-toggle', $('#rankology_tools').attr('data-toggle') == '1' ? '0' : '1');
        $.ajax({
            method: 'POST',
            url: rankologyAjaxDisplay.rankology_display,
            data: {
                action: 'rankology_display',
                tools_center: $('#rankology_tools').attr('data-toggle'),
                _ajax_nonce: rankologyAjaxDisplay.rankology_nonce,
            },
        });
    });
    $('#notifications_center').on('click', function () {
        $('#rankology-notifications').toggleClass('is-active');
        $('#notifications_center').attr('data-toggle', $('#notifications_center').attr('data-toggle') == '1' ? '0' : '1');
        $.ajax({
            method: 'POST',
            url: rankologyAjaxDisplay.rankology_display,
            data: {
                action: 'rankology_display',
                notifications_center: $('#notifications_center').attr('data-toggle'),
                _ajax_nonce: rankologyAjaxDisplay.rankology_nonce,
            },
        });
    });
    $('#notice-tasks').on('click', function () {
        $('#notice-tasks-alert').toggleClass('is-active');
        $('#notice-tasks').attr('data-toggle', $('#notice-tasks').attr('data-toggle') == '1' ? '0' : '1');
    });
    $('#notice-get-started').on('click', function () {
        $('#notice-get-started-alert').toggleClass('is-active');
        $('#notice-get-started').attr('data-toggle', $('#notice-get-started').attr('data-toggle') == '1' ? '0' : '1');
    });
    $('#notice-go-insights').on('click', function () {
        $('#notice-go-insights-alert').toggleClass('is-active');
        $('#notice-go-insights').attr('data-toggle', $('#notice-go-insights').attr('data-toggle') == '1' ? '0' : '1');
    });
});

//SEO Tools Tabs
jQuery(document).ready(function ($) {
    var get_hash = window.location.hash;
    var clean_hash = get_hash.split('$');

    if (typeof sessionStorage != 'undefined') {
        var rankology_admin_tab_session_storage = sessionStorage.getItem("rankology_admin_tab");

        if (clean_hash[1] == '1') { //Analytics Tab
            $('#tab_rankology_analytics-tab').addClass("nav-tab-active");
            $('#tab_rankology_analytics').addClass("active");
        } else if (clean_hash[1] == '3') { //Page Speed Tab
            $('#tab_rankology_ps-tab').addClass("nav-tab-active");
            $('#tab_rankology_ps_tools').addClass("active");
        } else if (rankology_admin_tab_session_storage) {
            $('#rankology-admin-tabs').find('.nav-tab.nav-tab-active').removeClass("nav-tab-active");
            $('#rankology-admin-tabs').find('.rankology-tab.active').removeClass("active");
            $('#' + rankology_admin_tab_session_storage.split('#tab=') + '-tab').addClass("nav-tab-active");
            $('#' + rankology_admin_tab_session_storage.split('#tab=')).addClass("active");
        } else {
            //Default TAB
            $('#rankology-admin-tabs a.nav-tab').first().addClass("nav-tab-active");
            $('#rankology-admin-tabs .wrap-rankology-tab-content > div').first().addClass("active");
        }
    };
    $("#rankology-admin-tabs").find("a.nav-tab").click(function (e) {
        e.preventDefault();
        var hash = $(this).attr('href').split('#tab=')[1];

        $('#rankology-admin-tabs').find('.nav-tab.nav-tab-active').removeClass("nav-tab-active");
        $('#' + hash + '-tab').addClass("nav-tab-active");

        if (clean_hash[1] == 1) {
            sessionStorage.setItem("rankology_admin_tab", 'tab_rankology_analytics');
        } else if (clean_hash[1] == 2) {
            sessionStorage.setItem("rankology_admin_tab", 'tab_rankology_analytics');
        } else if (clean_hash[1] == 3) {
            sessionStorage.setItem("rankology_admin_tab", 'tab_rankology_ps_tools');
        } else {
            sessionStorage.setItem("rankology_admin_tab", hash);
        }

        $('#rankology-admin-tabs').find('.rankology-tab.active').removeClass("active");
        $('#' + hash).addClass("active");
    });
});
