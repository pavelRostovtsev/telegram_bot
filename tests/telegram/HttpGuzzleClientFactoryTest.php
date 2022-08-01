<?php

namespace App\Tests\telegram;

use App\Services\telegram\Factory\HttpClientFactoryTelegram;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

class HttpGuzzleClientFactoryTest extends TestCase
{
    public function test_http_guzzle_client_factory_checking_returned_object(): void
    {
        $client = $this->getFactory()->createHttpClient();
        $this->assertInstanceOf(Client::class, $client);
    }

    /**
     * @throws ReflectionException
     */
    public function test_http_guzzle_client_factory_checking_base_uri(): void
    {
        $client = $this->getFactory()->createHttpClient();
        $baseUri = $this->getClientBaseUri($client);

        $this->assertSame(implode($this->getFactoryConfig()) . '/', $baseUri);
    }

    private function getFactory(): HttpClientFactoryTelegram
    {
        $config = $this->getFactoryConfig();
        $telegramUrl = $config['url'];
        $telegramToken = $config['token'];

        return new HttpClientFactoryTelegram($telegramUrl, $telegramToken);
    }

    private function getFactoryConfig(): array
    {
        return [
            'url' => 'url',
            'token' => 'token'
        ];
    }

    /**
     * @throws ReflectionException
     */
    private function getClientBaseUri(Client $client)
    {
        $reflectionClass = new ReflectionClass($client);
        $config = $reflectionClass->getProperty('config');
        $config->setAccessible(true);
        $config = $config->getValue($client);

        $reflectionClass = new ReflectionClass($config['base_uri']);
        $path = $reflectionClass->getProperty('path');
        $path->setAccessible(true);
        return $path->getValue($config['base_uri']);
    }
}
