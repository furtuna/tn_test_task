<?php

namespace PFC\Demo\SimpleUserImport\User\Storage;

use PFC\Demo\SimpleUserImport\User\Model\User;

interface UserSearchInterface
{
    /**
     * @param SearchTerm $searchTerm
     *
     * @return User[]
     */
    public function search(SearchTerm $searchTerm): array;
}
