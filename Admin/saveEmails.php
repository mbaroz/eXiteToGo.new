<?
include_once("../config.inc.php");
//include_once("../database.php");
$db=new Database();

if(@$_GET['delEmail'] != '')
{
	$db->query("DELETE FROM `email_texts` WHERE `emailID`='{$_GET['delEmail']}'");
	header('Location: /Admin/emailsAdmin.php');
	die;
}
else
{
	
	if(@$_POST['newEmail'] == 1)
	{
		$db->query("SELECT `emailID` FROM `email_texts` WHERE `emailID`='ProductEmail_{$_POST['ProductID']}'");
		if($db->nextRecord())
		{
			$db->query("UPDATE email_texts SET `emailText`='{$_POST['emailText']}' WHERE `emailID`='ProductEmail_{$_POST['ProductID']}'");
		}
		else
		{
			$db->query("SELECT `productTitle` FROM `products` WHERE `ProductID`='{$_POST['ProductID']}'");
			$db->nextRecord();
			$emailTitle = addslashes($db->getField('productTitle'));
			//$emailText = addslashes($_POST['emailText']);
			$emailText = str_ireplace("'","&lsquo;",$emailText);
			$emailDetails = addslashes($_POST['emailDetails']);
			$db->query("INSERT INTO email_texts SET `emailID`='ProductEmail_{$_POST['ProductID']}',`emailTitle`='{$emailTitle}',`emailDetails`='{$emailDetails}',`emailText`='{$emailText}'");
		}
		
	}
	else
	{
		$SQL="UPDATE email_texts SET ";
	
		foreach ($_POST as $key => $value) {
			$value = str_replace(array('[[',']]'),array('%%','%%'),$value);
			//$value = addslashes($value);
			//$value=htmlspecialchars($value);
			$value=str_ireplace("'","&lsquo;",$value);
			$db->query($SQL."`emailText` = '{$value}' WHERE `emailID`='{$key}'");
		}
	}
}
print "השינויים נשמרו בהצלחה !";
?>


