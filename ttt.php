<?
$m = new Memcached;
$m->addServer('localhost',11211);
//$m->set("o","kdkdk");
print $m->get("o");
die("");
//print round((679.02-39));
//$checkdns=dns_get_record ("www.nagler.co.il");
//print $checkdns[0]['ip'];
//die();
require 'Predis/Autoloader.php';
Predis\Autoloader::register();
$client = new Predis\Client();
$client->set('foo', 'bar');
$value = $client->get('foo');
print $value;
?>