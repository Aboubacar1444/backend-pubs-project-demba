<?php

namespace App\Controller;

use App\Entity\Video;
use App\Entity\Visitor;
use App\Service\VideoService;
use App\Service\VisitorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/api/visitors',)]
class VisitorController extends AbstractController
{
    public function __construct(private readonly VisitorService $visitorService){}
    #[Route('/{id}', name: 'app_visitor', methods: ['POST']) ]
    public function addVisitor(Video $video, Request $request): JsonResponse
    {
        return $this->visitorService->addVisitor($video, $request->getContent());
    }

    #[Route('/{id}', name: 'app_delete_visitor', methods: ['DELETE']) ]
    public function deleteVisitor(Request $request): JsonResponse {
        return $this->visitorService->deleteVisitor($request->get('id'));
    }


    #[Route('/{id}', name: 'app_update_visitor', methods: ['PUT']) ]
    public function updateVisitor(Visitor $visitor,Request $request): JsonResponse {
        return $this->visitorService->updateVisitor($visitor, $request->getContent());
    }

    #[Route('', name: 'app_get_visitors', methods: ['GET']) ]
    public function getVisitors(): JsonResponse {
        return $this->visitorService->getVisitors();
    }

}
