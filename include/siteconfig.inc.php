<?php session_start();
#######################
#
# Data Base Connection
#
#######################
error_reporting(1);
define('DBHOST', 'localhost'); 
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'dashboard');

$sub = "/dashboard";
if(strstr($_SERVER['HTTP_HOST'],'dev1')){
	$sub = '/agency-dashboard';	
}
//define('SURL', 'http://'.$_SERVER['HTTP_HOST'].'/admin/');
define('SURL', 'http://'.$_SERVER['HTTP_HOST'].$sub.'/admin/');
define('MYSURL', 'http://'.$_SERVER['HTTP_HOST'].$sub.'/');

define('TITLE', 'Test Site');
define('ADMIN_TITLE',"LM DIGITAL AGENCY 2.0");

$tblprefix= 'tbl_';
define('SECURITY_CHECK',"1");
define('ADMIN_HEADER_LOG',"logo.png");

$server_arr = explode("/",$_SERVER['REQUEST_URI']);
$page_name = $server_arr[count($server_arr)-1];
include(ROOT.'adodb/adodb.inc.php');
$db = ADONewConnection('mysqli');
//$db->debug = true;
$db->PConnect(DBHOST,DBUSER,DBPASS,DBNAME) or die("Database not found! please install your application properly ".$db->ErrorMsg());

//If memcache enabled enable this as well to improve performance
//$memcache = new Memcached();
//$memcache->addServer('localhost', 11211);
?>
