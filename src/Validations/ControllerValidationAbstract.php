<?php

namespace Gvera\Validations;

use Gvera\Exceptions\EmptyValidationStrategiesException;
use Gvera\Exceptions\InvalidValidationMethodException;
use Gvera\Helpers\validation\ValidationService;

abstract class ControllerValidationAbstract
{
    private ValidationService $validationService;
    protected array $fields;
    protected array $headers;

    public function __construct(ValidationService $validationService, array $fields, array $headers)
    {
        $this->validationService = $validationService;
        $this->fields = $fields;
        $this->headers = $headers;
    }

    /**
     * @param string|null $field
     * @param array $validationStrategies
     * @return bool
     * @throws EmptyValidationStrategiesException
     * @throws \Exception
     */
    public function validate(?string $field, array $validationStrategies): bool
    {
        if (0 === count($validationStrategies)) {
            throw new EmptyValidationStrategiesException('there is no validation strategy to perform');
        }

        return $this->validationService->validate($field, $validationStrategies);
    }
}