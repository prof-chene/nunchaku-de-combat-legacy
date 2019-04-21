# Nunchaku de Combat
## Requirements
This project needs the following components to run properly :
- [PHP](https://www.php.net/manual/fr/install.php) (7.1 or higher version)
- A web server
- A database management system (DBMS) instance compatible with the [PDO_MYSQL](https://www.php.net/manual/en/ref.pdo-mysql.php) driver (in other words, MySQL or one of its forks)
- [Composer](https://getcomposer.org/) (1.3 or higher version)

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
Once you have cloned the project, run the following commands depending on your environment :

**Developpement**
```
$ composer install
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:create
$ php bin/console doctrine:fixtures:load
```

**Production**
```
$ composer install --no-dev --optimize-autoloader
$ sh deploy.sh
```

Now, if your virtual hosts are not configured, go ahead and do it , otherwise nobody will be able to see the fantastic content you wish to make publicly available !
