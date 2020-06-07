<?php

namespace App\DataFixtures;

use App\Entity\Departement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $departement=new Departement();
        $departement->setName('direction');
        $departement->setCapacity(155);
        $manager->persist($departement);
        $departement=new Departement();
        $departement->setName('commercial');
        $departement->setCapacity(155);
        $manager->persist($departement);
        $manager->flush();
    }
}
