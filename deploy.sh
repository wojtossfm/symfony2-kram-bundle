#!/bin/bash

if [ -z "$1" ]; then
	ACTION="none"
else
	ACTION="$1"
fi

if [ -z "$2" ]; then
	ENV="prod"
else
	ENV="$2"
fi


function usage() {
	echo "./deploy.sh <action> [env]"
	echo "\t action = install|update"
}

case $ACTION in
    install )
        php app/console doctrine:schema:create
		php app/console doctrine:fixtures:load

		;;
    update )
		php app/console doctrine:schema:update --force
        ;;
	clean )
		rm -r app/cache/* app/logs/*
		rm -r web/js/*
		rm -r web/css/*
		;;
	*)
		usage
		exit 1
		;;
esac

case $ENV in
    prod )
		php app/console cache:clear --env=$ENV --no-debug
		php app/console cache:warmup --env=$ENV --no-debug
		php app/console assetic:dump --env=$ENV --no-debug
		#php app/console assets:install --env=$ENV --no-debug
		;;
    dev )
		php app/console cache:clear --env=$ENV
		php app/console cache:warmup --env=$ENV --no-debug
		php app/console assets:install --env=$ENV --symlink
        ;;
	*)
		usage
		exit 1
		;;
esac

cp -r src/WojciechM/KramBundle/Resources/public/css/images web/css/



