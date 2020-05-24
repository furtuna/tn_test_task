<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Tests\User\Import;

use PFC\Demo\SimpleUserImport\User\Import\UserDataTransfer;
use PFC\Demo\SimpleUserImport\User\Import\UserDataTransferMapper;
use PHPUnit\Framework\TestCase;

final class UserDataTransferMapperTest extends TestCase
{
    public function testMap(): void
    {
        $userDataTransferMapper = new UserDataTransferMapper();
        $data = ['uid1', 'Name', 'email@gmail.com', 'usd', '88.15'];
        $userDataTransfer = $userDataTransferMapper->map($data);
        $this->assertInstanceOf(UserDataTransfer::class, $userDataTransfer);
        $this->assertEquals('uid1', $userDataTransfer->id);
        $this->assertEquals('Name', $userDataTransfer->name);
        $this->assertEquals('email@gmail.com', $userDataTransfer->email);
        $this->assertEquals('usd', $userDataTransfer->currency);
        $this->assertSame(88.15, $userDataTransfer->sum);
    }
}
