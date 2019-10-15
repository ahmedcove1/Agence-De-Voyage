<?php

namespace App\Controller;

use App\Entity\Circuit;
use App\Form\Circuit2Type;
use App\Form\CircuitType;
use App\Repository\CircuitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Etape;
use App\Form\Etape1Type;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

/**
 * @Route("/admin/circuit")
 */
class BackOfficeCircuitController extends AbstractController
{
    private $nbjours = 0;
    
    
    /**
     * @Route("/", name="admin_circuit_index", methods="GET")
     */
    public function index(CircuitRepository $circuitRepository): Response
    {
        return $this->render('back/circuit/index.html.twig', ['circuits' => $circuitRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_circuit_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $circuit = new Circuit();
        $form = $this->createForm(Circuit2Type::class, $circuit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($circuit);
            $em->flush();
            
            return $this->redirectToRoute('admin_circuit_index');
        }
        return $this->render('back/circuit/new.html.twig', [
            'circuit' => $circuit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_circuit_show", methods="GET")
     */
    public function show(Circuit $circuit): Response
    {
        $n = 0;
        foreach ($circuit->getEtapes() as $etape){
            $n += $etape->getNombreJours();
        }
        $this->nbjours=$circuit->getDureeCircuit()-$n;
        $erreur="";
        if($this->nbjours != 0){
            $erreur = "Circuit pas encore totalement rempli";
        }
        $etapes = $circuit->getEtapes();
        return $this->render('back/circuit/show.html.twig', [
            'circuit' => $circuit ,
            'etapes'=>$etapes,
            'erreur'=>$erreur,
            
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_circuit_edit", methods="GET|POST")
     */
    public function edit(Request $request, Circuit $circuit): Response
    {
        $originalEtapes = new ArrayCollection();
        $n = 0;
        foreach ($circuit->getEtapes() as $etape){
            $n += $etape->getNombreJours();
            $originalEtapes->add($etape);
        }
        $this->nbjours=$circuit->getDureeCircuit()-$n;
        $erreur="";
        if($this->nbjours != 0){
            $erreur = "Circuit pas encore totalement rempli";
        }
        
     
        
        $form = $this->createForm(Circuit2Type::class, $circuit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            foreach ($originalEtapes as $etape) {
                
                if (! $circuit->getEtapes()->contains($etape)) {
                    // la Todo n'est plus présente dans le tableau. Il faut donc la supprimer de la base.
                    $this->getDoctrine()->getManager()->remove($etape);
                }
            }
            
            $this->getDoctrine()->getManager()->flush();

           
            return $this->redirectToRoute('admin_circuit_edit', [
                'id' => $circuit->getId(),
                'erreur' => $erreur,
                
            ]);
        }
        
        return $this->render('back/circuit/edit.html.twig', [
            'circuit' => $circuit,
            'form' => $form->createView(),
            'erreur' => $erreur,
        ]);
    }
    
    
    /**
     * @Route("/{id}/delete", name="admin_circuit_delete", methods="DELETE")
     */
    public function delete(Request $request, Circuit $circuit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$circuit->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            foreach ($circuit->getEtapes() as $etape){
            $em->remove($etape);
            }
            $em->remove($circuit);
            $em->flush();
        }
        
        return $this->redirectToRoute('admin_etape_index');
    }

    /**
     * @Route("/{id}/addetape", name="etape_add", methods="GET|POST")
     */
    public function add(Request $request, Circuit $circuit): Response
    {
        $etape = new Etape();
        $form = $this->createForm(Etape1Type::class, $etape);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $circuit->addEtape($etape);
            $em = $this->getDoctrine()->getManager();
            $em->persist($etape);
            $em->persist($circuit);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('message', 'étape bien ajoutée au circuit');
            
            return $this->redirectToRoute('admin_circuit_index');
        }
        
        return $this->render('back/etape/add.html.twig', [
            'circuit' => $circuit,
            'etape' => $etape,
            'form' => $form->createView(),
        ]);
    }

    
  
}
