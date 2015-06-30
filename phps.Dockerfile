# sshd
#
# VERSION               0.0.2

FROM davm85/php:latest
MAINTAINER David Moreau <dav.m85@gmail.com>

RUN mkdir /var/www
WORKDIR /var/www
EXPOSE 80
CMD ["php", "-S", "0.0.0.0:80"]
