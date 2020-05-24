<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Command;

use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\Index;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\DecimalType;
use Doctrine\DBAL\Types\StringType;
use PFC\Demo\SimpleUserImport\User\Storage\UserRepository;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DBPreparerCommand extends AbstractBaseCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'db:prepare';

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $conn = $this->factory->getDBConnection();
        $sm = $conn->getSchemaManager();
        $sm->dropAndCreateTable(new Table(
            UserRepository::TABLE_NAME,
            [
                new Column('id', new StringType(), ['length' => 100]),
                new Column('name', new StringType(), ['length' => 100]),
                new Column('email', new StringType(), ['length' => 100]),
                new Column('currency', new StringType(), ['length' => 3]),
                new Column('sum', new DecimalType(), ['scale' => 2, 'precision' => 5]),
            ],
            [
                new Index('id', ['id'], true, true),
                new Index('name_idx', ['name']),
                new Index('email_idx', ['email'], true),
            ]
        ));

        $output->writeln('<info>Users table created successfully.</info>');

        return 0;
    }
}
