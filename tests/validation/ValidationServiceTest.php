<?php

use Gvera\Helpers\http\HttpResponse;
use Gvera\Helpers\validation\EmailValidationStrategy;
use Gvera\Helpers\validation\IsNotEmptyValidationStrategy;
use Gvera\Helpers\validation\ValidationService;
use PHPUnit\Framework\TestCase;

class ValidationServiceTest extends TestCase
{
    /**
     * @test
     */
    public function testService()
    {
        $service = new ValidationService();
        $emailValidation = new EmailValidationStrategy();
        $notEmptyValidation = new IsNotEmptyValidationStrategy();
        $this->assertTrue($service->validate('peperino@pomoro.com', [$emailValidation, $notEmptyValidation]));
    }

    /**
     * @test
     */
    public function testException()
    {
        $this->expectException(Exception::class);
        $service = new ValidationService();
        $service->validate('a', [new ValidationService()]);
    }

    /** @test */
    public function testFalsy()
    {
        $service = new ValidationService();
        $emailValidation = new EmailValidationStrategy();
        $this->assertFalse($service->validate('pepe', [$emailValidation]));
    }
}