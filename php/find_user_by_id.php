<?php 

require('../db/database.php');
require('../classes/admin.php');

$dbObj = new Database();
$adminObj = new Admin(0, $dbObj->open_db_connection());

$secret_id = $_GET['id'];
$type = "secret_id";

$data = $adminObj->findExactUserBy($type, $secret_id);

if($data['summoner']) {
    echo $data['name'] . "," . $data['summoner'];
}
else {
    echo false;
}
?>