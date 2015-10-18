# Interfic
Text quest game special for http://masseffect2.in.

Requirements
------------

For now there are:
- PHP 5.4
- MySQL 5.1

Installation
------------

1. Create new database in MySQL. You can use any name, let it be `interfic`.
2. Clone this repo
3. Run
~~~
composer global require "fxp/composer-asset-plugin:~1.0.3"
composer install
~~~
to install framework and all dependencies.
4. Run `composer run-script post-create-project-cmd` to process some after-project installation. This step will be removed after publication at Packagist.
5. Run
~~~
php init.php --db_username=<DB username> --db_password=<DB password> --db_host=<DB host> --db_name=<DB name>
~~~
where parameters match your MySQL server settings.

5. Run `path/to/php yii migrate` to setup database. If you run on server, use `--interactive=0` argument to skip confirmation on this next console commands.
6. Run `path/to/php yii migrate --migrationPath=@yii/rbac/migrations`
7. Run `yii rbac/init` to install users authentication system.
8. Run `yii rbac/create-admin` to create first admin account in system, if you do not have it.

For better URL's you can configure your server to use /web as root directory for site.
 
System is installed, use it at your own risk!