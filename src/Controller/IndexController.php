<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    /**
     * @Route("/{slug}", name="index", requirements={"token"=".+"})
     */
    public function index($slug = '')
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'IndexController',
            'slug' => $slug,
        ]);
    }
}
