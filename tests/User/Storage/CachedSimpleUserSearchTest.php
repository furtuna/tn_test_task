<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Tests\User\Storage;

use Doctrine\Common\Cache\Cache;
use PFC\Demo\SimpleUserImport\User\Model\User;
use PFC\Demo\SimpleUserImport\User\Storage\CachedSimpleUserSearch;
use PFC\Demo\SimpleUserImport\User\Storage\SearchTerm;
use PFC\Demo\SimpleUserImport\User\Storage\SimpleUserSearch;
use PHPUnit\Framework\TestCase;

final class CachedSimpleUserSearchTest extends TestCase
{
    /**
     * @var CachedSimpleUserSearch
     */
    private $cachedSimpleUserSearch;

    public function setUp(): void
    {
        $cacheMock = $this->createMock(Cache::class);
        $cacheMock
            ->method('contains')
            ->will($this->returnValueMap([
                ['alice cooper', false],
                ['john doe', true],
            ]));
        $cacheMock
            ->method('fetch')
            ->will($this->returnValueMap([
                ['alice cooper', false],
                ['john doe', [new User('1', 'John Doe', '1@gmail.com', 'usd', '18.95')]],
            ]));

        $userSearchMock = $this->createMock(SimpleUserSearch::class);
        $userSearchMock
            ->method('search')
            ->willReturn([new User('2', 'Alice Cooper', '2@gmail.com', 'usd', '1.23')]);

        $this->cachedSimpleUserSearch = new CachedSimpleUserSearch(
            $userSearchMock,
            $cacheMock
        );
    }

    public function testResultFromCache(): void
    {
        $users = $this->cachedSimpleUserSearch->search(new SearchTerm('John Doe'));
        $this->assertIsArray($users);
        $this->assertCount(1, $users);
        $this->assertArrayHasKey(0, $users);
        $user = $users[0];
        $this->assertEquals('1', $user->id());
    }

    public function testResultNotFromCache(): void
    {
        $users = $this->cachedSimpleUserSearch->search(new SearchTerm('Alice Cooper'));
        $this->assertIsArray($users);
        $this->assertCount(1, $users);
        $this->assertArrayHasKey(0, $users);
        $user = $users[0];
        $this->assertEquals('2', $user->id());
    }
}
