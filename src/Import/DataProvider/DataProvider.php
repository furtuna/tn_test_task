<?php

namespace PFC\Demo\SimpleUserImport\Import\DataProvider;

use PFC\Demo\SimpleUserImport\Import\Reader\DataReaderInterface;

class DataProvider implements DataProviderInterface
{
    /**
     * @var DataReaderInterface
     */
    private $dataReader;

    /**
     * @var DataTransferMapperInterface
     */
    private $dataTransferMapper;

    /**
     * @param DataReaderInterface $dataReader
     * @param DataTransferMapperInterface $dataTransferMapper
     */
    public function __construct(
        DataReaderInterface $dataReader,
        DataTransferMapperInterface $dataTransferMapper
    ) {
        $this->dataTransferMapper = $dataTransferMapper;
        $this->dataReader = $dataReader;
    }

    /**
     * @return \Iterator|DataTransferInterface[]
     */
    public function getData(): \Iterator
    {
        $data = $this->dataReader->getData();

        foreach ($data as $dataRow) {
            yield $this->dataTransferMapper->map($dataRow);
        }
    }
}
