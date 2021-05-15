#!/usr/bin/env bash

echo 'WARNING /!\ Do not execute this script if you already have a working database for this project.'

while true
do
  read -p 'Do you want to continue ? [y/n] : ' yn

  case $yn in

      [Yy]* )

          echo 'Creating database...'
          php bin/console doctrine:database:create &&

          echo 'Creating database schema...'
          php bin/console doctrine:schema:create &&

          echo 'Creating superadmin user...'
          php bin/console fos:user:create --super-admin

          echo 'Inserting default Sonata data...'
          php bin/console sonata:media:fix-media-context

          exit;;

      [Nn]* ) exit;;

      * ) echo 'Please answer yes (y) or no (n)';;

  esac
done

