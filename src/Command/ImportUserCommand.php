<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportUserCommand extends AbstractBaseCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'import:users';

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
        $infoCollector = $this->factory->getImportInfoCollector();
        $importProcessor = $this->factory->createImportProcessor();

        $infoCollector->start();
        $infoCollector->setTotal($this->factory->createDataReader()->rowsCount());
        $importProcessor->process();
        $infoCollector->finish();

        $output->writeln('');
        $output->writeln('<info>Count of invalid rows: </info>'.$infoCollector->validationErrorsCount());
        $output->writeln('<info>Inserted: </info>'.$infoCollector->inserted());
        $output->writeln('<info>Updated: </info>'.$infoCollector->updated());
        $output->writeln('<info>Total successfully processed: </info>'.$infoCollector->processed().'/'.$infoCollector->total());

        return 0;
    }
}
