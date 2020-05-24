#### Installation
```bash
$ git clone git@github.com:furtuna/tn_test_task.git
$ cd tn_test_task/
$ composer install
```
#### Config
Hardcoded in `src/Config.php`
#### Commands in order
Create users table
```bash
$ php ./index.php db:prepare
```
Generate random users csv file
```bash
$ php ./index.php import:users:csv:generate [number of rows]
```
Import users to db
```bash
$ php ./index.php import:users
```
Search for users
```bash
$ php ./index.php users:search [search term]
```
#### Additional
List of commands
```bash
php ./index.php
```
Run unit tests
```bash
php ./vendor/bin/phpunit
```
