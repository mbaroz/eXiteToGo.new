<?
function PickColor($elName,$val) {
	global $SITE;
	?>
	<link href="<?=$SITE[url];?>/Admin/colourmod/ColourModStyle.css" rel="stylesheet" type="text/css" />
	<script src="<?=$SITE[url];?>/Admin/colourmod/StyleModScript.js" type="text/JavaScript"></script>
	<script src="<?=$SITE[url];?>/Admin/colourmod/ColourModScript.js" type="text/JavaScript"></script>
	<script language="javascript">
	function t() {

	}
	</script>
	
	<div id="ColourMod" dir="ltr">
	<div id="cmDefault" dir="ltr">
		<div id="cmColorContainer" class="cmColorContainer" dir="ltr"></div>
		<div id="cmSatValBg" class="cmSatValBg" dir="ltr"></div>
		<div id="cmDefaultMiniOverlay" class="cmDefaultMiniOverlay" dir="ltr"></div>
		<div id="cmSatValContainer"  dir="ltr">
			<div id="cmBlueDot" class="cmBlueDot" dir="ltr"></div>
		</div>
		<div id="cmHueContainer"  dir="ltr">
			<div id="cmBlueArrow" class="cmBlueArrow" dir="ltr" align="justify"></div>
		</div>
		<div id="cmClose" dir="ltr">
			<input type="text" name="cmHex" id="cmHex" value="FFFFFF" maxlength="6" size="9" /> <a href="#" id="cmCloseButton" onclick="t();" ><img src="<?=$SITE[url];?>/Admin/colourmod/images/close.gif" border="0" alt="Close ColourMod" /></a>
		</div>
		<div style="display:none" dir="ltr">
			<input type="text" name="cmHue" id="cmHue" value="0" maxlength="3" />
		</div>
	</div>
	</div>
	<input class="StyleEditFrm" style="background-color:#fff" type="text" name="<?=$elName;?>" id="<?=$elName;?>" value="<?=$val;?>">
	<a href="#" onclick="pickcolor('.demoBG', 'color', '', '<?=$elName;?>', this);">
	<div style="display:inline-block;background:#<?=$val;?>;width:15px;height:15px;border:1px solid silver"></div>
	</a>
	<?
}