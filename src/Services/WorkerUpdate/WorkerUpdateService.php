<?php

declare(strict_types=1);

namespace App\Services\WorkerUpdate;

use App\Entity\Worker;
use App\Repository\WorkerRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WorkerUpdateService
{
    public function __construct(private readonly WorkerRepository $workerRepository)
    {
    }

    public function setBoardRecognitionPoints(int $id, int $boardRecognitionPoints): Worker
    {
        $worker = $this->workerRepository->find($id);
        if (!$worker) {
            throw new NotFoundHttpException('Worker not found.');
        }

        $worker->setBoardRecognitionPoints($boardRecognitionPoints);
        $this->workerRepository->save($worker, true);

        return $worker;
    }

    public function setDonutBanned(int $id, bool $donutBanned): Worker
    {
        $worker = $this->workerRepository->find($id);
        if (!$worker) {
            throw new NotFoundHttpException('Worker not found.');
        }

        $worker->setDonutBanned($donutBanned);
        $this->workerRepository->save($worker, true);

        return $worker;
    }
}
