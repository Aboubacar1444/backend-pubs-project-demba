<?php

namespace App\Helper;

use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseHelper
{

    public function createdResponse(string $message, $body, int $status = 1, int $http_state = Response::HTTP_CREATED,): JsonResponse
    {
        $data = [
            "status" => $status,
            "message" => $message,
            "body" => $body
        ];
        return new JsonResponse($data, $http_state);
    }

    public function errorResponse(string $message, $body, int $status = 0, int $http_state = Response::HTTP_OK): JsonResponse
    {
        $data = [
            "status" => $status,
            "message" => $message,
            "body" => $body
        ];
        return new JsonResponse($data, $http_state);
    }


    public function baseResponse(string $message, $body, int $status = 1, int $http_state = Response::HTTP_OK): JsonResponse
    {
        $data = [
            "status" => $status,
            "message" => $message,
            "body" => $body
        ];
        return new JsonResponse($data, $http_state);
    }

    public function baseResponseCountUser(string $message, $body,  int $totalUser, int $status = 1, int $http_state = Response::HTTP_OK): JsonResponse
    {
        $data = [
            "status" => $status,
            "message" => $message,
            "totalUser" => $totalUser,
            "body" => $body
        ];
        return new JsonResponse($data, $http_state);
    }


    public function basePaginationResponse(string $message, PaginationInterface $paginator, int $status = 1, int $http_state = Response::HTTP_OK): JsonResponse
    {
        $dataJson = [];
        if (sizeof($paginator) > 0) {
            foreach ($paginator as $p) {
                $dataJson[] = $p;
            }
        }
        $body = [
            'currentPage' => $paginator->getCurrentPageNumber(),
            'size' => $paginator->getItemNumberPerPage(),
            'totalElements' => $paginator->getTotalItemCount(),
            'totalPages' => ceil($paginator->getTotalItemCount() / $paginator->getItemNumberPerPage()),
            'content' => $dataJson,
        ];
        return $this->baseResponse($message, $body, $status, $http_state);
    }


}
