<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'categories_id', targetEntity: ProjectsCategories::class, orphanRemoval: true)]
    private Collection $projectsCategories;

    public function __construct()
    {
        $this->projectsCategories = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, ProjectsCategories>
     */
    public function getProjectsCategories(): Collection
    {
        return $this->projectsCategories;
    }

    public function addProjectsCategory(ProjectsCategories $projectsCategory): static
    {
        if (!$this->projectsCategories->contains($projectsCategory)) {
            $this->projectsCategories->add($projectsCategory);
            $projectsCategory->setCategoriesId($this);
        }

        return $this;
    }

    public function removeProjectsCategory(ProjectsCategories $projectsCategory): static
    {
        if ($this->projectsCategories->removeElement($projectsCategory)) {
            // set the owning side to null (unless already changed)
            if ($projectsCategory->getCategoriesId() === $this) {
                $projectsCategory->setCategoriesId(null);
            }
        }

        return $this;
    }
}
