document.addEventListener('DOMContentLoaded', function() {
    var score_bgcolor = rankologyScoreData.score_bgcolor;
    var score_color = rankologyScoreData.score_color;
    var score_txt = rankologyScoreData.score_txt;

    var sidebar_score_html = '\
    <div class="misc-pub-section rkns-sidebar-seoscore" style="background-color:' + score_bgcolor + ';">\
        <strong style="color:' + score_color + ';">SEO Score: ' + score_txt + '</strong>\
    </div>';
    if (document.getElementById('misc-publishing-actions') !== null) {
        document.getElementById('misc-publishing-actions').innerHTML += sidebar_score_html;
    }

    var titlemeta_score_html = '\
    <div class="rkns-metatitle-scorecon" style="background-color:' + score_bgcolor + ';">\
        <strong style="color:' + score_color + ';">Overall SEO Score: ' + score_txt + '</strong>\
    </div>';
    if (document.getElementById('rkns-postmeta-seoscore') !== null) {
        document.getElementById('rkns-postmeta-seoscore').innerHTML += titlemeta_score_html;
    }
});
