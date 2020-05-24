<?php

namespace PFC\Demo\SimpleUserImport\Command;

use PFC\Demo\SimpleUserImport\Factory;
use Symfony\Component\Console\Command\Command;

abstract class AbstractBaseCommand extends Command
{
    /**
     * @var Factory
     */
    protected $factory;

    /**
     * @param Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;

        parent::__construct();
    }
}
