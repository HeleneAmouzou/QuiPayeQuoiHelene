# Qui Paie Quoi ?

Qui Paie Quoi ? is an application helping groups to organize their expenses.

## Table of contents
* [Requirements] (#requirements)
* [Installation] (#installation)
* [Technologies] (#technologies)

## Requirements

- Docker engine `>20.10`
- Docker compose `>2`

## Installation
To run this project :
1. Clone the project : https://github.com/KnpLabs/QuiPayeQuoiHelene.git ;
2. Run `cp --no-clobber .env.dist .env` ;
3. Run `docker compose build --no-cache php` ;
5. Run `docker-compose exec php composer install`;
6. Run `docker-compose exec php bin/console doctrine:migrations:migrate`;
7. Run `docker-compose exec php bin/console doctrine:fixtures:load --append`;


## Technologies
This project is created with:
- Nginx 1.21.3-alpine
- Docker 23.0.2
- PHP 8.1
- Symfony 6.2
- Twig 3.0
- MySQL 8.0.32
- Doctrine 2.7.1
- Bootstrap 5.3.0-alpha3