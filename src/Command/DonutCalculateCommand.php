<?php

declare(strict_types=1);

namespace App\Command;

use App\Services\Calculator\DonutCalculator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:count-donuts')]
class DonutCalculateCommand extends Command
{
    public function __construct(private readonly DonutCalculator $donutCalculator)
    {
        parent::__construct();
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        parent::initialize($input, $output);

        if ((int)$input->getArgument('donut_reference') <= 0) {
            throw new InvalidArgumentException();
        }
    }

    protected function configure(): void
    {
        $this->setDescription(
            'This command allows you to calculate earned donuts by each worker and update it in database.'
        );
        $this->addArgument('donut_reference', InputArgument::REQUIRED, 'Reference donuts');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->donutCalculator->updateAllWorkersEarnedDonuts(
            (int)$input->getArgument('donut_reference')
        );

        return Command::SUCCESS;
    }
}
