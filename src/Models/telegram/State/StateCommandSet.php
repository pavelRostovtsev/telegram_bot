<?php

declare(strict_types=1);

namespace App\Models\telegram\State;

class StateCommandSet
{
    private const STATE_START = 0;
    private const STATE_IN_PROCESS = 1;
    private const STATE_END = 2;

    private const STATE = [
      self::STATE_START,
      self::STATE_IN_PROCESS,
      self::STATE_END,
    ];

    private string $link;
    private string|null $name = null;
    private array $tags = [];
    private int $currentState;

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return int
     */
    public function getCurrentState(): int
    {
        return $this->currentState;
    }

    /**
     * @param int $currentState
     */
    public function setCurrentState(int $currentState): void
    {
        $this->currentState = $currentState;
    }
}
