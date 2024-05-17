<?php

namespace App\Service;

use App\Entity\Video;
use App\Entity\Visitor;
use App\Helper\ResponseHelper;
use App\Repository\VideoRepository;
use App\Repository\VisitorRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class VisitorService
{
    public function __construct(
        private readonly ResponseHelper                             $responseHelper,
        private readonly VisitorRepository                          $visitorRepository,
        private                                                     $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]),

    ){}

    public function addVisitor (Video $video, $data): JsonResponse {
        $visitor = $this->serializer->deserialize($data, Visitor::class, 'json');
        $visitor->setVideo($video);

        $this->visitorRepository->save($visitor, true);

        return $this->responseHelper->baseResponse('Visitor added successfully', $visitor->serialize());
    }

    public function updateVisitor (Visitor $selectedVisitor, $data): JsonResponse {
        $visitor = $this->serializer->deserialize($data, $selectedVisitor::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $selectedVisitor]);
        $this->visitorRepository->save($visitor, true);
        return $this->responseHelper->baseResponse('Visitor updated successfully', $visitor->serialize());
    }


    public function deleteVisitor ($id): JsonResponse {
        $visitor = $this->visitorRepository->find($id);
        if ($visitor) {
            $this->visitorRepository->remove($visitor, true);
            return $this->responseHelper->baseResponse('$visitor deleted successfully', null);
        }
        else return $this->responseHelper->baseResponse('$visitor not found', null);
    }

    public function getVisitors (): JsonResponse {
        $visitors = $this->visitorRepository->findAll();
        $data = [];
        foreach ($visitors as $visitor) {
            $data[] = $visitor->serialize();
        };
        return $this->responseHelper->baseResponse('Visitors retrieved successfully', $data);
    }



}