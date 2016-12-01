<?
include_once("../config.inc.php");
$MESSAGE['copyPage']['he']="עמוד התוכן הועתק לזכרון.<br>על מנת להדביק את התוכן והתמונות בעמוד אחר נווטו לעמוד היעד";
$MESSAGE['copyPage']['en']="The Current template have been copied to clipboard.<br>To paste the content in other page navigate to the desired page and use the Paste Content button";
$MESSAGE['mainpicHeightErr']['he']="התמונה שהועלתה גבוהה מדיי יש להעלות תמונה בגובה מקסימלי של 800 פיקסלים";
$MESSAGE['mainpicHeightErr']['en']="The Photo you have uploaded is too high, maximum photo height is 800 pixels.";

switch($_GET['messageAction']) {
    case 'copyPage':
        print $MESSAGE['copyPage'][$SITE_LANG[selected]];
        break;
     case 'pastePage':
        print "paste_0";
        break;
     case 'mainpicHeightErr':
       print $MESSAGE['mainpicHeightErr'][$SITE_LANG[selected]];
       
        break;
    default:
        print "Hey... there are no messages!";
        break;
        
}
?>