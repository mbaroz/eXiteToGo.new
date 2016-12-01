<?
//General Config Form
include_once("checkAuth.php");
include("colorpicker.php");
include_once("AmazonUtil.php");
require_once '../inc/CustomForm.inc.php';
$db=new Database();
if ($_POST['history_id'] AND isset($_SESSION['LOGGED_ADMIN'])) {
	$remark_value=strip_tags($_POST['remark']);
	if ($remark_value!="") {
		$db->query("SELECT data from custom_forms_history WHERE id={$_POST['history_id']}");
		$db->nextRecord();
		$unserialize_data=unserialize($db->getField('data'));
		$unserialize_data['hist_remarks']=$remark_value;
		updateFormHistory($_POST['history_id'],$unserialize_data);
		print $remark_value;
	}
	die();
} 
?>
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<script src="<?=$SITE['cdn'];?>/js/jquery.jeditable.mini.js"></script>
<script>
function loadFormDetails(f_file) {
	jQuery(".leftAdmin .inside").load("<?=$PHP_SELF;?>?"+f_file);
}
</script>
<style type="text/css">

table.maincolor tr td {
	border-<?=$SITE[opalign];?>:1px solid silver;
	border-bottom:1px solid silver;
}

table.maincolor tr td table tr td{
	border:0;
}
table.maincolor tr.total-view {
	font-weight:bold;
	font-size:14px;
	background: #e9e9e9;
	color:#000;
}

