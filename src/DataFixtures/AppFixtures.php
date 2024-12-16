<?php

namespace App\DataFixtures;

use App\Entity\AdminUser;
use App\Entity\SweatShirt;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $userPasswordHasher;

    public function __construct (UserPasswordHasherInterface $userPasswordHasher) {
        $this -> userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $sweatShirt = new SweatShirt();
        $sweatShirt -> setName('Sweat1');
        $sweatShirt -> setPrice(10);
        $sweatShirt -> setIsTop(true);
        $sweatShirt -> setImg('img/sweatShirts/1.jpeg');
        $manager -> persist($sweatShirt);

        $user = new User();
        $user -> setName('user');
        $user -> setPassword(
            $this -> userPasswordHasher -> hashPassword(
                $user, "password"
            )
        );
        $user -> setEmail('user@www.com');
        $user -> setDeliveryAddress('0 rue du chien, 20220 Bastia, France');
        $manager -> persist($user);

        $admin = new AdminUser();
        $admin -> setName('admin');
        $admin -> setPassword(
            $this -> userPasswordHasher -> hashPassword(
                $admin, "password"
            )
        );
        $admin -> setEmail('admin@www.com');
        $manager -> persist($admin);

        $manager->flush();
    }
}
