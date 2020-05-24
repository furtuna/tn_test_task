<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Tests\Import\Writer;

use PFC\Demo\SimpleUserImport\Import\Writer\PersisterResult;
use PHPUnit\Framework\TestCase;

final class PersisterResultTest extends TestCase
{
    /**
     * @return PersisterResult
     */
    public function testInsertedUpdated(): PersisterResult
    {
        $persisterResult = new PersisterResult();
        $this->assertEquals(0, $persisterResult->inserted());
        $this->assertEquals(0, $persisterResult->updated());
        $persisterResult->update();
        $persisterResult->update();
        $persisterResult->insert();
        $this->assertEquals(1, $persisterResult->inserted());
        $this->assertEquals(2, $persisterResult->updated());

        return $persisterResult;
    }

    /**
     * @depends testInsertedUpdated
     *
     * @param PersisterResult $persisterResult
     */
    public function testAbort(PersisterResult $persisterResult): void
    {
        $persisterResult->abort();
        $this->assertEquals(0, $persisterResult->inserted());
        $this->assertEquals(0, $persisterResult->updated());
    }
}
