#!/usr/bin/make

SHELL = /bin/sh

CURRENT_UID := $(shell id -u)
CURRENT_GID := $(shell id -g)

export CURRENT_UID
export CURRENT_GID
export APP_NAME=employee_benefits_app

build:
	composer install
	docker-compose up -d --build

bash:
	docker exec -it ${APP_NAME}_php_1 /bin/sh

start:
	docker-compose up -d

stop:
	docker-compose down
