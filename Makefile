
build:
	compass compile src/WojciechM/KramBundle/Resources/public/
	php app/console translation:update pl --force WojciechMKramBundle
	rm -rf app/cache/* app/logs/*
	rm -rf web/bundles/*
	sudo rsync --delete -r ../kram /var/www/
	sudo chown -R www-data:www-data /var/www/kram
	sudo rm -rf /var/www/kram/app/{cache,logs}/*
	sudo rm -rf /var/www/kram/web/bundles/*
	sudo su www-data -c "php /var/www/kram/app/console assets:install --symlink /var/www/kram/web"
