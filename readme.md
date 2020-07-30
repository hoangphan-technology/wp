# Hoang.Phuong (A Personal Wordpress Blog)

# PHP container
## Getting image
```bash
$ sudo docker image pull nanoninja/php-fpm

```

## Starting
```bash
$ docker container run --rm --name php -v $(pwd):/var/www/html -p 3000:3000 nanoninja/php-fpm  php -S="0.0.0.0:3000" -t="/var/www/html"

$ [Thu Jul 30 14:15:52 2020] PHP 7.4.4 Development Server (http://0.0.0.0:3000) 

```


# NGINX
## Getting image & Starting
```bash
$ docker pull nginx
$ docker container run --rm --name phn -v $(pwd):/usr/share/nginx/html:ro -p8080:80  nginx

```

## Useful Commands
> Start container without create new container
```bash
$ docker start container phn
```
> View Log
```
$ docker  container logs phn -f
```
> Resource Usage
```bash
$ docker  container stats phn
```

## Down...
```bash
$ docker container stop phn
$ docker container rm -f phn

```