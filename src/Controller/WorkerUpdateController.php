<?php

declare(strict_types=1);

namespace App\Controller;

use App\Services\WorkerUpdate\WorkerUpdateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class WorkerUpdateController extends AbstractController
{
    public function __construct(
        private readonly WorkerUpdateService $workerUpdateService,
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Route('/workers/{id}/points', name: 'board_recognition_points_update', methods: ['PATCH'])]
    public function updateBoardRecognitionPoints(int $id, Request $request): JsonResponse
    {
        $boardRecognitionPoints = $request->get('board_recognition_points') ?? null;
        if (!is_numeric($boardRecognitionPoints)) {
            throw new BadRequestHttpException('board_recognition_points must be numeric');
        }

        $worker = $this->workerUpdateService->setBoardRecognitionPoints($id, (int)$boardRecognitionPoints);

        return new JsonResponse(
            $this->serializer->serialize($worker, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    #[Route('/workers/{id}/ban', name: 'donut_banned_update', methods: ['PATCH'])]
    public function updateDonutBanned(int $id, Request $request): JsonResponse
    {
        $donutBanned = $request->get('donut_banned') ?? null;
        if (!is_bool($donutBanned)) {
            throw new BadRequestHttpException('donut_banned must be a boolean.');
        }

        $worker = $this->workerUpdateService->setDonutBanned($id, $donutBanned);

        return new JsonResponse(
            $this->serializer->serialize($worker, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
