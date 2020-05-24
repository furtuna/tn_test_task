<?php

namespace PFC\Demo\SimpleUserImport\Import\DataProvider;

interface DataTransferInterface
{
    /**
     * @return string
     */
    public function getRowId(): ?string;
}
