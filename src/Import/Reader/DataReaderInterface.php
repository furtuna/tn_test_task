<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Import\Reader;

interface DataReaderInterface
{
    /**
     * @return \Iterator|string[]
     */
    public function getData(): \Iterator;

    /**
     * @return int
     */
    public function rowsCount(): int;
}
