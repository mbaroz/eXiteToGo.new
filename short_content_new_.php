<?
?>
<html>
<head>
	<title>Test</title>
	<style type="text/css">
	.main {font-family: arial;width:100%;direction: rtl;}
	#boxes {width: 930px;margin:0 auto;}
	ul#boxes {padding:0;margin:0;list-style: none}
	ul#boxes li {
		box-sizing:border-box;
		width:200px;
		height:auto;
		padding:0px;
		background-color: #999999;
		float:right;
		margin-bottom:10px;
		margin-left:10px;


	}
	
	ul#boxes li.wide {width:100%;}
	.photoHolder{background-color: #333;height:100px;clear: both;margin:6px;width:auto;}
	ul#boxes li .short_content_container {
		background-color: silver;
		padding:6px;
	}
	ul#boxes li, ul#boxes li .short_content_container {
		//border-radius: 6px;
	}
	ul#boxes li .short_content_container {
		//border-top-left-radius: 0px;
		//border-top-right-radius: 0px;
	}
	ul#boxes li.wide .photoHolder {
		float:right;
		width:190px;
	}
	ul#boxes li.wide .short_content_container {
		float:right;
		margin:6px 0px;
		box-sizing:border-box;
		width:712px;
		display: block;
		max-height: 100%;
	}
	ul#boxes li.wide .short_content_container {
		border-radius: 0px;

	}
	ul#boxes li.wide .inner {
		background-color: silver;
		//border-radius: 6px;
		height: auto
	}
	
	</style>
<script src="http://exitetogo.local:8888/js/jquery-1.9.1.min.js"></script>
<script src="http://exitetogo.local:8888/js/jquery-migrate-1.2.1.min.js"></script>
<script language="JavaScript" type="text/javascript" src="http://exitetogo.local:8888/js/gallery/jquery-ui-1.9.2.custom.min.js"></script>
</head>
<body>
<div class="main">
	<ul id="boxes">
		<li>
			<div class="inner">
				<div class="photoHolder"></div>
				<div class="short_content_container">
					here comes the content
				</div>
				<div style="clear:both"></div>
			</div>
		</li>
		<li>
			<div class="inner">
				<div class="photoHolder"></div>
				<div class="short_content_container">
					here comes the content
				</div>
				<div style="clear:both"></div>
			</div>
		</li>
		<li>
			<div class="inner">
				
				<div class="short_content_container">
					here comes the content<br>here comes the content<br>
				</div>
				<div style="clear:both"></div>
			</div>
		</li>
		<li>
			<div class="inner">
				<div class="photoHolder"></div>
				<div class="short_content_container">
					here comes the content
				</div>
				<div style="clear:both"></div>
			</div>
		</li>
		<li class="wide">
			<div class="inner">
				<div class="photoHolder"></div>
				<div class="short_content_container">
					here comes the content
				</div>
				<div style="clear:both"></div>
			</div>
		</li>
		<li>
			<div class="inner">
				<div class="photoHolder"></div>
				<div class="short_content_container">
					here comes the content
				</div>
				<div style="clear:both"></div>
			</div>
		</li>
		<li class="wide">
			<div class="inner">
				
				<div class="short_content_container">
					here comes the content
				</div>
				<div style="clear:both"></div>
			</div>


</div>
</body>
</html>