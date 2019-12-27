<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeRepository")
 */
class Employee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=28)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=28, nullable=true)
     */
    private $lastname;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WorkingHours", mappedBy="employee", orphanRemoval=true)
     */
    private $workingHours;

    public function __construct()
    {
        $this->workingHours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return Collection|WorkingHours[]
     */
    public function getWorkingHours(): Collection
    {
        return $this->workingHours;
    }

    public function addWorkingHour(WorkingHours $workingHour): self
    {
        if (!$this->workingHours->contains($workingHour)) {
            $this->workingHours[] = $workingHour;
            $workingHour->setEmployee($this);
        }

        return $this;
    }

    public function removeWorkingHour(WorkingHours $workingHour): self
    {
        if ($this->workingHours->contains($workingHour)) {
            $this->workingHours->removeElement($workingHour);
            // set the owning side to null (unless already changed)
            if ($workingHour->getEmployee() === $this) {
                $workingHour->setEmployee(null);
            }
        }

        return $this;
    }
}
