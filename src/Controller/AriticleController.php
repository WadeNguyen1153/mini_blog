<?php

namespace App\Controller;

use App\Entity\Ariticle;
use App\Form\AriticleType;
use App\Repository\AriticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ariticle")
 */
class AriticleController extends AbstractController
{
    /**
     * @Route("/", name="app_ariticle_index", methods={"GET"})
     */
    public function index(AriticleRepository $ariticleRepository): Response
    {
        return $this->render('ariticle/index.html.twig', [
            'ariticles' => $ariticleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_ariticle_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AriticleRepository $ariticleRepository): Response
    {
        $ariticle = new Ariticle();
        $form = $this->createForm(AriticleType::class, $ariticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ariticleRepository->add($ariticle, true);

            return $this->redirectToRoute('app_ariticle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ariticle/new.html.twig', [
            'ariticle' => $ariticle,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ariticle_show", methods={"GET"})
     */
    public function show(Ariticle $ariticle): Response
    {
        return $this->render('ariticle/show.html.twig', [
            'ariticle' => $ariticle,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_ariticle_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Ariticle $ariticle, AriticleRepository $ariticleRepository): Response
    {
        $form = $this->createForm(AriticleType::class, $ariticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ariticleRepository->add($ariticle, true);

            return $this->redirectToRoute('app_ariticle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ariticle/edit.html.twig', [
            'ariticle' => $ariticle,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ariticle_delete", methods={"POST"})
     */
    public function delete(Request $request, Ariticle $ariticle, AriticleRepository $ariticleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ariticle->getId(), $request->request->get('_token'))) {
            $ariticleRepository->remove($ariticle, true);
        }

        return $this->redirectToRoute('app_ariticle_index', [], Response::HTTP_SEE_OTHER);
    }
}
