<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Import\DataProvider;

interface DataTransferInterface
{
    /**
     * @return string
     */
    public function getRowId(): ?string;
}
