<?
//Form Generator function
function GenerateForm($E,$OPTION,$FRM,$NUMCOLS,$align,$falign){
	if ($falign=="right") $opalign="left";
	else $opalign="right";
	?>
	<div align="<?=$align;?>">
	<form name="<?=$FRM[frmName];?>" id="<?=$FRM[frmName];?>" method="<?=$FRM[frmMethod];?>" action="<?=$FRM[frmAction];?>" enctype="multipart/form-data" target="<?=$FRM[frmTarget];?>" onsubmit="<?=$FRM[submitaction];?>">
	<table border="0"  cellspacing="0" cellpadding="2" class="general">
	<?
	$numRows=count($E[Label]);
	$numLines=ceil($numRows/$NUMCOLS);
	$b=0;
	for ($a=0;$a<$numRows;$a++) {	
		
		$tabIndex=1+(floor($a/$NUMCOLS))+$numLines*(fmod($a,$NUMCOLS));
		IF (fmod($a,$NUMCOLS)==0) {
			print "<tr>";
		}
		$CloseStrInput="";
		switch ($E[Type][$a]){
			case "select":
			$b=$b+1;
			$strInput="<select Name='".$E[Name][$a]."' class=".$E[CLS][$a]." ".$E[Status][$a]." tabindex=".$tabIndex.">";
			for ($i=0;$i<count($OPTION[Value][$b]);$i++) {
				if ($OPTION[Value][$b][$i]==$OPTION[Selected][$b]) $strInput.="<option selected value='".$OPTION[Value][$b][$i]."'>".$OPTION[Text][$b][$i]."</option>";
					else $strInput.="<option value='".$OPTION[Value][$b][$i]."'>".$OPTION[Text][$b][$i]."</option>";
			}
			$strInput.="</select>";
			break;
			case "textarea":
			$strInput="<textarea Name='".$E[Name][$a]."' ".$E[Status][$a]." tabindex=".$tabIndex." class=".$E[CLS][$a].">".$E[Value][$a]."</textarea>";
			break;
			case "file":
			$strInput="<input ".$E[Status][$a]." name='".$E[Name][$a]."' type='".$E[Type][$a]."' class='".$E[CLS][$a]."' tabindex='".$tabIndex."'>";
			break;
			default:
			$strInput="<input ".$E[Status][$a]." name='".$E[Name][$a]."' type='".$E[Type][$a]."' value='".$E[Value][$a]."' class='".$E[CLS][$a]."' tabindex='".$tabIndex."'>";
			break;
		} //End Switch
 	?>
			<td class="Fields" align="<?=$align;?>"><?=$E[Label][$a];?>: </td>
			<td class="general" align="<?=$falign;?>"><?=$strInput;?></td>
			
	<?
	} //end for

print "</tr></table></div>";
//print "</form>";
}
?>
