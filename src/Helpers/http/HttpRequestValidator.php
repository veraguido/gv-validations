<?php

namespace Gvera\Helpers\http;

use Gvera\Exceptions\NotFoundException;
use Gvera\Helpers\validation\ValidationService;
use Gvera\Validations\ControllerValidationAbstract;

class HttpRequestValidator
{

    private const VALIDATIONS_PREFIX = 'Gvera\\Validations\\';
    private ValidationService $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    /**
     * @param string $validationClassName
     * @param string $validationMethod
     * @param array $fields
     * @param array $headers
     * @return mixed
     * @throws NotFoundException
     */
    public function validate(
        string $validationClassName,
        string $validationMethod,
        array $fields = [],
        array $headers = []
    )
    {
        $validationFullClassName = self::VALIDATIONS_PREFIX . $validationClassName;

        if (!class_exists($validationFullClassName)) {
            throw new NotFoundException('validation class does not exist');
        }

        $validation = new $validationFullClassName($this->validationService, $fields, $headers);

        if (!method_exists($validation, $validationMethod)) {
            throw new NotFoundException('validation method ' . $validationMethod . ' does not exist');
        }

        return $validation->$validationMethod();
    }
}