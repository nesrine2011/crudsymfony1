<?php

namespace App\DataFixtures;

use App\Entity\Employes;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class EmployesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i=1 ; $i<5; $i++)
        {
            $employes=new Employes;
            $employes->setPrenom("Prenom de l'employé n°$i")
                    ->setNom("Nom de l'employé n°$i")
                    ->SetTelephone("063425$i")
                    ->setEmail("email$i@gmail.com")
                    ->setAdresse("0$i rue du pave")
                    ->setPoste("commercial")
                    ->setSalaire(2000*$i)
                    ->setDateDeNaissance(new \DateTime("12/25/1985"));
            $manager->persist($employes);
        }
        // $product = new Product();
         

        $manager->flush();
    }
}
