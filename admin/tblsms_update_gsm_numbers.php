<?php
error_reporting(1);
include('../adodb/adodb.inc.php');
include('../include/siteconfig.inc.php');
$db = ADONewConnection('mysql');
$db->Connect(DBHOST,DBUSER,DBPASS,DBNAME) or die("Database not found! please install your application properly");

$sql = "SELECT sms.id as sms_id, gsm.gsm_number, sms.forward_number, sms.callerid , sms.sms, sms.sms_dt FROM sms, gsm 
		WHERE sms.forward_number = gsm.mapped_number AND sms.gsm_number IS NULL;";
$result = $db->Execute($sql);
echo "Updating...";
while(!$result->EOF){
    //echo $result->fields['sms_id'] . '='  . $result->fields['gsm_number'] . "<br>";
    $updateSql = "UPDATE sms SET gsm_number = '" . strip_tags($result->fields['gsm_number']) 
    				. "' WHERE sms.id=".intval($result->fields['sms_id']) . ";";
    $db->Execute($updateSql);
    $result->MoveNext();
}
echo "Done";
