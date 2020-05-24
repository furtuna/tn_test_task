<?php

require_once __DIR__.'/vendor/autoload.php';

use PFC\Demo\SimpleUserImport\Command\DBPreparerCommand;
use PFC\Demo\SimpleUserImport\Command\ImportUserCommand;
use PFC\Demo\SimpleUserImport\Command\UsersCsvGeneratorCommand;
use PFC\Demo\SimpleUserImport\Command\UserSearchCommand;
use PFC\Demo\SimpleUserImport\Factory;
use Symfony\Component\Console\Application;

$factory = new Factory();
$application = new Application();
$application->add(new ImportUserCommand($factory));
$application->add(new DBPreparerCommand($factory));
$application->add(new UsersCsvGeneratorCommand());
$application->add(new UserSearchCommand($factory));

$application->run();
