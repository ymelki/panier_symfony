<?php

namespace App\Controller;

use App\Entity\Mescommandes;
use App\Form\MescommandesType;
use App\Repository\MescommandesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mescommandes")
 */
class MescommandesController extends AbstractController
{
    /**
     * @Route("/", name="app_mescommandes_index", methods={"GET"})
     */
    public function index(MescommandesRepository $mescommandesRepository): Response
    {
        return $this->render('mescommandes/index.html.twig', [
            'mescommandes' => $mescommandesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_mescommandes_new", methods={"GET", "POST"})
     */
    public function new(Request $request, MescommandesRepository $mescommandesRepository): Response
    {
        $mescommande = new Mescommandes();
        $form = $this->createForm(MescommandesType::class, $mescommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mescommandesRepository->add($mescommande);
            return $this->redirectToRoute('app_mescommandes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mescommandes/new.html.twig', [
            'mescommande' => $mescommande,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_mescommandes_show", methods={"GET"})
     */
    public function show(Mescommandes $mescommande): Response
    {
        return $this->render('mescommandes/show.html.twig', [
            'mescommande' => $mescommande,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_mescommandes_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Mescommandes $mescommande, MescommandesRepository $mescommandesRepository): Response
    {
        $form = $this->createForm(MescommandesType::class, $mescommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mescommandesRepository->add($mescommande);
            return $this->redirectToRoute('app_mescommandes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mescommandes/edit.html.twig', [
            'mescommande' => $mescommande,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_mescommandes_delete", methods={"POST"})
     */
    public function delete(Request $request, Mescommandes $mescommande, MescommandesRepository $mescommandesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mescommande->getId(), $request->request->get('_token'))) {
            $mescommandesRepository->remove($mescommande);
        }

        return $this->redirectToRoute('app_mescommandes_index', [], Response::HTTP_SEE_OTHER);
    }
}
