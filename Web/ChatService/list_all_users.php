<?php
include 'util.php';
include 'chat_service_db_pdo.php';
header('Content-Type: application/json');

//$entityBody = file_get_contents('php://input');


//$entityBody='{ 
//    "requester_user_id": 1
//}';

//$requester = JSONUtil::getArray($entityBody);
$requester = $_GET;

$db = new ChatServiceDB();
$data = $db->getAllUsersJSON($requester['requester_user_id']);
if($data != null)
{
    echo $data;
}
else {
    echo Error::getDataBaseError();
}


?>