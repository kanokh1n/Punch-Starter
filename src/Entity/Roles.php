<?php

namespace App\Entity;

use App\Repository\RolesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RolesRepository::class)]
class Roles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'role_id', targetEntity: UsersRoles::class, orphanRemoval: true)]
    private Collection $usersRoles;

    public function __construct()
    {
        $this->usersRoles = new ArrayCollection();
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
            $usersRole->setRoleId($this);
        }

        return $this;
    }

    public function removeUsersRole(UsersRoles $usersRole): static
    {
        if ($this->usersRoles->removeElement($usersRole)) {
            // set the owning side to null (unless already changed)
            if ($usersRole->getRoleId() === $this) {
                $usersRole->setRoleId(null);
            }
        }

        return $this;
    }
}
