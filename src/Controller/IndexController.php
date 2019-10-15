<?php
/**
 * Gestion de la page d'accueil de l'application
 *
 * @copyright  2017 Telecom SudParis
 * @license    "MIT/X" License - cf. LICENSE file at project root
 */

namespace App\Controller;

use App\Entity\ProgrammationCircuit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Circuit;

/**
 * Controleur de la page d'accueil
 */
class IndexController extends Controller
{    
    /**
     * @Route("/", name = "home", methods="GET")
     */
    public function indexAction()
    {
        $idProg = array();
        $em = $this->getDoctrine()->getManager();
        $circuits=array();
        $circuitsProgrammes = $em->getRepository(ProgrammationCircuit::class)->findAll();
        $likes = $this->get('session')->get('likes');
        if($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            $circuits = $em->getRepository(Circuit::class)->findAll();
        }
        dump($likes);
        $size = count($circuitsProgrammes);
        for ($i=0; $i<$size ; $i++){
            array_push($idProg,$circuitsProgrammes[$i]->getCircuit()->getId());
        }
        $circuitsNonProgrammes = array();
        $size = count($circuits);
        for($i=0;$i<$size;$i++){
            if(!in_array($circuits[$i]->getId(), $idProg)){
                array_push($circuitsNonProgrammes, $circuits[$i]);
            }
        }
        dump($circuitsNonProgrammes);
        if($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            return $this->render('front/home.html.twig', [
            'circuitsProgrammes' => $circuitsProgrammes,
            'cnp' => $circuitsNonProgrammes,
            'likes' => $likes,
        ]);
        }
        else{
            $cnp=array();
            return $this->render('front/home.html.twig', [
            'circuitsProgrammes' => $circuitsProgrammes,
            'likes' => $likes,
            'cnp' => $cnp,
        ]); 
        }
    }
    /**
     * @Route("/connexion", name = "login", methods="GET")
     */
    public function Connexion()
    {
        return $this->render('login.html', [
        ]);
    }
}
