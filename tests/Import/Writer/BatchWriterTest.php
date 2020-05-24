<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Tests\Import\Writer;

use PFC\Demo\SimpleUserImport\Import\InfoCollector\InfoCollectorInterface;
use PFC\Demo\SimpleUserImport\Import\Writer\BatchWriter;
use PFC\Demo\SimpleUserImport\Import\Writer\PersisterInterface;
use PFC\Demo\SimpleUserImport\Import\Writer\WriterException;
use PFC\Demo\SimpleUserImport\User\Import\UserDataTransferMapper;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class BatchWriterTest extends TestCase
{
    /**
     * @var BatchWriter
     */
    private $batchWriter;

    /**
     * @var PersisterInterface|MockObject
     */
    private $persister;

    public function setUp(): void
    {
        $this->persister = $this->createMock(PersisterInterface::class);

        $this->batchWriter = new BatchWriter(
            $this->persister,
            $this->createMock(InfoCollectorInterface::class),
            2
        );
    }

    public function testInvalidTransferException(): void
    {
        $dataTransfers = new \ArrayIterator(['Invalid Transfer']);
        $this->expectException(WriterException::class);
        $this->batchWriter->write($dataTransfers);
    }

    public function testCorrectBatchProcessing(): void
    {
        $dataTransferMapper = new UserDataTransferMapper();
        $dataTransfers = new \ArrayIterator([
            $dataTransferMapper->map(['1', 'Name 1', '1@gmail.com', 'usd', '5.50']),
            $dataTransferMapper->map(['2', 'Name 2', '2@gmail.com', 'usd', '5.50']),
            $dataTransferMapper->map(['3', 'Name 3', '3@gmail.com', 'usd', '5.50']),
            $dataTransferMapper->map(['4', 'Name 4', '4@gmail.com', 'usd', '5.50']),
            $dataTransferMapper->map(['5', 'Name 5', '5@gmail.com', 'usd', '5.50']),
        ]);

        $this->persister
            ->expects($this->exactly(3))
            ->method('persistCollection');

        $this->batchWriter->write($dataTransfers);
    }
}
