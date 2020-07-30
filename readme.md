# Hoang.Phuong (A Personal Wordpress Blog)

# PHP container
## Getting image
```
$ sudo docker image pull nanoninja/php-fpm
```
## Starting
```
$ docker container run --rm --name php -v $(pwd):/var/www/html -p 3000:3000 nanoninja/php-fpm  php -S="0.0.0.0:3000" -t="/var/www/html"

$ [Thu Jul 30 14:15:52 2020] PHP 7.4.4 Development Server (http://0.0.0.0:3000) 
```


