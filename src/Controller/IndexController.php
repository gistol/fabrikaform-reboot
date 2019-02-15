<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    /**
     * @Route("/", name="index", requirements={"token"=".+"})
     */
    public function index($slug = '')
    {
        return $this->render('base.html.twig', [
            'slug' => $slug,
        ]);
    }
}
