jQuery(document).ready(function ($) {
    //Regenerate Video XML sitemap
    $("#rankology-video-regenerate").click(function () {
        url = rankologyAjaxVdeoRegenerate.rankology_video_regenerate;
        action = 'rankology_video_xml_sitemap_regenerate';
        _ajax_nonce = rankologyAjaxVdeoRegenerate.rankology_nonce;

        self.process_offset2(0, self, url, action, _ajax_nonce);
    });

    process_offset2 = function (
        offset,
        self,
        url,
        action,
        _ajax_nonce
    ) {
        i18n = rankologyAjaxMigrate.i18n.video;
        $.ajax({
            method: 'POST',
            url: url,
            data: {
                action: action,
                offset: offset,
                _ajax_nonce: _ajax_nonce,
            },
            success: function (data) {
                if ("done" == data.data.offset) {
                    $("#rankology-video-regenerate").removeAttr(
                        "disabled"
                    );
                    $(".spinner").css("visibility", "hidden");
                    $("#tab_rankology_tool_video .log").css("display", "block");
                    $("#tab_rankology_tool_video .log").html("<div class='rankology-notice is-success'><p>" + i18n + "</p></div>");

                    if (data.data.url != "") {
                        $(location).attr("href", data.data.url);
                    }
                } else {
                    self.process_offset2(
                        parseInt(data.data.offset),
                        self,
                        url,
                        action,
                        _ajax_nonce
                    );
                    if (data.data.total) {
                        progress = (data.data.count / data.data.total * 100).toFixed(2);
                        $("#tab_rankology_tool_video .log").css("display", "block");
                        $("#tab_rankology_tool_video .log").html("<div class='rankology-notice'><p>" + progress + "%</p></div>");
                    }
                }
            },
        });
    };
    $("#rankology-video-regenerate").on("click", function () {
        $(this).attr("disabled", "disabled");
        $("#tab_rankology_tool_video .spinner").css(
            "visibility",
            "visible"
        );
        $("#tab_rankology_tool_video .spinner").css("float", "none");
        $("#tab_rankology_tool_video .log").html("");
    });

    //Select toggle
    $("#select-wizard-redirects, #select-wizard-import")
        .change(function (e) {
            e.preventDefault();

            var select = $(this).val();
            if (select == "none") {
                $(
                    "#select-wizard-redirects option, #select-wizard-import option"
                ).each(function () {
                    var ids_to_hide = $(this).val();
                    $("#" + ids_to_hide).hide();
                });
            } else {
                $(
                    "#select-wizard-redirects option:selected, #select-wizard-import option:selected"
                ).each(function () {
                    var ids_to_show = $(this).val();
                    $("#" + ids_to_show).show();
                });
                $(
                    "#select-wizard-redirects option:not(:selected), #select-wizard-import option:not(:selected)"
                ).each(function () {
                    var ids_to_hide = $(this).val();
                    $("#" + ids_to_hide).hide();
                });
            }
        })
        .trigger("change");

    //Import from SEO plugins
    const seo_plugins = [
        "yoast",
        "aio",
        "seo-framework",
        "rk",
        "squirrly",
        "seo-ultimate",
        "wp-meta-seo",
        "premium-seo-pack",
        "wpseo",
        "platinum-seo",
        "smart-crawl",
        "rankologyor",
        "slim-seo",
        "metadata",
    ];
    seo_plugins.forEach(function (item) {
        $("#rankology-" + item + "-migrate").on("click", function (e) {
            e.preventDefault();
            id = item;
            switch (e.target.id) {
                case "rankology-yoast-migrate":
                    url =
                        rankologyAjaxMigrate.rankology_yoast_migrate
                            .rankology_yoast_migration;
                    action = "rankology_yoast_migration";
                    _ajax_nonce =
                        rankologyAjaxMigrate.rankology_yoast_migrate
                            .rankology_nonce;
                    break;
                case "rankology-aio-migrate":
                    url =
                        rankologyAjaxMigrate.rankology_aio_migrate
                            .rankology_aio_migration;
                    action = "rankology_aio_migration";
                    _ajax_nonce =
                        rankologyAjaxMigrate.rankology_aio_migrate.rankology_nonce;
                    break;
                case "rankology-seo-framework-migrate":
                    url =
                        rankologyAjaxMigrate.rankology_seo_framework_migrate
                            .rankology_seo_framework_migration;
                    action = "rankology_seo_framework_migration";
                    _ajax_nonce =
                        rankologyAjaxMigrate.rankology_seo_framework_migrate
                            .rankology_nonce;
                    break;
                case "rankology-rk-migrate":
                    url =
                        rankologyAjaxMigrate.rankology_rk_migrate
                            .rankology_rk_migration;
                    action = "rankology_rk_migration";
                    _ajax_nonce =
                        rankologyAjaxMigrate.rankology_rk_migrate.rankology_nonce;
                    break;
                case "rankology-squirrly-migrate":
                    url =
                        rankologyAjaxMigrate.rankology_squirrly_migrate
                            .rankology_squirrly_migration;
                    action = "rankology_squirrly_migration";
                    _ajax_nonce =
                        rankologyAjaxMigrate.rankology_squirrly_migrate
                            .rankology_nonce;
                    break;
                case "rankology-seo-ultimate-migrate":
                    url =
                        rankologyAjaxMigrate.rankology_seo_ultimate_migrate
                            .rankology_seo_ultimate_migration;
                    action = "rankology_seo_ultimate_migration";
                    _ajax_nonce =
                        rankologyAjaxMigrate.rankology_seo_ultimate_migrate
                            .rankology_nonce;
                    break;
                case "rankology-wp-meta-seo-migrate":
                    url =
                        rankologyAjaxMigrate.rankology_wp_meta_seo_migrate
                            .rankology_wp_meta_seo_migration;
                    action = "rankology_wp_meta_seo_migration";
                    _ajax_nonce =
                        rankologyAjaxMigrate.rankology_wp_meta_seo_migrate
                            .rankology_nonce;
                    break;
                case "rankology-premium-seo-pack-migrate":
                    url =
                        rankologyAjaxMigrate.rankology_premium_seo_pack_migrate
                            .rankology_premium_seo_pack_migration;
                    action = "rankology_premium_seo_pack_migration";
                    _ajax_nonce =
                        rankologyAjaxMigrate.rankology_premium_seo_pack_migrate
                            .rankology_nonce;
                    break;
                case "rankology-wpseo-migrate":
                    url =
                        rankologyAjaxMigrate.rankology_wpseo_migrate
                            .rankology_wpseo_migration;
                    action = "rankology_wpseo_migration";
                    _ajax_nonce =
                        rankologyAjaxMigrate.rankology_wpseo_migrate
                            .rankology_nonce;
                    break;
                case "rankology-platinum-seo-migrate":
                    url =
                        rankologyAjaxMigrate.rankology_platinum_seo_migrate
                            .rankology_platinum_seo_migration;
                    action = "rankology_platinum_seo_migration";
                    _ajax_nonce =
                        rankologyAjaxMigrate.rankology_platinum_seo_migrate
                            .rankology_nonce;
                    break;
                case "rankology-smart-crawl-migrate":
                    url =
                        rankologyAjaxMigrate.rankology_smart_crawl_migrate
                            .rankology_smart_crawl_migration;
                    action = "rankology_smart_crawl_migration";
                    _ajax_nonce =
                        rankologyAjaxMigrate.rankology_smart_crawl_migrate
                            .rankology_nonce;
                    break;
                case "rankology-rankologyor-migrate":
                    url =
                        rankologyAjaxMigrate.rankology_rankologyor_migrate
                            .rankology_rankologyor_migration;
                    action = "rankology_rankologyor_migration";
                    _ajax_nonce =
                        rankologyAjaxMigrate.rankology_rankologyor_migrate
                            .rankology_nonce;
                    break;
                case "rankology-slim-seo-migrate":
                    url =
                        rankologyAjaxMigrate.rankology_slim_seo_migrate
                            .rankology_slim_seo_migration;
                    action = "rankology_slim_seo_migration";
                    _ajax_nonce =
                        rankologyAjaxMigrate.rankology_slim_seo_migrate
                            .rankology_nonce;
                    break;
                case "rankology-metadata-migrate":
                    url =
                        rankologyAjaxMigrate.rankology_metadata_csv
                            .rankology_metadata_export;
                    action = "rankology_metadata_export";
                    _ajax_nonce =
                        rankologyAjaxMigrate.rankology_metadata_csv
                            .rankology_nonce;
                    break;
                default:
            }
            self.process_offset(0, self, url, action, _ajax_nonce, id);
        });

        process_offset = function (
            offset,
            self,
            url,
            action,
            _ajax_nonce,
            id,
            post_export,
            term_export
        ) {
            i18n = rankologyAjaxMigrate.i18n.migration;
            if (id == "metadata") {
                i18n = rankologyAjaxMigrate.i18n.export;
            }
            $.ajax({
                method: "POST",
                url: url,
                data: {
                    action: action,
                    offset: offset,
                    post_export: post_export,
                    term_export: term_export,
                    _ajax_nonce: _ajax_nonce,
                },
                success: function (data) {
                    if ("done" == data.data.offset) {
                        $("#rankology-" + id + "-migrate").removeAttr(
                            "disabled"
                        );
                        $(".spinner").css("visibility", "hidden");
                        $("#" + id + "-migration-tool .log").css("display", "block");
                        $("#" + id + "-migration-tool .log").html("<div class='rankology-notice is-success'><p>" + i18n + "</p></div>");

                        if (data.data.url != "") {
                            $(location).attr("href", data.data.url);
                        }
                    } else {
                        self.process_offset(
                            parseInt(data.data.offset),
                            self,
                            url,
                            action,
                            _ajax_nonce,
                            id,
                            data.data.post_export,
                            data.data.term_export
                        );
                        if (data.data.total) {
                            progress = (data.data.count / data.data.total * 100).toFixed(2);
                            $("#" + id + "-migration-tool .log").css("display", "block");
                            $("#" + id + "-migration-tool .log").html("<div class='rankology-notice'><p>" + progress + "%</p></div>");
                        }
                    }
                },
            });
        };
        $("#rankology-" + item + "-migrate").on("click", function () {
            $(this).attr("disabled", "disabled");
            $("#" + item + "-migration-tool .spinner").css(
                "visibility",
                "visible"
            );
            $("#" + item + "-migration-tool .spinner").css("float", "none");
            $("#" + item + "-migration-tool .log").html("");
        });
    });
});
