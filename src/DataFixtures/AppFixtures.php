<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Team;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        // create 20 products! Bam!
        for ($i = 0; $i < 5; $i++) {
            $newTeam = new Team();
            $newTeam->setName('Team '.$i);
            $randomInt=random_int(10, 99);
            $newTeam->setUrlPicture('https://picsum.photos/2'.$randomInt);
            $manager->persist($newTeam);
        }

        $manager->flush();

        // $newTeam = new Product();
        // $manager->persist($newTeam);
    }
}
