ABOUT THIS FRAMEWORK
--------------------
This framework implements ideas and concepts from various
php frameworks and is designed to implement specific microservices 
of a project implemented on a microservice architecture.
Routing:
- Route are configured in routes/web.php file with you may use methods of "Router" class for example:
~~~
   Router::get("/api/post", PostApi::class,"index");
~~~
- Route for console commands are configured in routes/web.php file with you may use methods of "Router" class for example: 
- param msg get in handler:
~~~
RouterConsole::route("hello/index",\App\console\HelloController::class,"index");
~~~
Use this command in console you can like this
~~~
php command.php -c hello/index --msg="Hi"
~~~
The database instance, routes and configurations are configured in the App class,
and the configurations themselves are stored in a file "config.php ".
The same thing, but for console commands is configured in the Console class.
Model has method "load" for load post data(if post params exist), has property protected db property that
setting from db instance from App::$db.
Class Db has while two methods for batch insert and clear tables also
this class has property pdo of class PDO.
Class ActiveRecord has methods: save, delete, update

DIRECTORY STRUCTURE
-------------------

      app/                contains files of this application
      app/console         contains console commands (handlers)
      app/db              contains console commands (controllers)
      app/docs            contains console commands (controllers)
      app/handlers        contains handlers for actions
      app/handlers/api    contains handlers for api
      app/models          contains model classes
      app/utils           contains utilits for work freamwork
      app/views           contains view files for the Web application
      config/             contains application configurations
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 8.0.0


INSTALLATION
------------

### Install

- Download project
~~~
git clone <project-path>
~~~
- Rename all config/*.example files to config/<filename>.php
- Create database 
- Pull up all dependencies
~~~
composer install
~~~
- Apply sql scripts for create tables in app/db/db_scripts

- Example how to execute console command
~~~
php command.php -c hello/index --msg="Hello World"
~~~


TESTING
-------
Tests are located in `tests` directory.

- In first, you should set constant APP_MODE_TEST to true in index.php (in root directory)
- Create service_framework_test database and execute sql scripts(app/db/db_scripts) for this database
- Execute scripts in app/db/db_scripts for fill data into tables of test database.
```
php vendor/bin/codecept run  Api PostApiCest
```
The command above will execute tests for this api.