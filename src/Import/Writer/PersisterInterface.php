<?php

namespace PFC\Demo\SimpleUserImport\Import\Writer;

use PFC\Demo\SimpleUserImport\Import\DataProvider\DataTransferInterface;

interface PersisterInterface
{
    /**
     * @param \Iterator|DataTransferInterface[] $dataTransfers
     *
     * @return PersisterResult
     */
    public function persistCollection(\Iterator $dataTransfers): PersisterResult;
}
