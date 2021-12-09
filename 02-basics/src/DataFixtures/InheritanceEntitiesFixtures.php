<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Author;
use App\Entity\Pdf;
use App\Entity\Video;

class InheritanceEntitiesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i <= 2; $i++) { 
            $author = new Author();
            $author->setName("Author Name ".$i);
            $manager->persist($author);

            for ($j=1; $j <= 3; $j++) { 
                $pdf = new Pdf();
                $pdf->setFilename("pdf name od user".$i);
                $pdf->setDescription("pdf desc of user".$i);
                $pdf->setSize(5454);
                $pdf->setPagesNumber(3);
                $pdf->setOrientation("landscape");
                $pdf->setAuthor($author);
                $manager->persist($pdf);
            }

            for ($k=1; $k <= 2; $k++) { 
                $video = new Video();
                $video->setFilename("video name od user".$i);
                $video->setDescription("video desc of user".$i);
                $video->setSize(1000);
                $video->setFormat("mp4");
                $video->setDuration(200);
                $video->setAuthor($author);
                $manager->persist($video);
            }
        }

        $manager->flush();
    }
}
