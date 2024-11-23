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

    public static function calculateDue($cost_price , $quantity, $paid, $selling_price){
        $cost_price = number_format((float)$cost_price, 2, '.', '');
        $quantity = (int)$quantity;
        $paid = number_format((float)$paid, 2, '.', '');
        $selling_price = number_format((float)$selling_price, 2, '.', '');
        $total_cost_price = $cost_price * $quantity;
        $total_cost_price = number_format((float)$total_cost_price, 2, '.', '');
        $due = $total_cost_price - $paid;
        return array($cost_price , $quantity, $paid, $selling_price,$total_cost_price,$due);
    }

}