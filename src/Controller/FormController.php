<?php

namespace App\Controller;

use App\Request\FormPayloadRequest;
use App\Request\OpenAiRequest;
use App\Service\OpenAiApiClientService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class FormController extends AbstractController
{

    public function __construct(
        private readonly OpenAiApiClientService $openAiApiClientService,
        private readonly OpenAiRequest          $openAiRequest,
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/form', name: 'form', methods: ['POST'])]
    public function form(#[MapRequestPayload] FormPayloadRequest $formPayloadRequest): JsonResponse
    {
        $apiKey = '';

        $data = $this->openAiRequest->get($formPayloadRequest);

        $content = $this->openAiApiClientService->fetchOpenAIInfo($apiKey, $data);

        return new JsonResponse($content, Response::HTTP_OK);
    }
}