<?php

namespace App\Controller\Admin;

use App\Entity\Media;
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

        if ($id) {
            $media = $this->get('doctrine.orm.entity_manager')
                ->getRepository('App:Media')
                ->find($id);
        } else {
            $media = new Media();
        }

        $form = $this->createForm(MediaType::class, $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($media);
            $em->flush();
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('admin/media/index.html.twig', [
            'controller_name' => 'AdminMediaController',
            'media' => $media,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/fabrikadmin/media/{id}/delete", name="admin_delete_media")
     */
    public function deleteMedia($id = null, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($id) {
            $entity = $this->get('doctrine.orm.entity_manager')
                ->getRepository('App:Media')
                ->find($id);
        }

        if ($entity != null) {
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirectToRoute('dashboard');
    }
}
