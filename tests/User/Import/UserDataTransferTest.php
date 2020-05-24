<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Tests\User\Import;

use PFC\Demo\SimpleUserImport\User\Import\UserDataTransfer;
use PHPUnit\Framework\TestCase;

final class UserDataTransferTest extends TestCase
{
    /**
     * @var UserDataTransfer
     */
    private $userDataTransfer;

    public function setUp(): void
    {
        $this->userDataTransfer = new UserDataTransfer();
        $this->userDataTransfer->id = 'uid1';
        $this->userDataTransfer->name = 'Name';
        $this->userDataTransfer->email = 'email@gmail.com';
        $this->userDataTransfer->currency = 'usd';
        $this->userDataTransfer->sum = 18.85;
    }

    public function testUserDataTransfer(): void
    {
        $this->assertInstanceOf(UserDataTransfer::class, $this->userDataTransfer);
        $this->assertEquals('uid1', $this->userDataTransfer->id);
        $this->assertEquals('Name', $this->userDataTransfer->name);
        $this->assertEquals('email@gmail.com', $this->userDataTransfer->email);
        $this->assertEquals('usd', $this->userDataTransfer->currency);
        $this->assertEquals(18.85, $this->userDataTransfer->sum);
        $this->assertEquals('uid1', $this->userDataTransfer->getRowId());
    }
}
