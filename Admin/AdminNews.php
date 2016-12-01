<style type="text/css">

.NewsBoxContainer li {
	list-style:none;
	list-type:none;
	
}
.NewsItem a {
	text-decoration:none;
	color:#<?=$SITE[linkscolor];?>;
}

.NewsBox {
	overflow-y: hidden;
	padding-<?=$SITE[align];?>:10px;
	text-align:<?=$SITE[align];?>;
	margin-<?=$SITE[align];?>:5px;
	font-family:inherit;
	height:157px;
}
#NewsBoxContainer {
	list-type:none;
	padding:0px;
	margin:0;
}
.NewsItem,NewsItem a:visited {
	color:#333333;
	text-decoration:none;
	padding-bottom:10px;
	font-size:<?=$SITE[contenttextsize];?>px;
	list-type:none;
	list-style:none;
	overflow: hidden;
}
a, a:visited {font-family: inherit;}
.NewsSeperator {
	border-bottom:1px dotted #<?=$SITE[seperatorcolor];?>;;
}
</style>
<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/css/he_fonts.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/js/lightbox/css/jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript" src="<?=$SITE[url];?>/js/jquery.vticker.js"></script> 
<script type="text/javascript" src="<?=$SITE[url];?>/js/lightbox/jquery.lightbox-0.5.js"></script>
<script language="javascript" type="text/javascript">

jQuery.noConflict();
	jQuery(function(){
		jQuery('.news-container').vTicker({
		speed: 650,
		pause: 4000,
		showItems: 1,
		animation:'fade',
		mousePause: true,
		height: 0,
		direction: 'up'
		});
});
jQuery(function() {
			jQuery('a.photo_gallery').lightBox({
			imageLoading:'<?=$SITE[url];?>/images/lightbox/loading.gif',
			imageBtnPrev:'<?=$SITE[url];?>/images/lightbox/prev.gif',	
			imageBtnNext:'<?=$SITE[url];?>/images/lightbox/next.gif',	
			imageBtnClose:'<?=$SITE[url];?>/images/lightbox/close.gif',
			imageBlank:'<?=$SITE[url];?>/images/blank.gif',
			overlayOpacity:0.5,
			txtImage:'תמונה'
			})
});
function GetRemoteNews() {
	var url="http://admin.exite.co.il/GetAdminNewsApi/?urlKeyContent=<?=$urlKeyContent;?>";
	jQuery.getJSON( url, function( data ) {
	var items = [];
	jQuery.each(data, function( key, val ) {
	    items.push( "<li class='NewsItem'>" + val.news_content + "</li>" );
	  });
	 if (data[0].scrollspeed==0) jQuery(".NewsBox").addClass("news-container");
	 else jQuery(".NewsBox").attr("id","vmarquee");
	 jQuery("#footerContentAdmin").html(data[0].footer_content);
	 jQuery( "<ul/>", {
	    "id": "NewsBoxContainer",
	    html: items.join( "" )
	  }).appendTo( ".NewsBox" );
	});
}

</script>
<div class="NewsBox"></div>

<script>
GetRemoteNews();
</script>