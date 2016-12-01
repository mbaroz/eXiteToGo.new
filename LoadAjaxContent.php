<?
include_once("config.inc.php");
session_start();
if (isset($_SESSION['mobilePreview'])) unset($_SESSION['LOGGED_ADMIN']);
switch($type) {
    case 'contact':
        $db=new database();
        $db->query("SELECT UrlKey from categories WHERE UrlKey LIKE '%contact-our%' OR UrlKey LIKE '%contact-us%' OR UrlKey LIKE '%צור-קשר%' OR UrlKey LIKE '%צרו-קשר%'");
        $db->nextRecord();
        $urlKey=$db->getField("UrlKey");
        include_once("round_corners.inc.php");
        include_once("customFormPage.php");
        ?>
        <style>
            #boxes li {
                width:100%;
                margin-right:0px;
                margin-left:0px;
                padding:0 0 0 0;
            }
            ul#boxes {
                margin:0px;
            }
            #contact_layer input.frm_button {font-size:1em;border:0px;border-radius:0;width:100% !important}
            #contact_layer input.frm_button[type='reset'] {display: none;}
            #contentForm {margin-<?=$SITE[opalign];?>:20px;margin-<?=$SITE[align];?>:0px;}
            #contentForm #contact_layer, .formInput {width:100%;outline:none;zoom:1;min-height:25px}
            #contact_layer select.formInput {width:102.5%;}
            #contact_layer #inputs label {color:#<?=$SITE[mobilefootericonscolor];?>;}
            
        </style>
        <script>
                function rwdInsideForms() {
                       jQuery("#contact_layer input.frm_button").width(jQuery("#contact_layer .formInput").width()-20+"px");
                       jQuery("#contact_layer input.customFormDate").attr("readonly","true");
                       jQuery("#inputs div>label").each(function() {
                           var input_label=jQuery(this).text();
                           if (input_label.indexOf("טלפון")!==-1) {
                               jQuery("#"+jQuery(this).attr("for")).attr("type","number");
                               jQuery("#"+jQuery(this).attr("for")).attr("pattern","[0-9]*");
                           }
                           if (input_label=="אימייל")   jQuery("#"+jQuery(this).attr("for")).attr("type","email");
                               
                       });
                       jQuery("input[name='from_uri']").val(encodeURIComponent(top.location));
               }
            rwdInsideForms();
        </script>
        <?
        break;
    case "map":
        $waze_label="Send to waze";
        if ($SITE_LANG[selected]=="he") $waze_label="נווט עם Waze"
        ?>
        <style>
            .waze_icon {
                background: url('http://cdn.exiteme.com/images/waze_icon.png') no-repeat;
                background-size:auto 50px;
                background-position: 10% top;
                width:100%;height:40px;
                font-size:1.5em;
                text-align: center;
                font-family:arial;
                padding:10px;
                
                }
                .waze_icon a {
                    display: block;
                    height: 100%;
                    text-decoration:none;
                    color:white;
                    margin-top:0px;
                    padding:0px 0px 0px 60px;
                }
                .waze_arrow_button {color:#333333;background: #efefef;font-weight:bold;float:right;font-size:1.5em;font-family:arial;margin-top:-5px;direction: ltr;margin-right:10px;}
        </style>
        <div style="width:99%;"><iframe width="100%" height="320" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&source=s_q&hl=he&geocode=&q=<?=urlencode($SITE[bizaddress]);?>&ie=UTF8&z=15&t=m&iwloc=addr&output=embed"></iframe><br></div>
        <div style="clear: both"><br></div>
                    <div class="waze_icon"><a href="waze://?q=<?=$SITE[bizaddress];?>">Send to WAZE
                    <div class="exite circle_arrow waze_arrow_button">›</div>
                    </a></div>
        
        <?
        break;
    case "countCalls":
        $db=new database();
        $db->query("UPDATE config SET VarValue=VarValue+1 WHERE VarName='SITE[mobileCallCount]'");
        break;
        
    default:
    break;
}
if (isset($_SESSION['MEMBER'])
isset($_SESSION['MEMBER'])
isset($_SESSION['MEMBER'])
isset($_SESSION['mobilePreview'])) session_register('LOGGED_ADMIN');
?>

