<?php

declare(strict_types=1);

namespace Vigihdev\Faker\Exceptions;

use Throwable;

abstract class AbstractFakerException extends \Exception implements FakerExceptionInterface
{

    protected array $context = [];

    protected array $solutions = [];


    public function __construct(
        string $message,
        int $code = 0,
        \Throwable $previous = null,
        array $context = [],
        array $solutions = []
    ) {
        $this->context = $context;
        $this->solutions = $solutions;
        parent::__construct($message, $code, $previous);
    }

    public function getContext(): array
    {
        return $this->context;
    }

    public function getSolutions(): array
    {
        return $this->solutions;
    }

    public function getFormattedMessage(): string
    {
        $message = $this->getMessage();

        if (!empty($this->context)) {
            $contextStr = json_encode($this->context, JSON_UNESCAPED_SLASHES);
            $message .= " (context: {$contextStr})";
        }
        return $message;
    }

    public function toArray(): array
    {
        return [
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
            'context' => $this->context,
            'solutions' => $this->solutions,
            'exception' => static::class,
        ];
    }
}
