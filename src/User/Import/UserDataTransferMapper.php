<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\User\Import;

use PFC\Demo\SimpleUserImport\Import\DataProvider\DataTransferInterface;
use PFC\Demo\SimpleUserImport\Import\DataProvider\DataTransferMapperInterface;

class UserDataTransferMapper implements  DataTransferMapperInterface
{
    /**
     * @param array $data
     *
     * @return DataTransferInterface
     */
    public function map(array $data): DataTransferInterface
    {
        $userDataTransfer = new UserDataTransfer();

        $userDataTransfer->id = $data[0] ?? null;
        $userDataTransfer->name = $data[1] ?? null;
        $userDataTransfer->email = $data[2] ?? null;
        $userDataTransfer->currency = $data[3] ?? null;
        $sum = $data[4] ?? null;
        $userDataTransfer->sum = $sum ? (float) $sum : null;

        return $userDataTransfer;
    }
}
