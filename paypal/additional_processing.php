<?
$teststr='<tr class="cItem"><td><a href="http://www.htvegan.co.il/shop_product/אוכל-טבעוני-לחגים-ואירוח/סדנת-חג">סדנת חג – ראש השנה</a><br/><small><b>תאריך ושעה:</b> 07.09.15 ב-18:00</small></td>
			<td width="70">&nbsp;כמות: 1&nbsp;</td>
			<td align="left">מחיר: ₪<span>180</span></td></tr>';

$sadna_clean_str=str_ireplace("&nbsp;"," ",strip_tags($teststr));
$sadna_clean_str=str_ireplace("\n", " ", $sadna_clean_str);
//$sadna_clean_str=str_ireplace("  ", " ", $sadna_clean_str);
$date_pos=strpos($sadna_clean_str, "תאריך ושעה");
$qty_pos=strpos($sadna_clean_str, "כמות");
$sadna_name=substr($sadna_clean_str,0, $date_pos);

$sadna_date_str=substr($sadna_clean_str, $date_pos,$qty_pos);
preg_match('/(\d+(\.\d+)*)/', $sadna_date_str, $matches);
$sadnaDate=str_ireplace(".", "/", $matches[0]);
print $sadnaDate;

die();
$xmlData='<?xml version="1.0" encoding="utf-8"?>
	<ROOT>
	<PERMISSION>
	<USERNAME>API</USERNAME>
	<PASSWORD>1234</PASSWORD>
	</PERMISSION>
	<CARD_TYPE>private_customer</CARD_TYPE>
	<IDENTIFIER>CELL</IDENTIFIER>
	<CUST_DETAILS>
	<P_N>'.$first_name.'</P_N>
	<F_N>'.$last_name.'</F_N>
	<MAIL>'.$payer_email.'</MAIL>
	<CELL>'.$phone.'</CELL>
	<REM>'.$additional.'</REM>
	<CAMPAIGN>אתר החברה</CAMPAIGN>
	</CUST_DETAILS>
	<MODULES>
	<MODULE>
	<KEY>INTEREST</KEY>
	<ITEM>	<INT_STATUS>נרשם ושילם</INT_STATUS>
	<SADNA_NAME>'.$sadna_name.'</SADNA_NAME>
	<SADNA_DATE>'.$sadnaDate.'</SADNA_DATE>
	</ITEM>
	</MODULE>
	</MODULES>
	<FOCUSES>
	<FOCUS>
	<KEY>PNIYA_STATUS1</KEY>
	<STATUS>OPEN_PNIYA</STATUS>
	</FOCUS>
	</FOCUSES>
	</ROOT>';
	//print $xmlData;
	$zebraURL='https://18932.zebracrm.com/ext_interface.php?b=update_customer';
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $zebraURL );
	curl_setopt( $ch, CURLOPT_POST, true );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $xmlData );
	$result = curl_exec($ch);
	//print_r($result);
	//die();
	curl_close($ch);
?>