<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Import\InfoCollector;

use PFC\Demo\SimpleUserImport\Import\Validation\ValidationResult;

interface InfoCollectorInterface
{
    /**
     * @param ValidationResult $validationResult
     */
    public function addValidationError(ValidationResult $validationResult): void;

    /**
     * @return int
     */
    public function validationErrorsCount(): int;

    /**
     * @param int $insertedCount
     */
    public function addInserted(int $insertedCount): void;

    /**
     * @return int
     */
    public function inserted(): int;

    /**
     * @param int $updatedCount
     */
    public function addUpdated(int $updatedCount): void;

    /**
     * @return int
     */
    public function updated(): int;

    /**
     * @return int
     */
    public function processed(): int;

    /**
     */
    public function start(): void;

    /**
     */
    public function finish(): void;

    /**
     * @param int $steps
     */
    public function progress(int $steps): void;

    /**
     * @param int $total
     */
    public function setTotal(int $total): void;

    /**
     * @return int
     */
    public function total(): int;


}
