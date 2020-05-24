<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport;

class Config
{
    public const IMPORT_CSV_FILE_PATH = __DIR__.'/../data/users.csv';

    public const MYSQL_CONNECTION_PARAMS = [
        'dbname' => 'tn_test_task',
        'user' => 'organizer',
        'password' => '123456',
        'host' => 'localhost',
        'driver' => 'pdo_mysql',
    ];

    public const IMPORT_WRITER_BATCH_SIZE = 200;

    public const FILE_CACHE_DIRECTORY = __DIR__.'/../cache/';
}
