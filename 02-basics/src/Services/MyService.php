<?php

namespace App\Services;

class MyService {

    use OptionalServiceTrait;

    public function __construct()
    {
        //dump('');
    }

    public function someAction()
    {
        dump($this->service->doSomething2());
    }

    /**
     * @required
     */
    // public function setSecondService(MySecondService $second_service)
    // {
    //     dump($second_service);
    // }
}