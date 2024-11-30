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

    public static function calculateDue($cost_price , $quantity, $paid){
        $paid_arr = [];
        $cp_arr = [];
        $quantity_arr = [];
        $total_cost_price = 0;
        $total_paid_amount = 0;
        foreach($paid as $k => $p){
            $paid_arr[] = number_format((float)$paid[$k], 2, '.', '');
            $total_paid_amount += $paid_arr[$k];
        }
        foreach($cost_price as $key => $cp){
            $cp_arr[] = number_format((float)$cp, 2, '.', '');
            $quantity_arr[] = (int)$quantity[$key];
            $total_cost_price += $cp_arr[$key] * $quantity_arr[$key];
        }
        
        $total_cost_price = number_format((float)$total_cost_price, 2, '.', '');
        $due = $total_cost_price - $total_paid_amount;
        return array($cp_arr , $quantity_arr, $paid_arr, $total_cost_price,$total_paid_amount,$due);
    }

    public static function calculateAmountRecieved($selling_price , $quantity, $amount_received){
        $selling_price = number_format((float)$selling_price, 2, '.', '');
        $quantity = (int)$quantity;
        $amount_received = number_format((float)$amount_received, 2, '.', '');
        $total_selling_price = $selling_price * $quantity;
        $total_selling_price = number_format((float)$total_selling_price, 2, '.', '');
        $due = $total_selling_price - $amount_received;
        return array($selling_price , $quantity, $amount_received, $total_selling_price,$due);
    }

}