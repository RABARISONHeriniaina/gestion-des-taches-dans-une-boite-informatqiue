<?php

namespace App\Entity;

use App\Repository\PauseTimeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PauseTimeRepository::class)
 * @ORM\Table(name="pausetimes")
 */
class PauseTime
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reason;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $beginTimeAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $EndTimeAt;

    /**
     * @ORM\ManyToOne(targetEntity=Task::class, inversedBy="pausetime")
     * @ORM\JoinColumn(nullable=false)
     */
    private $task;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): self
    {
        $this->reason = $reason;

        return $this;
    }

    public function getBeginTimeAt(): ?\DateTimeImmutable
    {
        return $this->beginTimeAt;
    }

    public function setBeginTimeAt(\DateTimeImmutable $beginTimeAt): self
    {
        $this->beginTimeAt = $beginTimeAt;

        return $this;
    }

    public function getEndTimeAt(): ?\DateTimeImmutable
    {
        return $this->EndTimeAt;
    }

    public function setEndTimeAt(\DateTimeImmutable $EndTimeAt): self
    {
        $this->EndTimeAt = $EndTimeAt;

        return $this;
    }

    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(?Task $task): self
    {
        $this->task = $task;

        return $this;
    }
}
