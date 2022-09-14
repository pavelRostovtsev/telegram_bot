<?php

namespace App\Tests\telegram;

use App\Models\telegram\Exceptions\CommandAlreadyExistsException;
use App\Models\telegram\Services\CommandService;
use App\Tests\telegram\mock\TelegramCommandMock;
use PHPUnit\Framework\TestCase;

class CommandServiceTest extends TestCase
{
    public function test_command_service_command_already_exists_exception()
    {
        $this->expectException(CommandAlreadyExistsException::class);
        $this->getCommandService([$this->getCommands(), $this->getCommands()]);
    }

    /**
     * @throws CommandAlreadyExistsException
     */
    public function test_command_service_get_command()
    {
        $commandService = $this->getCommandService([$this->getCommands()]);
        $command = $commandService->getCommand('TelegramCommandMock');
        $this->assertInstanceOf('App\Tests\telegram\mock\TelegramCommandMock', $command);
    }

    /**
     * @throws CommandAlreadyExistsException
     */
    private function getCommandService(array $command): CommandService
    {
        return new CommandService($command);
    }

    private function getCommands(): TelegramCommandMock
    {
        return new TelegramCommandMock();
    }

}
