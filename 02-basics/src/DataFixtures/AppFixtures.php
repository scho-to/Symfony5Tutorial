<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\User;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private ?ObjectManager $_manager = null;
    public function load(ObjectManager $manager): void
    {
        $amounts = [
            'user' => 2
        ];
        $this->_manager = $manager;
        $this->_createUsers($amounts['user']);
        $this->_manager->flush();
    }

    private function _createUsers($amount): void
    {
        for ($i=1; $i <= $amount; $i++) { 
            $user = new User();
            $user->setName("User".$i);
            $this->_manager->persist($user);
        }
    }
}
