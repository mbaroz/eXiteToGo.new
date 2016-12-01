<?include_once("config.inc.php");
//TODO: Add option to add new Category even when there is no content in the middle
include_once("lang.admin.php");
$minShow="none";
$maxShow="";
if ($HTTP_COOKIE_VARS['admin_min']=="1") {
	$minShow="";
	$maxShow="none";
}
?>
<style type="text/css">
#newSaveIcon {
	background-image:url('<?=$SITE[url];?>/Admin/images/button_bg.png');
	background-repeat:repeat-x;
	min-width:50px;
	padding:3px;
	font-family:arial;
	height:30px;
	font-weight:bold;
	font-size:12px;
	cursor:pointer;
	display:inline;
	border:1px solid silver;
}
.hidemobile {border:0px !important;}
</style>
<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/Admin/AdminEditing.css.php?mode=view">
<div id="overlayBG" class="overlayBG" style="display:none"></div>
<div id="TopAdminLabel" class="AdminTopNew" align="center">
<div class="admin_switchViews" style="float:<?=$SITE[align];?>"><a href="<?=$SITE[url];?>/Admin/so.php"><i class="fa fa-power-off"></i> <?=$ADMIN_TRANS['sign out'];?></a></div>
<div class="admin_switchViews" style="float:<?=$SITE[align];?>"><a href="<?=$SITE[url];?>/Admin/switch_mode.php"><i class="fa fa-desktop"></i> <?=$ADMIN_TRANS['back to edit mode'];?></a></div>

<?include_once("clientscripts.inc.php");
if (!$pID) $pID=0;
?>
</div>
<div class="AdminTopMarginizer"></div>

<script language="javascript">
var catParentID="<?=$CHECK_CATPAGE[parentID];?>";
var url="";
var DivMessage="Loading...";
function toggleTopAdmin(t) {
	var AdminMinimized="1";
	if (t==2) AdminMinimized="0";
	SetCookie("admin_min",AdminMinimized,0);
	Effect.toggle('TopAdminBGMax','slide',{duration:0.5});
	window.setTimeout("$('TopAdminBGMin').toggle();",t);
}
function getPageScroll(){
	var yScroll;
	if (self.pageYOffset) {
		yScroll = self.pageYOffset;
	} else if (document.documentElement && document.documentElement.scrollTop){	 // Explorer 6 Strict
		yScroll = document.documentElement.scrollTop;
	} else if (document.body) {// all other Explorers
		yScroll = document.body.scrollTop;
	}

	arrayPageScroll = new Array('',yScroll) 
	return arrayPageScroll;
}

function getPageSize(){
	var xScroll, yScroll;
	if (window.innerHeight && window.scrollMaxY) {	
		xScroll = document.body.scrollWidth;
		yScroll = window.innerHeight + window.scrollMaxY;
	} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
		xScroll = document.body.scrollWidth;
		yScroll = document.body.scrollHeight;
	} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
		xScroll = document.body.offsetWidth;
		yScroll = document.body.offsetHeight;
	}
	
	var windowWidth, windowHeight;
	if (self.innerHeight) {	// all except Explorer
		windowWidth = self.innerWidth;
		windowHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
		windowWidth = document.documentElement.clientWidth;
		windowHeight = document.documentElement.clientHeight;
	} else if (document.body) { // other Explorers
		windowWidth = document.body.clientWidth;
		windowHeight = document.body.clientHeight;
	}	
	
	// for small pages with total height less then height of the viewport
	if(yScroll < windowHeight){
		pageHeight = windowHeight;
	} else { 
		pageHeight = yScroll;
	}

	// for small pages with total width less then width of the viewport
	if(xScroll < windowWidth){	
		pageWidth = windowWidth;
	} else {
		pageWidth = xScroll;
	}


	arrayPageSize = new Array(pageWidth,pageHeight,windowWidth,windowHeight) 
	return arrayPageSize;
}
function ScrollDetect() {
	var arrayScroll=getPageScroll();
	var scrollTop=arrayScroll[1];
	document.getElementById("TopAdminLabel").style.top=scrollTop-1+"px";	;
	//document.TopAdminLabel.top=scrollTop-1;
}
Object.extend(Element, {
	getWidth: function(element) {
	   	element = $(element);
	   	return element.offsetWidth; 
	},
	getHeight: function(element) {
	   	element = $(element);
	   	return element.offsetHeight; 
	},
	setWidth: function(element,w) {
	   	element = $(element);
    	element.style.width = w +"px";
	},
	setHeight: function(element,h) {
   		element = $(element);
    	element.style.height = h +"px";
	},
	setTop: function(element,t) {
	   	element = $(element);
    	element.style.top = t +"px";
	},
	setLeft: function(element,t) {
	   	element = $(element);
    	element.style.left = t +"px";
	},
	setSrc: function(element,src) {
    	element = $(element);
    	element.src = src; 
	},
	setHref: function(element,href) {
    	element = $(element);
    	element.href = href; 
	},
	setInnerHTML: function(element,content) {
		element = $(element);
		element.innerHTML = content;
	}
});
//window.onscroll=ScrollDetect;
//window.onresize=ScrollDetect;
</script>
<style type="text/css">.masterHeader_wrapper{margin-top:40px;}</style>