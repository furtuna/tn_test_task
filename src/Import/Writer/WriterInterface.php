<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Import\Writer;

use PFC\Demo\SimpleUserImport\Import\DataProvider\DataTransferInterface;

interface WriterInterface
{
    /**
     * @param \Iterator|DataTransferInterface[] $data
     */
    public function write(\Iterator $data): void;
}
