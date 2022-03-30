<?php

namespace App\Logging;

class SimpleFormatter
{
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(new \Monolog\Formatter\LineFormatter(
                "[%datetime%]: %message% %context%"
            ));
        }
    }
}