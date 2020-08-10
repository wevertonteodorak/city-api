<?php
namespace App\src\Http;

use Exception;
use HttpResponse as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BaseController {
    

    public function validate($data, $rules){
        $validator = (new Validator())->make(
            $data,
            $rules
        );

        if (!$validator->passes()) {
            $message = $validator->errors()->getMessages();
            $final_message = '';
            foreach ($message as $key => $value) {
                $final_message .= "$key: ".implode(',', $value)." ";
            }
            //exit();
            $message = json_encode($final_message);
            
            throw new Exception($message, 422);
           
        }

        $result = [];
        foreach ($rules as $key => $value) {
            if(isset($data[$key])) $result[$key] = $data[$key];
        }

        return $result;

        //getMessageBag()->toArray()
    }
}