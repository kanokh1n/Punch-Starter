<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $login = null;

    #[ORM\Column(length: 255)]
    private ?string $password_hash = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Projects::class, orphanRemoval: true)]
    private Collection $projects;

    #[ORM\OneToOne(mappedBy: 'user_id', cascade: ['persist', 'remove'])]
    private ?UserProfile $userProfile = null;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Pledges::class)]
    private Collection $pledges;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Comments::class, orphanRemoval: true)]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: UsersRoles::class, orphanRemoval: true)]
    private Collection $usersRoles;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->pledges = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->usersRoles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    public function getPasswordHash(): ?string
    {
        return $this->password_hash;
    }

    public function setPasswordHash(string $password_hash): static
    {
        $this->password_hash = $password_hash;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

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

    /**
     * @return Collection<int, Projects>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Projects $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->setUserId($this);
        }

        return $this;
    }

    public function removeProject(Projects $project): static
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getUserId() === $this) {
                $project->setUserId(null);
            }
        }

        return $this;
    }

    public function getUserProfile(): ?UserProfile
    {
        return $this->userProfile;
    }

    public function setUserProfile(UserProfile $userProfile): static
    {
        // set the owning side of the relation if necessary
        if ($userProfile->getUserId() !== $this) {
            $userProfile->setUserId($this);
        }

        $this->userProfile = $userProfile;

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
            $pledge->setUserId($this);
        }

        return $this;
    }

    public function removePledge(Pledges $pledge): static
    {
        if ($this->pledges->removeElement($pledge)) {
            // set the owning side to null (unless already changed)
            if ($pledge->getUserId() === $this) {
                $pledge->setUserId(null);
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
            $comment->setUserId($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUserId() === $this) {
                $comment->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UsersRoles>
     */
    public function getUsersRoles(): Collection
    {
        return $this->usersRoles;
    }

    public function addUsersRole(UsersRoles $usersRole): static
    {
        if (!$this->usersRoles->contains($usersRole)) {
            $this->usersRoles->add($usersRole);
            $usersRole->setUserId($this);
        }

        return $this;
    }

    public function removeUsersRole(UsersRoles $usersRole): static
    {
        if ($this->usersRoles->removeElement($usersRole)) {
            // set the owning side to null (unless already changed)
            if ($usersRole->getUserId() === $this) {
                $usersRole->setUserId(null);
            }
        }

        return $this;
    }
}
