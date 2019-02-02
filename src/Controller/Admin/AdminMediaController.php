<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Form\MediaType;

class AdminMediaController extends Controller
{
    /**
     * @Route("/fabrikadmin/media/{id}", name="admin_media")
     */
    public function index($id = null, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $media = $this->get('doctrine.orm.entity_manager')
            ->getRepository('App:Media')
            ->find($id);

        $form = $this->createForm(MediaType::class, $media);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('dashboard');
        }

        // $formatted = [];
        // foreach ($medias as $media) {
        //     $formatted[] = [
        //         'id' => $media->getId(),
        //         'name' => $media->getName(),
        //         'legend' => $media->getLegend(),
        //         'image_url' => $media->getImageurl(),
        //     ];
        // }

        return $this->render('admin/media/index.html.twig', [
            'controller_name' => 'AdminMediaController',
            'media' => $media,
            'form' => $form->createView()
        ]);
    }
}
