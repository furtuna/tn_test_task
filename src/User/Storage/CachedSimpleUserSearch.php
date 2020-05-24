<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\User\Storage;

use Doctrine\Common\Cache\Cache;
use PFC\Demo\SimpleUserImport\User\Model\User;

class CachedSimpleUserSearch implements UserSearchInterface
{
    /**
     * @var UserSearchInterface
     */
    private $userSearch;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @param UserSearchInterface $userSearch
     * @param Cache $cache
     */
    public function __construct(UserSearchInterface $userSearch, Cache $cache)
    {
        $this->userSearch = $userSearch;
        $this->cache = $cache;
    }

    /**
     * @param SearchTerm $searchTerm
     *
     * @return User[]
     */
    public function search(SearchTerm $searchTerm): array
    {
        $cacheKey = $this->generateCacheKey($searchTerm);
        if ($this->cache->contains($cacheKey)) {
            return $this->cache->fetch($cacheKey);
        }

        $users = $this->userSearch->search($searchTerm);
        if (!empty($users)) {
            $this->cache->save($cacheKey, $users);
        }

        return $users;
    }

    /**
     * @param SearchTerm $searchTerm
     *
     * @return string
     */
    private function generateCacheKey(SearchTerm $searchTerm): string
    {
        return $searchTerm->value();
    }
}
