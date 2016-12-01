<?
include_once("checkAuth.php");
include_once("../config.inc.php");
?>
<div align="center" style="margin-top:3px;height:20px;"><div id="top_notify"></div></div>
<script language="JavaScript" type="text/javascript" src="<?=$SITE[url];?>/js/gallery/jquery-1.4.4.min.js"></script>
<style type="text/css">
.redirects {direction:rtl;margin-top:40px;font-family:inherit;}
.redirects table {
    border:0;
    font-size:inherit;
    width:950px;
    direction:ltr;
}
.redirects table th {
    font-weight:bold;
    text-align:left;
    
}
.redirects table td {
    padding:1px;
    color:#333333;
    font-weight: normal;
    width:400px;
    overflow-wrap:break-word;
}
.addnew textarea {
    width:505px;
    height:50px;
    padding:4px;
    font-family:arial;
    direction:ltr;
    border:1px solid silver;
    font-style:italic;
    color:gray;
    font-size:13px
}
.addnew textarea.focused {
    font-style:normal;
    color:#333333;
}
#top_notify {
    width:400px;
    height:20px;
    font-size:12px;
    color:black;
    background-color:yellow;
    text-align:center;
    display:none;
    font-family:Arial;
}
.save {
    border:1px solid silver;
    background-color:whiteSmoke
    background-image:-moz-linear-gradient(top,#f5f5f5,#f1f1f1);
    background-image:-ms-linear-gradient(top,#f5f5f5,#f1f1f1);
    border: 1px solid gainsboro;
    outline:none;
    cursor:pointer;
    color:green;
    font-weight:bold;
}
#newSaveIcon.greenSave {float:none;margin-top:10px;}
</style>
<script language="javascript">
var url="<?=$SITE[url];?>/Admin/GetRedirects.php";
function reloaded(data) {
    jQuery("#redirects_list").html(data);
}
function notify(data) {
    if (data=="Redirection Added Succefully.") {
        jQuery("#top_notify").fadeTo(2000,0);
	jQuery('#src').val('');
	jQuery('#dst').val('');
        ReloadRedirects();
    }
    else {
        jQuery("#top_notify").fadeTo(2000,100);
        jQuery("#top_notify").html(data);
      
        
    }
    
}
function AddRedirect() {
    var src=jQuery("#src").val();
    var dst=jQuery("#dst").val();
    src=encodeURIComponent(src);
    var pars ="src="+src+"&dst="+dst+"&action=add";
	jQuery.ajax({
		  url: url,type:'POST',
		  data:pars,
		  success: function(data) {
		  	notify(data);
		  }
	});
	
}
function ReloadRedirects() {
	var pars ="";
	jQuery.ajax({
		  url: url,type:'POST',
		  data:pars,
		  success: function(data) {
		  	reloaded(data);
		  }
	});
}

var focused_src=0;
var focused_dst=0;
function focused(o) {
    if (o.id=="src") {
            if (focused_src==0) {
            document.getElementById(o.id).value="";
            focused_src=1;
       
       }
    }

    if (o.id=="dst") {
        if (focused_dst==0) {
            document.getElementById(o.id).value="";
            focused_dst=1;
        }
}
    document.getElementById(o.id).className="focused";
}
function deleteRedirect(rID) {
    var a=confirm("Ary you sure ?");
    if (a) {
         var pars ="rID="+rID+"&action=delredirect&sc=<?=session_id();?>";
            jQuery.ajax({
                      url: url,type:'POST',
                      data:pars,
                      success: function(data) {
                            jQuery("#top_notify").html(data);
                            jQuery("#top_notify").fadeTo(2000,100);
                            ReloadRedirects();
                      }
            });
        }
}
document.onload=ReloadRedirects();
</script>
<div class="redirects" align="center">
    <h3><?=$ADMIN_TRANS['301 redirects'];?></h3>
<div class="addnew">
    <div><?=$ADMIN_TRANS['enter source url to redirect'];?></div>
     <textarea id="src" name="src" onfocus="focused(this);"></textarea>
     <br><br>
     <div><?=$ADMIN_TRANS['enter destination url to redirect'];?></div>
     <textarea id="dst" name="dst" onfocus="focused(this);"></textarea>
        <br>
    <div id="newSaveIcon" class="greenSave" onclick="AddRedirect();"><i class="fa fa-save"></i> <?=$ADMIN_TRANS['save changes'];?></div>
</div>
<br />
    <div id="redirects_list"></div>
</div>

