<?
$LANGS=GetLanguages();
$LANGS="";
if ($SITE_LANG[selected]=="") $SITE_LANG[selected]="he";
if (is_array($LANGS)) {
	?>
	<script language="javascript">
	function changelang() {
		var selected_lang=jQuery('select#langs option:selected').val();
		if (selected_lang=="") selected_lang="he";
		document.location.href="<?=$SITE[url];?>/changelang.php?langID="+selected_lang;
	}
	</script>
	<select id="langs" onchange="changelang()">
	<option  value=''>Language</option>
		<?
		for ($a=0;$a<count($LANGS[LangID]);$a++) {
			$lang_code=$LANGS[LangCode][$a];
			$lang_label=$LANGS[LangLabel][$a];
			if ($lang_code=="") $lang_code="he";
			$lang_id=$LANGS[LangID][$a];
			//if ($SITE_LANG[selected]==$lang_code) print '<option selected value="'.$lang_id.'">'.$lang_label.'</option>';
			print '<option  value="'.$lang_id.'">'.$lang_label.'</option>';
		}
		?>
	
	</select>
<?
}