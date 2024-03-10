# Projet de test technique HW

* Symfony 7.0
* PHP 8.3
* SQLite

## Getting Started
This is a fork of the project [Symfony Docker](https://github.com/dunglas/symfony-docker)

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --no-cache` to build fresh images
3. Run `docker compose up --pull always -d --wait` to start the project
4. Run `make vendor` to install composer dependencies
5. Run `make sh` to connect to Docker container
6. Run `php bin/console doctrine:migrations:migrate` on the docker container to create and migrate the SQLite database
7. Add the appropriate credentials for the France Travail API in .env file
8. Run `php bin/console app:ft:import-offers --commune=35238` from container to import job offers for RENNES



