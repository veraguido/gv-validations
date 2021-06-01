<?php

namespace validation;

use Gvera\Exceptions\EmptyValidationStrategiesException;
use Gvera\Helpers\validation\EmailValidationStrategy;
use Gvera\Helpers\validation\ValidationService;
use Gvera\Validations\ControllerValidationAbstract;
use PHPUnit\Framework\TestCase;

class ControllerValidationAbstractTest extends TestCase
{
    /**
     * @var ValidationService
     */
    private ValidationService $validationService;

    /**
     * @test
     */
    public function testValidateCases()
    {
        $testObject = $this->getMockForAbstractClass(
            ControllerValidationAbstract::class,
            [$this->validationService, ['asd' => 'asd'], []]
        );
        $emailValidationStrategy = new EmailValidationStrategy();
        $this->assertTrue($testObject->validate('asd@asd.com', [$emailValidationStrategy]));
        $this->assertFalse($testObject->validate('falsytest', [$emailValidationStrategy]));
    }

    /**
     * @test
     */
    public function testException()
    {
        $this->expectException(EmptyValidationStrategiesException::class);
        $testObject = $this->getMockForAbstractClass(
            ControllerValidationAbstract::class,
            [$this->validationService, ['asd' => 'asd'], []]
        );
        $testObject->validate('asd', []);

    }

    public function setUp(): void
    {
        $this->validationService = new ValidationService();
    }
}