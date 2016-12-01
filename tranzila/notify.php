<?php
error_reporting(0);
//@file_put_contents('tmp'.time(),print_r($_POST,true));

$errorCodes = array('000' => 'עיסקה תקינה', '001' => 'חסום,החרם כרטיס', '002' => 'גנוב,החרם כרטיס', '003' => 'התקשר לחברת האשראי', '004' => 'סירוב', '005' => 'מזויף,החרם כרטיס', '006' => 'ת.ז או CVV שגויים', '007' => 'חובה להתקשר לחברת האשראי', '008' => 'תקלה בבניית מפתח גישה לקובץ חסומים', '009' => 'לא הצליח להתקשר,התקשר לחברת האשראי', '010' => 'תוכנית הופסקה על פי הוראת המפעיל (ESC)', '015' => 'אין התאמה בין המספר שהוקלד לפס המגנטי', '017' => 'לא הוקלדו 4 ספרות אחרונות', '019' => 'רשומה בקובץ INTֹIN קצרה מ-16 תווים', '020' => 'קובץ קלט (INTֹIN) לא קיים', '021' => 'קובץ חסומים (NEG) לא קיים או לא מעודכן - בצע שידור או בקשה לאישור עבור כל עיסקה', '022' => 'אחד מקבצי פרמטרים או ווקטורים לא קיים', '023' => 'קובץ תאריכים (DATA) לא קיים', '024' => 'קובף אתחול (START) לא קיים', '025' => 'הפרש בימים בקליטת חסומים גדול מדי-בצע שידור או בקשה לאישור עבור כל עיסקה', '026' => 'הפרש דורות בקליטת חסומים גדול מידי-בצע שידור או בקשה לאישור עבור כל עיסקה', '027' => 'כאשר לא הוכנס פס מגנטי כולו הגדר עיסקה כעיסקה טלפונית או כעיסקת חתימה בלבד', '028' => 'מספר מסוף מרכזי לא הוכנס למסוף המוגדר לעבודה כרב ספק', '029' => 'מספר מוטב לא הוכנס למסוף המוגדר לעבודה כרב מוטב', '030' => 'מסוף שאינו מעודכן כרב ספק/רב מוטב והוקלד מספר ספק/מספר מוטב', '031' => 'מסוף מעודכן כרב ספק והוקלד גם מספר מוטב', '032' => 'תנועות ישנות בצע שידור או בקשה לאישור עבור כל עיסקה', '033' => 'כרטיס לא תקין', '034' => 'כרטיס לא רשאי לבצע במסוף זה או אין אישור לעיסקה כזאת', '035' => 'כרטיס לא רשאי לבצע עיסקה עם סוג אשראי זה', '036' => 'פג תוקף', '037' => 'שגיאה בתשלומים -סכום עיסקה צריך להיות שווה תשלום ראשון +(תשלום קבוע כפול מספר תשלומים)', '038' => 'לא ניתן לבצע עיסקה מעל תקרה לכרטיס לאשראי חיוב מיידי', '039' => 'סיפרת בקורת לא תקינה', '040' => 'מסוף שמוגדר כרב מוטב הוקלד מספר ספק', '041' => 'מעל תקרה כאשר קובץ הקלט מכיל J3 או J2 או J1 (אסור להתקשר)', '042' => 'כרטיס חסום בספק כאשר קובץ הקלט מכיל J3 או J2 או J1 (אסור להתקשר)', '043' => 'אקראית כאשר קובץ הקלט מכיל J1 (אסור להתקשר)', '044' => 'מסוף לא רשאי לבקש אישור ללא עיסקה (J5)', '045' => 'מסוף לא רשאי לבקש אישור ביוזמת קמעונאי(J6)', '046' => 'מסוף חייב לבקש אישור כאשר קובץ הקלט מכיל J3 או J2 או J1 (אסור להתקשר)', '047' => 'חייב להקליד מספר סודי,כאשר קובץ הקלט מכיל J3 או J2 או J1 (אסור להתקשר)', '051' => 'מספר רכב לא תקין', '052' => 'מד מרחק לא הוקלד', '053' => 'מסוף לא מוגדר כתחנת דלק(הועבר כרטיס דלק או קוד עיסקה לא מתאים)', '057' => 'לא הוקלד מספר תעודת זהות', '058' => 'לא הוקלד CVV2', '059' => 'לא הוקלדו מספר תעודת הזהות וה-CVV2', '060' => 'צרוף ABS לא נמצא בהתחלת נתוני קלט בזיכרון', '061' => 'מספר כרטיס לא נמצא או נמצא פעמיים', '062' => 'סוג עיסקה לא תקין', '063' => 'קוד עיסקה לא תקין', '064' => 'סוג אשראי לא תקין', '065' => 'מטבע לא תקין', '066' => 'קיים תשלום ראשון ו.או תשלום קבוע לסוג אשראי שונה מתשלומים', '067' => 'קיים מספר תשלומים לסוג אשראי שאינו דורש זה', '068' => 'לא ניתן להצמיד לדולר או למדד לסוג אשראי שונה מתשלומים', '069' => 'אורך הפס המגנטי קצר מידי', '070' => 'לא מוגדר מכשיר להקשת מספר סודי', '071' => 'חובה להקליד מספר סודי', '072' => 'קכח לא זמין-העבר בקורא מגנטי', '073' => 'הכרטיס נושא שבב ויש להעבירו דרך הקכח', '074' => 'דחייה-כרטיס נעול', '075' => 'דחייה-פעולה עם קכח לא הסתיימה בזמן הראוי', '076' => 'דחייה-נתונים אשר התקבלו מקכח אינם מוגדרים במערכת', '077' => 'הוקש מספר סודי שגוי', '080' => 'הוכנס קוד מועדון לסוג אשראי לא מתאים', '099' => 'לא מצליח לקרוא/לכתוב/לפתוח קובץ TRAN', '100' => 'לא קיים מכשיר להקשת קוד סודי', '101' => 'אין אישור מחברת האשראי לעבודה', '106' => 'למסוף אין אישור לביצוע שאילתא לאשראי חיוב מיידי', '107' => 'סכום העיסקה גדול מידי-חלק במספר העיסקאות', '108' => 'למסוף אין אישור לבצע עסקאות מאולצות', '109' => 'למסוף אין אישור לכרטיס עם קוד השרות 587', '110' => 'למסוף אין אישור לכרטיס חיוב מיידי', '111' => 'למסוף אין אישור לעיסקה בתשלומים', '112' => 'למסוף אין אישור לעיסקה טלפון/חתימה בלבד בתשלומים', '113' => 'למסוף אין אישור בעיסקה טלפונית', '114' => 'למסוף אין אישור לעיסקה חתימה בלבד', '115' => 'למסוף אין אישור לעיסקה בדולרים', '116' => 'למסוף אין אישור לעסקת מועדון', '117' => 'למסוף אין אישור לעיסקת כוכבים/נקודות מיילים', '118' => 'למסוף אין אישור לאשראי ישראקרדיט', '119' => 'למסוף אין אישור לאשראי אמקס קרדיט', '120' => 'למסוף אין אישור להצמדה לדולר', '121' => 'למסוף אין אישור להצמדה למדד', '122' => 'למסוף אין אישור להצמדה למדד לכרטיסי חוץ לארץ', '123' => 'למסוף אין אישור לעסקת כוכבים /נקודות/מיילים/ לסווג אשראי זה', '124' => 'למסוף אין אישור לאשראי קרדיט בתשלומים לכרטיס ישרכארט', '125' => 'למסוף אין אישור לאשראי קרדיט בתשלומים לכרטיסי אמקס', '126' => 'למסוף אין אישור לקוד מועדון זה', '127' => 'למסוף אין אישור לעסקת חיוב מיידי פרט לכרטיסי חיוב מיידי', '128' => 'למסוף אין אישור לקבל כרטיסי ויזה אשר מתחילים ב-3', '129' => 'למסוף אין אישור לבצע עסקת זכות מעל תקרה', '130' => 'כרטיס לא רשאי לבצע עסקת מועדון', '131' => 'כרטיס לא רשאי לבצע עסקת כוכבים/נקודות/מיילים', '132' => 'כרטיס לא רשאי לבצע עסקאות בדולרים(רגילות או טלפוניות(', '133' => 'כרטיס לא תקף על פי רשימת כרטיסים תקפים של ישרכארט', '134' => 'כרטיס לא תקין על פי הגדרות המערכת(VECTOR1 של ישראכרט)-מספר הספרות בכרטיס שגוי', '135' => 'כרטיס לא רשאי לבצע עסקאות דולריות על פי הגדרת המערכת (VECTOR1 של ישרכארט)', '136' => 'הכרטיס שייך לקבוצת כרטיסים אשר אינה רשאית לבצע עיסקאות על פי הגדרת המערכת(VECTOR20 של ויזה)', '137' => 'קידומת הכרטיס (7 ספרות) לא תקפה על פי הגדרת המערכת(VECTOR 21 של דיינרס)', '138' => 'כרטיס לא רשאי לבצע עסקאות בתשלומים על פי רשימת כרטיסים תקפים של ישרכארט', '139' => 'מספר תשלומים גדול מידי על פי רשימת כרטיסים תקפים של ישראכרט', '140' => 'כרטיסי ויזה ודיינרס לא רשאים לבצע עיסקאות מועדון בתשלום', '141' => 'סידרת כרטיסים לא תקפה על פי הגדרת המערכת(VECTOR5 של ישראכרט)', '142' => 'קוד שרות לא תקף על פי הגדרת המערכת (VECTOR7 של ישראכרט)', '143' => 'קידומת הכרטיס (2 ספרות) לא תקפה על פי הגדרת המערכת)VECTOR7 של ישראכרט(', '144' => 'קוד שרות לא תקף על פי הגדרת המערכת (VECTOR12 של ויזה)', '145' => 'קוד שרות לא תקף על פי הגדרת המערכת (VECTOR13 של ויזה)', '146' => 'לכרטיס חיוב מיידי אסור לבצע עסקת זכות', '147' => 'כרטיס לא רשאי לבצע עיסקאות בתשלומים על פי וקטור 31 של לאומיקארד', '148' => 'כרטיס לא רשאי לבצע עיסקאות טלפוניות וחתימה בלבד על פי וקטור 31 של לאומיקארד', '149' => 'כרטיס אינו רשאי לבצע עיסקאות טלפוניות על פי וקטור 31 של לאומיקארד', '150' => 'אשראי לא מאושר לכרטיס חיוב מיידי', '151' => 'אשראי לא מאושר לכרטסי חול', '152' => 'קוד מועדון לא תקין', '153' => 'כרטיס לא רשאי לבצע עסקאות גמיש (עדיף/30+(', '154' => 'כרטיס לא רשאי לבצע עסקאות חיוב מיידי על פי הגדרת המערכת )VECTOR21 של דיינרס(', '155' => 'סכום לתשלום בעסקת קרדיט קטן מידי', '156' => 'מספר תשלומים לעסקת קרדיט לא תקין', '157' => 'תקרה 0 לסוג כרטיס זה בעיסקה עם אשראי רגיל או קרדיט', '158' => 'תקרה 0 לסוג כרטיס זה בעיסקה עם אשראי חיוב מיידי', '159' => 'תקרה 0 לסוג כרטיס זה בעסקת חיוב מיידי בדולרים', '160' => 'תקרה 0 לסוג כרטיס זה בעיסקה טלפונית', '161' => 'תקרה 0 לסוג כרטיס זה בעסקת זכות', '162' => 'תקרה 0 לסוג כרטיס זה בעסקת תשלומים', '163' => 'כרטיס אמריקן אקספרס אשר הונפק בחוץ לארץ לא רשאי לבצע עסקאות תשלומים', '164' => 'כרטיס JCB רשאי לבצע עסקאות רק באשראי רגיל', '165' => 'סכום בכוכבים/נקודות/מיילים גדול מסכום העיסקה', '166' => 'כרטיס מועדון לא בתחום של המסוף', '167' => 'לא ניתן לבצע עסקת כוכבים/נקודות /מיילים בדולרים', '168' => 'למסוף אין אישור לעיסקה דולרית עם סוג אשראי זה', '169' => 'לא ניתן לבצע עסקת זכות עם אשראי שונה מהרגיל', '170' => 'סכום הנחה בכוכבים/נקודות/מיילים גדול מהמותר', '171' => 'לא ניתן לבצע עיסקה מאולצת לכרטיס/אשראי חיוב מיידי', '172' => 'לא ניתן לבצע עיסקה קודמת|(עיסקה זכות או מספר כרטיס אינו זהה)', '173' => 'עיסקה כפולה', '174' => 'למסוף אין אישור להצמדה למדד לאשראי זה', '175' => 'למסוף אין אישור להצמדה לדולר לאשראי זה', '176' => 'כרטיס אינו תקף על פי הגדרת מערכת (וקטור 1 של ישראכרט)', '177' => 'בתחנות דלק לא ניתן לבצע שרות עצמי אלא שרות עצמי בתחנות דלק', '178' => 'אסור לבצע עיסקת זכות בכוכבים/נקודות/מיילים', '179' => 'אסור לבצע עיסקת זכות בדולר בכרטיס תייר', '180' => 'בכרטיס מועדון לא ניתן לבצע עיסקה טלפונית', '200' => 'שגיאה יישומית', '700' => 'עסקה ניסיונית מאושרת', '701' => 'מספר בנק לא תקין', '702' => 'מספר סניף לא תקין', '703' => 'מספר חשבון לא תקין', '704' => 'מספרי בנק/סניף/חשבון לא תקינים', '705' => 'שגיאת ביישום', '706' => 'לא הוגדרה ספריה עבור הסוחר', '707' => 'קובץ הגדרות לא קיים לסוחר', '708' => 'סכום אפס או שלילי', '709' => 'קובץ הגדרות לא תקין', '710' => 'תאריך לא תקין', '711' => 'תקלה בבסיס הנתונים', '712' => 'פרמטר חסר או מוסד לא קיים', '800' => 'עסקה בוטלה', '900' => '3D Secure לא תקין', '903' => 'חשד להונאה' );

