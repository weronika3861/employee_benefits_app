<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\WorkerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkerRepository::class)]
class Worker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255)]
    private string $email;

    #[ORM\Column]
    private int $closedTickets;

    #[ORM\Column]
    private int $receivedKudos;

    #[ORM\Column]
    private int $clientComplaints;

    #[ORM\Column]
    private int $earnedDonuts;

    #[ORM\Column]
    private ?bool $donutBanned = null;

    #[ORM\Column]
    private ?int $boardRecognitionPoints = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getClosedTickets(): int
    {
        return $this->closedTickets;
    }

    public function setClosedTickets(int $closedTickets): void
    {
        $this->closedTickets = $closedTickets;
    }

    public function getReceivedKudos(): int
    {
        return $this->receivedKudos;
    }

    public function setReceivedKudos(int $receivedKudos): void
    {
        $this->receivedKudos = $receivedKudos;
    }

    public function getClientComplaints(): int
    {
        return $this->clientComplaints;
    }

    public function setClientComplaints(int $clientComplaints): void
    {
        $this->clientComplaints = $clientComplaints;
    }

    public function getEarnedDonuts(): int
    {
        return $this->earnedDonuts;
    }

    public function setEarnedDonuts(int $earnedDonuts): void
    {
        $this->earnedDonuts = $earnedDonuts;
    }

    public function isDonutBanned(): ?bool
    {
        return $this->donutBanned;
    }

    public function setDonutBanned(bool $donutBanned): self
    {
        $this->donutBanned = $donutBanned;

        return $this;
    }

    public function getBoardRecognitionPoints(): ?int
    {
        return $this->boardRecognitionPoints;
    }

    public function setBoardRecognitionPoints(int $boardRecognitionPoints): self
    {
        $this->boardRecognitionPoints = $boardRecognitionPoints;

        return $this;
    }
}
