<?php

namespace App\Controller;

use App\Form\VisualType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class VisualController extends AbstractController
{
    /**
     * @param Request $request
     * @Route("/visual", name="visualView")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function visual(Request $request)
    {
        $form = $this->createForm(VisualType::class, []);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dd('it works');
            return $this->redirectToRoute('visualView');
        }

        return $this->render('visual/visual.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
