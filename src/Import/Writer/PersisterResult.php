<?php

namespace PFC\Demo\SimpleUserImport\Import\Writer;

class PersisterResult
{
    /**
     * @var int
     */
    private $updatedCount;

    /**
     * @var int
     */
    private $insertedCount;

    /**
     */
    public function __construct()
    {
        $this->abort();
    }

    /**
     */
    public function update(): void
    {
        ++$this->updatedCount;
    }

    /**
     */
    public function insert(): void
    {
        ++$this->insertedCount;
    }

    /**
     */
    public function abort(): void
    {
        $this->updatedCount = 0;
        $this->insertedCount = 0;
    }

    /**
     * @return int
     */
    public function updated(): int
    {
        return $this->updatedCount;
    }

    /**
     * @return int
     */
    public function inserted(): int
    {
        return $this->insertedCount;
    }
}
