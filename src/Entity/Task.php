<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 * @ORM\Table(name="tasks")
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $subject;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $beginAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $endAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isComplished;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isInProgress;

    /**
     * @ORM\ManyToOne(targetEntity=Employee::class, inversedBy="task")
     * @ORM\JoinColumn(nullable=false)
     */
    private $employee;

    /**
     * @ORM\OneToMany(targetEntity=PauseTime::class, mappedBy="task", orphanRemoval=true)
     */
    private $pausetime;

    public function __construct()
    {
        $this->pausetime = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getBeginAt(): ?\DateTimeImmutable
    {
        return $this->beginAt;
    }

    public function setBeginAt(\DateTimeImmutable $beginAt): self
    {
        $this->beginAt = $beginAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeImmutable $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getIsComplished(): ?bool
    {
        return $this->isComplished;
    }

    public function setIsComplished(bool $isComplished): self
    {
        $this->isComplished = $isComplished;

        return $this;
    }

    public function getIsInProgress(): ?bool
    {
        return $this->isInProgress;
    }

    public function setIsInProgress(bool $isInProgress): self
    {
        $this->isInProgress = $isInProgress;

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * @return Collection|PauseTime[]
     */
    public function getPausetime(): Collection
    {
        return $this->pausetime;
    }

    public function addPausetime(PauseTime $pausetime): self
    {
        if (!$this->pausetime->contains($pausetime)) {
            $this->pausetime[] = $pausetime;
            $pausetime->setTask($this);
        }

        return $this;
    }

    public function removePausetime(PauseTime $pausetime): self
    {
        if ($this->pausetime->removeElement($pausetime)) {
            // set the owning side to null (unless already changed)
            if ($pausetime->getTask() === $this) {
                $pausetime->setTask(null);
            }
        }

        return $this;
    }
}
