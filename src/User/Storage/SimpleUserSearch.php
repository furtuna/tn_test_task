<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\User\Storage;

use PFC\Demo\SimpleUserImport\User\Model\User;

class SimpleUserSearch implements UserSearchInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param SearchTerm $searchTerm
     *
     * @return User[]
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function search(SearchTerm $searchTerm): array
    {
        return $this->userRepository->findByNameOrEmail($searchTerm->value());
    }
}
