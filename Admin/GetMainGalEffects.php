<?
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type:text/html; charset=UTF-8");
include_once("../config.inc.php");
$galleryID=$_GET['galID'];
$LS_EFFECTS=array("Sliding from right", "Sliding from left", "Sliding from bottom", "Sliding from top", "Crossfading", "Fading tiles forward", "Fading tiles reverse", "Fading tiles col-forward", "Fading tiles col-reverse", "Fading tiles (random)", "Smooth fading from right", "Smooth fading from left", "Smooth fading from bottom", "Smooth fading from top", "Smooth sliding from right", "Smooth sliding from left", "Smooth sliging from bottom", "Smooth sliding from top", "Sliding tiles to right (random)", "Sliding tiles to left (random)", "Sliding tiles to bottom (random)", "Sliding tiles to top (random)", "Sliding random tiles to random directions", "Sliding rows to right (forward)", "Sliding rows to right (reverse)", "Sliding rows to right (random)", "Sliding rows to left (forward)", "Sliding rows to left (reverse)", "Sliding rows to left (random)", "Sliding rows from top to bottom (forward)", "Sliding rows from top to bottom (random)", "Sliding rows from bottom to top (reverse)", "Sliding rows from bottom to top (random)", "Sliding columns to bottom (forward)", "Sliding columns to bottom (reverse)", "Sliding columns to bottom (random)", "Sliding columns to top (forward)", "Sliding columns to top (reverse)", "Sliding columns to top (random)", "Sliding columns from left to right (forward)", "Sliding columns from left to right (random)", "Sliding columns from right to left (reverse)", "Sliding columns from right to left (random)", "Fading and sliding tiles to right (random)", "Fading and sliding tiles to left (random)", "Fading and sliding tiles to bottom (random)", "Fading and sliding tiles to top (random)", "Fading and sliding random tiles to random directions", "Fading and sliding tiles from top-left (forward)", "Fading and sliding tiles from bottom-right (reverse)", "Fading and sliding tiles from top-right (random)", "Fading and sliding tiles from bottom-left (random)", "Fading and sliding rows to right (forward)", "Fading and sliding rows to right (reverse)", "Fading and sliding rows to right (random)", "Fading and sliding rows to left (forward)", "Fading and sliding rows to left (reverse)", "Fading and sliding rows to left (random)", "Fading and sliding rows from top to bottom (forward)", "Fading and sliding rows from top to bottom (random)", "Fading and sliding rows from bottom to top (reverse)", "Fading and sliding rows from bottom to top (random)", "Fading and sliding columns to bottom (forward)", "Fading and sliding columns to bottom (reverse)", "Fading and sliding columns to bottom (random)", "Fading and sliding columns to top (forward)", "Fading and sliding columns to top (reverse)", "Fading and sliding columns to top (random)", "Fading and sliding columns from left to right (forward)", "Fading and sliding columns from left to right (random)", "Fading and sliding columns from right to left (reverse)", "Fading and sliding columns from right to left (random)", "Carousel", "Carousel rows", "Carousel cols", "Carousel tiles horizontal", "Carousel tiles vertical", "Carousel-mirror tiles horizontal", "Carousel-mirror tiles vertical", "Carousel mirror rows", "Carousel mirror cols", "Turning tile from left", "Turning tile from right", "Turning tile from top", "Turning tile from bottom", "Turning tiles from left", "Turning tiles from right", "Turning tiles from top", "Turning tiles from bottom", "Turning rows from top", "Turning rows from bottom", "Turning cols from left", "Turning cols from right", "Flying rows from left", "Flying rows from right", "Flying cols from top", "Flying cols from bottom", "Flying and rotating tile from left", "Flying and rotating tile from right", "Flying and rotating tiles from left", "Flying and rotating tiles from right", "Flying and rotating tiles from random", "Scaling tile in", "Scaling tile from out", "Scaling tiles random", "Scaling tiles from out random", "Scaling in and rotating tiles random", "Scaling and rotating tiles from out random", "Mirror-sliding tiles diagonal", "Mirror-sliding rows horizontal", "Mirror-sliding rows vertical", "Mirror-sliding cols horizontal", "Mirror-sliding cols vertical");
$LS_3D_EFFECTS=array("Spinning tile to right (180°)","Spinning tile to left (180°)","Spinning tile to bottom (180°)","Spinning tile to top (180°)","Spinning tiles to right (180°)","Spinning tiles to left (180°)","Spinning tiles to bottom (180°)","Spinning tiles to top (180°)","Horizontal spinning tiles random (180°)","Vertical spinning tiles random (180°)","Scaling and spinning tiles to right (180°)","Scaling and spinning tiles to left (180°)","Scaling and spinning tiles to bottom (180°)","Scaling and spinning tiles to top (180°)","Scaling and horizontal spinning tiles random (180°)","Scaling and vertical spinning tiles random (180°)","Spinning rows to right (180°)","Spinning rows to left (180°)","Spinning rows to bottom (180°)","Spinning rows to top (180°)","Horizontal spinning rows random (180°)","Vertical spinning rows random (180°)","Vertical spinning rows random (540°)","Scaling and spinning rows to right (180°)","Scaling and spinning rows to left (180°)","Scaling and spinning rows to bottom (180°)","Scaling and spinning rows to top (180°)","Scaling and horizontal spinning rows random (180°)","Scaling and vertical spinning rows random (180°)","Spinning columns to right (180°)","Spinning columns to left (180°)","Spinning columns to bottom (180°)","Spinning columns to top (180°)","Horizontal spinning columns random (180°)","Vertical spinning columns random (180°)","Horizontal spinning columns random (540°)","Scaling and spinning columns to right (180°)","Scaling and spinning columns to left (180°)","Scaling and spinning columns to bottom (180°)","Scaling and spinning columns to top (180°)","Scaling and horizontal spinning columns random (180°)","Scaling and vertical spinning columns random (180°)","Drunk colums scaling and spinning to right (180°)","Drunk colums scaling and spinning to left (180°)","Turning cuboid to right (90°)","Turning cuboid to left (90°)","Turning cuboid to bottom (90°)","Turning cuboid to top (90°)","Scaling and turning cuboid to right (90°)","Scaling and turning cuboid to left (90°)","Scaling and turning cuboids to right (90°)","Scaling and turning cuboids to left (90°)","Scaling and turning cuboids to bottom (90°)","Scaling and turning cuboids to top (90°)","Scaling and horizontal turning cuboids random (90°)","Scaling and vertical turning cuboids random (90°)","Turning rows to right (90°)","Turning rows to left (90°)","Horizontal turning rows random (90°)","Scaling and turning rows to right (90°)","Scaling and turning rows to left (90°)","Scaling and turning rows to bottom (90°)","Scaling and turning rows to top (90°)","Scaling and horizontal turning rows random (90°)","Scaling and vertical turning rows random (90°)","Scaling and horizontal turning drunk rows to right (90°)","Scaling and horizontal turning drunk rows to left (90°)","Turning columns to bottom (90°)","Turning columns to top (90°)","Vertical turning columns random (90°)","Scaling and turning columns to bottom (90°)","Scaling and turning columns to top (90°)","Scaling and turning columns to right (90°)","Scaling and turning columns to left (90°)","Scaling and horizontal turning columns random (90°)","Scaling and vertical turning columns random (90°)","Scaling and vertical turning drunk columns to right (90°)","Scaling and vertical turning drunk columns to left (90°)","Spinning cuboid to right (180°-large depth)","Spinning cuboid to left (180°-large depth)","Spinning cuboid to bottom (180°-large depth)","Spinning cuboid to top (180°-large depth)","Scaling and spinning cuboids to right (180°-large depth)","Scaling and spinning cuboids to left (180°-large depth)","Scaling and spinning cuboids to bottom (180°-large depth)","Scaling and spinning cuboids to top (180°-large depth)","Scaling and horizontal spinning cuboids random (180°-large depth)","Scaling and vertical spinning cuboids random (180°-large depth)","Scaling and spinning rows to right (180°-large depth)","Scaling and spinning rows to left (180°-large depth)","Scaling and spinning rows to bottom (180°-large depth)","Scaling and spinning rows to top (180°-large depth)","Scaling and horizontal spinning rows random (180°-large depth)","Scaling and vertical spinning rows random (180°-large depth)","Scaling and spinning columns to bottom (180°-large depth)","Scaling and spinning columns to top (180°-large depth)","Scaling and spinning columns to right (180°-large depth)","Scaling and spinning columns to left (180°-large depth)","Scaling and horizontal spinning columns random (180°-large depth)","Scaling and vertical spinning columns random (180°-large depth)");
$hideTumbs=GetGalleryAttribute("HideTumbs",$galleryID);
if ($hideTumbs==1) $hideTumbsCheck="checked";
$EXISTS_EFFECTS_STR=explode("-",GetGalleryAttribute("ExtraEffects",$galleryID));
$EXIST_EFFECTS_2D=explode("2d:", $EXISTS_EFFECTS_STR[0]);
$EXIST_2D_EFFECTS_STR=$EXIST_EFFECTS_2D[1];
$EXIST_2D_EFFECTS=explode("|", $EXIST_2D_EFFECTS_STR);
$EXIST_3D_EFFECTS=array();
$EXIST_EFFECTS_3D=explode("3d:", $EXISTS_EFFECTS_STR[1]);
$EXIST_3D_EFFECTS_STR=$EXIST_EFFECTS_3D[1];
$EXIST_3D_EFFECTS=explode("|", $EXIST_3D_EFFECTS_STR);

