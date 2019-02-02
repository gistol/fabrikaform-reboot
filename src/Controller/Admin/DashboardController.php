<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    /**
     * @Route("/fabrikadmin", name="dashboard")
     */
    public function index()
    {
        // $form = $this->createForm(LoginType::class, array($lastUsername));

        $medias = $this->get('doctrine.orm.entity_manager')
            ->getRepository('App:Media')
            ->findAll();

        // $formatted = [];
        // foreach ($medias as $media) {
        //     $formatted[] = [
        //         'id' => $media->getId(),
        //         'name' => $media->getName(),
        //         'legend' => $media->getLegend(),
        //         'image_url' => $media->getImageUrl(),
        //     ];
        // }

        // return new JsonResponse($formatted);

        return $this->render('admin/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'medias' => $medias,
        ]);
    }
}
