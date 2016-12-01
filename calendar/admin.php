<?php
include_once("../config.inc.php");
if (!isset($_SESSION['LOGGED_ADMIN'])) die("");
$site_url = $SITE[url];

require_once '../database.php';
$db = new Database;
mysql_set_charset('utf8');

$month = (isset($_GET['month'])) ? intval($_GET['month']) : date('m',time());
$year = (isset($_GET['year'])) ? intval($_GET['year']) : date('Y',time());

$month = (isset($_POST['month'])) ? intval($_POST['month']) : $month;
$year = (isset($_POST['year'])) ? intval($_POST['year']) : $year;

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

if(isset($_POST['name']))
{
	$errs = '';
	if($_POST['name'] == '')
		$errs .= 'שם האירוע לא יכול להיות ריק!\n';
	else
		$_POST['name'] = mysql_real_escape_string($_POST['name']);
	
	if($_POST['url'] == '')
		$_POST['url']="/#";
	else{
		$check_url=$_POST['url'];
		if(substr($_POST['url'],0,1) == '/')
			$check_url = 'http://'.$_SERVER['HTTP_HOST'].$_POST['url'];
		if(!preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $check_url))
			$errs .= 'הקישור לא תקין!\n';
	}
	$_POST['url']=str_ireplace($SITE[url],"",$_POST['url']);
	if($errs == '')	
		mysql_query("
			INSERT INTO
				`calendar_events`(`day`,`name`,`link`)
			VALUES
				('{$_POST['day']}','{$_POST['name']}','{$_POST['url']}')
			ON DUPLICATE KEY UPDATE
				`name`='{$_POST['name']}',
				`link`='{$_POST['url']}'
		");

	if($errs!= '')
		echo '<script type="text/javascript">alert("'.$errs.'");</script>';
	echo gen_cal();
	die;
}

if(@$_POST['remove'] != '')
{
	$_POST['remove'] = mysql_real_escape_string($_POST['remove']);
	mysql_query("DELETE FROM `calendar_events` WHERE `day`='{$_POST['remove']}'");

	echo gen_cal();
	die;
}

