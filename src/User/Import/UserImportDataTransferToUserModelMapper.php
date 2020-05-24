<?php

namespace PFC\Demo\SimpleUserImport\User\Import;

use PFC\Demo\SimpleUserImport\User\Model\User;

class UserImportDataTransferToUserModelMapper
{
    /**
     * @param UserDataTransfer $userDataTransfer
     *
     * @return User
     */
    public function map(UserDataTransfer $userDataTransfer): User
    {
        return new User(
            $userDataTransfer->id,
            $userDataTransfer->name,
            $userDataTransfer->email,
            $userDataTransfer->currency,
            number_format($userDataTransfer->sum, 2)
        );
    }
}
