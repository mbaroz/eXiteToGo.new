<?
?>
<style type="text/css">
    .help_container {
        position: fixed;
        bottom: 50%;
        right: 0px;
    }
    .help_button {
        width: 29px;
        height: 147px;
        background-image:url('http://guide.exite.co.il/Admin/images/ask-bot-exite_vert_2.png');
        background-repeat: no-repeat;
        cursor: pointer;
        z-index:2000;
        position:relative;
    }
    .help_window_container {
        width:720px;
        height: 370px;
        border: 1px solid #b1c9d3;
        background-color: white;
        border-radius: 7px 0px 0px 7px;
        -moz-border-radius: 7px;
        -moz-box-shadow: 0 0 28px #333;
        -webkit-box-shadow: 0 0 28px #333;
        box-shadow: 0 0 28px #333;
        display: none;
        position: fixed;
        bottom:32%;
        right:0px;
        z-index:2000;
    }
    .close_help_win {
        width:36px;height:36px;
        cursor:pointer;
        background-image:url('http://guide.exite.co.il/Admin/images/close_help_win.png');
        background-repeat:no-repeat;
        float:left;
        margin:-8px -8px;
    }
    .iframe_search_exite_guide{
        margin-right:20px;
        padding-top:28px;
        overflow: hidden;    
    }
    .exite_help_bottom_notes {direction: rtl;text-align: right;margin-top:5px}
</style>
<script>
    var exite_help_iframe_loaded=false;
    function show_exite_help(x) {
        jQuery(".help_window_container").toggle("fast");
        if (!exite_help_iframe_loaded) {
            jQuery('#exite_help_ifrm').attr('src', "http://guide.exite.co.il/exite_guide_search.php?currentTemplate=<?=$CHECK_CATPAGE[CatType];?>");
            exite_help_iframe_loaded=true;
        }
        if (x==1) jQuery(".help_button").show();
        else jQuery(".help_button").hide();
    }
    function ex_set_help_button(l,el) {
        var help_html='<a class="newSaveIcon ex_help_button">?</a>';
        var top=jQuery("."+el).position().pos+30;
        var left=jQuery("."+el).position().left;
        jQuery(".ex_help_button").css({'top':top+'px','left':left+'px'});
        jQuery(".ex_help_button").attr("href",el);
       
    }
    
</script>
<div class="help_container">
    <div class="help_button" onclick="show_exite_help(0)"></div>
</div>
<div class="help_window_container">
    <div class="close_help_win" onclick="show_exite_help(1);"></div>
    <div class="iframe_search_exite_guide">
    <iframe name="exite_help_ifrm" id="exite_help_ifrm" frameborder="no" style="border:0px" allowTranparency="true" src="" width="100%" height="315" scrolling="yes"></iframe>
    <div class="exite_help_bottom_notes">לשאלות נוספות ניתן לכתוב לפנות אלינו בכתובת support@exite.co.il</div>
    </div>
</div>