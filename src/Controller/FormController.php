<?php

namespace App\Controller;

use App\Exception\ApiClientException;
use App\Request\FormPayloadRequest;
use App\Request\OpenAiRequestPayload;
use App\Service\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class FormController extends AbstractController
{

    public function __construct(
        private readonly ApiClient $apiClient,
        private readonly string $model
    )
    {
    }

    #[Route('/form', name: 'form', methods: ['POST'])]
    public function form(#[MapRequestPayload] FormPayloadRequest $formPayloadRequest): Response
    {
        $request = new OpenAiRequestPayload($this->model, $formPayloadRequest);

        try {
            $content = $this->apiClient->get($request);
            $result = $content['choices'][0]['message']['content'];
        } catch (ApiClientException $exception) {
            return $this->render('main/index.html.twig', [
                'result' => $exception->getMessage(),
            ]);
        }

        return $this->render('main/index.html.twig', [
            'result' => $result,
        ]);
    }
}