//GA user consent
jQuery(document).ready(function ($) {
    if (Cookies.get('rankology-user-consent-close') == undefined && Cookies.get('rankology-user-consent-accept') == undefined) {
        $('.rankology-user-consent.rankology-user-message').removeClass('rankology-user-consent-hide');
        $('.rankology-user-consent-backdrop').removeClass('rankology-user-consent-hide');
    }
    $('#rankology-user-consent-accept').on('click', function () {
        $('.rankology-user-consent.rankology-user-message').addClass('rankology-user-consent-hide');
        $('.rankology-user-consent-backdrop').addClass('rankology-user-consent-hide');
        $.ajax({
            method: 'GET',
            url: rankologyAjaxGAUserConsent.rankology_cookies_user_consent,
            data: {
                action: 'rankology_cookies_user_consent',
                _ajax_nonce: rankologyAjaxGAUserConsent.rankology_nonce,
            },
            success: function (data) {
                if (data.data) {
                    $('head').append(data.data.gtag_js);
                    $('head').append(data.data.custom);
                    $('head').append(data.data.head_js);
                    $('body').prepend(data.data.body_js);
                    $('body').append(data.data.footer_js);
                }
                Cookies.set('rankology-user-consent-accept', '1', { expires: Number(rankologyAjaxGAUserConsent.rankology_cookies_expiration_days) });
            },
        });
    });
    $('#rankology-user-consent-close').on('click', function () {
        $('.rankology-user-consent.rankology-user-message').addClass('rankology-user-consent-hide');
        $('.rankology-user-consent-backdrop').addClass('rankology-user-consent-hide');
        Cookies.set('rankology-user-consent-close', '1', { expires: Number(rankologyAjaxGAUserConsent.rankology_cookies_expiration_days) });
        Cookies.remove('rankology-user-consent-accept');
    });
    $('#rankology-user-consent-edit').on('click', function () {
        $('.rankology-user-consent.rankology-user-message').removeClass('rankology-user-consent-hide');
        $('.rankology-user-consent-backdrop').removeClass('rankology-user-consent-hide');
    });
});
