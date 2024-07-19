<?php
declare(strict_types=1);

namespace App\Service\Logger;

use Psr\Log\LoggerInterface;

final readonly class ApiLogger
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function log(
        string $message,
        array  $context
    ): void
    {
        $this->logger->info($message, $context);
    }
}