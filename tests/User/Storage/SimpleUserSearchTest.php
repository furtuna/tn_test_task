<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Tests\User\Storage;

use PFC\Demo\SimpleUserImport\User\Model\User;
use PFC\Demo\SimpleUserImport\User\Storage\SearchTerm;
use PFC\Demo\SimpleUserImport\User\Storage\SimpleUserSearch;
use PFC\Demo\SimpleUserImport\User\Storage\UserRepository;
use PHPUnit\Framework\TestCase;

final class SimpleUserSearchTest extends TestCase
{
    /**
     * @var SimpleUserSearch
     */
    private $simpleUserSearch;

    /**
     * @var User
     */
    private $user;

    public function setUp(): void
    {
        $this->user = new User('1', 'Name', 'email@gmail.com', 'usd', '18.15');
        $userRepositoryMock = $this->createMock(UserRepository::class);
        $userRepositoryMock
            ->method('findByNameOrEmail')
            ->willReturn([clone $this->user]);

        $this->simpleUserSearch = new SimpleUserSearch($userRepositoryMock);
    }

    public function testValidSearchResult(): void
    {
        $users = $this->simpleUserSearch->search(new SearchTerm('Alice Cooper'));
        $this->assertIsArray($users);
        $this->assertCount(1, $users);
        $this->assertArrayHasKey(0, $users);
        $user = $users[0];
        $this->assertEquals($this->user, $user);
    }
}
