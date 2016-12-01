<?
print sha1("Tomeriko@321");
die();
include_once('Predis/Autoloader.php');
Predis\Autoloader::register();

$m = new Predis\Client();
//$m->flushAll();
$P=array("moshe","yossi","avi","don");
define('CACHE_PRE',"m.l");
function getCacheResult($k,$m) {
    if ($m->exists(CACHE_PRE.$k)) return json_decode($m->get(CACHE_PRE.$k),true);
    else return false;
}
function setCacheVal($k,$v,$m) {
    $m->del(CACHE_PRE.$k);
    $m->set(CACHE_PRE.$k,json_encode($v));
    return json_decode($m->get(CACHE_PRE.$k),true);
}
if ($SITE=getCacheResult('SITE',$m)) {
    print "from cachr:<br>";
    print_r($SITE);
}
else {
    $SITE=setCacheVal('SITE',$P,$m);
    print_r($SITE);
}
die('');

//$db->query("select * from admins");
$i=0;
while($db->nextRecord()) {
    $numFields=$db->numFields();
    
   for ($fNum=0;$fNum<$numFields;$fNum++) {
                $fName=$db->getFieldName($fNum);
                $CONFIG[$fName][$i]=$db->getField($fNum);
    }
    print $CONFIG['Email'][$i];
    $i++;
}



//$m->set("o","kdkdk");
//print $m->get("o");

//session_start();
//unset($site_data);
    $db=new mysqli("localhost","exitetogo","@exitetogo@", "exitetogo-new");
    if ($db->connect_errno) {
        echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
            die("dd");
    }
    $db->query("SET NAMES utf8");
    $res=$db->query("select table_name from information_schema.tables where table_schema='exitetogo-new'");
    while($row=$res->fetch_array(MYSQLI_ASSOC)) 
    {
        if ($row['table_name']=="videos") continue;
        foreach ($row as $tName) {
            $res2=$db->query("select * from {$tName}");
            while($row2=$res2->fetch_array(MYSQLI_ASSOC)) 
                $rData[$tName][]=$row2;
        }
    }
    //print json_encode($rData);
    //$m->delete('SITE_DATA');
    if (!$m->get('SITE_DATA')) {
        $m->set('SITE_DATA',json_encode($rData));
       
        print "did set";
    }
   $SITEDATA=json_decode($m->get('SITE_DATA'));
   print $SITEDATA->admins[2]->Email;

die();
