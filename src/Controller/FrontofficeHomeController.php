<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Circuit;
use App\Entity\ProgrammationCircuit;


class FrontofficeHomeController extends AbstractController
{
    /**
     * @Route("/home", name="frontoffice_home")
     */
    public function index()
    {

        $idProg = array();
        $em = $this->getDoctrine()->getManager();
        $circuitsProgrammes = $em->getRepository(ProgrammationCircuit::class)->findAll();
        $likes = $this->get('session')->get('likes');
        $circuits=array();
        if($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            $circuits = $em->getRepository(Circuit::class)->findAll();
        }
        #dump($likes);
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
     * Finds and displays a circuit entity.
     *
     * @Route("/circuitProgramme/{id}", name="front_circuit_show")
     */
    public function circuitShow($id)
    {
        $em = $this->getDoctrine()->getManager();

        $circuitProgramme = $em->getRepository(ProgrammationCircuit::class)->find($id);

        dump($circuitProgramme);

        return $this->render('front/circuit_show.html.twig', [
            'circuitProgramme' => $circuitProgramme,
        ]);

    }

        /**
     * Finds and displays a circuit entity.
     *
     * @Route("/circuit/{id}", name="front_circuitnp_show")
     */
    public function circuitNpShow($id)
    {
        if ( ! $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
        // throw $this->createAccessDeniedException();
            throw $this->createNotFoundException('The circuit does not exist');
        }
        $em = $this->getDoctrine()->getManager();

        $circuit = $em->getRepository(Circuit::class)->find($id);

        dump($circuit);

        return $this->render('front/circuitnp_show.html.twig', [
            'circuit' => $circuit,
        ]);

    }

    /**
     * @Route("/likes/{id}", name = "addToLikes")
     */
    public function addToLikes($id)
    {

        $likes = $this->get('session')->get('likes');
        if($likes==null){
            $this->get('session')->set('likes', []);

        }
        $likes = $this->get('session')->get('likes');
        // si l'identifiant n'est pas présent dans le tableau des likes, l'ajouter
        if (! in_array($id, $likes) )
        {

             array_push($likes,$id);
        }
        else
        // sinon, le retirer du tableau
        {
            $likes = array_diff($likes, array($id));
        }
        $this->get('session')->set('likes', $likes);
        return $this->redirectToRoute('frontoffice_home');
    }
        /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('about_us.html.twig', [
        ]);
    }
    /**
 * @Route("/likes", name="likes")
 */

    public function likeshow()
    {         $em = $this->getDoctrine()->getManager();
      $circuits=[];
      $likes = $this->get('session')->get('likes');
      if($likes==null){
          $this->get('session')->set('likes', []);

      }else {

         foreach ($likes as $likeid => $like) {
           $circuit = $em->getRepository(Circuit::class)->find($like);
          array_push($circuits,$circuit);

            }}
        return $this->render('front/likes_show.html.twig',['circuits' => $circuits]);

    }

}
