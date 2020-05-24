<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\User\Import;

use PFC\Demo\SimpleUserImport\Import\DataProvider\DataTransferInterface;
use PFC\Demo\SimpleUserImport\Import\Validation\ValidationResult;
use PFC\Demo\SimpleUserImport\Import\Validation\ValidatorException;
use PFC\Demo\SimpleUserImport\Import\Validation\ValidatorInterface;

/**
 * Just simple raw implementation for demo purposes.
 */
class UserDataValidator implements ValidatorInterface
{
    /**
     * Just simple raw implementation for demo purposes.
     *
     * @param DataTransferInterface $dataTransfer
     *
     * @return ValidationResult
     *
     * @throws ValidatorException
     */
    public function validate(DataTransferInterface $dataTransfer): ValidationResult
    {
        if (!$dataTransfer instanceof UserDataTransfer) {
            throw new ValidatorException(sprintf('Invalid import data transfer passed "%s"', get_class($dataTransfer)));
        }

        $validationErrors = [];
        if (empty($dataTransfer->id) || strlen($dataTransfer->id) > 100) {
            $validationErrors[] = 'Invalid "id" field value.';
        }

        if (empty($dataTransfer->name) || strlen($dataTransfer->name) > 100) {
            $validationErrors[] = 'Invalid "name" field value.';
        }

        if (empty($dataTransfer->email) || strlen($dataTransfer->email) > 100) {
            $validationErrors[] = 'Invalid "email" field value.';
        }

        if (!in_array($dataTransfer->currency, ['usd', 'uah'])) {
            $validationErrors[] = 'Invalid "currency" field value.';
        }

        if (!is_float($dataTransfer->sum) || $dataTransfer->sum >= 1000) {
            $validationErrors[] = 'Invalid "sum" field value.';
        }

        $rowId = $dataTransfer->getRowId() ?? 'unknown';

        return new ValidationResult($rowId, $validationErrors);
    }
}
