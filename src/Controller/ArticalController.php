<?php

namespace App\Controller;

use App\Entity\Artical;
use App\Form\ArticalType;
use App\Repository\ArticalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/artical")
 */
class ArticalController extends AbstractController
{
    /**
     * @Route("/", name="app_artical_index", methods={"GET"})
     */
    public function index(ArticalRepository $articalRepository): Response
    {
        return $this->render('artical/index.html.twig', [
            'articals' => $articalRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_artical_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ArticalRepository $articalRepository): Response
    {
        $artical = new Artical();
        $form = $this->createForm(ArticalType::class, $artical);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articalRepository->add($artical, true);

            return $this->redirectToRoute('app_artical_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('artical/new.html.twig', [
            'artical' => $artical,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_artical_show", methods={"GET"})
     */
    public function show(Artical $artical): Response
    {
        return $this->render('artical/show.html.twig', [
            'artical' => $artical,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_artical_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Artical $artical, ArticalRepository $articalRepository): Response
    {
        $form = $this->createForm(ArticalType::class, $artical);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articalRepository->add($artical, true);

            return $this->redirectToRoute('app_artical_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('artical/edit.html.twig', [
            'artical' => $artical,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_artical_delete", methods={"POST"})
     */
    public function delete(Request $request, Artical $artical, ArticalRepository $articalRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artical->getId(), $request->request->get('_token'))) {
            $articalRepository->remove($artical, true);
        }

        return $this->redirectToRoute('app_artical_index', [], Response::HTTP_SEE_OTHER);
    }
}
