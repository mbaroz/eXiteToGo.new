<?
$google_plus_lang="en-US";
if (($SITE_LANG[selected]=="" OR $SITE_LANG[selected]=="he") AND ($default_lang=="he")) {
	$google_plus_lang="iw";
}
function AddGoogleWidget($type=1) {
    global $google_plus_lang;
    $scriptCode='<script type="text/javascript" src="https://apis.google.com/js/plusone.js">';
    $scriptCode.="{lang: '".$google_plus_lang."'}>";
    $scriptCode.='</script>';
    switch ($type) {
        case 1:
             $srcCode="<g:plusone></g:plusone>";
             $srcCode.=$scriptCode;
            break;
        default:
        break;
        
    }
    return $srcCode;
    
}
?>
<div style="float:<?=$SITE[align];?>">
<?
if ($SITE[g_integration]) $P_DETAILS[G_WIDGET]=$SITE[g_integration];
print AddGoogleWidget($P_DETAILS[G_WIDGET]);
?>
</div>