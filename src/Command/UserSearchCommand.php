<?php

namespace PFC\Demo\SimpleUserImport\Command;

use PFC\Demo\SimpleUserImport\User\Storage\SearchTerm;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserSearchCommand extends AbstractBaseCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'users:search';

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->addArgument('search_term', InputArgument::REQUIRED, 'Search term.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws \PFC\Demo\SimpleUserImport\User\Storage\SearchException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userSearch = $this->factory->createUserSearch();
        $searchTerm = new SearchTerm($input->getArgument('search_term'));
        $users = $userSearch->search($searchTerm);
        if (empty($users)) {
            $output->writeln('Users not found.');

            return 0;
        }

        foreach ($users as $user) {
            $output->writeln(implode(',', $user->toArray()));
        }

        $output->writeln(sprintf('%s <info>users found.</info>', count($users)));

        return 0;
    }
}
