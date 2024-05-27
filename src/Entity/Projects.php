<?php

namespace App\Entity;

use App\Repository\ProjectsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectsRepository::class)]
class Projects
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\OneToOne(mappedBy: 'project_id', cascade: ['persist', 'remove'])]
    private ?ProjectInfo $projectInfo = null;

    #[ORM\OneToMany(mappedBy: 'project_id', targetEntity: ProjectsCategories::class, orphanRemoval: true)]
    private Collection $projectsCategories;

    #[ORM\OneToMany(mappedBy: 'project_id', targetEntity: Pledges::class)]
    private Collection $pledges;

    #[ORM\OneToMany(mappedBy: 'projects_id', targetEntity: Comments::class, orphanRemoval: true)]
    private Collection $comments;

    #[ORM\Column(length: 255)]
    #[ORM\JoinColumn(nullable: true)]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Likes::class)]
    private Collection $likes;

    public function __construct()
    {
        $this->projectsCategories = new ArrayCollection();
        $this->pledges = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getTitle(): ?ProjectInfo
    {
        return $this->title;
    }

    public function setTitle(ProjectInfo $title): static
    {
        // set the owning side of the relation if necessary
        if ($title->getProjectId() !== $this) {
            $title->setProjectId($this);
        }

        $this->title = $title;

        return $this;
    }

    public function getProjectInfo(): ?ProjectInfo
    {
        return $this->projectInfo;
    }

    public function setProjectInfo(ProjectInfo $projectInfo): static
    {
        // set the owning side of the relation if necessary
        if ($projectInfo->getProjectId() !== $this) {
            $projectInfo->setProjectId($this);
        }

        $this->projectInfo = $projectInfo;

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
            $projectsCategory->setProjectId($this);
        }

        return $this;
    }

    public function removeProjectsCategory(ProjectsCategories $projectsCategory): static
    {
        if ($this->projectsCategories->removeElement($projectsCategory)) {
            // set the owning side to null (unless already changed)
            if ($projectsCategory->getProjectId() === $this) {
                $projectsCategory->setProjectId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pledges>
     */
    public function getPledges(): Collection
    {
        return $this->pledges;
    }

    public function addPledge(Pledges $pledge): static
    {
        if (!$this->pledges->contains($pledge)) {
            $this->pledges->add($pledge);
            $pledge->setProjectId($this);
        }

        return $this;
    }

    public function removePledge(Pledges $pledge): static
    {
        if ($this->pledges->removeElement($pledge)) {
            // set the owning side to null (unless already changed)
            if ($pledge->getProjectId() === $this) {
                $pledge->setProjectId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setProjectsId($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getProjectsId() === $this) {
                $comment->setProjectsId(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Likes>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Likes $like): static
    {
        if (!$this->likes->contains($like)) {
            $this->likes->add($like);
            $like->setProject($this);
        }

        return $this;
    }

    public function removeLike(Likes $like): static
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getProject() === $this) {
                $like->setProject(null);
            }
        }

        return $this;
    }

    public function getLikesCount(): int
    {
        return $this->likes->count();
    }

    public function isLikedByUser(?User $user): bool
    {
        if ($user === null) {
            return false;
        }

        foreach ($this->likes as $like) {
            if ($like->getUser() === $user) {
                return true;
            }
        }
        return false;
    }
}
