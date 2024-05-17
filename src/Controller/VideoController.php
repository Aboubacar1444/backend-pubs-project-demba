<?php

namespace App\Controller;

use App\Entity\Video;
use App\Service\VideoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/api/videos',)]
class VideoController extends AbstractController
{
    public function __construct(private readonly VideoService $videoService){}
    #[Route('', name: 'app_video', methods: ['POST']) ]
    public function addVideo(Request $request): JsonResponse
    {
        return $this->videoService->addVideo($request->getContent());
    }

    #[Route('', name: 'app_get_videos', methods: ['GET']) ]
    public function getVideos(Request $request): JsonResponse {
        return $this->videoService->getAllVideos();
    }
    #[Route('/{id}', name: 'app_delete_video', methods: ['DELETE']) ]
    public function deleteVideo(Request $request): JsonResponse {
        return $this->videoService->deleteVideo($request->get('id'));
    }
    #[Route('/{id}', name: 'app_update_video', methods: ['PUT']) ]
    public function updateVideo(Video $video,Request $request): JsonResponse {

        return $this->videoService->updateVideo($video, $request->getContent());
    }
    #[Route('/{id}', name: 'app_get_video', methods: ['GET']) ]
    public function getVideo(Request $request): JsonResponse {
        return $this->videoService->getVideoById($request->get('id'));
    }
    #[Route('/find/first-last', name: 'app_get_first_last_video', methods: ['GET']) ]
    public function findFirstAndLastVideos(): JsonResponse {
        return $this->videoService->findFirstAndLastVideos();
    }
}
