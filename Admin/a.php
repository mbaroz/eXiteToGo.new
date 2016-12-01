<?php
$email="shmigola@yahoo.com";
$site_id="292";
$websiteaddress="hakita.co.il";
$user_data_encoded=base64_encode($email."|".$site_id."|".$websiteaddress);
$link='http://www.accessi.do/sites/www.accessi.do/accessi_pay.php?togo_item='.$user_data_encoded;
print $link;
die();
?>

</body>
</html>