.button_top {
	font-family: Arial;
	height:30px;
	color:#ffffff;
	background-color: #4D90FE;
	background-image: -webkit-linear-gradient(top,#4D90FE,#4787ED);
	background-image: -moz-linear-gradient(top,#4D90FE,#4787ED);
	background-image: -ms-linear-gradient(top,#4D90FE,#4787ED);
	background-image: -o-linear-gradient(top,#4D90FE,#4787ED);
	background-image: linear-gradient(top,#4D90FE,#4787ED);
	border: 1px solid #3079ED;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
	cursor: pointer;
	font-size: 11px;
	font-weight: bold;
	text-align: center;
	outline: 0;
	padding: 0 3px;
	float:<?=$SITE[align];?>;
	margin:10px;
}
.button_text{
	line-height:30px;
	vertical-align: top;
}
.button_top a{
	text-decoration: none;
	color: inherit
}
.excel {
	color:green;
	background-color: #e7e7e7;
	background-image: -webkit-linear-gradient(top,#e7e7e7,#e6e6e6);
	background-image: -moz-linear-gradient(top,#e7e7e7,#e6e6e6);
	background-image: -ms-linear-gradient(top,#e7e7e7,#e6e6e6);
	background-image: -o-linear-gradient(top,#e7e7e7,#e6e6e6);
	background-image: linear-gradient(top,#e7e7e7,#e6e6e6);
	border: 1px solid #d4d4d4;
}

#date_from,#date_to {
	background:url(/images/calendar_icon.png) no-repeat <?=$SITE[opalign];?> center;
}
.form_row_remarks {
	min-width:210px;
	width:210px;
	font-size: 13px;
}
.form_row_remarks i.fa:hover{background-color: green;color:white;}
.form_row_remarks i.fa {transition:all 0.4s;float:right;margin:15px 0px 0px 5px;border:1px solid #333;border-radius: 100%;cursor: pointer;padding:2px;}
.form_row_remarks textarea {border:0px;padding:6px;outline: none;font-size: inherit;border:1px solid orange;}
</style>
<br/><br/>
<div style="padding-top:5px;overflow:visible;direction:<?=($SITE[align] == 'left') ? 'ltr' : 'rtl';?>;">
<?


if(@$_GET['formID'] > 0) {
	
	$db = new Database();
	$formID = intval($_GET['formID']);
	$db->query("
		SELECT
			`custom_forms`.*,
			IF(`custom_forms`.`formName` = '',`categories`.`MenuTitle`,`custom_forms`.`formName`) AS `formName`,
			`categories`.`UrlKey`
		FROM
			`custom_forms`
		INNER JOIN
			`categories` USING(`CatID`)
		WHERE
			`custom_forms`.`formID`='{$formID}'
	");
	if(!$db->nextRecord())
		die;
	
	$form = $db->record;
	
	$inputs = getFormInputs(intval($_GET['formID']));
	global $AWS_S3_ENABLED;

	if(is_array($_POST['delHistory']))
	{
		$ids = implode(',',$_POST['delHistory']);
		$find_files = false;
		foreach($inputs as $input)
			if($input['inputType'] == 'file')
				$find_files = true;
			
		if($find_files)
		{
			$db->query("SELECT * FROM `custom_forms_history` WHERE `id` IN({$ids})");
			while($db->nextRecord())
			{
				$history = $db->record;
				$data = unserialize($history['data']);
				foreach($inputs as $input)
				{
					if($input['inputType'] == 'file' && $data['input_'.$input['inputID']] != '')
					{
						$fl_loc = substr($data['input_'.$input['inputID']],strlen($SITE[url].'/'));
						if($AWS_S3_ENABLED){
							DeleteImageFromAmazon($fl_loc);
						}
						else{
							@unlink('../'.$fl_loc);
						}
					}
				}	
			}
		}
		$db->query("DELETE FROM `custom_forms_history` WHERE `id` IN({$ids})");
	}

	$page = (isset($_GET['page'])) ? intval($_GET['page']) : 1;
	if($page < 1)
		$page = 1;
	$limit = 50;
	$offset = ($page-1)*$limit;
	
	?>
	
	<script type="text/javascript">
		
		jQuery(document).ready(function() { 
		    var options = { 
		        target:        '.leftAdmin .inside', 
		        success:       function(){}  // target element(s) to be updated with server response 
		        

		    }; 
		   	jQuery('#searchFrm, #frmAllList').ajaxForm(options); 

		   	jQuery(function(){
			
			jQuery('#date_from,#date_to').datepicker({
					dateFormat: 'dd.mm.yy'
			});
			
			if(jQuery('.leftAdmin .inside').width()-300 < (jQuery('#historyTable').width()+20))
			{
				//jQuery('.leftAdmin .inside').width(jQuery('#historyTable').width()-210);
				var isIE = /*@cc_on!@*/false;
				var coef = (isIE) ? <?=($SITE[align] == 'left') ? '1 : -1' : '-1 : 1';?>;
				window.scrollBy(coef*(jQuery('.adminBody').width()),0);
			}

		});

		 jQuery('.form_row_remarks').editable('<?=$PHP_SELF;?>?saveRemarks=w', {
	         type      : 'textarea',
	         submit: '<i class="fa fa-check"></i>',
	         indicator : '<i class="fa fa-spinner"></i>',
	         tooltip   : 'Click to add remarks',
	         width: '170',
	         rows:'2',
	         id:'history_id',
	         name:'remark'

	     });
		}); 
	</script>
	<form action="formHistoryAdmin.php" method="get" name="searchFrm" id="searchFrm" style="float:right">
		<input type="hidden" name="search" value="1" />
		<input type="hidden" name="formID" value="<?=intval($_GET['formID']);?>" />
		<?=$ADMIN_TRANS['search query'];?>:&nbsp;
		<input type="text" class="ConfigAdminInput" name="search_query" style="width:150px;" value="<?=@$_GET['search_query'];?>" />
		&nbsp;<?=$ADMIN_TRANS['from'];?>:&nbsp;
		<input type="text" class="ConfigAdminInput" id="date_from" name="date_from" style="width:150px;" value="<?=@$_GET['date_from'];?>" />
		&nbsp;<?=$ADMIN_TRANS['till'];?>:&nbsp;
		<input type="text" class="ConfigAdminInput" id="date_to" name="date_to" style="width:150px;" value="<?=@$_GET['date_to'];?>" />
		
		<input type="submit" value="<?=$ADMIN_TRANS['search'];?>" class="newSaveIcon" />
	</form>
	<div class="button_top excel" style="margin-top:5px;float:<?=$SITE[opalign];?>;" onclick="document.location.href='formHistoryExport.php?<?=$_SERVER['QUERY_STRING'];?>';"><div class="button_text"><img align="absmiddle" src="/images/excel.png" border="0" style="margin-left:5px"> <?=$ADMIN_TRANS['export to excel'];?></div></div>
	<div class="button_top excel" style="margin-top:5px;float:<?=$SITE[opalign];?>;"><div class="button_text"><a href="<?=$SITE[url];?>/category/<?=$form['UrlKey'];?>" target="_blank"><?=$translations[$SITE_LANG['selected']]['go_to_form'];?></a></div></div>
	<div style="clear:both;height:20px;"></div>
	<form action="formHistoryAdmin.php?<?=$_SERVER['QUERY_STRING'];?>" method="POST" name="frmAllList" id="frmAllList">
	
	<table class="maincolor general" id="historyTable" border="0" style="border-collapse:collapse;" cellpadding="8" cellspacing="0">
	<tr style="background-color:#efefef;font-weight:bold;">
	<td><i class="fa fa-mobile fa-2x"></i></td>
	<td><input type="checkbox" onclick="jQuery('.delHistory').attr('checked',jQuery(this).is(':checked'));" /></td>
	<? $cols = 3;
	$uri = $_SERVER['QUERY_STRING'];
	$ex = explode('&sort=',$uri);
	if(count($ex) > 1)
	{
		$exx = explode('&',$ex[1]);
		$uri = $ex[0];
		if($exx[1] != '')
			$uri .= '&'.$exx[1];
	}
	$ex = explode('&order=',$uri);
	if(count($ex) > 1)
	{
		$exx = explode('&',$ex[1]);
		$uri = $ex[0];
		if($exx[1] != '')
			$uri .= '&'.$exx[1];
	}
	$ex = explode('&page=',$uri);
	if(count($ex) > 1)
	{
		$uri = $ex[0];	
	} ?>
	
	<td style="font-size:11pt"><a style="text-decoration:underline;" href="#formHistoryAdmin?<?=$uri;?>&sort=date&order=<?=(@$_GET['order'] == 'ASC') ? 'DESC' : 'ASC';?>"><?=$ADMIN_TRANS['date'];?></a></td>
	<?
	foreach($inputs as $i => $input)
		if($input['inputType'] != 'title' && $input['inputType'] != 'hidden'){
			$cols++; ?>
			<td align="<?=$SITE[align];?>" style="font-size:11pt;min-width:<?=($input['minTableWidth'] > 0) ? $input['minTableWidth'] : 150;?>px;max-width:<?=($input['maxTableWidth'] > 0) ? $input['maxTableWidth'] : 400;?>px;<? if($i == count($inputs)-1){ ?>border-<?=$SITE[opalign];?>:1px solid silver;<? } ?>">
				<? if($input['inputType'] != 'checkbox'){ ?><a style="text-decoration:underline;" href="#formHistoryAdmin?<?=$uri;?>&sort=<?=$input['inputID'];?>&order=<?=(@$_GET['order'] == 'ASC') ? 'DESC' : 'ASC';?>"><?=(trim($input['inputName']) != '') ? $input['inputName'] : $ADMIN_TRANS['untitled'];?><? }
				else { ?><?=(trim($input['inputName']) != '') ? $input['inputName'] : $ADMIN_TRANS['untitled'];?><? } ?>
			</td>
		<? } ?>
		<td>Remarks</td>
	</tr>
	<?
	$sort = (@$_GET['sort'] == 'date' && @$_GET['order'] != '') ? $_GET['order'] : 'DESC';
	if(!isset($_GET['search']))
	{
		$db->query("
			SELECT
				*
			FROM
				`custom_forms_history`
			WHERE
				`formID`='{$_GET['formID']}'
			ORDER BY `date` {$sort}
		");
		
	}
	else
	{		
		$where = '';
		if(@$_GET['date_from'] != '')
			$where .= " AND `date` >= '".date('Y-m-d 00:00:00',strtotime($_GET['date_from']))."'";
			
		if(@$_GET['date_to'] != '')
			$where .= " AND `date` <= '".date('Y-m-d 23:59:59',strtotime($_GET['date_to']))."'";
		
		$db->query("
			SELECT
				*
			FROM
				`custom_forms_history`
			WHERE
				`formID`='{$_GET['formID']}'
			{$where}
			ORDER BY `date` {$sort}
		");
	}
	$all = array();
	$tosort = array();
	$ii = 0;
	while($db->nextRecord())
	{
		$history = $db->record;
		$data = unserialize($history['data']);
		$show = (@$_GET['search_query'] != '') ? false : true;
		foreach($inputs as $i => $input)
			if($input['inputType'] != 'title' && $input['inputType'] != 'hidden'){
				if(@$_GET['search_query'] != '')
				{
					switch($input['inputType'])
					{
						default:
							if(substr_count($data['input_'.$input['inputID']],$_GET['search_query']) > 0)
								$show = true;
							break;
						case 'checkbox':
							$string = '';
							if(is_array(@$data['input_'.$input['inputID']]))
							{
								foreach($data['input_'.$input['inputID']] as $val)
								{
									$string .= $val.'; ';
								}
							}
							if(substr_count($string,$_GET['search_query']) > 0)
								$show = true;
							break;
					}
				}
			}
		
		if($show)
		{
			$all[$ii] = $history;
			if(isset($_GET['sort']) && $_GET['sort'] != 'date')
				$tosort[$ii] = $data['input_'.$_GET['sort']];
			$ii++;
		}
	}
	
	if(isset($_GET['sort']) && $_GET['sort'] != 'date')
	{
		if(@$_GET['order'] == 'DESC')
			arsort($tosort);
		else
			asort($tosort);
		$old_all = $all;
		$all = array();
		foreach($tosort as $i => $data)
			$all[] = $old_all[$i];
	}
	$sorted = array_slice($all,$offset,$limit);
	$total = count($all);
	print '<tr class="total-view"><td colspan=100>'.$ADMIN_TRANS['total leads'].':'.$total.'</td></tr>';
	foreach($sorted as $history){
		$data = unserialize($history['data']);
		?>
		<tr>
		<td><?if ($history[fromMobile]==1) print '<i class="fa fa-mobile fa-2x"></i>';?></td>
		<td valign="top"><input type="checkbox" class="delHistory" name="delHistory[]" value="<?=$history['id'];?>" /></td>
		<td valign="top">
			<?=date('d.m.Y H:i',strtotime($history['date']));?>
		</td>
		<? foreach($inputs as $i => $input)
				if($input['inputType'] != 'title' && $input['inputType'] != 'hidden'){
				?>
				<td style="<? if($input['inputType'] != 'file'){ ?>min-width:<?=($input['minTableWidth'] > 0) ? $input['minTableWidth'] : 150;?>px;max-width:<?=($input['maxTableWidth'] > 0) ? $input['maxTableWidth'] : 400;?>px;<? } if($i == count($inputs)-1){ ?>border-<?=$SITE[opalign];?>:1px solid silver;<? } ?><?=($input['inputType'] == 'file') ? 'white-space:nowrap;' : '';?>" valign="top">
				<? switch($input['inputType'])
				{
					default:
						echo stripslashes($data['input_'.$input['inputID']]);
						break;
					case 'checkbox':
						if(is_array(@$data['input_'.$input['inputID']]))
						{
							foreach($data['input_'.$input['inputID']] as $val)
							{
								echo stripslashes($val).'; ';
							}
						}
						break;
				} ?>
				</td>
			<? } ?>
			<td><div class="form_row_remarks" id="<?=$history['id'];?>"><?=$data['hist_remarks'];?></div></td>
		</tr>
		<? 
	} ?>
	<tr>
		<td colspan="<?=$cols;?>" align="<?=$SITE['align'];?>" style="border-<?=$SITE[opalign];?>:0;"><input type="submit" value="<?=$ADMIN_TRANS['delete'];?>" class="newSaveIcon"/></td>
	</tr>
	</form>
	</table>
	<br>
	<? if($total > $limit) {
		$uri = $_SERVER['QUERY_STRING'];
		$ex = explode('&page=',$uri);
		if(count($ex) > 1)
		{
			$uri = $ex[0];	
		}
		$pages = ceil($total/$limit);
		?>
		<br/>
		<p align="center">
			<? for($p = 1;$p <= $pages;$p++){ ?>
			<a href="#formHistoryAdmin?<?=$uri;?>&page=<?=$p;?>"><?=$p;?></a>&nbsp;&nbsp;
			<? } ?>
		</p>
		<?
	}
} else { ?>
	<div style="text-align:center"><h3><?=$ADMIN_TRANS['forms list'];?></h3></div>
	<table class="configAdmin" border="0" style="border-collapse:;margin:0 auto;width:900px" cellpadding="3" cellspacing="5">
	<tr style="background-color:#efefef;font-weight:bold;">
	<td align="<?=$SITE[align];?>"><?=$ADMIN_TRANS['form title'];?></td>
	<td align="<?=$SITE[align];?>" style="border-<?=$SITE[opalign];?>:0;"><?=$ADMIN_TRANS['form link'];?></td>
	</tr>
	<?
	$db = new Database();
	$db->query("
		SELECT
			`custom_forms`.*,
			IF(`custom_forms`.`formName` = '',`categories`.`MenuTitle`,`custom_forms`.`formName`) AS `formName`,
			`categories`.`UrlKey`
		FROM
			`custom_forms`
		INNER JOIN
			`categories` USING(`CatID`) GROUP BY `custom_forms`.`catID`
	");
	while($db->nextRecord())
	{
		$form = $db->record;
		if($form['formName'] != '')
		{
		?>
		<tr>
		<td style="cursor:pointer">
			<a href="#formHistoryAdmin?formID=<?=$form['formID'];?>"><?=$form['formName'];?></a>
		</td>
		<td style="border-<?=$SITE[opalign];?>:0;direction:ltr;">
			<a href="<?=$SITE[url];?>/category/<?=$form['UrlKey'];?>" target="_blank"><?=$SITE[url];?>/category/<?=$form['UrlKey'];?></a>
		</td>
		</tr>
	<? }
	} ?>
	</table>
<? } ?>
</div>
<? include_once("footer.inc.php"); ?>