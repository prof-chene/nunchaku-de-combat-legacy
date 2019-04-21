#!/usr/bin/env bash

while true; do
    read -p 'WARNING /!\ Do not execute this script if you already have a working database for this project.\n
Do you want to continue ? [N/y] : \c' yn

    case $yn in

        [Yy]* )

            echo 'Creating database...'
            php bin/console doctrine:database:create --if-not-exists &&

            echo 'Creating database schema...'
            php bin/console doctrine:schema:create &&

            echo 'Creating superadmin user...'
            php bin/console fos:user:create --super-admin

            echo 'Inserting default Sonata data...'
            php bin/console sonata:media:fix-media-context

            break;;

        [Nn]* ) exit;;

        * ) echo 'Please answer yes (y) or no (n) : \c';;

    esac

done
