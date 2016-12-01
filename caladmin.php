<?
if (!isset($_SESSION['LOGGED_ADMIN'])) die(" יש להיכנס למצב ניהול על מנת לערוך או להוסיף אירועים למערכת ");
?>
<iframe src="/calendar/admin.php" border="0" frameborder="0" scrolling="no" style="width:98%;height:400px"></iframe>
