# Symfony 6 test task

### Init application on localhost
```sh
$ cd docker
$ docker compose up
Connect to php-fpm container:
$ docker container exec -it php-fpm /bin/bash
Install dependecies:
$ compsoser install
Run migrations inside of it:
$ php bin/console d:m:m
Run tests:
$ php bin/phpunit
```

### API Endpoints
| Path                       | Usage                                                              |
|----------------------------|--------------------------------------------------------------------|
| **GET** ```/hash/{hash}``` | search for items by their hash                                     |
| **POST** ```/hash```       | create hashed data (request body example: ```{"data": "apple"}```) |
