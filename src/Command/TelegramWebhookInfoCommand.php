<?php

namespace App\Command;

use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Psr\Http\Client\ClientInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:telegram:webhookInfo',
    description: 'Add a short description for your command',
)]
class TelegramWebhookInfoCommand extends Command
{

    private ClientInterface $httpClient;

    public function __construct(ClientInterface $httpClient, string $name = null)
    {
        parent::__construct($name);

        $this->httpClient = $httpClient;
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $response = $this->httpClient
            ->post('getWebhookInfo')
            ->getBody()
            ->getContents();
        $response = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

        $responseStatus = 'status: ' . $response['ok'];

        if (array_key_exists('last_error_message', $response)) {
            $responseStatus .= 'last_error_message' . $response['last_error_message'];
        }

        $io->success('response: ' . $responseStatus);

        return Command::SUCCESS;
    }
}
