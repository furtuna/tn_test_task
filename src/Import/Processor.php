<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Import;

use PFC\Demo\SimpleUserImport\Import\DataProvider\DataProviderInterface;
use PFC\Demo\SimpleUserImport\Import\Validation\ValidationFilterInterface;
use PFC\Demo\SimpleUserImport\Import\Writer\WriterInterface;

class Processor
{
    /**
     * @var DataProviderInterface
     */
    private $dataProvider;

    /**
     * @var ValidationFilterInterface
     */
    private $validationFilter;

    /**
     * @var WriterInterface
     */
    private $writer;

    /**
     * @param DataProviderInterface $dataProvider
     * @param ValidationFilterInterface $validationFilter
     * @param WriterInterface $writer
     */
    public function __construct(
        DataProviderInterface $dataProvider,
        ValidationFilterInterface $validationFilter,
        WriterInterface $writer
    ) {
        $this->dataProvider = $dataProvider;
        $this->validationFilter = $validationFilter;
        $this->writer = $writer;
    }

    /**
     */
    public function process(): void
    {
        $data = $this->dataProvider->getData();
        $data = $this->validationFilter->filter($data);
        $this->writer->write($data);
    }
}
