<?php
class JSONUtil
{
    public static  function getArray($jsonString)
    {
        $json = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $jsonString), true );
        return $json;
    }
    public static function printLastJSONStatus()
    {
        $status = json_last_error();
        $msg = json_last_error_msg();
        echo $msg;
        return $status;

    }
}

class Error
{
    const ERROR_LOGIN_FAILED = 101;
    const ERROR_USER_ALREADY_EXIST =201;
    const ERROR_USER_REGISTRATION_FAILED =202;
    
    const ERROR_DATABASE_ERROR =301;
    
    const ERROR_TITLE_LOGIN='Login Error!';
    const ERROR_TITLE_REGISTRATION ='Registration Error!';
    const ERROR_TITLE_DB ='Database Error!';
    public static function getErrorJSON($code, $title, $message)
    {
        $array = array(
            'error_code' => $code,
            'error_title' => $title,
            'error_message' => $message
        
        );
        $json = json_encode($array);
        return $json;
    }
    
    public static function getUserAlreadyExistError()
    {
        $error = self::getErrorJSON(self::ERROR_USER_ALREADY_EXIST
                , self::ERROR_TITLE_REGISTRATION
                , 'User Already exists!');
        return $error;
    }
    
    public static function getRegistrationFailedError()
    {
        $error = self::getErrorJSON(self::ERROR_USER_REGISTRATION_FAILED
                , self::ERROR_TITLE_REGISTRATION
                , 'Registration Failed!');
        return $error;
    }
    
    public static function getDataBaseError()
    {
        $error = self::getErrorJSON(self::ERROR_DATABASE_ERROR
                , self::ERROR_TITLE_DB
                , 'Database error!');
        return $error;
    }
    public static function getLoginFailedError()
    {
        $error = self::getErrorJSON(self::ERROR_LOGIN_FAILED
                , self::ERROR_TITLE_LOGIN
                , 'Email or Password was Invalid!');
        return $error;
    }
    
}


?>
