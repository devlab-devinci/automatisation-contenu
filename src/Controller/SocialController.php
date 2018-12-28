<?php

namespace App\Controller;

use Facebook;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SocialController extends AbstractController
{
    /**
     * @Route("/social", name="social")
     */
    public function socialScreenAction()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('social/choice.html.twig', [
            'success' => ''
        ]);
    }
}
