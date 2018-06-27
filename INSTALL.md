# Installing

This was written a while ago and only recently tweeked to get it to work in docker and against a later version of PHP so these are just quick notes to get it working. So there is no real installer, package management or anything like that. The cleanest method is to go with the docker container.

* Just stick to the "stable" directory, ignore the "unstable" directory thats a throwback to when the source was developed with CVS and it was easier than branching.

## Dependencies

* [Smarty v2](https://github.com/smarty-php/smarty) ( linked as a subproject )
* MySql V5 ( tested with 5.6 Definatly does not worth with V8)
* PHP V7
* A webserver ( eg Apache / Nginx )

## Database schema

Base schema is in "stable/database/Job-app-initialload.sql" It includes creating an low priviledge app user. The app doesn't populate the DB itself so you need to throw that sql at it.

## Running with Docker

The given Docker file will satisfy all but the Mysql and can be pulled directly from Docker: [![Docker Hub](https://img.shields.io/docker/pulls/vagnerr/jobtrack1.svg)](https://hub.docker.com/r/vagnerr/jobtrack1/)

It is also possible to use Docker for the database as well for example eg

```bash
docker run --name job-mysql -e MYSQL_ROOT_PASSWORD=my-secret-pw -d mysql:5.5
docker run -d --name job --link job-mysql:mysql -p 8080:80 -e DB_NAME='JOBAPPS' vagnerr/jobtrack1
```

(Though thats only usefull for testing the db, as it will be transient).

Note: a convenient way for installing the DB schema is to use the command...

```bash
docker run -it --link job-mysql:mysql --rm mysql:5 sh -c 'exec mysql -h"$MYSQL_PORT_3306_TCP_ADDR" -P"$MYSQL_PORT_3306_TCP_PORT" -uroot -p"my-secret-pw"'
```

... that will get to a root login to the mysql server just copy-n-paste the sql in.

I you have a "propper" mysql server and you have sensible user credentials settup you need to pass it all to the application docker container via environment. It honors the following environment variables for DB access

* DB_HOST ( default: job-mysql )
* DB_USER ( default: jobapp_u )
* DB_PASS ( default: jobapp_p )
* DB_NAME ( default: JOBAPPS )

eg

```bash
docker run -d --name jobt_test -e DB_HOST="172.17.0.1" -e DB_USER="fred" -e DB_PASS="secret" -e DB_NAME="JOBAPPS_TEST" vagnerr/jobtrack1
```
