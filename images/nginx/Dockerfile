FROM nginx:stable

WORKDIR /var/www

RUN apt-get update \
    && apt-get install vim -y

RUN rm /etc/nginx/conf.d/default.conf

COPY site.conf /etc/nginx/conf.d/