?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/css/styles.css.php?urlKey=<?=$urlKey;?>">
		<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/Admin/AdminEditing.css.php">
		<link rel="stylesheet" type="text/css" href="<?=$site_url;?>/js/shadowbox/shadowbox.css"> 
		<script type="text/javascript" src="<?=$site_url;?>/js/shadowbox/shadowbox.js"></script> 
		<script language="JavaScript" type="text/javascript" src="<?=$site_url;?>/js/gallery/jquery-1.4.4.min.js"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	</head>
	<script language="javascript" type="text/javascript"> 
	jQuery.noConflict();
	 
	Shadowbox.init({
			    language:   "en",
			     viewportPadding:1,
			    autoplayMovies:true
			  
	});
	 
	</script> 
	<style type="text/css">
		.events_body{direction:<?=$dir;?>;color:#<?=$SITE[contenttextcolor];?>;font-family:Arial;font-size:10px;padding-right:2px;}
		
		.events_body table{font-size:14px;}
		.events_body table tbody tr td{height:24px;text-align:center;width:26px}
		.events_body table tbody tr td.calendar-month{font-size:16px;padding-bottom:10px;text-align:<?=$right;?>}
		.events_body table tbody tr td.pn-links{color:#8f939c;font-family:Tahoma;font-size:18px;padding-bottom:10px;text-align:<?=$left;?>}
		.events_body table tbody tr th{font-weight:400}
		.this_week{background:#e7eaef}
		.today{background:#f1f1f1}
		.events_body table tbody tr td a{color:#<?=$SITE[contenttextcolor];?>;font-weight:normal;text-decoration:none}
		.events_body table tbody tr td a.edit_link{font-weight:bold;color:<?=$SITE[linkscolor];?>}
		.pn-links a{color:#<?=$SITE[linkscolor];?>;font-weight:400}
		.prev_month,.next_month{color:#<?=$SITE[contenttextcolor];?>}
		.events_body table tbody tr td.prev_month a,.events_body table tbody tr td.next_month a{color:#<?=$SITE[contenttextcolor];?>;opacity:0.8;}
		.event_form{direction:rtl;font-size:14px;text-align:right;background:#ffffff;width:100%;height:100%;padding:0;margin:0}
		.event_form label{display:block;padding:10px 0;font-weight:700}
		.txtin{display:block;border:1px solid silver;width:250px;height:25px;padding:3px}
		.submit{display:block;margin:10px 0}
		.date_control{font-size:12px;direction:rtl;position:absolute;background:#ffffff;width:100px;padding:10px;border:1px solid #000000;display:none}
		.date_control a{color:#000000;text-decoration:underline;font-weight:bold}
		#sb-wrapper{font-family:Arial;padding:10px;background-color:#E0ECFF;border:2px solid #C3D9FF;color:#333333;}
		#sb-title{direction: rtl;text-align:right;}
		#sb-body{background-color:#E0ECFF}
		
	</style>
	<body style="background-color:transparent;" align="center">
		<div class="events_body" align="center">
		<?php
		
		echo gen_cal();
		
		function gen_cal()
		{
			global $day_links,$today,$calendar,$month,$year,$dow_he,$mon_he;
		
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
				'<tr><td colspan="4" class="calendar-month">'.$p.($month_href ? '<a href="'.htmlspecialchars($month_href).'">'.$title.'</a>' : $title)."</td><td colspan=\"3\" class=\"pn-links\"><a href=\"#\" onclick=\"goto({$pre_month},{$pre_year});return false;\">&lsaquo;</a>&nbsp;&nbsp;&nbsp;<a href=\"#\" onclick=\"goto({$next_month},{$next_year});return false;\">&rsaquo;</a></td></tr>\n<tr>";
		
			foreach($day_names as $d)
				$calendar .= '<th abbr="'.htmlentities($d).'">'.$d.'</th>';
			$calendar .= "</tr>\n<tr>";
			
			if($weekday > 0) 
				for($wd = 0;$wd < $weekday;$wd++)
					$calendar .= show_day($day_links,$today,$pre_day+$wd,$pre_month,$pre_year,true);
					
			$week_num = 0;
			for($day=1; $day<=$days_in_month; $day++,$weekday++){
				if($weekday == 7){
					$week_num++;
					$weekday   = 0;
					$calendar .= "</tr>\n<tr";
					$calendar .= ($week_num==$this_week) ? ' class="this_week"' : '';
					$calendar .= ">";
				}
				
				$calendar .= show_day($day_links,$today,$day,$month,$year);
			}
			if($weekday != 7)
				for($wd = $weekday;$wd<7;$wd++)
					$calendar .= show_day($day_links,$today,($wd-$weekday)+1,$next_month,$next_year,false,true);
		
			return $calendar."</tr>\n</tbody></table>\n";
		}
		
		function show_day($day_links,$today,$day,$month,$year,$pre = false,$next = false)
		{
			$classes = '';
			if(strlen($month) == 1)
				$month = '0'.$month;
			if($day == $today)
				$classes .= 'today ';
			if($pre)
				$classes .= 'prev_month ';
			if($next)
				$classes .= 'next_month ';
			if(isset($day_links[intval($day).'.'.$month.'.'.$year]))
				$day = '<a href="'.$day_links[intval($day).'.'.$month.'.'.$year]['link'].'" title="'.$day_links[intval($day).'.'.$month.'.'.$year]['name'].'" class="edit_link" id="'.intval($day).'.'.$month.'.'.$year.'">'.$day.'</a>';
			else
				$day = '<a href="#" class="add_link" id="'.intval($day).'.'.$month.'.'.$year.'">'.$day.'</a>';
			return '<td class="'.$classes.'">'.$day.'</td>';
		}
		?>
		</div>
		<script type="text/javascript">
			var day = '';
			var html_form = '<form name="eventform" id="eventform" class="event_form" action="" onsubmit="save_event();return false;"><label for="name">שם האירוע</label><input type="text" class="txtin" name="name" id="name" value="%%name%%" /><label for="url">קישור לאירוע</label><input type="text" class="txtin" name="url" id="url" value="%%url%%" /><br /><div id="newSaveIcon" onclick="save_event()"><img src="<?=$SITE[url];?>/Admin/images/saveIcon.gif" align="absmiddle" border="0"> <?=$ADMIN_TRANS['save changes'];?></div></form>';
			var exloc = document.location.toString().split('?');
			var loc = exloc[0];
			init_links();
			
			function init_links()
			{
				jQuery('.add_link').click(function(){
					jQuery('#edit_box').hide();
					jQuery('#add_box').css('top',(jQuery(this).offset().top+10)+'px').css('left',(jQuery(this).offset().left+10)+'px');
					jQuery('#add_box').show();
					day = jQuery(this).attr('id');
					return false;
				});
				
				jQuery('.edit_link').click(function(){
					day = jQuery(this).attr('id');
					jQuery('#add_box').hide();
					jQuery('#edit_box').css('top',(jQuery(this).offset().top+10)+'px').css('left',(jQuery(this).offset().left+10)+'px');
					obj = document.getElementById(day);
					jQuery('#event_name').html(jQuery(obj).attr('title'));
					jQuery('#edit_box').show();
					return false;
				});
				
				jQuery('body').click(function(){
					jQuery('#add_box').hide();
					jQuery('#edit_box').hide();
				});
			}
			
			function add_event()
			{
				Shadowbox.close();
				jQuery('#add_box').hide();
				jQuery('#edit_box').hide();
				div_content = html_form.replace('%%name%%','').replace('%%url%%','');
				Shadowbox.open({
			        content:    div_content,
			        player:     'html',
			        title:      'הוספת אירוע ב'+' - '+day,
			        height:     200,
			        width:      250,
			        options: { enableKeys: false }
			    });
			}
			
			function edit_event()
			{
				Shadowbox.close();
				jQuery('#add_box').hide();
				jQuery('#edit_box').hide();
				obj = document.getElementById(day);
				div_content = html_form.replace('%%name%%',jQuery(obj).attr('title')).replace('%%url%%',jQuery(obj).attr('href'));
				Shadowbox.open({
			        content:    div_content,
			        player:     'html',
			        title:      'עריכת אירוע ב'+' - '+day,
			        height:     200,
			        width:      250,
			        options: { enableKeys: false }
			    });
			}
			
			function save_event()
			{
				jQuery.post(loc,{'month' : '<?=$month;?>','year' : '<?=$year;?>','day':day,'name':jQuery('#name').val(),'url':jQuery('#url').val()},function(data){
					Shadowbox.close();
					jQuery('.events_body').html(data);
					init_links();
				}); 
				return false;
			}
			
			function remove_event()
			{
				Shadowbox.close();
				jQuery('#add_box').hide();
				jQuery('#edit_box').hide();
				if(confirm('האם למחוק אירוע ב - : '+day+'?'))
				{
					jQuery.post(loc,{'month' : '<?=$month;?>','year' : '<?=$year;?>','remove' : day},function(data){
						jQuery('.events_body').html(data);
						init_links();
					});
				} 
				return false;
			}
			
			function goto(month,year)
			{
				jQuery('#goto_month').val(month);
				jQuery('#goto_year').val(year);
				jQuery('#goto').submit();
			}
		</script>
		<div id="add_box" class="date_control">
			<a href="#" onclick="add_event();return false;"><img src="/calendar/add.png" height="16" valign="bottom" border="0" />&nbsp;&nbsp;הוסף אירוע</a>
		</div>
		<div id="edit_box" class="date_control">
			<span id="event_name"></span><br/><br/>
			<a href="#" onclick="edit_event();return false;"><img src="/calendar/edit.png" height="16" valign="bottom" border="0" />&nbsp;&nbsp;ערוך אירוע</a><br/>
			<a href="#" onclick="remove_event();return false;"><img src="/calendar/del.png" height="16" valign="bottom" border="0" />&nbsp;&nbsp;מחק אירוע</a>
		</div>
		<form id="goto" action="" method="post" style="display:none;">
			<input type="hidden" name="month" id="goto_month" value="<?=$month;?>" />
			<input type="hidden" name="year" id="goto_year" value="<?=$year;?>" />
			<input type="submit" />
		</form>
	</body>
</html>