<?php

namespace App\Entity;

use App\Repository\StatusesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusesRepository::class)]
class Statuses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToOne(mappedBy: 'status_id')]
    private ?Projects $projects = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getProjects(): ?Projects
    {
        return $this->projects;
    }

    public function setProjects(Projects $projects): static
    {
        // set the owning side of the relation if necessary
        if ($projects->getStatusId() !== $this) {
            $projects->setStatusId($this);
        }

        $this->projects = $projects;

        return $this;
    }
}
