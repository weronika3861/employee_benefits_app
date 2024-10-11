<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Worker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class DonutCalculatorFixtures extends Fixture
{
    public const WORKER_AMOUNT = 10000;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < self::WORKER_AMOUNT; $i++) {
            $worker = new Worker();
            $worker->setName($faker->firstNameMale);
            $worker->setEmail($faker->email);
            $worker->setClosedTickets($faker->numberBetween(0, 50));
            $worker->setReceivedKudos($faker->numberBetween(0, 30));
            $worker->setClientComplaints($faker->numberBetween(0, 20));
            $worker->setEarnedDonuts($faker->numberBetween(0, 101));
            $worker->setDonutBanned($faker->boolean(10));
            $worker->setBoardRecognitionPoints($faker->numberBetween(0, 10));
            $manager->persist($worker);
        }
        $manager->flush();
    }
}
