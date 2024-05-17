<?php

namespace App\Service;

use App\Entity\Video;
use App\Helper\ResponseHelper;
use App\Repository\VideoRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class VideoService
{
    public function __construct(
        private readonly ResponseHelper                             $responseHelper,
        private readonly VideoRepository                            $videoRepository,
        private                                                     $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]),

    ){}

    public function addVideo ($data): JsonResponse {
        $video = $this->serializer->deserialize($data, Video::class, 'json');
        $this->videoRepository->save($video, true);

        return $this->responseHelper->baseResponse('Video added successfully', $video->serialize());
    }

    public function updateVideo (Video $selectedVideo, $data): JsonResponse {
        $video = $this->serializer->deserialize($data, $selectedVideo::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $selectedVideo]);
        $this->videoRepository->save($video, true);
        return $this->responseHelper->baseResponse('Video updated successfully', $video->serialize());
    }


    public function deleteVideo ($id): JsonResponse {
        $video = $this->videoRepository->find($id);
        if ($video) {
            $this->videoRepository->remove($video, true);
            return $this->responseHelper->baseResponse('Video deleted successfully', null);
        }
        else return $this->responseHelper->baseResponse('Video not found', null);
    }

    public function getAllVideos (): JsonResponse {
        $videos = $this->videoRepository->findAll();
        foreach ($videos as $video) {
            $fetchedVideo [] = $video->serialize();
        }
        return $this->responseHelper->baseResponse('Videos fetched successfully', $fetchedVideo);

    }
    public function getVideoById ($id): JsonResponse {
        $video = $this->videoRepository->find($id);
        if ($video) {
            return $this->responseHelper->baseResponse('Video founded', $video->serialize());
        }
        else return $this->responseHelper->baseResponse('Video not found', null);
    }

    public function findFirstAndLastVideos (): JsonResponse {
        $first = $this->videoRepository->findOneBy([], ['id' => 'ASC']);
        $last = $this->videoRepository->findOneBy([], ['id' => 'DESC']);

        if ($first && $last) {
            $data = ['firstId' => $first->getId(), 'lastId' => $last->getId()];
            return $this->responseHelper->baseResponse('Video found', $data);
        }
        else return $this->responseHelper->baseResponse('Video dnot found', null);
    }

}