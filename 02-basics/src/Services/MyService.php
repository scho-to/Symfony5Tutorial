<?php

namespace App\Services;

class MyService {
    public function __construct($second_service)
    {
        dump($second_service);
    }
}