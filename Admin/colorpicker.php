<?
function PickColor($elName,$val,$event="",$onEvent="") {
	global $SITE;
	$colorElement="color".$elName;
	$event_pick="";
	if ($event) $event_pick=$onEvent.'="'.$event.'"';
	?>
	<input class="StyleEditFrm"  type="text" name="<?=$elName;?>" id="<?=$elName;?>" value="<?=$val;?>" <?=$event_pick;?>>
	<input readonly id="<?=$colorElement;?>" onmousedown="createPicker('<?=$elName;?>','<?=$colorElement;?>')" style="background:#<?=$val;?>;width:15px;height:15px;border:1px solid silver">
	<?
}