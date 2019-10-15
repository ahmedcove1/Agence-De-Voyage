<?php

namespace App\Controller;

use App\Entity\ProgrammationCircuit;
use App\Form\ProgrammationCircuitType;
use App\Repository\ProgrammationCircuitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/programmation_circuit")
 */
class BackOfficeProgrammationCircuitController extends AbstractController
{
    /**
     * @Route("/", name="admin_programmation_circuit_index", methods="GET")
     */
    public function index(ProgrammationCircuitRepository $programmationCircuitRepository): Response
    {
        return $this->render('back/programmation_circuit/index.html.twig', ['programmation_circuits' => $programmationCircuitRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_programmation_circuit_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $programmationCircuit = new ProgrammationCircuit();
        $form = $this->createForm(ProgrammationCircuitType::class, $programmationCircuit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($programmationCircuit);
            $em->flush();

            return $this->redirectToRoute('admin_programmation_circuit_index');
        }

        return $this->render('back/programmation_circuit/new.html.twig', [
            'programmation_circuit' => $programmationCircuit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_programmation_circuit_show", methods="GET")
     */
    public function show(ProgrammationCircuit $programmationCircuit): Response
    {
        return $this->render('back/programmation_circuit/show.html.twig', ['programmation_circuit' => $programmationCircuit]);
    }

    /**
     * @Route("/{id}/edit", name="admin_programmation_circuit_edit", methods="GET|POST")
     */
    public function edit(Request $request, ProgrammationCircuit $programmationCircuit): Response
    {
        $form = $this->createForm(ProgrammationCircuitType::class, $programmationCircuit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_programmation_circuit_edit', ['id' => $programmationCircuit->getId()]);
        }

        return $this->render('back/programmation_circuit/edit.html.twig', [
            'programmation_circuit' => $programmationCircuit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_programmation_circuit_delete", methods="DELETE")
     */
    public function delete(Request $request, ProgrammationCircuit $programmationCircuit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$programmationCircuit->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($programmationCircuit);
            $em->flush();
        }

        return $this->redirectToRoute('admin_programmation_circuit_index');
    }
}
