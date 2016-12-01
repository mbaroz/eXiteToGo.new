<?
function SetRoundedCorners($top_bottom=1,$topHead_round=0,$color="fff",$height_bottom=false) {  //Top=1, bottom=0
	if ($height_bottom===false) $height_bottom="default";
	else $height_bottom=$height_bottom."px";
	if ($color=="") $color="transparent";
	else $color="#".$color;
	if ($top_bottom==1) {
		$html_out='<div class="roundBox" align="left">
			<div class="round_top"></div>
			<b class="b1" style="background-color:'.$color.'"></b>
			<b class="b2" style="background-color:'.$color.'"></b>
			<b class="b3" style="background-color:'.$color.'"></b>
			<b class="b4" style="background-color:'.$color.'"></b>
			</div>';
	}
	else {
		$html_out='<div class="roundBox">';
		if ($topHead_round==1) $html_out.='<div class="round_bottom" style="background-color:'.$color.';height:'.$height_bottom.'"></div><div class="round_top" style="background-color:'.$color.'"></div>';
		$html_out.='<b class="b4" style="background-color:'.$color.'"></b>
		
		<b class="b3" style="background-color:'.$color.'"></b>
		<b class="b2" style="background-color:'.$color.'"></b>
		<b class="b1" style="background-color:'.$color.'"></b>
		</div>';
	}
	
	print $html_out;
}
function SetSideRoundedCorners($top_bottom=1,$topHead_round=0,$color="fff") {  //Top=1, bottom=0
	
	if ($color=="") $color="transparent";
	else $color="#".$color;
	if ($top_bottom==1) {
		$html_out='<div class="side_roundBox" align="left">
			<div class="round_top"></div>
			<b class="b1" style="background-color:'.$color.'"></b>
			<b class="b2" style="background-color:'.$color.'"></b>
			<b class="b3" style="background-color:'.$color.'"></b>
			<b class="b4" style="background-color:'.$color.'"></b>
			</div>';
	}
	else {
		$html_out='<div class="side_roundBox">';
		if ($topHead_round==1) $html_out.='<div class="round_bottom"></div><div class="round_top"></div>';
		$html_out.='<b class="b4" style="background-color:'.$color.'"></b>
		
		<b class="b3" style="background-color:'.$color.'"></b>
		<b class="b2" style="background-color:'.$color.'"></b>
		<b class="b1" style="background-color:'.$color.'"></b>
		</div>';
	}
	
	print $html_out;
}
function SetMiddleRoundedCorners($top_bottom=1,$topHead_round=0,$color="fff") {  //Top=1, bottom=0
	
	if ($color=="") $color="transparent";
	else $color="#".$color;
	if ($top_bottom==1) {
		$html_out='<div class="middle_roundBox" align="left">
			<div class="round_top"></div>
			<b class="b1" style="background-color:'.$color.'"></b>
			<b class="b2" style="background-color:'.$color.'"></b>
			<b class="b3" style="background-color:'.$color.'"></b>
			<b class="b4" style="background-color:'.$color.'"></b>
			</div>';
	}
	else {
		$html_out='<div class="middle_roundBox">';
		if ($topHead_round==1) $html_out.='<div class="round_bottom"></div><div class="round_top"></div>';
		$html_out.='<b class="b4" style="background-color:'.$color.'"></b>
		
		<b class="b3" style="background-color:'.$color.'"></b>
		<b class="b2" style="background-color:'.$color.'"></b>
		<b class="b1" style="background-color:'.$color.'"></b>
		</div>';
	}
	
	print $html_out;
}
function SetSearchDivRoundedCorners($top_bottom=1,$topHead_round=0,$color="fff") {  //Top=1, bottom=0
	
	if ($color=="") $color="transparent";
	else $color="#".$color;
	if ($top_bottom==1) {
		$html_out='<div class="search_roundBox" align="left">
			<div class="round_top"></div>
			<b class="b1" style="background-color:'.$color.'"></b>
			<b class="b2" style="background-color:'.$color.'"></b>
			<b class="b3" style="background-color:'.$color.'"></b>
			<b class="b4" style="background-color:'.$color.'"></b>
			</div>';
	}
	else {
		$html_out='<div class="search_roundBox">';
		if ($topHead_round==1) $html_out.='<div class="round_bottom"></div><div class="round_top"></div>';
		$html_out.='<b class="b4" style="background-color:'.$color.'"></b>
		
		<b class="b3" style="background-color:'.$color.'"></b>
		<b class="b2" style="background-color:'.$color.'"></b>
		<b class="b1" style="background-color:'.$color.'"></b>
		</div>';
	}
	
	print $html_out;
}
function SetShortContentRoundedCorners($top_bottom=1,$topHead_round=0,$color="fff",$width=0) {//Top=1, bottom=0
	if ($color=="") $color="transparent";
		else $color="#".$color;
	if ($top_bottom==1) {
		$html_out='<div class="short_content_roundBox" style="width:'.$width.'px;clear:'.$clear.'" align="left">
			<div class="round_top" style="height:0px"></div>
			<b class="b1" style="background-color:'.$color.'"></b>
			<b class="b2" style="background-color:'.$color.'"></b>
			<b class="b3" style="background-color:'.$color.'"></b>
			<b class="b4" style="background-color:'.$color.'"></b>
			</div>';
	}
	else {
		$html_out='<div class="short_content_roundBox" style="width:'.$width.'px;clear:both;height:4px">';
		if ($topHead_round==1) $html_out.='<div class="round_bottom"></div><div class="round_top"></div>';
		$html_out.='<b class="b4" style="background-color:'.$color.'"></b>
		
		<b class="b3" style="background-color:'.$color.'"></b>
		<b class="b2" style="background-color:'.$color.'"></b>
		<b class="b1" style="background-color:'.$color.'"></b>
		</div>';
	}
	
	print $html_out;
}
?>