<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Etape;

class LoadEtapeData extends Fixture implements DependentFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$circuit=$this->getReference('andalousie-circuit');
		
		$etape = new Etape();
		$etape->setNumeroEtape(1);
		$etape->setVilleEtape("Grenade");
		$etape->setNombreJours(1);
		//$etape = $circuit->addEtape("Grenade", 1);
		$circuit->addEtape($etape);
		$manager->persist($etape);
		
		$etape = new Etape();
		$etape->setNumeroEtape(2);
		$etape->setVilleEtape("Cordoue");
		$etape->setNombreJours(2);
//		$etape = $circuit->addEtape("Cordoue", 2);
		$circuit->addEtape($etape);
		$manager->persist($etape);
		
		$etape = new Etape();
		$etape->setNumeroEtape(3);
		$etape->setVilleEtape("Séville");
		$etape->setNombreJours(1);
////		$etape = $circuit->addEtape("Séville", 1);
		$circuit->addEtape($etape);
		$manager->persist($etape);

		$manager->persist($circuit);
		
		$circuit=$this->getReference('vietnam-circuit');
		
		$etape = new Etape();
		$etape->setNumeroEtape(1);
		$etape->setVilleEtape("Hanoï");
		$etape->setNombreJours(1);
////		$etape = $circuit->addEtape("Hanoï", 1);
		$circuit->addEtape($etape);
		$manager->persist($etape);
		
		
		$etape = new Etape();
		$etape->setNumeroEtape(3);
		$etape->setVilleEtape("Hôi An");
		$etape->setNombreJours(1);
//		$etape = $circuit->addEtape("Hôi An", 1);
		$circuit->addEtape($etape);
		$manager->persist($etape);
		
		$etape = new Etape();
		$etape->setNumeroEtape(4);
		$etape->setVilleEtape("Hô Chi Minh");
		$etape->setNombreJours(1);
//		$etape = $circuit->addEtape("Hô Chi Minh", 1);
		$circuit->addEtape($etape);
		$manager->persist($etape);
		
		$etape = new Etape();
		$etape->setNumeroEtape(2);
		$etape->setVilleEtape("Dà Nang");
		$etape->setNombreJours(1);
//		$etape = $circuit->addEtape("Dà Nang", 1);
		$circuit->addEtape($etape);
		$manager->persist($etape);
		
		$manager->persist($circuit);
		
		$circuit=$this->getReference('idf-circuit');
		
		$etape = new Etape();
		$etape->setNumeroEtape(1);
		$etape->setVilleEtape("Versailles");
		$etape->setNombreJours(1);
//		$etape = $circuit->addEtape("Versailles", 1);
		$circuit->addEtape($etape);
		$manager->persist($etape);
		
		$etape = new Etape();
		$etape->setNumeroEtape(2);
		$etape->setVilleEtape("Paris");
		$etape->setNombreJours(1);
//		$etape = $circuit->addEtape("Paris", 1);
		$circuit->addEtape($etape);
		$manager->persist($etape);
		
		$manager->persist($circuit);
		
		$circuit=$this->getReference('italie-circuit');
		
		$etape = new Etape();
		$etape->setNumeroEtape(1);
		$etape->setVilleEtape("Florence");
		$etape->setNombreJours(1);
//		$etape = $circuit->addEtape("Florence", 1);
		$circuit->addEtape($etape);
		$manager->persist($etape);
		
		$etape = new Etape();
		$etape->setNumeroEtape(2);
		$etape->setVilleEtape("Sienne");
		$etape->setNombreJours(1);
//		$etape = $circuit->addEtape("Sienne", 1);
		$circuit->addEtape($etape);
		$manager->persist($etape);
		
		$etape = new Etape();
		$etape->setNumeroEtape(3);
		$etape->setVilleEtape("Pise");
		$etape->setNombreJours(1);
//		$etape = $circuit->addEtape("Pise", 1);
		$circuit->addEtape($etape);
		$manager->persist($etape);
		
		$etape = new Etape();
		$etape->setNumeroEtape(4);
		$etape->setVilleEtape("Rome");
		$etape->setNombreJours(1);
//		$etape = $circuit->addEtape("Rome", 1);
		$circuit->addEtape($etape);
		$manager->persist($etape);
		
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