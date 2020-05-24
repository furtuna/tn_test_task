<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Import\DataProvider;

interface DataProviderInterface
{
    /**
     * @return \Iterator|DataTransferInterface[]
     */
    public function getData(): \Iterator;
}
