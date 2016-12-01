<?
session_start();
$timeout=40*60;
//$_SESSION['timeout']=3*60;
$startTime=$_GET['startTime'];

$currentTime=time();
$diff=$currentTime-$startTime;

if ($diff<1) $diff=1; 
$min=number_format(($timeout-$diff)/60,0);
if ($min<0) $min=0;
if (($timeout-$diff)<(5*60)) {
    print "<span dir='ltr'>דקות</span> ";  
    print $min;
  
    ?>
    <script>
      
        showAdminAlertTimeout();
        clearInterval(intervalAdminExit);
        var intervalAdminExit=setInterval("checkLoggedInTimeout()",2000);
    </script>
    
    <?
    
    
}
if ($min<1) {
    ?>
    <script>
        clearInterval(intervalAdminExit);
    </script>
    <?
}
?>