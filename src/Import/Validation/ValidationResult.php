<?php

namespace PFC\Demo\SimpleUserImport\Import\Validation;

class ValidationResult
{
    /**
     * @var string
     */
    private $rowId;

    /**
     * @var string[]
     */
    private $errors;

    /**
     * @param string|null $rowId
     * @param array $errors
     */
    public function __construct(string $rowId, array $errors = [])
    {
        $this->rowId = $rowId;
        $this->errors = $errors;
    }

    /**
     * @return string
     */
    public function rowId(): string
    {
        return $this->rowId;
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return 0 !== count($this->errors);
    }

    /**
     * @return string[]
     */
    public function errors(): array
    {
        return $this->errors;
    }
}
