<?
include_once("checkAuth.php");
$db=new database();
?>
<link rel="stylesheet" type="text/css" href="<?=$SITE[cdn_url];?>/js/datatables/jquery.dataTables.min.css"></link>
<link rel="stylesheet" type="text/css" href="<?=$SITE[cdn_url];?>/js/datatables/buttons.dataTables.min.css"></link>

<script type="text/javascript" src="<?=$SITE[cdn_url];?>/js/datatables/jszip.min.js"></script>
<script type="text/javascript" src="<?=$SITE[cdn_url];?>/js/datatables/pdfmake.min.js"></script>
<script type="text/javascript" src="<?=$SITE[cdn_url];?>/js/datatables/vfs_fonts.js"></script>
<script type="text/javascript" src="<?=$SITE[cdn_url];?>/js/datatables/buttons.html5.min.js"></script>
<style>
.AllWrapper {margin:0 auto;font-family: Arial;width:100%;text-align: center;}
.productsTableWrapper, .productsTableWrapper *  {box-sizing:border-box;font-family:arial;direction: rtl}
.productsTableWrapper {width:90%;margin:0 auto;}
.productsTableWrapper .dataTables_filter input[type="search"] {width:200px;padding:10px;min-height: 30px;border:0px;border-bottom: 1px solid silver;outline: none}
.q_out {color:red;}
.q_in {color:green;}
.productsTableWrapper tbody td {text-align: center;font-weight: normal;}
</style>
<div class="AllWrapper">
		<h2><?=$SHOP_TRANS['items'];?></h2>	
</div>

<div class="productsTableWrapper">
	<table id="productsList" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
				<th>קוד מוצר</th>
				<th><?=$SHOP_TRANS['item_name'];?></th>
				<th><?=$SHOP_TRANS['price'];?></th>
				<th><?=$SHOP_TRANS['quantity'];?></th>
		
			</tr>
		</thead>
		<tfoot>
            <tr>
				<th>קוד מוצר</th>
				<th><?=$SHOP_TRANS['item_name'];?></th>
				<th><?=$SHOP_TRANS['price'];?></th>
				<th><?=$SHOP_TRANS['quantity'];?></th>
		
			</tr>
		</tfoot>
		<tbody>
		<?
		$db->query("SELECT * from products ORDER BY ProductID DESC");
		while($db->nextRecord()) {
			$q_class="q_in";
			if ($db->getField("quantity")<1) $q_class="q_out";
			?>
			<tr>
				<td><?=$db->getField("ProductID");?></td>
				<td><?=$db->getField("ProductTitle");?></td>
				<td><?=$SITE['ItemsCurrency'];?><?=$db->getField("ProductPrice");?></td>
				<td class="<?=$q_class;?>"><?=$db->getField("quantity");?></td>
			</tr>
		<?
		}
		?>
		</tbody>
</table>
</div>
<script>
function initEXiteAdminTables() {
	jQuery('#productsList').DataTable( {
        dom: 'Bfrtip',
        buttons: [{
        	 extend: 'excelHtml5',
        	 title: 'ProductsExport'
        },
       
        {
        	extend:'csvHtml5',
        	title:'ProductsExport'
        },
        {
        	extend:'pdfHtml5',
        	title:'ProductsExport'
        },
        {extend:'copyHtml5'}
        ],
        "language": {
		    "paginate": {
		      "next": "לעמוד הבא","previous": "לעמוד הקודם"
		    },
		    "search": "חפש מוצר/ים",
		    "info": "מציג עמוד _PAGE_ מתוך _PAGES_"
	  }
    } );
}
</script>

<script>

 	window.setTimeout("initEXiteAdminTables();",60);

</script>

<br><br>