<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\User\Model;

class User
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $sum;

    /**
     * @param string $id
     * @param string $name
     * @param string $email
     * @param string $currency
     * @param string $sum
     */
    public function __construct(string $id, string $name, string $email, string $currency, string $sum)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->currency = $currency;
        $this->sum = $sum;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'email'    => $this->email,
            'currency' => $this->currency,
            'sum'      => $this->sum,
        ];
    }
}
