<?
function AddSetting($obj=null,$Head=0) {
	if (!is_array($obj)) return false;
	if ($Head==1) $out="<table>";
	foreach ($obj as $key => $value) {
		$labelFor=$value['id'];
		$class=$value['class'];
		if ($value['type']=="color") {
			$value['type']="text";
			$class="pick";$labelFor="picker";
		}
		$isChecked="";
		if ($value['type']=="checkbox") {
			$isChecked=$value['Defvalue'];
			$value['Defvalue']="";

		}
		$slider_html='';
		if ($value['slider']) $slider_html='<div class="s_slider" data-input="'.$value['id'].'" data-css-class="'.$value['css-class'].'" data-css-prop="'.$value['css-prop'].'" data-max-val="'.$value['max-val'].'"></div>';
		$out.='<tr><td style="width:50%"><lable for="'.$labelFor.'">'.$value['Label'].'</label></td><td>'.$value['icon'].' <input type="'.$value['type'].'" class="'.$class.'" value="'.$value['Defvalue'].'" name="'.$value['id'].'" id="'.$value['id'].'" style="width:80px" '.$isChecked.' data-css-class="'.$value['css-class'].'" data-css-prop="'.$value['css-prop'].'">'.$value['postLabel'].$slider_html.'</td></tr>';
	}
	if ($Head==1) $out.="</table>";
	return $out;
}
?>