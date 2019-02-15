<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ImageType;

class AdminImageController extends Controller
{
    /**
     * @Route("/fabrikadmin/images", name="admin_images")
     */
    public function viewImages($id = null, Request $request)
    {
        $images = $this->get('doctrine.orm.entity_manager')
            ->getRepository('App:Image')
            ->findAll();

        return $this->render('admin/image/image_list.html.twig', [
            'images' => $images,
        ]);
    }

    /**
     * @Route("/fabrikadmin/image/{id}", name="admin_image")
     */
    public function index($id = null, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($id) {
            $image = $this->get('doctrine.orm.entity_manager')
                ->getRepository('App:Image')
                ->find($id);
        } else {
            $image = new Image();
        }

        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($image);
            $em->flush();

            $this->addFlash('success', 'Image enregistrée');
            return $this->redirectToRoute('admin_image', [
                'id' => $image->getId()
            ]);
        }

        return $this->render('admin/image/image.html.twig', [
            'image' => $image,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/fabrikadmin/image/{id}/delete", name="admin_delete_image")
     */
    public function deleteImage($id = null, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($id) {
            $entity = $this->get('doctrine.orm.entity_manager')
                ->getRepository('App:Image')
                ->find($id);
        }

        if ($entity != null) {
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirectToRoute('admin_images');
    }
}
