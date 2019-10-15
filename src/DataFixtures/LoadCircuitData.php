<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Circuit;
use App\Entity\ProgrammationCircuit;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use DateTime;

class LoadCircuitData extends Fixture
{
	public function load(ObjectManager $manager)
	{		
		$circuit = new Circuit();
		$circuit->setDescription('Andalousie');
		$circuit->setPaysDepart('Espagne');
		$circuit->setVilleDepart('Grenade');
		$circuit->setVilleArrivee('Séville');
		$circuit->setDureeCircuit(4);
		$manager->persist($circuit);
		
		$this->addReference('andalousie-circuit', $circuit);
		
		$circuit = new Circuit();
		$circuit->setDescription('Vietnam');
		$circuit->setPaysDepart('VietNam');
		$circuit->setVilleDepart('Hanoi');
		$circuit->setVilleArrivee('Hô Chi Minh');
		$circuit->setDureeCircuit(4);
		$manager->persist($circuit);
		
		$this->addReference('vietnam-circuit', $circuit);
		
		$circuit = new Circuit();
		$circuit->setDescription('Ile de France');
		$circuit->setPaysDepart('France');
		$circuit->setVilleDepart('Paris');
		$circuit->setVilleArrivee('Paris');
		$circuit->setDureeCircuit(2);
		$manager->persist($circuit);
		
		$this->addReference('idf-circuit', $circuit);
		
		$circuit = new Circuit();
		$circuit->setDescription('Italie');
		$circuit->setPaysDepart('Italie');
		$circuit->setVilleDepart('Milan');
		$circuit->setVilleArrivee('Rome');
		$circuit->setDureeCircuit(4);
		
		
		$formatDate="Y-m-d H:i";
		$programmationCircuit = new ProgrammationCircuit();
		$programmationCircuit->setDateDepart(DateTime::createFromFormat($formatDate, '2018-10-15 15:00'));
		$programmationCircuit->setNombrePersonnes(10);
		$programmationCircuit->setPrix(800);
		$programmationCircuit->setCircuit($circuit);
		
		$this->addReference('italie-circuit', $circuit);
		$manager->persist($programmationCircuit);
		
		$programmationCircuit = new ProgrammationCircuit();
		$programmationCircuit->setDateDepart(DateTime::createFromFormat($formatDate, '2018-12-24 18:45'));
		$programmationCircuit->setNombrePersonnes(30);
		$programmationCircuit->setPrix(1200);
		$programmationCircuit->setCircuit($circuit);
		
		$manager->persist($programmationCircuit);
		$manager->persist($circuit);
	
		
		
		$manager->flush();
	}
	
}
// (1, 'Andalousie', 'Espagne', 'Grenade', 'Séville', 4),
// (2, 'VietNam', 'VietNam', 'Hanoi', 'Hô Chi Minh', 4),
// (3, 'Ile de France', 'France', 'Paris', 'Paris', 2),
// (4, 'Italie', 'Italie', 'Milan', 'Rome', 4);