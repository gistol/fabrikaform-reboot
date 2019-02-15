<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminDashboardController extends Controller
{
    /**
     * @Route("/fabrikadmin", name="admin_dashboard")
     */
    public function index()
    {
        // $form = $this->createForm(LoginType::class, array($lastUsername));

        $medias = $this->get('doctrine.orm.entity_manager')
            ->getRepository('App:Media')
            ->findAll();

        return $this->render('admin/dashboard/index.html.twig', [
            'medias' => $medias,
        ]);
    }
}
