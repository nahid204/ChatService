<?php

include 'util.php';
include 'chat_service_db.php';
header('Content-Type: application/json');
$entityBody = file_get_contents('php://input');

//$entityBody='{ 
//     "email":"info@apppartner.com", 
//     "password":"qwerty" 
//}';

$userInfo = JSONUtil::getArray($entityBody);

$db = new ChatServiceDB();
$exisiting_id = $db->getUserId($userInfo['email'],$userInfo['password']);

if($exisiting_id != NULL)
{
    $user = $db->getUserInfoJSON($exisiting_id);
    if($user != null)
    {
        echo $user;
    }
    else {
        echo Error::getDataBaseError();
    }
}
else
{
    echo Error::getLoginFailedError();
}

?>

