<?
header("Cache-Control: no-cache, must-revalidate");
include_once("config.inc.php");

$db=new database();
$db->query("SELECT MenuRichText, CatID from categories WHERE CatID='{$cID}'");
$db->nextRecord();
$richText=$db->getField("MenuRichText");
?>
<div id="popUpRichTextContent" <?if (isset($_SESSION['LOGGED_ADMIN'])) print 'contenteditable="true"';?>><?=$richText;?></div>
<?
if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<script type="text/javascript">
	function savePopupRichText(text_data) {
		var richTextData=encodeURIComponent(text_data);	
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
		var pars = 'action=savePopUpRichText'+'&content='+richTextData+'&catID=<?=$cID;?>';
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
		editorInlneIsinitieted=false;
		//jQuery("div.richTextPopup.show").removeClass('editing_one');
	}
	function initInlineEditor() {
		//CKEDITOR.disableAutoInline = true;
		jQuery("div.richTextPopup.show").addClass('editing_one');
		CKEDITOR.inline('popUpRichTextContent'  ,{
		        on:{
		            blur: function(event){
		                 if (event.editor.checkDirty()) {
		                    savePopupRichText(event.editor.getData());
		                	CKEDITOR.instances.popUpRichTextContent.destroy();
		                }
		            }
		        },
		        customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_galleries.js',
		        filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
				filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images'
		       });
		editorInlneIsinitieted=true;
	}
	jQuery(document).ready(function() {
		jQuery('#popUpRichTextContent').click(function(){if (!editorInlneIsinitieted) initInlineEditor()});
		jQuery('#popUpRichTextContent').blur(function(){editorInlneIsinitieted=false;});
	});
	    </script>
	<?
}
