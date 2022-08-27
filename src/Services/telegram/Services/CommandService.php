<?php

declare(strict_types=1);

namespace App\Services\telegram\Services;

use App\Services\telegram\Commands\BaseTelegramCommand;
use App\Services\telegram\Commands\TelegramCommandInterface;
use App\Services\telegram\Exceptions\CommandAlreadyExistsException;
use App\Services\telegram\Exceptions\TelegramCommandNotFoundException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;

class CommandService
{
    /**
     * @var TelegramCommandInterface[]
     */
    private array $commands = [];
    private LoggerInterface $logger;

    /**
     * @throws CommandAlreadyExistsException
     */
    public function __construct(iterable $commands, LoggerInterface $logger)
    {
        $this->logger = $logger;
        foreach ($commands as $command)
        {
            $this->add($command);
        }
    }

    /**
     * @throws TelegramCommandNotFoundException
     */
    public function getCommand(string $commandName): TelegramCommandInterface
    {
        if (!array_key_exists($commandName, $this->commands)) {
            throw new TelegramCommandNotFoundException();
        }

        return $this->commands[$commandName];
    }

    /**
     * @throws CommandAlreadyExistsException
     */
    private function add(TelegramCommandInterface $command): void
    {
        $name = $command->getName();

        if ($this->has($name)) {
            $this->logger->alert('Command' . $name .'Not Found');
            throw new CommandAlreadyExistsException($name . ' telegram command has already been added');
        }

        $this->commands[$name] = $command;
    }

    private function has(string $name): bool
    {
        return array_key_exists($name, $this->commands);
    }
}
