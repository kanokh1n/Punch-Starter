<?php

namespace App\Entity;

use App\Repository\ProjectInfoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectInfoRepository::class)]
class ProjectInfo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'projectInfo', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Projects $project_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $current_amount = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $goal_amount = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $project_img = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column]
    private ?int $likes = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjectId(): ?Projects
    {
        return $this->project_id;
    }

    public function setProjectId(Projects $project_id): static
    {
        $this->project_id = $project_id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCurrentAmount(): ?string
    {
        return $this->current_amount;
    }

    public function setCurrentAmount(string $current_amount): static
    {
        $this->current_amount = $current_amount;

        return $this;
    }

    public function getGoalAmount(): ?string
    {
        return $this->goal_amount;
    }

    public function setGoalAmount(string $goal_amount): static
    {
        $this->goal_amount = $goal_amount;

        return $this;
    }

    public function getProjectImg(): ?string
    {
        return $this->project_img;
    }

    public function setProjectImg(?string $project_img): static
    {
        $this->project_img = $project_img;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): static
    {
        $this->likes = $likes;

        return $this;
    }

}
