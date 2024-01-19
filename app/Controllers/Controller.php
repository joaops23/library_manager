<?php

namespace Controllers\Abs;

abstract class Controller {
    protected function process($args){
        $result = [];
        $data = explode("&", $args);
        foreach($data as $key => $val){
            $data_content = explode("=", urldecode($val));
            $result[$data_content[0]] = $data_content[1];
        }

        $result = json_encode($result);
    
        return  $result;
    }
}