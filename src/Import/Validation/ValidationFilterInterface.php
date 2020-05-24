<?php

namespace PFC\Demo\SimpleUserImport\Import\Validation;

use PFC\Demo\SimpleUserImport\Import\DataProvider\DataTransferInterface;

interface ValidationFilterInterface
{
    /**
     * @param \Iterator|DataTransferInterface[] $data
     *
     * @return \Iterator
     */
    public function filter(\Iterator $data): \Iterator;
}
