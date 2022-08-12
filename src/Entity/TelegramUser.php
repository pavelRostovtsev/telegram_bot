<?php

namespace App\Entity;

use App\Repository\TelegramUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TelegramUserRepository::class)]
class TelegramUser
{
    #[ORM\Id]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $username = null;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Url::class)]
    private Collection $urls;

    public function __construct()
    {
        $this->urls = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getUserName(): ?string
    {
        return $this->username ;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection<int, Url>
     */
    public function getUrls(): Collection
    {
        return $this->urls;
    }

    public function addUrl(Url $url): self
    {
        if (!$this->urls->contains($url)) {
            $this->urls->add($url);
            $url->setUserId($this);
        }

        return $this;
    }

    public function removeUrl(Url $url): self
    {
        if ($this->urls->removeElement($url)) {
            // set the owning side to null (unless already changed)
            if ($url->getUserId() === $this) {
                $url->setUserId(null);
            }
        }

        return $this;
    }
}
