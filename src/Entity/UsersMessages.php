<?php

namespace App\Entity;

use App\Repository\UsersMessagesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersMessagesRepository::class)]
class UsersMessages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Messages $message = null;

    #[ORM\ManyToOne(inversedBy: 'sendedUsersMessages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_sender = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_recipient = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?Messages
    {
        return $this->message;
    }

    public function setMessage(Messages $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getUserSender(): ?User
    {
        return $this->user_sender;
    }

    public function setUserSender(?User $user_sender): static
    {
        $this->user_sender = $user_sender;

        return $this;
    }

    public function getUserRecipient(): ?User
    {
        return $this->user_recipient;
    }

    public function setUserRecipient(?User $user_recipient): static
    {
        $this->user_recipient = $user_recipient;

        return $this;
    }
}
