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
        $blackbelt = new SweatShirt();
        $blackbelt 
            ->setName('Blackbelt')
            ->setPrice(29.90)
            ->setIsTop(true)
            ->setImg('blackbelt.jpeg')
            ->setStockXs(2)
            ->setStockS(2)
            ->setStockM(2)
            ->setStockL(2)
            ->setStockXl(2); 
        $manager -> persist($blackbelt);

        $bluebelt = new SweatShirt();
        $bluebelt 
            ->setName('Bluebelt')
            ->setPrice(29.90)
            ->setIsTop(false)
            ->setImg('bluebelt.jpeg')
            ->setStockXs(2)
            ->setStockS(2)
            ->setStockM(2)
            ->setStockL(2)
            ->setStockXl(2); 
        $manager -> persist($bluebelt);
        
        $street = new SweatShirt();
        $street 
            ->setName('Street')
            ->setPrice(34.50)
            ->setIsTop(false)
            ->setImg('street.jpeg')
            ->setStockXs(2)
            ->setStockS(2)
            ->setStockM(2)
            ->setStockL(2)
            ->setStockXl(2); 
        $manager -> persist($street);

        $pokeball = new SweatShirt();
        $pokeball 
            ->setName('Pokeball')
            ->setPrice(45)
            ->setIsTop(true)
            ->setImg('pokeball.jpeg')
            ->setStockXs(2)
            ->setStockS(2)
            ->setStockM(2)
            ->setStockL(2)
            ->setStockXl(2); 
        $manager -> persist($pokeball);

        $pinklady = new SweatShirt();
        $pinklady 
            ->setName('PinkLady')
            ->setPrice(29.90)
            ->setIsTop(false)
            ->setImg('pinklady.jpeg')
            ->setStockXs(2)
            ->setStockS(2)
            ->setStockM(2)
            ->setStockL(2)
            ->setStockXl(2); 
        $manager -> persist($pinklady);

        $snow = new SweatShirt();
        $snow 
            ->setName('Snow')
            ->setPrice(32)
            ->setIsTop(false)
            ->setImg('snow.jpeg')
            ->setStockXs(2)
            ->setStockS(2)
            ->setStockM(2)
            ->setStockL(2)
            ->setStockXl(2); 
        $manager -> persist($snow);

        $greyback = new SweatShirt();
        $greyback 
            ->setName('Greyback')
            ->setPrice(28.50)
            ->setIsTop(false)
            ->setImg('greyback.jpeg')
            ->setStockXs(2)
            ->setStockS(2)
            ->setStockM(2)
            ->setStockL(2)
            ->setStockXl(2); 
        $manager -> persist($greyback);

        $bluecloud = new SweatShirt();
        $bluecloud 
            ->setName('BlueCloud')
            ->setPrice(45)
            ->setIsTop(false)
            ->setImg('bluecloud.jpeg')
            ->setStockXs(2)
            ->setStockS(2)
            ->setStockM(2)
            ->setStockL(2)
            ->setStockXl(2); 
        $manager -> persist($bluecloud);

        $borninusa = new SweatShirt();
        $borninusa 
            ->setName('BornInUsa')
            ->setPrice(59.90)
            ->setIsTop(true)
            ->setImg('borninusa.jpeg')
            ->setStockXs(2)
            ->setStockS(2)
            ->setStockM(2)
            ->setStockL(2)
            ->setStockXl(2); 
        $manager -> persist($borninusa);

        $greenschool = new SweatShirt();
        $greenschool 
            ->setName('GreenSchool')
            ->setPrice(42.20)
            ->setIsTop(false)
            ->setImg('greenschool.jpeg')
            ->setStockXs(2)
            ->setStockS(2)
            ->setStockM(2)
            ->setStockL(2)
            ->setStockXl(2); 
        $manager -> persist($greenschool);

        $user = new User();
        $user -> setName('user');
        $user -> setPassword(
            $this -> userPasswordHasher -> hashPassword(
                $user, "password"
            )
        );
        $user -> setEmail('user@www.com');
        $user -> setDeliveryAddress('0 rue du chien, 20220 Bastia, France');
        $user -> setVerified(true);
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
