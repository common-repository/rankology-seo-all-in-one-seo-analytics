jQuery(document).ready(function ($) {

    var get_hash = window.location.hash;
    var clean_hash = get_hash.split('$');

    if (typeof sessionStorage != 'undefined') {
        var rankology_tab_session_storage = sessionStorage.getItem("rankology_robots_tab");

        if (clean_hash[1] == '1') { //Robots Tab
            $('#tab_rankology_robots-tab').addClass("nav-tab-active");
            $('#tab_rankology_robots').addClass("active");
        } else if (clean_hash[1] == '2') { //htaccess Tab
            $('#tab_rankology_htaccess-tab').addClass("nav-tab-active");
            $('#tab_rankology_htaccess').addClass("active");
        } else if (clean_hash[1] == '3') { //White Label Tab
            $('#tab_rankology_white_label-tab').addClass("nav-tab-active");
            $('#tab_rankology_white_label').addClass("active");
        } else if (rankology_tab_session_storage) {
            $('#rankology-tabs').find('.nav-tab.nav-tab-active').removeClass("nav-tab-active");
            $('#rankology-tabs').find('.rankology-tab.active').removeClass("active");

            $('#' + rankology_tab_session_storage.split('#tab=') + '-tab').addClass("nav-tab-active");
            $('#' + rankology_tab_session_storage.split('#tab=')).addClass("active");
        } else {
            //Default TAB
            $('#tab_rankology_robots-tab').addClass("nav-tab-active");
            $('#tab_rankology_robots').addClass("active");
        }
    };
    $("#rankology-tabs").find("a.nav-tab").click(function (e) {
        e.preventDefault();
        var hash = $(this).attr('href').split('#tab=')[1];

        $('#rankology-tabs').find('.nav-tab.nav-tab-active').removeClass("nav-tab-active");
        $('#' + hash + '-tab').addClass("nav-tab-active");

        if (clean_hash[1] == 1) {
            sessionStorage.setItem("rankology_robots_tab", 'tab_rankology_robots');
        } else if (clean_hash[1] == 2) {
            sessionStorage.setItem("rankology_robots_tab", 'tab_rankology_htaccess');
        } else if (clean_hash[1] == 3) {
            sessionStorage.setItem("rankology_white_label", 'tab_rankology_white_label');
        } else {
            sessionStorage.setItem("rankology_robots_tab", hash);
        }

        $('#rankology-tabs').find('.rankology-tab.active').removeClass("active");
        $('#' + hash).addClass("active");
    });
    //Robots
    $('#rankology-tag-robots-1, #rankology-tag-robots-2, #rankology-tag-robots-3, #rankology-tag-robots-4, #rankology-tag-robots-5, #rankology-tag-robots-6, #rankology-tag-robots-7, #rankology-tag-robots-8, #rankology-tag-robots-9, #rankology-tag-robots-10, #rankology-tag-robots-11').click(function () {
        $(".rankology_robots_file").val($(".rankology_robots_file").val() + '\n' + $(this).attr('data-tag'));
    });
});
