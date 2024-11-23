<?php

namespace App\Http\Helpers;

class Helper
{
    public static function generateResponseBody($data , $msg, $success = true, $errorCode = 200)
    {
        if ($success) {
            $status = \Config::get('ws_constant.status.SUCCESS');     //for success
        } else {
            $status = \Config::get('ws_constant.status.FAILED');     //for error
        }
        if(gettype($msg) === 'array' && array_key_exists('errors',$msg)){
            $msg = implode(",",$msg['errors']);
        }

        $result['responseData'] = $data;
        $result['responseStatus'] = array(
            'STATUS' => $status,
            'MESSAGE' => $msg,
            'STATUSCODE' => $errorCode
        );
        $result['extraData'] = (object)[];     

        return $result;
    }
}