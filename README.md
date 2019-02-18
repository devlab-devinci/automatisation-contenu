# automatisation-contenu

## Dependencies

- Curl
- Composer
- PHP **(At least 7.1)**

## Install the project

- `git clone https://github.com/devlab-devinci/automatisation-contenu.git`
- `composer install`

## Configure

- Change `.env` to connect database
- Create database with this command `php bin/console doctrine:database:create`
- Create schema columns with this command `php bin/console doctrine:schema:update --force`

## _Note for Developers only_

If you want to add _fixtures_, run this command : `php bin/console doctrine:fixtures:load` (Optional : Add `--append` at the end of the command line to not purge database)

## Run the project

- `php bin/console server:run`

UPDATE 18/02/19

## Yarn

- yarn install
- yarn encore dev

## Compiler Scss

- yarn encore dev --watch
