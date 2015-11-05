<?php

include 'util.php';
include 'chat_service_db_pdo.php';
header('Content-Type: application/json');
$entityBody = file_get_contents('php://input');
//$entityBody='{ 
//    "email":"info@apppartner.com", 
//    "password":"qwerty", 
//    "first_name":"John", 
//    "last_name":"Doe" 
//}';
$userInfo = JSONUtil::getArray($entityBody);

$db = new ChatServiceDB();
$exisiting_id = $db->getUserId($userInfo['email'],$userInfo['password']);


if($exisiting_id != NULL)
{
    echo Error::getUserAlreadyExistError(); //User Already exisits
}
else
{
    $insert_id = $db->registerUser($userInfo['email'],
                            $userInfo['password'], 
                            $userInfo['first_name'], 
                            $userInfo['last_name']);
    
    if($insert_id != NULL)
    {
        $user = $db->getUserInfoJSON($insert_id); //Registration successful
        
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
        echo Error::getRegistrationFailedError();
    }
    
}



?> 
