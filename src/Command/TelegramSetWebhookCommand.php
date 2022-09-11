<?php

namespace App\Command;

use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Psr\Http\Client\ClientInterface;

#[AsCommand(
    name: 'telegram:set-webhook',
    description: 'registers a webhook',
)]
class TelegramSetWebhookCommand extends Command
{
    private ClientInterface $httpClient;

    public function __construct(ClientInterface $httpClient, string $name = null)
    {
        parent::__construct($name);

        $this->httpClient = $httpClient;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('webhookUri', description:'the url that your handler for web hooks is bound to')
        ;
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $webhookUri= $input->getArgument('webhookUri');

        $response = $this->httpClient
            ->post('setWebhook?url=' . $webhookUri)
            ->getBody()
            ->getContents();

        $response = implode(' ', json_decode($response, true, 512, JSON_THROW_ON_ERROR));

        $io->success('response: ' . $response);

        return Command::SUCCESS;
    }
}
