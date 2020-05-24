<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Tests\Import\Validation;

use PFC\Demo\SimpleUserImport\Import\Validation\ValidationResult;
use PHPUnit\Framework\TestCase;

final class ValidationResultTest extends TestCase
{
    public function testHasErrors(): void
    {
        $validationResult = new ValidationResult('1', ['Error 1', 'Error 2']);
        $this->assertTrue($validationResult->hasErrors());
        $errors = $validationResult->errors();
        $this->assertIsArray($errors);
        $this->assertCount(2, $errors);
    }

    public function testNoErrors(): void
    {
        $validationResult = new ValidationResult('1');
        $this->assertFalse($validationResult->hasErrors());
        $errors = $validationResult->errors();
        $this->assertIsArray($errors);
        $this->assertCount(0, $errors);
    }

    public function testRowIdIsSet(): void
    {
        $validationResult = new ValidationResult('1');
        $this->assertSame('1', $validationResult->rowId());
    }
}
