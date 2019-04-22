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

**Development / local**
```
$ composer install
$ cp .env .env.local
```
Edit the .env.local file to suits your needs, then if you don't already have a working database :
```
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:create
$ php bin/console doctrine:fixtures:load
```

**Production**
```
$ composer install --no-dev --optimize-autoloader
```
Then if you don't already have a working database :
```
$ sh deploy.sh
```
