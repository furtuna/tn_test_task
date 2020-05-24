<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Tests\User\Storage;

use PFC\Demo\SimpleUserImport\User\Storage\SearchException;
use PFC\Demo\SimpleUserImport\User\Storage\SearchTerm;
use PHPUnit\Framework\TestCase;

final class SearchTermTest extends TestCase
{
    public function testInvalidSearchTerm(): void
    {
        $this->expectException(SearchException::class);
        $searchTerm = new SearchTerm('12');
    }

    public function testValidSearchTerm(): void
    {
        $searchTerm = new SearchTerm('Alice Cooper');
        $this->assertSame('alice cooper', $searchTerm->value());
    }
}
