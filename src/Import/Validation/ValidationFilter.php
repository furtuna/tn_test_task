<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Import\Validation;

use PFC\Demo\SimpleUserImport\Import\DataProvider\DataTransferInterface;
use PFC\Demo\SimpleUserImport\Import\InfoCollector\InfoCollectorInterface;

class ValidationFilter implements ValidationFilterInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var InfoCollectorInterface
     */
    private $infoCollector;

    /**
     * @param ValidatorInterface $validator
     * @param InfoCollectorInterface $infoCollector
     */
    public function __construct(ValidatorInterface $validator, InfoCollectorInterface $infoCollector)
    {
        $this->validator = $validator;
        $this->infoCollector = $infoCollector;
    }

    /**
     * @param \Iterator|DataTransferInterface[] $data
     *
     * @return \Iterator
     */
    public function filter(\Iterator $data): \Iterator
    {
        foreach ($data as $dataTransfer) {
            $validationResult = $this->validator->validate($dataTransfer);
            if ($validationResult->hasErrors()) {
                $this->infoCollector->addValidationError($validationResult);

                continue;
            }

            yield $dataTransfer;
        }
    }
}
