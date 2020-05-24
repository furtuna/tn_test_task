<?php

namespace PFC\Demo\SimpleUserImport\User\Import;

use Doctrine\DBAL\Connection;
use PFC\Demo\SimpleUserImport\Import\DataProvider\DataTransferInterface;
use PFC\Demo\SimpleUserImport\Import\Writer\PersisterInterface;
use PFC\Demo\SimpleUserImport\Import\Writer\PersisterResult;
use PFC\Demo\SimpleUserImport\Import\Writer\WriterException;
use PFC\Demo\SimpleUserImport\User\Storage\UserRepository;

class Persister implements PersisterInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var UserRepository
     */
    private $dbRepository;

    /**
     * @var UserImportDataTransferToUserModelMapper
     */
    private $mapper;

    /**
     * @param Connection $connection
     * @param UserRepository $dbRepository
     * @param UserImportDataTransferToUserModelMapper $mapper
     */
    public function __construct(
        Connection $connection,
        UserRepository $dbRepository,
        UserImportDataTransferToUserModelMapper $mapper
    ) {
        $this->connection = $connection;
        $this->dbRepository = $dbRepository;
        $this->mapper = $mapper;
    }

    /**
     * @param \Iterator|DataTransferInterface[] $dataTransfers
     *
     * @return PersisterResult
     *
     * @throws WriterException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function persistCollection(\Iterator $dataTransfers): PersisterResult
    {
        $persisterResult = new PersisterResult();
        $this->connection->beginTransaction();

        try {
            $userDataTransferIds = [];
            $users = [];
            foreach ($dataTransfers as $userDataTransfer) {
                $userDataTransfer = $this->requireUserDataTransfer($userDataTransfer);
                $userDataTransferIds[] = $userDataTransfer->id;
                $users[$userDataTransfer->id] = $this->mapper->map($userDataTransfer);
            }

            $foundIds = $this->dbRepository->findIdsByIds($userDataTransferIds);

            foreach ($users as $key => $user) {
                if (in_array($key, $foundIds)) {
                    $this->dbRepository->update($user);
                    $persisterResult->update();
                } else {
                    $this->dbRepository->insert($user);
                    $persisterResult->insert();
                }
            }

            $this->connection->commit();
        } catch (\Throwable $exception) {
            $this->connection->rollBack();
            throw new WriterException(sprintf('Writer exception: %s', $exception->getMessage()));
        }

        return $persisterResult;
    }

    /**
     * @param object $object
     *
     * @return UserDataTransfer
     *
     * @throws WriterException
     */
    private function requireUserDataTransfer(object $object): UserDataTransfer
    {
        if (!$object instanceof UserDataTransfer) {
            throw new WriterException(sprintf(
                'Instance of "%s" expected, but instance of "%s" passed',
                UserDataTransfer::class,
                get_class($object)
            ));
        }

        return $object;
    }
}
