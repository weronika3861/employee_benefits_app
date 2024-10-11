<?php

declare(strict_types=1);

namespace Services\Calculator;

use App\Repository\WorkerRepository;
use App\Services\Calculator\DonutCalculator;
use App\Entity\Worker;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DonutCalculatorTest extends TestCase
{
    private Worker|MockObject $worker;

    private DonutCalculator $donutCalculator;

    protected function setUp(): void
    {
        $this->worker = $this->createMock(Worker::class);
        $workerRepository = $this->createMock(WorkerRepository::class);
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->donutCalculator = new DonutCalculator($workerRepository, $eventDispatcher);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testCalculateWorkerEarnedDonuts($donutReference, $donutBanned, $closedTickets, $receivedKudos, $clientComplaints, $boardRecognitionPoints, $expectedResult)
    {
        if ($donutReference <= 0) {
            $this->expectException(\UnexpectedValueException::class);
            $this->expectExceptionMessage('Donut reference must be greater than 0.');
        }

        $this->worker->method('isDonutBanned')->willReturn($donutBanned);
        $this->worker->method('getClosedTickets')->willReturn($closedTickets);
        $this->worker->method('getReceivedKudos')->willReturn($receivedKudos);
        $this->worker->method('getClientComplaints')->willReturn($clientComplaints);
        $this->worker->method('getBoardRecognitionPoints')->willReturn($boardRecognitionPoints);

        $result = $this->donutCalculator->calculateWorkerEarnedDonuts($this->worker, $donutReference);

        $this->assertEquals($expectedResult, $result);
    }

    public function dataProvider(): array
    {
        return [
            // $donutReference, $donutBanned, $closedTickets, $receivedKudos, $clientComplaints, $boardRecognitionPoints, $expectedResult
            'valid calculation with multiple positive parameters' => [5, false, 10, 5, 2, 3, 10],
            'worker is banned from receiving donuts should result in zero earnedDonuts' => [5, true, 10, 5, 2, 3, 0],
            'more clientComplaints than other parameters should result in zero earnedDonuts' => [1, false, 0, 0, 10, 0, 0],
            'all parameters set to zero should result in zero earnedDonuts' => [1, false, 0, 0, 0, 0, 0],
            'high receivedKudos should increase earnedDonuts' => [5, false, 0, 50, 0, 0, 20],
            'high boardRecognitionPoints should increase earnedDonuts' => [5, false, 0, 0, 0, 50, 30],
            'high clientComplaints should result in zero earnedDonuts' => [5, false, 0, 0, 50, 0, 0],
            'negative donutReference should throw exception' => [-1, false, 10, 5, 2, 3, null],
            'zero donutReference should throw exception' => [0, false, 10, 5, 2, 3, null],
        ];
    }
}