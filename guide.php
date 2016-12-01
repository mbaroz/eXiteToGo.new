<link rel="stylesheet" type="text/css" href="<?=$SITE['cdn_url'];?>/js/guide/css/style.css">
<link rel="stylesheet" type="text/css" href="<?=$SITE['cdn_url'];?>/js/guide/css/introjs.min.css?time=22">
<script type="text/javascript" src="<?=$SITE['cdn_url'];?>/js/guide/js/intro.min.js"></script>
<style>
.introjs-helperLayer {
  border:0px !important;
  background-color: rgba(255,255,255,0.9) !important;
}
.introjs-tooltiptext, .introjs-tooltipbuttons{direction: rtl;font-size:17px;line-height: 1.4}
.introjs-button{font-size:17px;padding:8px;margin:5px;direction: rtl;font-family: almoni-dl-aaa-400}
.introjs-prevbutton, .introjs-nextbutton, .introjs-skipbutton {border-radius:0;}
.introjs-tooltip{font-family: almoni-dl-aaa-400;margin:15px;min-width: 270px}
.introjs-helperNumberLayer{bottom:-16px;top:auto;}
.introjs-button.introjs-skipbutton{color:inherit;}
</style>
<script type="text/javascript">
jQuery(function(){
  var introguide = introJs();
  // var startbtn   = $('#startdemotour');
 
  introguide.setOptions({
 	nextLabel:'<?=($SITE_LANG['selected']=='de') ? 'Nächstes' :'הבא';?>',
  	prevLabel:'<?=($SITE_LANG['selected']=='de') ? 'Vorheriges' :'הקודם';?>',
  	skipLabel: '<?=($SITE_LANG['selected']=='de') ? 'Anleitung überspringen' :'דלג על המדריך';?>',
  	doneLabel: '<?=($SITE_LANG['selected']=='de') ? 'Ich habe es verstanden, Anleitung verlassen.' :'הבנתי, צא מהסיור המודרך';?>',
    steps: [
    {
      element: '.AdminTopMenu',
      intro: '<?=($SITE_LANG['selected']=='de') ? 'Willkommen auf Ihrer neuen Webseite. Diese obere Leiste wird verwendet, um allgemeine Einstellungen der Webseite, Farben und Stil-Optionen, Text- und Link-Stile festzulegen.
' :'ברוכים הבאים, זהו בר הניהול באתר שלכם מכאן תוכלו להגיע למסך הגדרות כלליות,שינוי צבעים באתר,עיצוב טקסטים וקישורים';?>',
      position: 'bottom'
   	},
    {
      element: '.topHeaderLogo',
      intro: '<?=($SITE_LANG['selected']=='de') ? 'Dies ist Ihr Logo, bewegen Sie die Maus über das Logo, um es zu ändern oder verwenden Sie einfach ein textbasiertes Logo.
' :'כאן נמצא הלוגו של האתר שלכן, מעבר עכבר עליו יאפשר לכם להעלות לוגו אחר או להשתמש בכתיבת לוגו טקסטואלי';?>',
      position: '<?=$SITE[opalign];?>'
   	},
    {
      element: '.topMenuNew',
      intro: '<?=($SITE_LANG['selected']=='de') ? 'Das ist das Hauptnavigationsmenü Ihrer Webseite, hier können Sie Inhalte und Namen ändern oder unerwünschte Inhalte entfernen.
' :'זהו התפריט ניווט הראשי של האתר. מעבר על כל פריט יאפשר לכם לערוך את שם התפריט או למחוק אותו';?>',
      position: 'bottom'
   	},
    {
      element: '.topMainPic',
      intro: '<?=($SITE_LANG['selected']=='de') ? 'Dies ist der Hauptbanner der Seite, es kann ein Foto enthalten oder Sie können es zu einer Slide-Galerie für jede bestehende Seite ändern.
' :'אזור תמונת ראשית לאתר ולעמוד, אזור זה מאפשר לכם להעלות תמונה או מספר תמונות';?>',
      position: 'bottom'
   	},
    <?
    if ($P_DETAILS[PageStyle]!=1) {
      ?>
      {
        element: '.rightSide',
        intro: '<?=($SITE_LANG['selected']=='de') ? 'Dies sind die Untermenüs für die Unterseiten. Untermenüs beziehen sich auf den jeweiligen Hauptmenüpunkt, auf dem Sie sich befinden. Sie können auf jeder Seite individuell auswählen, ob Sie ein Untermenü bevorzugen oder lieber ein Nachrichten-Scroll-Feld anzeigen lassen möchten. Darüber hinaus können Sie einen Rich-Text in den oberen oder unteren Rand dieses Abschnitts einfügen.  
' :'אזור תתי עמודים באתר. כאן יוצגו תתי העמודים בהתאם לעמוד הראשי בו אתם נמצאים, באפשרותכם להגדיר בכל עמוד שיוצגו באזור זה חדשות ו/או תוכן עשיר בחלק העליון והחלק התחתון של האזור';?>',
        position: '<?=$SITE[opalign];?>'
     	},
      <?
      }
      ?>
   	{
      element: '.mainContent',
      intro: '<?=($SITE_LANG['selected']=='de') ? 'Dies ist der Hauptinhalts-Bereich der Seite, hier können Sie aus verschiedenen Vorlagen diese auswählen, die Sie auf den jeweiligen Seiten anzeigen möchten. Zusätzlich können Sie die Struktur des Hauptinhalts ändern, um ein, zwei oder drei Spalten einzufügen. All dies kann auf den Seiteneinstellungen auf dem unteren linken Symbol vorgenommen werden.
' :'אזור התוכן המרכזי בעמוד, זה המקום בו יוצג התוכן המרכזי בעמוד, באפשרותכם לשנות את התבנית ומבנה העמוד על ידי כניסה להגדרות עמוד באייקון מימין';?>',
      position: 'top'
   	}
   	,
   	{
      element: '.admin_settings .fa',
      intro: '<?=($SITE_LANG['selected']=='de') ? 'Seiteneinstellungen – hier können Sie die Seitenstruktur, die Vorlage für den Inhalt und die SEO-Einstellungen für die Meta-Tags und den optionalen Code für jede Seite, festlegen. Zusätzlich haben Sie die Möglichkeit Widgets für Soziale Netzwerke auf den gewünschten Seiten anzubringen.
' :'הגדרות העמוד - כאן ניתן לקבוע את מבנה ותבנית התוכן בעמוד,תגיות META, ותוספי רשתות חברתיות';?>',
      position: '<?=$SITE[opalign];?>'
   	},
   	{
      element: '.adminAction .add.newpage',
      intro: '<?=($SITE_LANG['selected']=='de') ? 'Das Symbol (+) ermöglicht es Ihnen, neue Hauptseiten oder Unterseiten zu Ihrer Webseite hinzuzufügen.
' :'הוספת עמוד חדש - לחיצה כאן תאפשר לכם להוסיף עמוד ראשי או משני באתר';?>',
      position: '<?=$SITE[opalign];?>'
   	}
    ]
  });
  introguide.start();


});
</script>
<?

$MEMBER_GUIDE_SHOWN['guide_activated']=1;
$MEMBER[FAILS]=json_encode($MEMBER_GUIDE_SHOWN);
$_SESSION['MEMBER']=$MEMBER;
$db=new database();
$db->query("UPDATE admins SET FAILS='{$MEMBER[FAILS]}' WHERE UID='{$MEMBER[UID]}'");
mysqli_close();
?>