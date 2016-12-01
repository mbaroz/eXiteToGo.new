<?
include_once("../config.inc.php");
switch(@$_GET['lang'])
{
	case 'he':
	default:
		$dow_he = array('א','ב','ג','ד','ה','ו','ש');
		$mon_he = array('','ינואר','פברואר','מרץ','אפריל','מאי','יוני','יולי','אוגוסט','ספטמבר','אוקטובר','נובמבר','דצמבר');
		$left = 'left';
		$right = 'right';
		$dir = 'rtl';
		break;
	case 'en':
		$dow_he = array('S','M','T','W','T','F','S');
		$mon_he = array('','January','February','March','April','May','June','July','August','September','October','November','December');
		$left = 'right';
		$right = 'left';
		$dir = 'ltr';
		break;
}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	</head>
	<style type="text/css">
		body{color:#<?=$SITE[contenttextcolor];?>;font-family:Arial;font-size:10px;direction:<?=$dir;?>;}
		.calendar-month{font-size:16px;padding-bottom:10px;text-align:<?=$right;?>;width:104px}
		.pn-links{color:#8f939c;font-family:Tahoma;font-size:18px;padding-bottom:10px;text-align:<?=$left;?>;width:78px}
		table{font-size:14px;}
		table tbody tr td{height:24px;text-align:center;width:26px}
		table tbody tr th{font-weight:400}
		.this_week{background:#e7eaef}
		.today{background:#f1f1f1}
		table a{color:#<?=$SITE[linkscolor];?>;font-weight:700;text-decoration:none}
		.pn-links a{color:#8f939c;font-weight:400}
		.prev_month,.next_month{color:#8f939c}
		table tbody tr td.prev_month a,table tbody tr td.next_month a{color:#8f939c}
	</style>
	<body>
<?php
	require_once '../database.php';
	$db = new Database;
	mysql_set_charset('utf8');
	
	$month = (isset($_GET['month'])) ? intval($_GET['month']) : date('m',time());
	$year = (isset($_GET['year'])) ? intval($_GET['year']) : date('Y',time());
	
	$first_of_month = gmmktime(0,0,0,$month,1,$year);
	$days_in_month=gmdate('t',$first_of_month);
	
	
	$first_week = date('W',$first_of_month);
	$this_week = date('W',time()) - $first_week;
	if(date('w',time()) == 0)
		$this_week++;
	$dow = date('w',$first_of_month);
	
	$remain = 7 - (($days_in_month + $dow) - (floor(($days_in_month + $dow)/7)*7));
	
	$next_month = $month+1;
	$next_year = $year;
	if($next_month==13)
	{
		$next_month = 1;
		$next_year++;
	}
	
	$pre_month = $month-1;
	$pre_year = $year;
	if($pre_month==0)
	{
		$pre_month = 12;
		$pre_year--;
	}
	
	if($remain > 0)
	{
		
		$last_day = $remain.'.'.$next_month.'.'.$next_year;
	}
	else
		$last_day = $days_in_month.'.'.$month.'.'.$year;
		
	$last_day_time = strtotime($last_day);
	
	$today = 0;
	if($month == date('m',time()))
		$today = date('d',time());
	if($dow > 0)
		$pre_day_time = strtotime('last Sunday',$first_of_month);
	else
		$pre_day_time = $first_of_month;
		
	$pre_day = date('d',$pre_day_time);
		
	$q_days = '';
	$the_day = date('j.m.Y',$pre_day_time);
	while($pre_day_time <= $last_day_time)
	{
		$q_days .= "'{$the_day}',";
		$pre_day_time += 24*3600;
		$the_day = date('j.m.Y',$pre_day_time);
	}
	$q_days = substr($q_days,0,-1);
	$day_links = array();
	
	$q = mysql_query("SELECT * FROM `calendar_events` WHERE `day` IN ({$q_days})");
	while($r = mysql_fetch_array($q))
		$day_links[$r['day']] = array('name' => $r['name'],'link' => $r['link']);
	
	$day_names = array();
	for($n=0,$t=(3+$first_day)*86400; $n<7; $n++,$t+=86400)
		$day_names[$n] = $dow_he[date('w',$t)];

	list($month, $year, $month_name, $weekday) = explode(',',gmstrftime('%m,%Y,%B,%w',$first_of_month));
	$month_name = $mon_he[intval($month)];
	$weekday = ($weekday + 7) % 7;
	$title   = $month_name.'&nbsp;'.$year;

	$calendar = '<table class="calendar" cellspacing="0" cellpadding="0" border="0"><tbody>'."\n".
		'<tr><td colspan="4" class="calendar-month">'.$p.($month_href ? '<a href="'.htmlspecialchars($month_href).'">'.$title.'</a>' : $title)."</td><td colspan=\"3\" class=\"pn-links\"><a href=\"?month={$pre_month}&year={$pre_year}\">&lsaquo;</a>&nbsp;&nbsp;&nbsp;<a href=\"?month={$next_month}&year={$next_year}\">&rsaquo;</a></td></tr>\n<tr>";

	foreach($day_names as $d)
		$calendar .= '<th abbr="'.htmlentities($d).'">'.$d.'</th>';
	$calendar .= "</tr>\n<tr>";
	
	if($weekday > 0) 
		for($wd = 0;$wd < $weekday;$wd++)
			show_day($pre_day+$wd,$pre_month,$pre_year,true);
			
	$week_num = 0;
	for($day=1; $day<=$days_in_month; $day++,$weekday++){
		if($weekday == 7){
			$week_num++;
			$weekday   = 0;
			$calendar .= "</tr>\n<tr";
			$calendar .= ($week_num==$this_week) ? ' class="this_week"' : '';
			$calendar .= ">";
		}
		
		show_day($day,$month,$year);
	}
	if($weekday != 7)
		for($wd = $weekday;$wd<7;$wd++)
			show_day(($wd-$weekday)+1,$next_month,$next_year,false,true);

	echo $calendar."</tr>\n</tbody></table>\n";

	function show_day($day,$month,$year,$pre = false,$next = false)
	{
		
		global $day_links,$today,$calendar;
		$event_link=$day_links[intval($day).'.'.$month.'.'.$year]['link'];
		
		$targetLink="_top";
		if (!stripos($event_link,"/")==0) $targetLink="_blank";
		$classes = '';
		if(strlen($month) == 1)
			$month = '0'.$month;
		if($day == $today)
			$classes .= 'today ';
		if($pre)
			$classes .= 'prev_month ';
		if($next)
			$classes .= 'next_month ';
		if(isset($day_links[intval($day).'.'.$month.'.'.$year])) {
			if ($event_link=="/#")  $day = '<a style="cursor:pointer" target="'.$targetLink.'" title="'.$day_links[intval($day).'.'.$month.'.'.$year]['name'].'">'.$day.'</a>';
			else $day = '<a target="'.$targetLink.'" href="'.$day_links[intval($day).'.'.$month.'.'.$year]['link'].'" title="'.$day_links[intval($day).'.'.$month.'.'.$year]['name'].'">'.$day.'</a>';
		}
		$calendar .= '<td class="'.$classes.'">'.$day.'</td>';
	}
?>
	<?
	if (isset($_SESSION['LOGGED_ADMIN'])) {
		?>
		<a href="/pages/caladmin" target="_top" style="font-weight:bold">לעריכת אירועים</a>
		<?
	}
	?>
	</body>
</html>