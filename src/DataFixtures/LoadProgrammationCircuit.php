<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DateTime;
use App\Entity\ProgrammationCircuit;

class LoadProgrammationCircuit extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $circuit=$this->getReference('andalousie-circuit');
        
        $programmationCircuit = new ProgrammationCircuit();
        $formatDate="Y-m-d H:i";
        $programmationCircuit = new ProgrammationCircuit();
        $programmationCircuit->setDateDepart(DateTime::createFromFormat($formatDate, '2018-10-19 19:19'));
        $programmationCircuit->setNombrePersonnes(16);
        $programmationCircuit->setPrix(850);
        $circuit->addProgrammationCircuit($programmationCircuit);
        $manager->persist($programmationCircuit);
        
        $programmationCircuit = new ProgrammationCircuit();
        $programmationCircuit->setDateDepart(DateTime::createFromFormat($formatDate, '2018-10-29 15:19'));
        $programmationCircuit->setNombrePersonnes(16);
        $programmationCircuit->setPrix(850);
        $circuit->addProgrammationCircuit($programmationCircuit);
        $manager->persist($programmationCircuit);
        $manager->persist($circuit);
        
        $manager->flush();
    }
    
    public function getDependencies()
    {
        return array(
            LoadCircuitData::class,
        );
    }
}

// (1, 1, 'Grenade', 1),
// (1, 2, 'Cordoue', 2),
// (1, 3, 'Séville', 1),
// (2, 1, 'Hanoï', 1),
// (2, 2, 'Dà Nang', 1),
// (2, 3, 'Hôi An', 1),
// (2, 4, 'Hô Chi Minh', 2),
// (3, 1, 'Versailles', 1),
// (3, 2, 'Paris', 1),
// (4, 1, 'Florence', 2),
// (4, 2, 'Sienne', 1),
// (4, 3, 'Pise', 1),
// (4, 4, 'Rome', 2);