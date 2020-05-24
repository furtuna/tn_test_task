<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Tests\User\Model;

use PFC\Demo\SimpleUserImport\User\Model\User;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    /**
     * @return User
     */
    public function testCreateUser(): User
    {
        $user = new User('uid1', 'Name', 'email@gmail.com', 'usd', '88.15');
        $this->assertInstanceOf(User::class, $user);

        return $user;
    }

    /**
     * @depends testCreateUser
     *
     * @param User $user
     */
    public function testIdMethod(User $user): void
    {
        $this->assertEquals('uid1', $user->id());
    }

    /**
     * @depends testCreateUser
     *
     * @param User $user
     */
    public function testToArrayMethod(User $user): void
    {
        $this->assertSame([
            'id'       => 'uid1',
            'name'     => 'Name',
            'email'    => 'email@gmail.com',
            'currency' => 'usd',
            'sum'      => '88.15',
        ], $user->toArray());
    }
}
