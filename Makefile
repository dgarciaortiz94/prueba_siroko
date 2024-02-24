UID = $(shell id -u)
SERVICE_CONTAINER_NAME = prueba_siroko
SERVER_IP = $(shell ip address \ grep docker0)

help:
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

build:
	U_ID=${UID} docker-compose up -d --remove-orphans --build
	@echo "Waiting for containers to start..."
	@while [ $$(docker ps --filter "status=running" --format "{{.Names}}" | grep -c "U_ID=${SERVICE_CONTAINER_NAME}") -eq 0 ]; do \
		sleep 3; \
	done
	docker exec ${SERVICE_CONTAINER_NAME} sh -c "cd /var/www/html/${SERVICE_CONTAINER_NAME} && chmod 777 -R ."
	cp ./.env.example ./.env.local
	cp ./.env.example ./.env
	docker exec ${SERVICE_CONTAINER_NAME} sh -c "cd /var/www/html/${SERVICE_CONTAINER_NAME} && composer install"

start:
	U_ID=${UID} docker-compose up -d

stop:
	U_ID=${UID} docker-compose stop

restart:
	$(MAKE) stop && $(MAKE) start

ssh: 
	U_ID=${UID} docker exec -it --user ${UID} ${SERVICE_CONTAINER_NAME} bash

delete:
	U_ID=${UID} docker rm -f U_ID=${UID}

test:
	U_ID=${UID} docker exec -it --user ${UID} ${SERVICE_CONTAINER_NAME} sh -c "cd /var/www/html/${SERVICE_CONTAINER_NAME} && php bin/phpunit"

cs-fix:
	U_ID=${UID} docker exec -it --user ${UID} ${SERVICE_CONTAINER_NAME} sh -c "cd /var/www/html/${SERVICE_CONTAINER_NAME} && vendor/bin/php-cs-fixer fix"
	
