<?php

namespace Amp\Http\Server\Driver;

use Amp\Http\Server\ErrorHandler;
use Amp\Http\Server\Options;
use Psr\Log\LoggerInterface as PsrLogger;

final class DefaultHttpDriverFactory implements HttpDriverFactory
{
    public function selectDriver(
        Client $client,
        ErrorHandler $errorHandler,
        PsrLogger $logger,
        Options $options
    ): HttpDriver {
        if ($client->getTlsInfo()?->getApplicationLayerProtocol() === "h2") {
            return new Http2Driver($options, $logger);
        }

        return new Http1Driver($options, $errorHandler, $logger);
    }

    public function getApplicationLayerProtocols(): array
    {
        return ["h2", "http/1.1"];
    }
}
