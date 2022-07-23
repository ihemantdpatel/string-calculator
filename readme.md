<a href='https://coveralls.io/github/ihemantdpatel/string-calculator'><img src='https://coveralls.io/repos/github/ihemantdpatel/string-calculator/badge.svg' alt='Coverage Status' /></a>
## Running locally 

Pre-requisites

- Download Docker for mac: [https://docs.docker.com/docker-for-mac/install/](https://docs.docker.com/docker-for-mac/install/)

### Boot up docker containers 
The following command will start up the docker environment.  This is the only command needed to start the environment if you have already completed the "First Time Setup".  When running this command for the first time, docker will pull and build a series of images.  This initial pull and build will take some time (~2-5 minutes).

- `docker compose up -d` this will fire up following containers 
    - docker compose up -d
    - string-calculator_web    
- `docker ps` to see the services you have running

### Stopping containers
To stop the environment without removing any containers, run the following command:
- `docker compose stop`

### To Tear Down Containers
Running the following command will stop and remove the containers and networks created when the environment was started.
- `docker compose down` while in the the root of this repository

### 1. Prepare the Environment
Install the composer dependencies `docker compose exec web composer install`.  This process will take ~2-5 minutes.

### 2. Code Style / Linting
In this project, we try to maintain coding standards following [PSR 12](https://www.php-fig.org/psr/psr-12/).

You can check for linting errors locally with the following command:

```bash
$ docker compose exec web ./vendor/bin/phpcs --standard=PSR12 app/
$ docker compose exec web ./vendor/bin/phpcs --standard=PSR12 tests/
```

Many errors can automatically be fixed and `PHPCS` will let you know that. The command for that is:

```bash
$ docker compose exec web ./vendor/bin/phpcbf --standard=PSR12 app/
$ docker compose exec web ./vendor/bin/phpcbf --standard=PSR12 tests/
```

### 3. Static Analysis Tool
In this project, we try to moves PHP closer to compiled languages.

You can run the analysis locally with the following command.

```bash
$ docker compose exec web ./vendor/bin/phpstan analyse -c phpstan.neon
```

### 4. Run Unit Tests
You can run the unit tests locally with the following command.

```bash
$ docker compose exec web vendor/bin/phpunit tests/ --testdox
```