?>
<style>
#eXite_OperationBox{-webkit-transition: all 0.5s;transition:all 0.5s}
#eXite_OperationBox{width: 750px;min-height: 300px}
.effects_wrapper {width:750px}
.effects_wrapper h3 {padding:0px;margin: 0px 0px 11px 0px}
.effects_wrapper .left, .effects_wrapper .right {width:250px;float:left;margin:-10px 10px 10px;max-height: 350px;overflow-y: auto;direction: ltr;text-align: left;padding:5px;}
.effects_wrapper .right {float:right;width:320px}
.effects_wrapper ul {list-style-type: none;margin: 0;padding: 0}
.effects_wrapper ul li{white-space:nowrap ;overflow-x: hidden}
.effects_wrapper ul li:hover {background-color:#0b0909;color: white;}
.effects_wrapper #more_options {border-bottom:1px solid silver;width:95%;padding:0px 5px;}
.ls-popup {
	width: 300px;
	height: 150px;
	position: absolute;
	padding: 5px;
	background: white;
	background: rgba(255,255,255,.8);
	border-radius: 7px;
	color: #eee;
	z-index: 156000;
	box-shadow: 0px 5px 30px -5px black;
}
</style>
<script src="http://cdn.exiteme.com/js/ls-preview/doc.js"></script>
<script src="http://cdn.exiteme.com/js/ls-preview/layerslider.transition.gallery.js"></script>

<script>
function setMainGalAttributeProperty(gID,v,p) {
	var url = '<?=$SITE[url];?>/Admin/uploadHeadPic.php';
	var pars = 'uploadtype=setGalleryAttributeProperty&galID='+gID+'&property_type='+p+'&val='+v;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
}
function saveSelectedEffects() {
	var selectedEffects=new Array();
	var selected3DEffects=new Array();
	var hideTumbsChecked=jQuery("input#hideTumbs:checked").length;
	jQuery(".effects_wrapper input[name=EF]:checked").each(function(){
		selectedEffects.push(jQuery(this).val());
	});
	jQuery(".effects_wrapper input[name=EF3D]:checked").each(function(){
		selected3DEffects.push(jQuery(this).val());
	});
	var selectedEffectsSTR='2d:'+selectedEffects.join("|");
	var selectedEffects3DSTR='-3d:'+selected3DEffects.join("|");
	setMainGalAttributeProperty(<?=$galleryID;?>, selectedEffectsSTR+selectedEffects3DSTR, "ExtraEffects");
	setMainGalAttributeProperty(<?=$galleryID;?>, hideTumbsChecked, "HideTumbs");
	showLSEffects(0);
}
</script>
<div class="effects_wrapper">
	<div id="more_options">
		<strong><?=$ADMIN_TRANS['options'];?></strong><br>
		<input type="checkbox" name="hideTumbs" id="hideTumbs" <?=$hideTumbsCheck;?> /> Hide Tumbs & Controls</div>
	<br>
	<div class="left transition-list">
	<h3>2D Effects</h3>
	<ul id="2d">
		<?
		foreach($LS_EFFECTS as $k=>$v) {
			$key=$k+1;
			$ch="";
			if (in_array($key, $EXIST_2D_EFFECTS)) $ch="checked";
			print '<li><input type="checkbox" id="EF" name="EF" value="'.($key).'" '.$ch.'/> <a href="#" rel="tr'.$key.'">'.$v.'</a>';
			print "</li>";
		}
		?>
	</ul>
	</div>
	<div class="right transition-list">
		<h3>3D Effects</h3>
		<ul id="3d">
		<?
		foreach($LS_3D_EFFECTS as $k=>$v) {
			$key=$k+1;
			$ch="";
			if (in_array($key, $EXIST_3D_EFFECTS)) $ch="checked";
			print '<li><input type="checkbox" id="EF3D" name="EF3D" value="'.($key).'" '.$ch.'/> <a href="#" rel="tr'.$key.'">'.$v.'</a>';
			print "</li>";
		}
		?>
	</ul>

	</div>

	
</div>
<div style="clear:both;" align="center">
	<div style="float:left" id="newSaveIcon" onclick="showLSEffects(0);"><?=$ADMIN_TRANS['cancel'];?></div>
	<div style="float:right" id="newSaveIcon" class="greenSave" onclick="saveSelectedEffects()"><?=$ADMIN_TRANS['save changes'];?></div>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
		window.setTimeout('transitionGallery.init();',1000);
});

</script>