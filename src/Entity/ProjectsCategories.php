<?php

namespace App\Entity;

use App\Repository\ProjectsCategoriesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectsCategoriesRepository::class)]
class ProjectsCategories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'projectsCategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Projects $project_id = null;

    #[ORM\ManyToOne(inversedBy: 'projectsCategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categories $categories_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjectId(): ?Projects
    {
        return $this->project_id;
    }

    public function setProjectId(?Projects $project_id): static
    {
        $this->project_id = $project_id;

        return $this;
    }

    public function getCategoriesId(): ?Categories
    {
        return $this->categories_id;
    }

    public function setCategoriesId(?Categories $categories_id): static
    {
        $this->categories_id = $categories_id;

        return $this;
    }
}
