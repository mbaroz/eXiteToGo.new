<div align="center">
<form name="login" id="login" method="POST" action="login/" target="_self" onsubmit="return validAuth()">
<table border="0" width="100%" height="100%" style="border-collapse: collapse" bordercolor="silver" cellpadding="4" cellspacing="3">
	<tr>
		<td align="center">
		<table cellpadding="0" cellspacing="0" class="general">
			
			<tr>
				<td style="color:white;font-weight:bold" valign="middle" width="150" align="center"><?=$LABEL[login][0];?> : </td>
				<td>
				<input type="text" name="email" class="ENtextboxSign" dir="ltr" value="<?=$HTTP_COOKIE_VARS["Email"];?>">
				</td>
			</tr>
			<tr>
				<td style="color:white;font-weight:bold" height="50" width="150" align="center" valign="middle"><?=$LABEL[login][1];?>: </td>
				<td>
				<input type="password" name="passwd" class="ENtextboxSign" dir="ltr">
				</td>
			</tr>
			<tr>
				<td valign="middle"  colspan="3" align="left" style="padding-left:5px;">
				<input type="submit" class="BigButton" value="<?=$LABEL[login][2];?>">
				<div class="loginMsg" id="loginMessage"><br><?=$curMsg;?></div>
				</td>
			</tr>
			<tr>
				<td valign="middle" width="150" align="center">
				<a href="<?=$SITE[url];?>/register.php" style="color:white"><?=$LABEL[login][3];?></a></td>
				
				<td  valign="middle" width="150" align="center">
				<a href="<?=$SITE[url];?>/Admin/passreminder.php" style="color:white"><?=$LABEL[login][4];?></a></td>
				
			</tr>
		</table>
		</td>
	</tr>
</table>
<input type="hidden" name="RET_URL" value="<?=$RET_URL;?>">
</form>
</div>
<?
if ($HTTP_COOKIE_VARS['Email']) {
	?>
	<script language="javascript">
	document.onload=login.passwd.focus();
	</script>
	<?
}
else {
	?>
	<script language="javascript">
	document.onload=login.email.focus();
	</script>
	<?
}
?>
