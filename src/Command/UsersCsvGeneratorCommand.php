<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Command;

use PFC\Demo\SimpleUserImport\Config;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Simple users csv generator just for testing and demo reasons.
 */
class UsersCsvGeneratorCommand extends Command
{
    private const RANDOM_NAMES = [
        'Petr',
        'Vasily',
        'John',
        'Michael',
        'Morris',
        'Robert',
        'Alice',
        'Jane',
        'Mary',
        'Julia',
        'Penelopa',
        'Tom',
        'Halk',
    ];

    private const RANDOM_LAST_NAMES = [
        'Snow',
        'Duglas',
        'Vase4kin',
        'Petrov',
        'Nosov',
        'Foster',
        'Barns',
        'Cruise',
        'Tailor',
        'Stark',
        'Hogan',
    ];

    private const CURRENCIES = [
        'usd',
        'uah',
    ];

    /**
     * @var string
     */
    protected static $defaultName = 'import:users:csv:generate';

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->addArgument('rows_count', InputArgument::REQUIRED, 'Count of rows in csv file to generate.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $rowsCount = $input->getArgument('rows_count');
        $fh = fopen(Config::IMPORT_CSV_FILE_PATH, 'w');

        for ($i = 0; $i < $rowsCount; $i++) {
            $uid = str_replace('.', '', uniqid('uid', true));
            $name = array_rand(self::RANDOM_NAMES);
            $name = self::RANDOM_NAMES[$name];
            $lastName = array_rand(self::RANDOM_LAST_NAMES);
            $lastName = self::RANDOM_LAST_NAMES[$lastName];
            $currency = array_rand(self::CURRENCIES);
            $currency = self::CURRENCIES[$currency];

            fputcsv($fh, [
                $uid,
                $name.' '.$lastName,
                strtolower($name.$lastName).$uid.'@gmail.com',
                $currency,
                rand(50,999).'.'.rand(10,99),
            ]);
        }

        fclose($fh);

        $output->writeln(sprintf('<info>Successfully generated csv file with %s rows.</info>', $rowsCount));

        return 0;
    }
}
