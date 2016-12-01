<?
$SEARCH_LABELS=array("לא נמצאו תוצאות חיפוש עבור הביטוי");
if ($SITE_LANG[selected]=="en") $SEARCH_LABELS=array("No search results were found for ");
$instantOn=0;
?>

<style type="text/css">
.results ul {
	list-type:none;
	margin:4px 18px;
	padding:0px;
	width:99%;
	
}
.results li {
	list-style:none;
	list-type:none;
	margin-bottom:15px;
}
.resultsTitle a{
	font-size:16px;
	text-decoration:underline;
	color:#<?=$SITE[titlescolor];?>
}
.resultsDesc {
	text-decoration:none;
	color:#<?=$SITE[contenttextcolor];?>
}
</style>
<script language="javascript">
function loadingResults(targetDiv) {
	
}
function FailedSearch() {
	
}
function GetResultsHTML(TargetDiv,search_str) {
	if (TargetDiv) var TargetDATA=document.getElementById(TargetDiv);
	var pars="q="+search_str;
	jQuery.ajax({
		  url: sr_url,type:'POST',
		  data:pars,
		  success: function(data) {
		  	 if (TargetDiv)  jQuery(TargetDATA).html(data);
		  }
	});
//	var myAjax = new Ajax.Request(sr_url, {method: 'post',postBody:pars,onSuccess: function(transport){
//	     var response = transport.responseText;
//	   	 if (TargetDiv)  TargetDATA.innerHTML=response;
//	       },onFailure:FailedSearch,onLoading:function () {loadingResults(TargetDiv)}
//	    });
}
</script>
<div id="sr" style="padding:0;margin:0">
<?include_once("GetSearchResults.php");?>
</div>
<div class="clear" style="height:10px"></div>

