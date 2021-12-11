<?php

namespace App\Services;

class MyService implements ServiceInterface {

    public function __construct()
    {
        dump("Hi!");
    }
}