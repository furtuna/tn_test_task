<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Import\DataProvider;

interface DataTransferMapperInterface
{
    /**
     * @param array $data
     *
     * @return DataTransferInterface
     */
    public function map(array $data): DataTransferInterface;
}
