<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\User\Import;

use PFC\Demo\SimpleUserImport\Import\DataProvider\DataTransferInterface;

class UserDataTransfer implements DataTransferInterface
{
    /**
     * @var string|null
     */
    public $id;

    /**
     * @var string|null
     */
    public $name;

    /**
     * @var string|null
     */
    public $email;

    /**
     * @var string|null
     */
    public $currency;

    /**
     * @var string|null
     */
    public $sum;

    /**
     * @return string|null
     */
    public function getRowId(): ?string
    {
        return $this->id;
    }
}
