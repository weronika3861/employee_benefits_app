<?php

declare(strict_types=1);

namespace App\Events;

use App\Entity\Worker;
use Symfony\Contracts\EventDispatcher\Event;

class DonutCalculationFinishEvent extends Event
{
    public const NAME = 'donut.calculate.all.finish';


    /**
     * @var Worker[] $workers
     */
    private array $workers;

    public function __construct(array $workers)
    {
        $this->workers = $workers;
    }

    /**
     * @return Worker[]
     */
    public function getWorkers(): array
    {
        return $this->workers;
    }
}
