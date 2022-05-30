<?php

declare(strict_types=1);

namespace App\Services\telegram\Services;

use App\Services\telegram\Commands\TelegramCommandInterface;
use App\Services\telegram\Exceptions\CommandAlreadyExistsException;

class CommandService
{
    /**
     * @var TelegramCommandInterface[]
     */
    private array $commands = [];

    /**
     * @param iterable $commands
     * @throws CommandAlreadyExistsException
     */
    public function __construct(iterable $commands)
    {
        foreach ($commands as $command)
        {
            $this->add($command);
        }
    }

    public function getCommand(string $commandName): TelegramCommandInterface
    {
        return $this->commands[$commandName];
    }

    /**
     * @throws CommandAlreadyExistsException
     */
    private function add(TelegramCommandInterface $command)
    {
        $name = $command->getName();

        if ($this->has($name)) {
            throw new CommandAlreadyExistsException($name . ' telegram command has already been added');
        }

        $this->commands[$name] = $command;
    }

    private function has(string $name): bool
    {
        return array_key_exists($name, $this->commands);
    }
}
