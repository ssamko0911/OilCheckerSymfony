<?php

namespace App\Request;

class OpenAiRequest
{
    public function get(FormPayloadRequest $request): array
    {
        $oilGrade = $request->oilGrade;
        $engineType = $request->engineType;

        return [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "Is this {$oilGrade} compatible with the engine {$engineType}? Provide some precise examples if the given grade is not compatible with the engine",
                ]
            ],
        ];
    }
}