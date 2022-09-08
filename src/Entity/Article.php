<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    private const READING_STATUS_NOT_READ = 0;
    private const READING_STATUS_READ = 1;
    private const  READING_STATUS = [
        self::READING_STATUS_NOT_READ,
        self::READING_STATUS_READ,
    ];

    private const DELETION_REQUEST_TRUE = true;
    private const DELETION_REQUEST_FALSE = false;
    private const DELETION_REQUEST_STATUS = [
      self::DELETION_REQUEST_FALSE,
      self::DELETION_REQUEST_TRUE,
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TelegramUser $user = null;

    #[ORM\Column(nullable: true)]
    private ?bool $readingStatus = false;

    #[ORM\Column(nullable: true)]
    private ?bool $deletionRequestStatus = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUserId(): TelegramUser
    {
        return $this->user;
    }

    public function setUserId(TelegramUser $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function isReadingStatus(): ?bool
    {
        return $this->readingStatus;
    }

    public function setReadingStatus(bool $readingStatus): self
    {
        $this->readingStatus = $readingStatus;

        return $this;
    }

    public function isDeletionRequestStatus(): ?bool
    {
        return $this->deletionRequestStatus;
    }

    public function setDeletionRequestStatus(bool $deletionRequestStatus): self
    {
        $this->deletionRequestStatus = $deletionRequestStatus;

        return $this;
    }
}
