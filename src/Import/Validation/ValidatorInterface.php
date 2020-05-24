<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Import\Validation;

use PFC\Demo\SimpleUserImport\Import\DataProvider\DataTransferInterface;

interface ValidatorInterface
{
    /**
     * @param DataTransferInterface $dataTransfer
     *
     * @return ValidationResult
     */
    public function validate(DataTransferInterface $dataTransfer): ValidationResult;
}
