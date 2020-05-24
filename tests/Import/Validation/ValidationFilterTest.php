<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Tests\Import\Validation;

use PFC\Demo\SimpleUserImport\Import\DataProvider\DataTransferInterface;
use PFC\Demo\SimpleUserImport\Import\InfoCollector\InfoCollectorInterface;
use PFC\Demo\SimpleUserImport\Import\Validation\ValidationFilter;
use PFC\Demo\SimpleUserImport\User\Import\UserDataTransferMapper;
use PFC\Demo\SimpleUserImport\User\Import\UserDataValidator;
use PHPUnit\Framework\TestCase;

final class ValidationFilterTest extends TestCase
{
    public function testFiltrationIsCorrect(): void
    {
        $dataTransferMapper = new UserDataTransferMapper();
        $dataTransfers = new \ArrayIterator([
            $dataTransferMapper->map(['1', 'Name', '1@gmail.com', 'usd', '5.50']),
            $dataTransferMapper->map(['2', 'Name', '1@gmail.com', 'uah', '5.50']),
            $dataTransferMapper->map(['3', 'Name', '1@gmail.com', 'Unknown Currency', '5.50']),
        ]);

        $validationFilter = new ValidationFilter(
            new UserDataValidator(),
            $this->createMock(InfoCollectorInterface::class)
        );

        $dataTransfers = $validationFilter->filter($dataTransfers);
        /** @var DataTransferInterface $dataTransfer */
        $dataTransfer = $dataTransfers->current();
        $this->assertInstanceOf(DataTransferInterface::class, $dataTransfer);
        $this->assertSame('1', $dataTransfer->getRowId());
        $dataTransfers->next();
        $dataTransfer = $dataTransfers->current();
        $this->assertInstanceOf(DataTransferInterface::class, $dataTransfer);
        $this->assertSame('2', $dataTransfer->getRowId());
        $dataTransfers->next();
        $this->assertFalse($dataTransfers->valid());
    }
}