$sel_lang = 'he';
$item_number = $_POST['TranzilaToken'];
$ex = explode('-',$item_number);
if(count($ex) == 2)
{
	$sel_lang = $ex[0];
	$item_number = $ex[1];
}
else
	$item_number = $ex[0];
	
$SITE_LANG[selected] = $sel_lang;
	
require_once '../config.inc.php';
require_once '../inc/ProductsShop.inc.php';

if(@$_GET['secret'] != $SITE[tranzila_secret])
	die;

$db = new Database();
$pay_types = array(
	'paypal' => 'PayPal',
	'phone' => $SHOP_TRANS['pay_type_phone'],
	'tranzila' => 'Tranzila',
	'hand' => $SHOP_TRANS['pay_type_hand'],
);
$payment_status = $_POST['Response'];
$payment_amount = $_POST['sum'];
$payment_currency = $_POST['currency'];
$phone = $_POST['phone'];

$supplier = $_POST['supplier'];
$admin_notify_mail=$SITE[shop_email];
if (trim($admin_notify_mail)=="") $admin_notify_mail=$SITE[FromEmail];
$db->query("SELECT `email`,`fullname`,`adres`,`total`,`subtotal`,`items`,`hash`,`payments`,`shippingPrice`,`additional`,`shipping_name`,`shipping_adres`,`pay_type`,`greetingText`,`memberNumber`,`coupon`,`coupon_discount`,`onlyProductID` FROM `shoporders` WHERE `OrderID`='{$item_number}'");

