# Nunchaku de Combat
## Requirements
This project needs the following components to run properly :
- [PHP](https://www.php.net/manual/fr/install.php) (7.1 or higher version)
- A web server
- A database management system (DBMS) instance compatible with the [PDO_MYSQL](https://www.php.net/manual/en/ref.pdo-mysql.php) driver (in other words, MySQL or one of its forks)
- [Composer](https://getcomposer.org/) (1.3 or higher version)


## Configuration
### PHP

Edit you php.ini to set these values :
```
realpath_cache_ttl: 7200;
memory_limit: 128M;
upload_max_filesize: 10M;
post_max_size: 20M;`
```

If you don't know where your php.ini file is, execute this command :

```
$ php --ini
```

### Environment variables
Symfony uses the web server's environment variables to do some part of its configuration (such as database connection infos).

You **do want** to have a look at the **/.env file** and define your own variables (in your virtual host file for example).

## Deploying the project
First, you have to clone the source code in your web server's filesystem :
```
$ cd $PATH_TO_YOUR_WEB_APPS_FOLDER
$ git clone git@bitbucket.org:alexandre_duchene/nunchaku-de-combat.git
```
You might need to setup a [ssh key](https://confluence.atlassian.com/bitbucket/set-up-an-ssh-key-728138079.html) before doing that.

Then, choose the release you wish to deploy with :
```
$ git checkout $TAG_NAME
```
Once you have cloned the project, make it the current working directory and run the following commands (depending on your environment) :

### For Development / Test env
```
$ cp .env .env.local
```
Edit the .env.local file to suits your needs, then :
```
$ composer install
```
Then if you don't already have a working database :
```
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:create
$ php bin/console doctrine:fixtures:load
```
Then, you can use whatever web server you wish.
You could use the built-in [Symfony web server](https://symfony.com/doc/3.4/setup/symfony_server.html), that is based on the [PHP web server](https://www.php.net/manual/en/features.commandline.webserver.php).
Simply run :
```
$ php bin/console server:run
```

### For Production env
```
$ composer install --no-dev --optimize-autoloader
```
Then if you don't already have a working database :
```
$ sh deploy.sh
```

To run the application on you own web server, you can use Apache or Nginx. Here is how from the [Symfony documentation](https://symfony.com/doc/3.4/setup/web_server_configuration.html)

An example of a virtual host configuration for Nginx would be :
```
server {
    server_name domain.tld www.domain.tld;
    root /var/www/project/web;

    location / {
        # try to serve file directly, fallback to app.php
        try_files $uri /app.php$is_args$args;
    }

    location ~ ^/app\.php(/|$) {
        fastcgi_pass unix:/var/run/php/php7.1-fpm.sock;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        # When you are using symlinks to link the document root to the
        # current version of your application, you should pass the real
        # application path instead of the path to the symlink to PHP
        # FPM.
        # Otherwise, PHP's OPcache may not properly detect changes to
        # your PHP files (see https://github.com/zendtech/ZendOptimizerPlus/issues/126
        # for more information).
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
        # Prevents URIs that include the front controller. This will 404:
        # http://domain.tld/app.php/some-path
        # Remove the internal directive to allow URIs like this
        internal;
    }

    # return 404 for all other php files not matching the front controller
    # this prevents access to other php files you don't want to be accessible.
    location ~ \.php$ {
        return 404;
    }

    #error_log /var/log/nginx/project_error.log;
    #access_log /var/log/nginx/project_access.log;
}
```
