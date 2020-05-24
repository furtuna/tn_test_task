<?php

namespace PFC\Demo\SimpleUserImport\Import\Reader;

class CsvFileDataReader implements DataReaderInterface
{
    /**
     * @var string
     */
    private $filePath;

    /**
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @return int
     *
     * @throws DataReaderException
     */
    public function rowsCount(): int
    {
        $fileHandler = $this->openFile();

        $rowsCount = 0;
        while (fgetcsv($fileHandler)) {
            ++$rowsCount;
        }

        fclose($fileHandler);

        return $rowsCount;
    }

    /**
     * @return \Iterator|string[]
     *
     * @throws DataReaderException
     */
    public function getData(): \Iterator
    {
        $fileHandler = $this->openFile();

        while ($row = fgetcsv($fileHandler)) {
            yield $row;
        }

        fclose($fileHandler);
    }

    /**
     * @return resource
     *
     * @throws DataReaderException
     */
    private function openFile()
    {
        if (!file_exists($this->filePath)) {
            throw new DataReaderException(sprintf('File not found in "%s"', $this->filePath));
        }

        $fileHandler = fopen($this->filePath, 'r');

        if (false === $fileHandler) {
            throw new DataReaderException(sprintf('Can not open file "%s"', $this->filePath));
        }

        return $fileHandler;
    }
}
