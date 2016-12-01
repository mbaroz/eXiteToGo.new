<?
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type:text/html; charset=UTF-8");

include_once("../config.inc.php");
include_once("../defaults.php");

$ADMIN_TRANS=$_SESSION['ADMIN_TRANS'];

//die("Ok we got here!!");
?>
<style>
#boxesmainGal  {
		font-family: Arial, sans-serif;
		list-style-type: none;
		margin: 0px;
		margin-<?=$SITE[align];?>: 0px;
		padding: 0px;
		
	}
#boxesmainGal li {
		float: <?=$SITE[align];?>;
		margin:0px 0 15px;
		width: 400px;
		cursor: move;

	}
.gal_photoHolder {
	border:0px;
	height: 120px;
	background-repeat: no-repeat;	
	background-size: cover;
	background-position: center;
	background-color: white;
	box-shadow: 0px 0px 10px -4px #666;

}
.gal_photoHolder:hover {opacity: 0.85}
.gal_photoHolder img {
	border:1px;
}
#newSaveIcon.mainPicEditSMALLDD {
	padding:5px 10px;
}
.newSaveIcon.mainGalPicEditing  {
	margin-<?=$SITE[opalign];?>:160px;
}
#boxesmainGal .gal_photoHolder .video_admin_preview {
	text-align: center;
	overflow: hidden;
	color:silver;
	opacity: 0.8;
	position: absolute;
	width:400px;
	
}
#boxesmainGal .gal_photoHolder.video {
	background-color: #555;
	background-size: inherit;
}
</style>
<ul id="boxesmainGal">
<?
$gallery_dir=$SITE_LANG[dir].$gallery_dir;
$GAL=GetCatGallery($urlKey,4);
if (!is_array($GAL[PhotoID])) $GAL=GetCatGallery($urlKey,100);
for ($a=0;$a<count($GAL[PhotoID]);$a++){
		
		?>
		<li id="photoGal_cell-<?=$GAL[PhotoID][$a];?>">
			<?
			$file_extension=end(explode(".", $GAL[FileName][$a]));
			if ($file_extension=="mp4") {
				?>
				
					<div title="<?=$GAL[PhotoText][$a];?>" class="gal_photoHolder video" style="background-image:url('<?=$SITE[url];?>/images/video-bot-circle.png');">
				<?
			}
			else {
				?>
				<div title="<?=$GAL[PhotoText][$a];?>" class="gal_photoHolder" style="background-image:url('<?=SITE_MEDIA;?>/<?=$gallery_dir;?>/tumbs/<?=$GAL[FileName][$a];?>');">
				<?
			}
			?>
			
				<div id="newSaveIcon" class="mainPicEditSMALLDD" style="position:relative;z-index:4000" onclick="jQuery('#editMainPhotoTumb_<?=$a;?>').toggle()">
					<i class="fa fa-angle-down"></i> | <?=$ADMIN_TRANS['edit photo'];?>
				</div>
				<div class="newSaveIcon mainGalPicEditing" style="display:none;height:auto;margin-top:0px" id="editMainPhotoTumb_<?=$a;?>">
						<div class="photoEditDropDown" onclick="EditGalPhotoDetails('<?=urldecode($GAL[PhotoUrl][$a]);?>','<?=htmlspecialchars($GAL[PhotoText][$a]);?>',<?=$GAL[PhotoID][$a];?>,'<?=$GAL[PhotoExtraEffect][$a];?>')"><i class="fa fa-edit"></i> <?=$ADMIN_TRANS['edit photo'];?></div>
						<div class="photoEditDropDown" onclick="DelMainPicGalPhoto(<?=$GAL[PhotoID][$a];?>)"><i class="fa fa-trash-o"></i> <?=$ADMIN_TRANS['delete photo'];?></div>
						<div class="photoEditDropDown" onclick="editMainPicRichText(<?=$GAL[PhotoID][$a];?>)"><i class="fa fa-align-right"></i> <?=$ADMIN_TRANS['edit rich content'];?></div>
				</div>
			<?	
			//if (strlen($GAL[PhotoText][$a])>90) $GAL[PhotoText][$a]=substr($GAL[PhotoText][$a],0,90)."...";
			$GAL[PhotoText][$a]=trim($GAL[PhotoText][$a]);
			?>
				<div class="photoName"><?=$GAL[PhotoText][$a];?></div>
			</div>
		</li>
		<?
	}
	?>
</ul>
<script>


</script>

