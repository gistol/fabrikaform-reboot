<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Media;

class MediaController extends Controller
{
    /**
     * @Route("/medias", name="media_list")
     * @Method({"GET"})
     */
    public function getMediasAction(Request $request)
    {
        $medias = $this->get('doctrine.orm.entity_manager')
            ->getRepository('App:Media')
            ->findAll();
        /* @var $medias Media[] */

        $formatted = [];
        foreach ($medias as $media) {
            $formatted[] = [
                'id' => $media->getId(),
                'name' => $media->getName(),
                'legend' => $media->getLegend(),
                'imageUrl' => $media->getImageUrl(),
            ];
        }

        return new JsonResponse($formatted);
    }

    /**
     * @Route("/media/{id}", name="media")
     * @Method({"GET"})
     */
    public function getMediaAction($id = null, Request $request)
    {
        $media = $this->get('doctrine.orm.entity_manager')
            ->getRepository('App:Media')
            ->find($id);

        $neighbours = $this->get('doctrine.orm.entity_manager')
            ->getRepository('App:Media')
            ->getNeighbours($id);

        $formatted = [
            'id' => $media->getId(),
            'name' => $media->getName(),
            'legend' => $media->getLegend(),
            'imageUrl' => $media->getImageUrl(),
            'navigation' => $neighbours
        ];

        return new JsonResponse($formatted);
    }

}
