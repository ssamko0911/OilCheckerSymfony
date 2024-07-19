<?php

namespace App\Service;

use App\Exception\ApiClientException;
use App\Request\OpenAiRequestPayload;
use App\Service\Logger\ApiLogger;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class ApiClient
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private ApiLogger           $logger,
        private string              $url,
        private string              $apiKey,
    )
    {
    }

    /**
     * @throws ApiClientException
     */
    public function get(OpenAiRequestPayload $payload): array
    {
        try {
            $response = $this->httpClient->request(
                'POST',
                $this->url,
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $this->apiKey,
                    ],
                    'json' => $payload->payLoad,
                ]
            );

            $content = $response->getContent();
            $context = [
                'content' => $content,
                'statusCode' => $response->getStatusCode(),
                'headers' => $response->getHeaders(),
                'url' => $this->url,
                'exception' => null,
            ];
        } catch (\Throwable $exception) {
            throw new ApiClientException($exception->getMessage(), $exception->getCode(), $exception);
        }

        $this->logger->log('ApiClient: ', $context);

        return json_decode($content, true);
    }
}