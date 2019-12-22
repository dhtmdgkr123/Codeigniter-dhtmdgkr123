<?php
if(! class_exists('Json')) {
    class Json
    {
        public function __construct()
        {
            
        }
        public function echo(array $data) : void
        {
            header('content-type application/json charset=utf-8');
            echo json_encode($data);
        }
    }
}