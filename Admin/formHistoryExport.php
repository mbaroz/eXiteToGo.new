<?
//General Config Form
include_once("checkAuth.php");

include_once("../config.inc.php");
$loc=strtolower($_SERVER['SCRIPT_NAME']);
if (!$_SERVER['SERVER_PORT_SECURE'] AND $loc=="/admin/signin.php") {
	$url_location=$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
}
include_once("lang.admin.php");
include_once("../defaults.php");

include("colorpicker.php");

$db=new Database();

require_once '../inc/CustomForm.inc.php';

if(@$_GET['formID'] > 0) {
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream;charset=window-1255");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=form_{$_GET['formID']}_export.csv");
	
	$assoc = array();
	$keys = array(); 
	
	$db = new Database();

	$inputs = getFormInputs(intval($_GET['formID']));
	
	$output = '';
    $output .= $ADMIN_TRANS['date'].',';
	foreach($inputs as $i => $input)
		if($input['inputType'] != 'title' && $input['inputType'] != 'hidden'){
			$output .= '"'.str_replace('"','""',$input['inputName']).'",';
		}
	
	$output = substr($output,0,-1)."\r\n";
		
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
						case 'hidden':
							if(substr_count($input['inputName'],$_GET['search_query']) > 0)
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
				$tosort[$ii] = (string)$data['input_'.$_GET['sort']];
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
	foreach($all as $history){
		$data = unserialize($history['data']);
		$output .= date('d.m.Y H:i',strtotime($history['date'])).',';
		foreach($inputs as $i => $input)
			if($input['inputType'] != 'title' && $input['inputType'] != 'hidden'){
				switch($input['inputType'])
				{
					default:
						$output .= '"=""'.str_replace('"','""',$data['input_'.$input['inputID']]).'""",';
						break;
					case 'hidden':
						$output .= '"=""'.str_replace('"','""',$input['inputName']).'""",';
						break;
					case 'checkbox':
						$string = '';
						if(is_array(@$data['input_'.$input['inputID']]))
						{
							foreach($data['input_'.$input['inputID']] as $val)
							{
								$string .= $val.', ';
							}
						}
						$output .= '"=""'.str_replace('"','""',$string).'""",';
						break;
				}
			}
		$output = substr($output,0,-1)."\r\n";
	}
	
	echo chr(239) . chr(187) . chr(191) . trim($output);
	exit();
}

?>