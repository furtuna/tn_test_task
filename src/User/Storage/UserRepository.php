<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\User\Storage;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use PFC\Demo\SimpleUserImport\User\Model\User;

class UserRepository
{
    public const TABLE_NAME = 'users';

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $id
     *
     * @return User
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findById(string $id): ?User
    {
        $sql = 'SELECT * FROM users WHERE id = ?';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        $userData = $stmt->fetch();

        if (false === $userData) {
            return null;
        }

        return $this->mapToModel($userData);
    }

    /**
     * @param string $searchTerm
     *
     * @return User[]
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findByNameOrEmail(string $searchTerm): array
    {
        $sql = 'SELECT * FROM users WHERE name LIKE ? OR email LIKE ?';
        $stmt = $this->connection->prepare($sql);
        $searchExpression = $searchTerm.'%';
        $stmt->bindValue(1, $searchExpression);
        $stmt->bindValue(2, $searchExpression);
        $stmt->execute();
        $usersData = $stmt->fetchAll();

        $users = [];
        foreach ($usersData as $userData) {
            $users[] = $this->mapToModel($userData);
        }

        return $users;
    }

    /**
     * @param string[] $ids
     *
     * @return string[]
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findIdsByIds(array $ids): array
    {
        $stmt = $this->connection->executeQuery(
            'SELECT id FROM users WHERE id IN (?)',
            [$ids],
            [Connection::PARAM_STR_ARRAY]
        );

        return $stmt->fetchAll(FetchMode::COLUMN);
    }

    /**
     * @param User $user
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function insert(User $user): void
    {
        $this->connection->insert(self::TABLE_NAME, $user->toArray());
    }

    /**
     * @param User $user
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function update(User $user): void
    {
        $this->connection->update(self::TABLE_NAME, $user->toArray(), ['id' => $user->id()]);
    }

    /**
     * @param array $data
     *
     * @return User
     */
    private function mapToModel(array $data): User
    {
        return new User(
            $data['id'],
            $data['name'],
            $data['email'],
            $data['currency'],
            $data['sum']
        );
    }
}
