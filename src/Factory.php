<?php

namespace PFC\Demo\SimpleUserImport;

use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use PFC\Demo\SimpleUserImport\Import\DataProvider\DataProvider;
use PFC\Demo\SimpleUserImport\Import\DataProvider\DataProviderInterface;
use PFC\Demo\SimpleUserImport\Import\InfoCollector\InfoCollectorInterface;
use PFC\Demo\SimpleUserImport\Import\InfoCollector\SimpleInfoCollector;
use PFC\Demo\SimpleUserImport\Import\Processor;
use PFC\Demo\SimpleUserImport\Import\Reader\CsvFileDataReader;
use PFC\Demo\SimpleUserImport\Import\Reader\DataReaderInterface;
use PFC\Demo\SimpleUserImport\Import\Validation\ValidationFilter;
use PFC\Demo\SimpleUserImport\Import\Validation\ValidationFilterInterface;
use PFC\Demo\SimpleUserImport\Import\Writer\BatchWriter;
use PFC\Demo\SimpleUserImport\Import\Writer\WriterInterface;
use PFC\Demo\SimpleUserImport\User\Import\Persister;
use PFC\Demo\SimpleUserImport\User\Import\UserDataTransferMapper;
use PFC\Demo\SimpleUserImport\User\Import\UserDataValidator;
use PFC\Demo\SimpleUserImport\User\Import\UserImportDataTransferToUserModelMapper;
use PFC\Demo\SimpleUserImport\User\Storage\CachedSimpleUserSearch;
use PFC\Demo\SimpleUserImport\User\Storage\SimpleUserSearch;
use PFC\Demo\SimpleUserImport\User\Storage\UserRepository;
use PFC\Demo\SimpleUserImport\User\Storage\UserSearchInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\ConsoleOutput;

class Factory
{
    /**
     * @var InfoCollectorInterface
     */
    private $infoCollector;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @return Processor
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function createImportProcessor(): Processor
    {
        return new Processor(
            $this->createImportDataProvider(),
            $this->createImportValidationFilter(),
            $this->createWriter()
        );
    }

    /**
     * @return WriterInterface
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function createWriter(): WriterInterface
    {
        return new BatchWriter(
            new Persister($this->getDBConnection(), $this->createUserRepository(), new UserImportDataTransferToUserModelMapper()),
            $this->getImportInfoCollector(),
            Config::IMPORT_WRITER_BATCH_SIZE
        );
    }

    /**
     * @return UserRepository
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function createUserRepository(): UserRepository
    {
        return new UserRepository($this->getDBConnection());
    }

    /**
     * @return DataProviderInterface
     */
    public function createImportDataProvider(): DataProviderInterface
    {
        return new DataProvider(
            $this->createDataReader(),
            new UserDataTransferMapper()
        );
    }

    /**
     * @return DataReaderInterface
     */
    public function createDataReader(): DataReaderInterface
    {
        return new CsvFileDataReader(Config::IMPORT_CSV_FILE_PATH);
    }

    /**
     * @return ValidationFilterInterface
     */
    public function createImportValidationFilter(): ValidationFilterInterface
    {
        return new ValidationFilter(
            new UserDataValidator(),
            $this->getImportInfoCollector()
        );
    }

    /**
     * @return InfoCollectorInterface
     */
    public function getImportInfoCollector(): InfoCollectorInterface
    {
        if (null === $this->infoCollector) {
            $output = new ConsoleOutput();
            $this->infoCollector = new SimpleInfoCollector(new ConsoleLogger($output), new ProgressBar($output));
        }

        return $this->infoCollector;
    }

    /**
     * @return Connection
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getDBConnection(): Connection
    {
        if (null === $this->connection) {
            $this->connection = DriverManager::getConnection(Config::MYSQL_CONNECTION_PARAMS);
        }

        return $this->connection;
    }

    /**
     * @return UserSearchInterface
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function createUserSearch(): UserSearchInterface
    {
        return new CachedSimpleUserSearch(
            new SimpleUserSearch($this->createUserRepository()),
            new FilesystemCache(Config::FILE_CACHE_DIRECTORY)
        );
    }
}
