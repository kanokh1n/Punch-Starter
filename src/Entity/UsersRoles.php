<?php

namespace App\Entity;

use App\Repository\UsersRolesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRolesRepository::class)]
class UsersRoles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'usersRoles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'usersRoles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Roles $role_id = null;

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

    public function getRoleId(): ?Roles
    {
        return $this->role_id;
    }

    public function setRoleId(?Roles $role_id): static
    {
        $this->role_id = $role_id;

        return $this;
    }
}
