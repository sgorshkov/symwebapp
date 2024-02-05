<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

final class ValidationException extends \RuntimeException implements HttpExceptionInterface
{
    private const int STATUS_CODE = Response::HTTP_UNPROCESSABLE_ENTITY;

    private array $errors = [];

    #[\Override]
    public function getStatusCode(): int
    {
        return self::STATUS_CODE;
    }

    #[\Override]
    public function getHeaders(): array
    {
        return [];
    }

    public static function fromViolationArray(iterable $errors): self
    {
        $exception = new self(
            'Validation error',
            self::STATUS_CODE
        );
        $resultErrors = [];
        /** @var ConstraintViolationInterface $error */
        foreach ($errors as $error) {
            $resultErrors[$error->getPropertyPath()] = $error->getMessage();
        }
        $exception->setErrors($resultErrors);

        return $exception;
    }

    public static function fromArray(array $errors): self
    {
        $exception = new self(
            'Validation error',
            self::STATUS_CODE
        );
        $exception->setErrors($errors);

        return $exception;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }
}
