<?php
namespace App\src\Http;

use Exception;
use HttpResponse as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BaseController {
    

    public function validate($data, $rules){
        $valdiator = (new Validator())->make(
            $data,
            $rules
        );

        throw_if(!$valdiator->passes(), new Exception('Erros de preenchimento'));

        $result = [];
        foreach ($rules as $key => $value) {
            if(isset($data[$key])) $result[$key] = $data[$key];
        }

        return $result;

        //getMessageBag()->toArray()
    }
}