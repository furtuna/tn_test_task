<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Tests\User\Import;

use Doctrine\DBAL\Connection;
use PFC\Demo\SimpleUserImport\Import\Writer\PersisterInterface;
use PFC\Demo\SimpleUserImport\Import\Writer\PersisterResult;
use PFC\Demo\SimpleUserImport\Import\Writer\WriterException;
use PFC\Demo\SimpleUserImport\User\Import\Persister;
use PFC\Demo\SimpleUserImport\User\Import\UserDataTransfer;
use PFC\Demo\SimpleUserImport\User\Import\UserDataTransferMapper;
use PFC\Demo\SimpleUserImport\User\Import\UserImportDataTransferToUserModelMapper;
use PFC\Demo\SimpleUserImport\User\Storage\UserRepository;
use PHPUnit\Framework\TestCase;

final class PersisterTest extends TestCase
{
    /**
     * @var Persister
     */
    private $persister;

    /**
     * @var \Iterator|UserDataTransfer[]
     */
    private $validIterator;

    public function setUp(): void
    {
        $userRepositoryMock = $this->createMock(UserRepository::class);
        $userRepositoryMock
            ->method('findIdsByIds')
            ->willReturn(['1', '2']);

        $this->persister = new Persister(
            $this->createMock(Connection::class),
            $userRepositoryMock,
            new UserImportDataTransferToUserModelMapper()
        );

        $mapperHelper = new UserDataTransferMapper();
        $this->validIterator = new \ArrayIterator([
            $mapperHelper->map(['1','Name1', 'e1@gmail.com', 'usd', '1.99']),
            $mapperHelper->map(['2','Name2', 'e2@gmail.com', 'usd', '1.99']),
            $mapperHelper->map(['3','Name3', 'e3@gmail.com', 'usd', '1.99']),
        ]);
    }

    public function testImplementsValidInterface(): void
    {
        $this->assertInstanceOf(PersisterInterface::class, $this->persister);
    }

    public function testInvalidTransfer(): void
    {
        $iterator = new \ArrayIterator(['Not an object.']);

        $this->expectException(WriterException::class);
        $this->persister->persistCollection($iterator);
    }

    public function testValidPersisterResult(): void
    {
        $persisterResult = $this->persister->persistCollection($this->validIterator);
        $this->assertInstanceOf(PersisterResult::class, $persisterResult);
        $this->assertSame(2, $persisterResult->updated());
        $this->assertSame(1, $persisterResult->inserted());
    }
}
