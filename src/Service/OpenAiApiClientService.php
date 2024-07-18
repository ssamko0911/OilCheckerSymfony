<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenAiApiClientService
{
    public function __construct(
        private HttpClientInterface $httpClient
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function fetchOpenAIInfo(string $apiKey, array $data): array
    {
        $apiUrl = 'https://api.openai.com/v1/chat/completions';

        $this->httpClient->withOptions([
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $apiKey,
            ],
            'json' => $data,
        ]);

        $response = $this->httpClient->request(
            'POST',
            $apiUrl
        );

        $content = $response->getContent();

        return $response->toArray();
    }
}