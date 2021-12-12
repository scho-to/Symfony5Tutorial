<?php

namespace App\Events;

use stdClass;
use Symfony\Contracts\EventDispatcher\Event;

class VideoCreatedEvent extends Event {
    public ?stdClass $video = null;
    public function __construct($video)
    {
        $this->video = $video;
    }
}