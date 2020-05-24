<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Tests\User\Import;

use PFC\Demo\SimpleUserImport\User\Import\UserDataTransfer;
use PFC\Demo\SimpleUserImport\User\Import\UserImportDataTransferToUserModelMapper;
use PFC\Demo\SimpleUserImport\User\Model\User;
use PHPUnit\Framework\TestCase;

final class UserImportDataTransferToUserModelMapperTest extends TestCase
{
    public function testMap(): void
    {
        $mapper = new UserImportDataTransferToUserModelMapper();

        $userDataTransfer = new UserDataTransfer();
        $userDataTransfer->id = 'uid1';
        $userDataTransfer->name = 'Name';
        $userDataTransfer->email = 'email@gmail.com';
        $userDataTransfer->currency = 'usd';
        $userDataTransfer->sum = 18.8578;

        $user = $mapper->map($userDataTransfer);
        $this->assertInstanceOf(User::class, $user);
        $this->assertSame([
            'id'       => 'uid1',
            'name'     => 'Name',
            'email'    => 'email@gmail.com',
            'currency' => 'usd',
            'sum'      => '18.86',
        ], $user->toArray());
    }
}
