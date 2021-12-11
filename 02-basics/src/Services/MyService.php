<?php

namespace App\Services;

class MyService {

    public $logger;
    public $my;

    public function __construct()
    {
        //dump($this->logger);
        //dump($this->my);
    }

    public function someAction()
    {
        dump($this->logger);
        dump($this->my);
    }
}