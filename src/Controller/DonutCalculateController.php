<?php

declare(strict_types=1);

namespace App\Controller;

use App\Services\Calculator\DonutCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class DonutCalculateController extends AbstractController
{
    public function __construct(
        private readonly DonutCalculator $donutCalculator,
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Route(
        '/donuts/count/{reference}/{id?}',
        name: 'donuts_count',
        requirements: ['reference' => '\d+'],
        methods: ['GET']
    )]
    public function countEarnedDonuts(int $reference, ?int $id = null): JsonResponse
    {
        if ($reference <= 0) {
            throw new BadRequestHttpException('Donut reference must be greater than 0.');
        }

        if ($id === null) {
            $data = $this->donutCalculator->updateAllWorkersEarnedDonuts($reference);
        } else {
            $data = $this->donutCalculator->updateWorkerEarnedDonuts($id, $reference);
        }

        return new JsonResponse(
            $this->serializer->serialize($data, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
