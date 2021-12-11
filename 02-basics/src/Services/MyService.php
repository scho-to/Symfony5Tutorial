<?php

namespace App\Services;

use Doctrine\ORM\Event\PostFlushEventArgs;

class MyService {

    public function __construct()
    {
        dump("Hi!");
    }

    public function postFlush(PostFlushEventArgs $args)
    {
        dump("postFlush here!");
        dump($args);
    }

    public function clear()
    {
        dump("hello from clear");
    }
}