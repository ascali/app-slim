# Slim Framework 3 Skeleton Application

Use this skeleton application to quickly setup and start working on a new Slim Framework 3 application. This application uses the latest Slim 3 with the PHP-View template renderer. It also uses the Monolog logger.

This skeleton application was built for Composer. This makes setting up a new Slim Framework application quick and easy.

## Install the Application

Run this command from the directory in which you want to install your new Slim Framework application.

    php composer.phar create-project slim/slim-skeleton [my-app-name]

Replace `[my-app-name]` with the desired directory name for your new application. You'll want to:

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writeable.

To run the application in development, you can run these commands 

	cd [my-app-name]
	php composer.phar start

Run this command in the application directory to run the test suite

	php composer.phar test

That's it! Now go build something cool.

# RESTful api / webservice tutorial for slim framework
for complete tutorial https://www.petanikode.com/slim-api/

# How to run this app
1. Pull the repo `git pull https://repourl`
2. `cd app-slim`
3. `composer install`
4. set database on `src\settings.php`
	in this line code 
	`
    // Database SQL Server
    'db' => [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => 'root',
        'dbname' => 'kontak',
        'driver' => 'mysql',
    ],
	`
5. run project `composer start`


# For MVC Slim Framework here
https://github.com/revuls/SlimMVC