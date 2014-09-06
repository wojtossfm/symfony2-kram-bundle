
build:
	compass compile src/WojciechM/KramBundle/Resources/public/
	php app/console translation:update pl --force WojciechMKramBundle
	sudo rm -rf app/cache/* app/logs/*
	sudo rm -rf web/bundles/*
	sudo chmod 777 -R app/cache app/logs web
	sudo rsync --delete -r src /var/www/kram/
	sudo chown -R www-data:www-data /var/www/kram
	sudo su www-data -s/bin/bash -c "cd /var/www/kram/; /var/www/kram/deploy.sh update prod"

syncfull:
	sudo rsync --delete -r ../kram /var/www/

buildfull: syncfull build

