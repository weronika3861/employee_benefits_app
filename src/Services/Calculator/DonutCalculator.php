<?php

declare(strict_types=1);

namespace App\Services\Calculator;

use App\Entity\Worker;
use App\Events\DonutCalculationFinishEvent;
use App\Repository\WorkerRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DonutCalculator
{
    public function __construct(
        private readonly WorkerRepository $workerRepository,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function updateWorkerEarnedDonuts(int $id, int $donutReference): Worker
    {
        $worker = $this->workerRepository->find($id);
        if (!$worker) {
            throw new BadRequestHttpException('Worker not found.');
        }

        $this->updateWorkersEarnedDonuts([$worker], $donutReference);

        return $worker;
    }

    /**
     * @return Worker[]
     */
    public function updateAllWorkersEarnedDonuts(int $donutReference): array
    {
        $workers = $this->workerRepository->findAll();
        $this->updateWorkersEarnedDonuts($workers, $donutReference);

        return $workers;
    }

    public function calculateWorkerEarnedDonuts(Worker $worker, int $donutReference): int
    {
        if ($donutReference <= 0) {
            throw new \UnexpectedValueException('Donut reference must be greater than 0.');
        };

        if ($worker->isDonutBanned()) {
            return 0;
        }

        $earnedDonuts = (
                $worker->getClosedTickets() * 5
                + $worker->getReceivedKudos() * 2
                - $worker->getClientcomplaints() * 8
                + $worker->getBoardRecognitionPoints() * 3
            ) / $donutReference;

        return max((int)$earnedDonuts, 0);
    }

    /**
     * @param Worker[] $workers
     */
    private function updateWorkersEarnedDonuts(array $workers, int $donutReference): void
    {
        foreach ($workers as $worker) {
            $earnedDonuts = $this->calculateWorkerEarnedDonuts($worker, $donutReference);
            $worker->setEarnedDonuts($earnedDonuts);
        }

        $this->workerRepository->flush();
        $this->eventDispatcher->dispatch(
            new DonutCalculationFinishEvent($workers),
            DonutCalculationFinishEvent::NAME
        );
    }
}
