<?php

namespace App\Request;

final readonly class OpenAiRequestPayload
{
    public array $payLoad;

    public function __construct(
        private string            $model,
        public FormPayloadRequest $formPayloadRequest
    )
    {
        $this->payLoad = [
            'model' => $this->model,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "Is this {$this->formPayloadRequest->oilGrade} compatible with the engine {$this->formPayloadRequest->engineType}? Provide some precise examples if the given grade is not compatible with the engine",
                ]
            ]
        ];
    }
}