if($db->nextRecord())
{
	$OrderTotal = floatval($db->getField('total'));
	$subtotal = floatval($db->getField('subtotal'));
	$items = $db->getField('items');
	$order_hash = $db->getField('hash');
	$payments = $db->getField('payments');
	$payer_email = $db->getField('email');
	$contact_adres = $db->getField('adres');
	$fullname = $db->getField('fullname');
	$shipping_price = floatval($db->getField('shippingPrice'));
	$additional = $db->getField('additional');
	$onlyProductID = $db->getField('onlyProductID');
	$pay_type = $db->getField('pay_type');
	$processing_details = "ID: {$_POST['myid']}\r\n";
	$processing_details .= "Crediting type: {$_POST['cred_type']}\r\n";
	$processing_details .= "Last 4 digits: {$_POST['ccno']}\r\n";
	$processing_details .= "Expires: {$_POST['expmonth']}/{$_POST['expyear']}\r\n";
	$processing_details .= "Confirmation code: {$_POST['cred_type']}\r\n";
	$processing_details .= "Tranzila Merchant index: {$_POST['index']}\r\n";
	$processing_details .= "Reference number: {$_POST['Tempref']}";
	
	$currency = $currencies[$SITE[nis]]['tranzila'];
	if($currency == '')
		$currency = '1';
	
	if (($OrderTotal > 0) && ($payment_status == '000') && ($supplier == $SITE[tranzila_merchant]) && ($payment_amount >= $subtotal) && ($payment_currency == $currency))
	{
		$db->query("UPDATE  `shoporders` SET `status`='payed',`processing_details`='{$processing_details}' WHERE `OrderID`='{$item_number}'");
		
		$order_list = '<table cellpadding="0" cellspacing="10" border="0">'.$items.'</table>';
		$replace = array(
			'http://'.$_SERVER['HTTP_HOST'].'/Admin/shopOrdersAdmin.php#order_'.$item_number,
			$fullname,
			$phone,
			$payer_email,
			$contact_adres,
			$additional,
			$payment_amount,
			$order_list,
			$SITE['tax'],
			$OrderTotal,
			$shipping_price,
			$pay_types[$pay_type],
		);
		$search = array(
			'%%admin_link%%',
			'%%fullname%%',
			'%%phone%%',
			'%%email%%',
			'%%adres%%',
			'%%additional%%',
			'%%total%%',
			'%%order_list%%',
			'%%tax%%',
			'%%before_tax%%',
			'%%shipping_price%%',
			'%%payment_type%%',
		);
		$admin_email = '<html><body style="direction:';
		$admin_email .= ($sel_lang == 'he') ? 'rtl' : 'ltr';
		$admin_email .= ';">'.nl2br(str_replace($search,$replace,GetEmailText('adminNewOrder'))).'</body></html>';
		$replace = array(
			$fullname,
			$phone,
			$payer_email,
			$contact_adres,
			$additional,
			$payment_amount,
			$order_list,
			$SITE[name],
			'http://'.$_SERVER['HTTP_HOST'].'/orderDetails.php?hash='.$order_hash.'&lang='.$SITE_LANG[selected],
			$SITE['tax'],
			$OrderTotal,
			$shipping_price,
			$pay_types[$pay_type],
		);
		$search = array(
			'%%fullname%%',
			'%%phone%%',
			'%%email%%',
			'%%adres%%',
			'%%additional%%',
			'%%total%%',
			'%%order_list%%',
			'%%site_name%%',
			'%%order_link%%',
			'%%tax%%',
			'%%before_tax%%',
			'%%shipping_price%%',
			'%%payment_type%%',
		);
		$costumer_email = '<html><body style="direction:';
		$costumer_email .= ($sel_lang == 'he') ? 'rtl' : 'ltr';
		$costumer_email .= ';">'.nl2br(str_replace($search,$replace,GetEmailText('costumerNewOrder'))).'<br/>'.GetProductFooterText($onlyProductID).'</body></html>';
		//$subject = 'הזמנה חדשה באתר '.$SITE[name];
		$subject = sprintf($SHOP_TRANS['new_order_at'],$item_number).$SITE['name'];
		sendHTMLemail($admin_notify_mail, $subject, $SITE[name].' <'.$SITE[FromEmail].'>', $admin_email);
		sendHTMLemail($payer_email, $subject, $SITE[name].' <'.$SITE[FromEmail].'>', $costumer_email);
		if(file_exists('../sites/'.$_SERVER['SERVER_NAME'].'/additional_processing.php'))
		{
			require_once('../sites/'.$_SERVER['SERVER_NAME'].'/additional_processing.php');
		}

	}
	if($payment_status != '000')
	{
		$error_details = $payment_status.' : '.$errorCodes[$payment_status];
		$db->query("UPDATE  `shoporders` SET `status`='error',`processing_details`='{$processing_details}',`error_details`='{$error_details}' WHERE `OrderID`='{$item_number}'");
	}
}
?>