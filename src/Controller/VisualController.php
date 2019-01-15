<?php

namespace App\Controller;

use App\Form\VisualType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class VisualController extends AbstractController
{
    /**
     * @param Request $request
     * @param UserInterface $user
     * @Route("/visual", name="visualView")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function visual(Request $request, UserInterface $user)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(VisualType::class, []);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $request->files->get('visual')['photo'];
            $file->move(__DIR__ . '/../../public/uploads/' . $user->getId() . '/', $file->getClientOriginalName());
            return $this->redirectToRoute('visualView');
        }

        return $this->render('visual/visual.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
