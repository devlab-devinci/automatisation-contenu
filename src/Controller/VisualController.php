<?php

namespace App\Controller;

use App\Entity\Gallery;
use App\Form\VisualType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

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
            $pictureUrl = '';
            /** @var UploadedFile $file */
            $file = $request->files->get('visual')['photo'];
            $photoExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($file->getClientOriginalExtension(), $photoExtensions)) {
                $pictureName = uniqid($user->getId()) . '.' . $file->getClientOriginalExtension();
                $pictureUrl = 'uploads/gallery/' . $pictureName;
                $file->move(__DIR__ . '/../../public/uploads/gallery/', $pictureName);
                // Write in database path
                $entity = $this->getDoctrine()->getManager();
                $picture = new Gallery();
                $picture->setPath($pictureUrl);
                $picture->setUserId($user);
                $picture->setCreatedAt(new \DateTime());
                $entity->persist($picture);
                $entity->flush();
                $status = 'ok';
            } else {
                $status = 'not a picture';
            }
            return $this->render('visual/visual.html.twig', [
                'form' => $form->createView(),
                'photo' => $pictureUrl,
                'status' => $status
            ]);
        }

        return $this->render('visual/visual.html.twig', [
            'form' => $form->createView(),
            'photo' => '',
            'status' => ''
        ]);
    }

    /**
     * @param UserInterface $user
     * @Route("/gallery", name="gallery")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function galleryUser(UserInterface $user)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $repositoryGallery = $this->getDoctrine()->getRepository(Gallery::class);
        $photos = $repositoryGallery->findBy(['userId' => $user->getId()], ['createdAt' => 'DESC']);

        return $this->render('visual/gallery.html.twig', [
            'photos' => $photos
        ]);
    }

    /**
     * @param Request $request
     * @param UserInterface $user
     * @Route("/creation", name="creation")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function creation(Request $request, UserInterface $user)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $repositoryGallery = $this->getDoctrine()->getRepository(Gallery::class);
        $photo = $repositoryGallery->findOneBy(['userId' => $user->getId()], ['createdAt' => 'DESC']);

        return $this->render('visual/creation.html.twig', [
            'photo' => $photo,
        ]);
    }

    /**
     * @param Request $request
     * @param UserInterface $user
     * @Route("/publication", name="publication")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function publication(Request $request, UserInterface $user)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $img = $request->request->get('img');

        list(, $img) = explode(';', $img);
        list(, $img) = explode(',', $img);
        $img = base64_decode($img);
        file_put_contents(__DIR__ . '/../../public/uploads/visual/'.$user->getId().'.jpeg', $img);

        $response = new JsonResponse();
        $response->setData($user->getId());
        return $response;

    }
}
