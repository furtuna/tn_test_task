<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Tests\User\Import;

use PFC\Demo\SimpleUserImport\Import\Validation\ValidationResult;
use PFC\Demo\SimpleUserImport\User\Import\UserDataTransfer;
use PFC\Demo\SimpleUserImport\User\Import\UserDataValidator;
use PHPUnit\Framework\TestCase;

final class UserDataValidatorTest extends TestCase
{
    public function testValidData(): void
    {
        $userDataTransfer = new UserDataTransfer();

        $userDataTransfer->id = 'uid1';
        $userDataTransfer->name = 'Name';
        $userDataTransfer->email = 'email@gmail.com';
        $userDataTransfer->currency = 'usd';
        $userDataTransfer->sum = 18.85;

        $userDataValidator = new UserDataValidator();

        $validationResult = $userDataValidator->validate($userDataTransfer);
        $this->assertInstanceOf(ValidationResult::class, $validationResult);
        $this->assertFalse($validationResult->hasErrors());
    }

    public function testNotValidData(): void
    {
        $userDataTransfer = new UserDataTransfer();

        $userDataTransfer->id = 'uid1';
        $userDataTransfer->name = null;
        $userDataTransfer->email = 'email@gmail.com';
        $userDataTransfer->currency = 'usdD';
        $userDataTransfer->sum = '18.85';

        $userDataValidator = new UserDataValidator();

        $validationResult = $userDataValidator->validate($userDataTransfer);
        $this->assertInstanceOf(ValidationResult::class, $validationResult);
        $this->assertTrue($validationResult->hasErrors());
        $this->assertCount(3, $validationResult->errors());
    }
}
