<?php

namespace App\DataFixtures;

use App\Entity\SweatShirt;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $sweatShirt = new SweatShirt();
        $sweatShirt -> setName('Sweat1');
        $sweatShirt -> setPrice(10);
        $sweatShirt -> setTop(true);
        $sweatShirt -> setImg('img/sweatShirts/1.jpeg');
        $manager -> persist($sweatShirt);

        $manager->flush();
    }
}
