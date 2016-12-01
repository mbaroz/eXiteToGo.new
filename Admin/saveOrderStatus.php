<?
include_once("../config.inc.php");
if (!isset($_SESSION['LOGGED_ADMIN'])) 
	die;
if(!isset($db))
	$db=new Database();
$allowed_statuses = array('awaiting','payed','delivered','cancelled');

switch($_POST['action'])
{
	case 'StatusUpdate':
		$OrderID = intval($_POST['OrderID']);
		$status = $_POST['status'];
		if($OrderID > 0 && in_array($status,$allowed_statuses))
		{
			
			$db->query("UPDATE `shoporders` SET `status`='{$status}' WHERE `OrderID`='{$OrderID}'");
			?>
			<? if($status == 'awaiting') { ?><a href="#" onclick="ChangeOrderStatus(<?=$OrderID;?>,'payed');return false;"><?=$SHOP_TRANS['payed'];?></a>&nbsp;|&nbsp;<a href="#" onclick="ChangeOrderStatus(<?=$OrderID;?>,'cancelled');return false;"><?=$SHOP_TRANS['cancelled'];?></a><? } ?>
			<? if($status == 'payed') { ?><a href="#" onclick="ChangeOrderStatus(<?=$OrderID;?>,'awaiting');return false;"><?=$SHOP_TRANS['awaiting_payment'];?></a>&nbsp;|&nbsp;<a href="#" onclick="ChangeOrderStatus(<?=$OrderID;?>,'delivered');return false;"><?=$SHOP_TRANS['sent'];?></a>&nbsp;|&nbsp;<a href="#" onclick="ChangeOrderStatus(<?=$OrderID;?>,'cancelled');return false;"><?=$SHOP_TRANS['cancelled'];?></a><? } ?>
			<? if($status == 'delivered') { ?><a href="#" onclick="ChangeOrderStatus(<?=$OrderID;?>,'payed');return false;"><?=$SHOP_TRANS['payed'];?></a>&nbsp;|&nbsp;<a href="#" onclick="ChangeOrderStatus(<?=$OrderID;?>,'cancelled');return false;"><?=$SHOP_TRANS['cancelled'];?></a><? } ?>
			<?
		}
		break;
	case 'MassStatusUpdate':
		$status = $_POST['status'];
		if(in_array($status,$allowed_statuses))
		{
			$db = new Database();
			foreach($_POST['orderid'] as $OrderID)
			{
				$OrderID = intval($OrderID);
				if($OrderID > 0)
					$db->query("UPDATE `shoporders` SET `status`='{$status}' WHERE `OrderID`='{$OrderID}'");
			}
		}
		break;
}

?>